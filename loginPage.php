<?php 
  //adapted from
    //http://stackoverflow.com/questions/5106313/redirecting-from-http-to-https-with-php
    if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $redirect);
    exit();
}
include('template/header.php');

    $loginStatus = false; 
    $activationStatus = false; 
    $incorrectDetails = false; 
    
    if(isset($_SESSION['Member'])){
        $loginStatus = true;
    }


	//* Login Script *//
	if (isset($_POST['submit'])) {
      include('functions/Tools.php');
	  $username = $_POST['txt_username'];
	  $password = $_POST['txt_password'];
	  $Tools = new Tools();
        
	  //Password verification
	  $userData = $Tools->verifyPassword($username, $password);
	  if ($userData != NULL) {
        //if verification is sucessfull the, user's data is stored in a session
		$_SESSION['Member'] = $userData;
		$loginStatus = true; 
		  //Check if account is activated 
          if ($userData[4] != TRUE) {
		      $activationStatus = true;
	       } 
	   } else {
          $incorrectDetails  = true; 
      }
        
    }
?>
<!-- Failed login message -->
<?php if(isset($_POST['submit']) && $incorrectDetails){ ?>
    <p>The details you entered were incorrect. Please try again.</p>
<?php } ?>
<!-- Login Form -->
<?php if(!$loginStatus){ ?>
<h1>Login</h1>
<form id="loginForm" method="post" action="loginPage.php" class="centerItems">
    <table class="clear">
        <tr>
            <td>Username: </td>
            <td><input id="txtLogin" type="text" name="txt_username" value="" /></td>
        </tr>
        <tr>
            <td>Password: </td>
            <td><input type="password" name="txt_password" /></td>
        </tr>
        <tr><td></td><td><input id="btnLogin" type="submit" name="submit" value="Submit" /></td></tr>
    </table>

    <p>Don't have an account yet? <br /><a href="registrationPage.php"><b>sign up</b></a>?</p>
</form>
<?php } ?>

<!-- LoggedIn Message -->
<?php if($loginStatus){ ?>
<p>You have sucessfully logged in. Click <a href="index.php">here</a> to return to home page.</p>
<?php } ?>
	
<!-- Activation required message -->
<?php if($activationStatus){ ?>
    <p>Your account needs to be activated before you can use member's functionality. Click <a href="accountActivationPage.php">here</a> to enter your activation code.</p>
<?php } ?>

<?php

include ('template/footer.php');
?>