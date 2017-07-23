<?php
	//REQUIRES DB CONNECTION AND PROPERTY DATA TO BE SET UP IN CALLING FILE!
	$imgClass = new ImageUpload();
    if(file_exists($p['Images'].'/')){
       $dirImages = array_values(array_diff(scandir($p['Images'].'/'), array('..', '.')));
	   $img = (count($dirImages) > 0) ? $p['Images'].'/'.$dirImages[0] : 'img/houseIcon.png';
    } else {
        $img = 'img/houseIcon.png';
    }
	

	//get image to be displayed 
	if(isset($_GET['img'])){
		$imgName = $_GET['img'];
		$img = $p['Images'] .'/'. $imgName;
	} elseif(true){
		
	}
?>

	<img src="<?php echo $img; ?>" width="100%" height="500px" alt="propertyImage" />

<?php
	echo $imgClass->displayThumbnails($p['Images'], $propertyID);
	
?>