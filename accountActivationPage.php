<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
 if(!isset($_SESSION['Member']) && empty($_SESSION['Member'])) {
     header('Location: index.php');
     exit();
  }

include('template/header.php');
$accountActivated = false; 
$loginStatus = true; 
if(isset($_SESSION['Member']) && $_SESSION['Member'][4] == 1) {
   $accountActivated = true; 
}

if(!isset($_SESSION['Member'])) {
   $loginStatus = false; 
}

//* Activation Script *//
if (isset($_POST['submit'])) {
  $formCode = $_POST['activationCode'];
  $dbCode = $_SESSION['Member'][6];

  if ($dbCode === $formCode) {
    require_once('functions/dbConnection.php');
    $dbConnection = new dbConnection();
    $dbConnection->activateAccount($_SESSION['Member'][1]);
    $dbConnection->activateAccount($_SESSION['Member'][1]);
    $_SESSION['Member'] = $dbConnection->getLoginData($_SESSION['Member'][1]);
    $accountActivated = true; 
      
  } else {
    echo '<script>alert("Wrong activation code!"); </script>';
  }

}

?>
    <h1>Account Activation</h1>


<?php if(!$accountActivated){ ?>
    <form action="accountActivationPage.php" method="post" style="display: inline">
    <p>Enter your activation code:</p>  <p><input type="text" name="activationCode" size="40" /> <input type="submit" value="Activate" name="submit" /></p>
    </form>
<?php } ?>

<?php if($accountActivated){ ?>
    <p>You account has been activated. Now you can access member's area. Click <a href="addPropertyPage.php">here</a> to add a new property.</p>
<?php } ?>


<?php
  include 'template/footer.php';
?>