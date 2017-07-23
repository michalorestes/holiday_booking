<?php
	if (session_status() == PHP_SESSION_NONE) {
	  session_start();
	}
?>
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb">
    <head>
        <title>Brighton Holiday Accomodation</title>
        <link rel="stylesheet" type="text/css" href="css/header.css"/>
		<link rel="stylesheet" type="text/css" href="css/master.css"/>
        <link rel="stylesheet" type="text/css" href="css/content.css" />
        <link rel="stylesheet" type="text/css" href="css/footer.css" />
		<link rel="stylesheet" type="text/css" href="css/sidebar.css" />
		<link rel="stylesheet" type="text/css" href="css/sidebar.css" />
		
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" type="text/javascript"></script>
    </head>
    <body>
      <div id="topCont" class="clear">
          
          <div id="mainNaviationCont" class="clear">
            <div class="centerCont">

              <ul class="navigation floatRight">
                <li class="homeBtn"><a href="index.php">Home</a></li>
                  <?php if(isset($_SESSION['Member'])){ ?>
                  <?php if ($_SESSION['Member'][4] == 0) { /*Display Activation Link*/?>
                  <li class="memberBtn"><a href="accountActivationPage.php">Activate Account</a></li>
                  <?php } else { //Member[4] is ststement end /*Display Members Panel Link*/ ?>
                  <li class="memberBtn" id="memberArea">Member Area</li>
                  <?php } } else { //Link to login page  ?>
                  <li id="loginBtn"><a href="loginPage.php">Log In</a></li><?php } ?>
                </ul>
              <a href="index.php" class="floatLeft"><img id="logoImg" src="img/logo.png" alt="logo" /></a>
            </div>
          </div>
          <div id="memberNavigationCont" class="clear">
            <script type="text/javascript">
              //Hide Member's navigation bar
              $('#memberNavigationCont').hide();
            </script>
            <div class="centerCont" >
              <ul class="navigation floatRight">
                <li><a href="myProperties.php">My Properties</a></li>
                <li><a href="property.php">List Property</a></li>
                <li><a href="functions/logoutScript.php">Logout</a></li>
              </ul>
            </div>
          </div>
      </div>
      <div class="centerCont">
        <div id="bodyCont">