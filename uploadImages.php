<?php
  session_start();
include('template/memberContent.php');
if (!isset($_SESSION['imgDir'])) {
    header('Location: index.php');
    exit();
  }
include('template/header.php');
  //Create folder to store property images
  $structure = $_SESSION['imgDir'];

$propertySaved = false;


  $dirImages = array();

  //upload images on button press
  if (isset($_POST['uploadSubmit'])) {
	 
    include 'functions/imageUploadScript.php';
    $upload = new ImageUpload();
    echo $upload->uploadFile($structure);
  }

  //Save property
  if (isset($_POST['saveProperty'])) {
    $_SESSION['message'] = 'Your property has been successfully saved.';
	$_SESSION['MemberIMGdir'] = NULL;
      $_SESSION['imgDir'] = NULL;
    $propertySaved = true;
  }
  /*DISPLAY Uploaded IMAGES */
  //Scan dir - gets files from a directory
  //array_diff removes non file indexes (., ..,)
  //array_values re-aranges array idex to start with 0
  if (file_exists($structure)) {
    $dirImages = array_values(array_diff(scandir($structure.'/'), array('..', '.')));
  }

  $uploadedImages="";
  foreach ($dirImages as $value) {
    $uploadedImages = $uploadedImages . '<img class="imgThumbnail" src="'.$structure.'/'.$value.'" alt="uploadedImage" />';
  }



  $imageContainer = '<div class="thumbnailCont">'.$uploadedImages.'</div>';
  $content = file_get_contents('html/uploadImageForm.html') . '<br />' . $imageContainer;
  
?>


<h1>Upload Images</h1>
<?php 

if($propertySaved){
    echo 'Your property has been saved. <a href="index.php">Click here</a> to return to home page.';
    
}else {
   echo $content;  
}


include('template/footer.php');
?>