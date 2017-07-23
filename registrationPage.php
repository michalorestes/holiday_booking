<?php
session_start();
    //Redirect to HTTPS protocol 
    //adapted from
    //http://stackoverflow.com/questions/5106313/redirecting-from-http-to-https-with-php
    if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){
        $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . $redirect);
        exit();
    }
if(isset($_SESSION['Member']) && !empty($_SESSION['Member'])) {
   header('Location: index.php');
   exit();
}

//* Registration Script *//
if(isset($_POST['submit'])){
  include 'functions/FormValidation.php';
  include 'functions/dbConnection.php';
  include 'securimage/securimage.php';
  include 'functions/Tools.php';
  //Load form data
  $Validator = new FormValidation();
  $dbConnection = new dbConnection();
  $Tools = new Tools();
  $securimage = new Securimage();

  $username = $_POST['txt_name'];
  $email = $_POST['txt_email'];
  $contact = $_POST['txt_contact'];
  $pass1 = $_POST['txt_password1'];
  $pass2 = $_POST['txt_password2'];
  $captcha = $_POST['captcha_code'];
  $chkBox = isset($_POST['chk_terms']);

  //Validate Data
  $results = $Validator->validateRegistration($username, $email, $contact, $pass1, $pass2);
  if ($securimage->check($captcha) == false) {
    $results[] = 'Wrong Captcha';
  }
  $message = NULL;
  //Display validation results & Add record to database
  if ($results == NULL ) {
    $code = $Tools->activationCode();
    $dbConnection->addMember($username, $email, $contact, $pass1, $code);
    $Tools->activationEmail($email, $code);
    $_SESSION['Member'] = $dbConnection->getLoginData($username);
    $message = 'Registration sucessfull. Shortly you will recievce e-mail with your activation code';
  } else {
    $message  = 'Ops! Please correct the following errors<br />';
    foreach ((array)$results as $value) {
      $message = $message . '<br /> - '  . $value;
    }
  }

  //* Verification Page Display *//
  $title = 'Verification';
  $content = $message;
} else {
  //* Regostration Form Display *//
  $title = 'Registration';
  $content = file_get_contents('html/registrationForm.html');
}
  include 'template/content.php';
?>