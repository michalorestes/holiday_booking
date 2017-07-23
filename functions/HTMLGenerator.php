<?php
  /**
   * This class is responsibile for generating html container that require multiple iterations 
   */
  class HTMLGenerator
  {
	// Generate a html containers containing information about published properties 
	//Requires a matrix array containing details about the properties and a 
	//boolean variable indicating wheter the content is generated for member or standard visitor 
    public function generateProperties($data, $member){
        $container = NULL;
        $updateLink = '';
        $deleteLink = '';
     
        if(count($data) === 0){
            $container = '<h2>No Properties available</h2>';
        }
        
        for ($i=0; $i < count($data) ; $i++) {
            if ($member == TRUE && $data[$i]['Member'] === $_SESSION['Member'][0]) {
                $updateLink = '<li><a class="btn" href="property.php?PropertyID='.$data[$i]['PropertyID'].';">Update</a></li>';
                $deleteLink = '<li><a class="btn" href="myProperties.php?PropertyID='.$data[$i]['PropertyID'].'&amp;imgDir='.$data[$i]['Images'].'">Delete</a></li>';
            }
            $container = $container . '<div class="propertyItem">
              <ul class="info floatRight">
                <li>Rent:</li>
                <li><b>£'.$data[$i]['Rent'].'</b></li>
                <li>Area:</li>
                <li><b>'.$data[$i]['Area'].'</b></li>
                <li>Bedrooms:</li>
                <li><b>'.$data[$i]['Beds'].'</b></li>
                <li>Type:</li>
                <li><b>'.$data[$i]['Type'].'</b></li>
              </ul>
              <img class="floatLeft" src="'.$this->getFrontImage($data[$i]['Images']).'" alt="propertyThumbnail" />
              <h3>'.$data[$i]['Title'].'</h3>
              <p>
                '.substr($data[$i]['Description'], 0,200).'
              </p>
              <ul class="btnPos floatRight">
              ' . $updateLink . $deleteLink. '
                <li><a class="btn" href="viewPropertyPage.php?propertyID='.$data[$i]['PropertyID'].';">View Property</a></li>
              </ul>
            </div>';
          }
        
        
        
      return $container;
    }
	 
	//Method for choosing a default thumbnail image
	//Requires directory of the location where property images are stored as a argument 
	//returns path to thumbnail image 
    private function getFrontImage($baseDir){
      $dir =null;
	//if directory exists and contains images, chose the first image from the array 
      if (file_exists($baseDir) && count($baseDir) > 0) {
        $img = array_values(array_diff(scandir($baseDir), array('..', '.')));
        $img = (count($img) > 0) ? $baseDir .'/'. $img[0] : 'img/houseIcon.png';
      } else {
		//set default image if no images are found 
        $img = 'img/houseIcon.png';
      }
      return $img;
    }
	  
	
	//Return pagenation pages links
	//Requires an integer of the number of pages 
	public function getPagesLinks($pages){
		$outpu ='';
		for($i = 1; $i <= $pages; $i++){
			$class = ' '; 
			if((isset($_GET['page']) && $_GET['page'] == $i) || !isset($_GET['page']) && $i == 1) {
				$class = 'class="currentPage"';
			} 
			$outpu = $outpu . '<a '.$class .' href="index.php?page='.$i.';">'.$i.'</a> | ';
		}
		return $outpu;
	}

  }

 ?>