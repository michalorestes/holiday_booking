<?php 
  if(!isset($_SESSION['Member']) && empty($_SESSION['Member'])) {
     header('Location: index.php');
     exit();
  } else if($_SESSION['Member'][4] === '0') {
      header('Location: accountActivationPage.php');
  }
?>