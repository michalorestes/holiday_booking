<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}


// remove all session variables
//session_unset();

// destroy the session
//session_destroy();
$_SESSION['Member'] = NULL;
$_SESSION['message'] = 'You have logged out';

header('Location: ../index.php');
exit();
?>