<?php
//CODE ADAPTED FROM 
//http://www.w3schools.com/php/php_file_upload.asp

  class ImageUpload
  {
    private $target_dir;
    private $target_file;
    private $fileName;
    private $fileSize;
    private $fileType;
    private $tempDir;
    private $upload;

   

    function getData(){
      return $this->fileName . '<br />' . $this->fileSize . '<br /> File type: ' . $this->fileType . '<br />' . $this->tempDir . 'HI';
    }

    function fileExists(){
      // Check if file already exists
      if (file_exists($this->target_file)) {
          $this->upload = FALSE;
          $_SESSION['message'] = 'file exists';
      }
    }

    function validateFileSize(){
          // Check file size
      if ($this->fileSize > 5000000) {
         $this->upload = FALSE;
         $_SESSION['message'] = 'image too large';
      }
    }

    function limitFileType(){
      // Allow certain file formats
      if($this->fileType != "image/jpg" && $this->fileType != "image/png" && $this->fileType != "image/jpeg"
      && $this->fileType != "image/gif" ) {
        $this->upload = FALSE;
        $_SESSION['message'] = 'wrong file format';
      }
    }

    function uploadFile($target){
      $this->target_dir = $target.'/';
      $this->target_file = $this->target_dir . basename($_FILES["userImage"]["name"]);
      $this->fileName = $_FILES['userImage']['name'];
      $this->fileSize = $_FILES['userImage']['size'];
      $this->fileType = $_FILES['userImage']['type'];
      $this->tempDir = $_FILES['userImage']['tmp_name'];
      $this->upload = TRUE;

      $this->fileExists();
      $this->validateFileSize();
      $this->limitFileType();


      // Check if $uploadOk is set to 0 by an error
      if ($this->upload == FALSE) {
          $_SESSION['message'] = 'File could not be uploaded';
      // if everything is ok, try to upload file
      } else {
          if (move_uploaded_file($this->tempDir, $this->target_file)) {
              $_SESSION['message'] = 'File has been uploaded.';
          } else {
              $_SESSION['message'] = "Error occured while uploading your file";
          }
      }
    }
	  
	 public function displayImages($structure){
		$dirImages = array();
		/*DISPLAY UPLOAED IMAGES */
		//Scan dir - gets files from a directory
		//array_diff removes non file indexes (., ..,)
		//array_values re-aranges array idex to start with 0
		if (file_exists($structure)) {
		  $dirImages = array_values(array_diff(scandir($structure.'/'), array('..', '.')));
		}

		$uploadedImages="";
		foreach ($dirImages as $value) {
		  $uploadedImages = $uploadedImages .
			' <div class="testing"><img class="imgThumbnail" src="'.$structure.'/'.$value.'" alt="imageThumbnail" /><span><input type="checkbox" name="img[]" value="'.$structure.'/'.$value.'"/></span></div> ';
		}
		echo $imageContainer = '<div class="thumbnailCont">'.$uploadedImages.'</div>';
	  }
	  
	  //Display list of thumbnails with selection checkbox 
	  public function displayThumbnails($structure, $propertyID){
		$dirImages = array();
		/*DISPLAY UPLOAED IMAGES */
		//Scan dir - gets files from a directory
		//array_diff removes non file indexes (., ..,)
		//array_values re-aranges array idex to start with 0
		if (file_exists($structure)) {
		  $dirImages = array_values(array_diff(scandir($structure.'/'), array('..', '.')));
		}

		$uploadedImages="";
		foreach ($dirImages as $value) {
		  $uploadedImages = $uploadedImages .
			'<a href="viewPropertyPage.php?propertyID='.$propertyID.'&amp;img='.$value.'"><img class="imgThumbnail" src="'.$structure.'/'.$value.'" alt="imageThumbnail" /></a>';
		}
		return $imageContainer = '<div class="thumbnailCont">'.$uploadedImages.'</div>';
	  }
      
      public function deleteImage($img){
          if(file_exists($img)){
              unlink($img);
          }
          
      }
      
      
  }

?>