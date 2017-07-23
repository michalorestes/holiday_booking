<?php session_start();
include 'template/memberContent.php';
$title = 'My Properties';
include 'functions/dbConnection.php';
include 'functions/HTMLGenerator.php';
$db = new dbConnection();
$html = new HTMLGenerator();

if(isset($_GET['imgDir'])){
    $db->deleteProperty($_GET['PropertyID'], $_GET['imgDir']);
}


$propertiesData = $db->getMemberProperties($_SESSION['Member'][0]);
$propertiesContainer = $html->generateProperties($propertiesData, TRUE);
$content = $propertiesContainer;

?>
<?php include('template/header.php') ?>
<h1>My Properties</h1>
<?php echo $content; ?>


<?php include('template/footer.php');