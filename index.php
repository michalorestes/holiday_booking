<?php
    include 'template/header.php';
	include 'functions/dbConnection.php';
	include 'functions/HTMLGenerator.php';
	$propertiesData = array();
	$db = new dbConnection();
	$html = new HTMLGenerator();

	if(isset($_GET['btnSearch'])){
		$searchQuery = $_GET['txtSearch'];
		$propertiesData = $db->searchProperties($searchQuery, (isset($_GET['page'])) ? $_GET['page'] : 1);
		
	} else if(isset($_GET['filterResults'])){
		$area = $type = $beds = '';
		if(isset($_GET['radioArea'])) {
			$area = $_GET['radioArea']; 
		}
		if(isset($_GET['radioType'])) {
			$type = $_GET['radioType']; 
		}
		if(isset($_GET['radioBeds'])) {
			$beds = $_GET['radioBeds']; 
		}

		$propertiesData = $db->getFilterProperties($area, $type, $beds, (isset($_GET['page'])) ? $_GET['page'] : 1);	
		
	} else {
		$propertiesData = $db->getAllProperties((isset($_GET['page'])) ? $_GET['page'] : 1);	
	}
?>
	<div id="propertiesContent" class="floatRight">
		<?php

		echo $title ='<h1>Latest Properties</h1>';
		$propertiesContainer = $html->generateProperties($propertiesData, FALSE);
		echo $propertiesContainer;
		?>

		<div id="pages">
			<?php echo $html->getPagesLinks($db->pages); ?>
		</div>
	</div>

<div id="sideBar" class="floatLeft">
<?php include 'template/sidebar.php'; ?>
</div>

<?php include 'template/footer.php'; ?>