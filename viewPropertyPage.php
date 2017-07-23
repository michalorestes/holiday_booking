<?php 
	//include necessary files and declare variables 
	include('template/header.php'); 
	include('functions/dbConnection.php');
	include('functions/imageUploadScript.php'); 
	$db = new dbConnection(); 
	$propertyID = null;
	$p = null;
?>

<?php 
	//load property details 
	if(isset($_GET['propertyID'])){
		$propertyID = $_GET['propertyID'];
		$p = $db->getproperty($propertyID);
	} else {
		header('Location: index.php');
		exit();
	}
?>

<!-- Display property title, rent, type and availability -->
<h1><?php echo $p['Title'] . ' - £' . $p['Rent'] . ' per week' ; ?></h1>
<h4><?php echo $p['Type'] . ', Available from: ' . $p['Available']; ?></h4>

<!-- Load image browser  -->
<h3>Images</h3>
<div id="browseImages">
	<?php include('html/imageBrowser.php') ?>
</div>

<!-- Display addition information about the property -->
<h3>Additional Information</h3>
<ul id="extraInfo">
	<?php echo getExtraInfo($p); ?>
</ul>

<!-- Display decription -->
<h3>Description</h3>
<p id="description"> 
	<?php echo $p['Description']; ?>
</p>

<!-- Display location details and a map -->
<h3>Location</h3>
<h4><?php echo $p['Area'] . ', ' . $p['Address'] . ', <span id="postCode">' . $p['PostCode'].'</span>'; ?></h4>

<div id="map">
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCDPBZBI1hd5wTiLM7MRpj6u51tXDbI55c&amp;region=ES&amp;callback=initMap" async defer></script>
</div>

<!-- Inactive button for booking an appartment -->
<a href="#">Book Property</a>


<?php include('template/footer.php'); ?>

<?php 
//FUNCTIONS

function getExtraInfo($p){
	$content = '<li id="beds">Bedrooms: '.$p['Beds'].'</li>'; 
	$content = $content . '<li id="bathrooms">Bathrooms: '.$p['Bathrooms'].'</li>'; 
	
	if($p['WiFi'] === '1'){
		$content = $content . '<li id="wifi">WiFi Available</li>';
	}
	
	if($p['TV'] === '1'){
		$content = $content . '<li id="tv">TV Available</li>';
	}
	
	if($p['Smoking'] === '1'){
		$content = $content . '<li id="smoking">Smoking Allowed</li>';
	}
	
	if($p['Outdoor'] === '1'){
		$content = $content . '<li id="outdoor">Outdoor Space</li>';
	}
	return $content;
}
?>