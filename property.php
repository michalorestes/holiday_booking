<?php
session_start();
include 'template/memberContent.php';
include 'template/header.php';
include 'functions/HTMLGenerator.php';
include 'functions/dbConnection.php';
require_once 'functions/imageUploadScript.php';
include 'functions/FormValidation.php';
$imgClass = new ImageUpload();
$title = 'Update Property Details';
$propertyData = array();
$dirImages;
$updated = false;  
$imgDeleted = false; 
$imgUploaded = false; 
$serverValidation ='';
$propertyAdded = false; 
$accessDenied = '';
$message ='';


  //Load property details if Property ID is specified
  if (isset($_GET['PropertyID'])) {
    $db = new dbConnection();
    $propertyData = $db->getProperty($_GET['PropertyID']);
    if($propertyData === false){
        $accessDenied = '<p>Property does not exists. Please click <a href="myProperties.php">here</a> to view your properties.</p><br />';
    } else if($propertyData['Member'] === $_SESSION['Member'][0])  {
        $_SESSION['imagesDirTemp'] = $propertyData['Images'];
        $_SESSION['PropertyIDTemp'] = $propertyData['PropertyID'];
    } else {
        $accessDenied = '<p>You may only edit properties that have been created by you. Please click <a href="myProperties.php">here</a> to view your properties.</p><br />';
    }
    
  } else {
          $wifi = (isset($_POST['cb_wifi'])) ? 1 : 0;
    $tv = (isset($_POST['cb_tv'])) ? 1 : 0;
    $smoking = (isset($_POST['cb_smoking'])) ? 1 : 0;
    $outdoor = (isset($_POST['cb_outdoorSpace'])) ? 1 : 0;

    $propertyData = array('Rent' => '',
    'Available' => '2016' . '-' . '01' . '-' . '01', 
    'Type' => '',
    'Area' => '',
    'Address' => '',
    'PostCode' => '',
    'Title' => '',
    'Description' => '',
    'Beds' => '',
    'Bathrooms' => '',
    'WiFi' => $wifi,
    'TV' => $tv,
    'Smoking' => $smoking,
    'Outdoor' => $outdoor,
    'Member' => $_SESSION['Member'][0],
    'Images' => $imgProperty = $_SESSION['Member'][0] . date("YmdHis"));
      
  }

if(isset($_POST['nextBtn'])){
    $wifi = (isset($_POST['cb_wifi'])) ? 1 : 0;
    $tv = (isset($_POST['cb_tv'])) ? 1 : 0;
    $smoking = (isset($_POST['cb_smoking'])) ? 1 : 0;
    $outdoor = (isset($_POST['cb_outdoorSpace'])) ? 1 : 0;

    $propertyData = array('Rent' => $_POST['txt_rent'],
    'Available' => $_POST['txt_dateYear'] . '-' . $_POST['txt_dateMonth'] . '-' . $_POST['txt_dateDay'], 
    'Type' => $_POST['txt_type'],
    'Area' => $_POST['txt_area'],
    'Address' => $_POST['txt_address'],
    'PostCode' => $_POST['txt_location'],
    'Title' => $_POST['txt_title'],
    'Description' => $_POST['txt_description'],
    'Beds' => $_POST['txt_noOfBeds'],
    'Bathrooms' => $_POST['txt_bathrooms'],
    'WiFi' => $wifi,
    'TV' => $tv,
    'Smoking' => $smoking,
    'Outdoor' => $outdoor,
    'Member' => $_SESSION['Member'][0],
    'Images' => $imgProperty = $_SESSION['Member'][0] . date("YmdHis"));
    
        $db = new dbConnection(); 
        $validation = new FormValidation(); 
        $serverValidation = $validation->validatePropertyPost($propertyData);
        if($serverValidation === true){
        
          $db->addProperty($propertyData);        
            //Create folder to store property images
          $structure = 'imgProperty/'. $imgProperty;
          if (!file_exists($structure)) {
            mkdir($structure, 0777, TRUE);
          }
          $_SESSION['propertyForm'] = NULL;
          $_SESSION['imgDir'] = $structure;
          $propertyAdded = true; 
            
        } 


}

  //Fill out the form  upon page refresh (e.g. when uploading or deleting image)
  if (isset($_POST['uploadIMGBtn']) || isset($_POST['deleteImages']) || isset($_POST['updateBtn']) ) {
      
    $wifi = (isset($_POST['cb_wifi'])) ? 1 : 0;
    $tv = (isset($_POST['cb_tv'])) ? 1 : 0;
    $smoking = (isset($_POST['cb_smoking'])) ? 1 : 0;
    $outdoor = (isset($_POST['cb_outdoorSpace'])) ? 1 : 0;

    $propertyData = array('PropertyID' => $_SESSION['PropertyIDTemp'],
    'Rent' => $_POST['txt_rent'],
    'Available' => $_POST['txt_dateYear'] . '-' . $_POST['txt_dateMonth'] . '-' . $_POST['txt_dateDay'], 
    'Type' => $_POST['txt_type'],
    'Area' => $_POST['txt_area'],
    'Address' => $_POST['txt_address'],
    'PostCode' => $_POST['txt_location'],
    'Title' => $_POST['txt_title'],
    'Description' => $_POST['txt_description'],
    'Beds' => $_POST['txt_noOfBeds'],
    'Bathrooms' => $_POST['txt_bathrooms'],
    'WiFi' => $wifi,
    'TV' => $tv,
    'Smoking' => $smoking,
    'Outdoor' => $outdoor,
    'Member' => $_SESSION['Member'][0],
    'Images' => $_SESSION['imagesDirTemp']);
  }

  if (isset($_POST['uploadIMGBtn'])) {
    $imgClass->uploadFile($propertyData['Images']);
      $imgUploaded = true; 
  }

	if (isset($_POST['deleteImages']) && isset($_POST['img'])) {
		$images = $_POST['img'];
		foreach ($images as $value) {
			$imgClass->deleteImage($value);
		}
        $imgDeleted = true; 
	}

	if(isset($_POST['updateBtn'])){
		$db = new dbConnection(); 
        $validation = new FormValidation(); 
        $serverValidation = $validation->validatePropertyPost($propertyData);
        if($serverValidation === true){
          $db->updateProperty($propertyData);
		  $updated = true;
        }

	}
?>

<?php if($serverValidation !== true){ ?>

<p><?php echo $serverValidation; ?></p>

<?php } ?>
<?php if(isset($_GET['PropertyID'])) { ?>
<form id="addProperty" class="centerItems" action="property.php?PropertyID=<?php echo $_GET['PropertyID']; ?>" onsubmit="return validateForm()" method="post" enctype="multipart/form-data">
<?php } else { ?>
<form id="addProperty" class="centerItems" action="property.php" onsubmit="return validateForm()" method="post" enctype="multipart/form-data">
<?php } ?>
	
        <?php if($propertyAdded){ ?>

        <p><em>Your property has been sucessfully saved. Click <a href="uploadImages.php">here</a> to add images to your post. Thank you.</em></p>

        <?php } ?>
        
        <?php if($updated){ ?>

        <p><em>Property details have been sucessfuly updated.</em></p>

        <?php } ?>

        <?php if($imgDeleted){ ?>

        <p><em>Images have been sucessfully deleted</em></p>

        <?php } ?>

        <?php if($imgUploaded){ ?>

        <p><em>Image has been sucessfully uploaded.</em></p>

        <?php } ?>
        
        <!-- check if this property belongs to this member. if it does not, do not allow editing information -->
        <?php if($accessDenied === '') { ?>
		<table>
			<tr>
				<th id="c1"></th>
				<th id="c2"></th>
			</tr>
			<tr>
				<td colspan="2">
					<h3>General Information</h3></td>
			</tr>
			<tr>
				<td>Rent p/w: </td>
				<td>
					<input id="txt_rent" type="text" name="txt_rent" value="<?php echo $propertyData['Rent']; ?>" maxlength="10" /><br /><span class="required"></span> </td>
			</tr>
			<tr>
				<?php
	  	$date = DateTime::createFromFormat("Y-m-d", $propertyData['Available']);
	  ?>
					<td>Alailable From (DD/MM/YYYY): </td>
					<td class="dateInput">
						<input id="txt_Day" type="text" name="txt_dateDay" value="<?php echo $date->format("d"); ?>" maxlength="2" size="2" />
						<input id="txt_Month" type="text" name="txt_dateMonth" value="<?php echo $date->format("m"); ?>" size="2" maxlength="2" />
						<input id="txt_Year" type="text" name="txt_dateYear" value="<?php echo $date->format("Y"); ?>" size="2" maxlength="4" /><span class="required"></span> </td>
			</tr>
			<tr>
				<td>Type: </td>
				<td>
					<select class="" name="txt_type">
						<option <?php echo $s=( $propertyData[ 'Type']==='Villa' )? 'selected="selected"' : ''; ?> >Villa</option>
						<option <?php echo $s=( $propertyData[ 'Type']==='Flat' )? 'selected="selected"' : ''; ?>>Flat</option>
						<option <?php echo $s=( $propertyData[ 'Type']==='Appartment' )? 'selected="selected"' : ''; ?>>Appartment</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Area: </td>
				<td>
					<select name="txt_area">
						<option <?php echo $s=( $propertyData[ 'Area']==='Preston Park' )? 'selected="selected"' : ''; ?>>Preston Park</option>
						<option <?php echo $s=( $propertyData[ 'Area']==='Kemptown' )? 'selected="selected"' : ''; ?>>Kemptown</option>
						<option <?php echo $s=( $propertyData[ 'Area']==='Marina' )? 'selected="selected"' : ''; ?>>Marina</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Address: </td>
				<td>
					<input id="txt_addr" type="text" name="txt_address" value="<?php echo $propertyData['Address']; ?>" /><span class="required"></span> </td>
			</tr>
			<tr>
				<td>Location (PostCode): </td>
				<td>
					<input id="txt_postCode" type="text" name="txt_location" value="<?php echo $propertyData['PostCode']; ?>" /><span class="required"></span> </td>
			</tr>
			<tr>
				<td>Title: </td>
				<td colspan="5">
					<input id="txt_title" type="text" name="txt_title" value="<?php echo $propertyData['Title']; ?>" /><span class="required"></span> </td>
			</tr>
			<tr>
				<td>Description: </td>
				<td colspan="5">
					<textarea id="txt_description" name="txt_description" cols="1" rows="8"><?php echo $propertyData['Description']; ?></textarea><span class="required"></span>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<h3>Facilities</h3> </td>
			</tr>
			<tr>
				<!--FACILITIES SECTION -->
				<td>No of beds:</td>
				<td>
					<select class="" name="txt_noOfBeds">
						<option <?php echo $s=( $propertyData[ 'Beds']==='0' )? 'selected="selected"' : ''; ?> >0</option>
						<option <?php echo $s=( $propertyData[ 'Beds']==='1' )? 'selected="selected"' : ''; ?>>1</option>
						<option <?php echo $s=( $propertyData[ 'Beds']==='2' )? 'selected="selected"' : ''; ?>>2</option>
						<option <?php echo $s=( $propertyData[ 'Beds']==='3' )? 'selected="selected"' : ''; ?>>3</option>
						<option <?php echo $s=( $propertyData[ 'Beds']==='4' )? 'selected="selected"' : ''; ?>>4</option>
						<option <?php echo $s=( $propertyData[ 'Beds']==='5' )? 'selected="selected"' : ''; ?>>5</option>
					</select>
				</td>
			</tr>
			<tr>
				<td> Bathrooms: </td>
				<td>
					<select class="" name="txt_bathrooms">
						<option <?php echo $s=( $propertyData[ 'Bathrooms']==='0' )? 'selected="selected"' : ''; ?> >0</option>
						<option <?php echo $s=( $propertyData[ 'Bathrooms']==='1' )? 'selected="selected"' : ''; ?>>1</option>
						<option <?php echo $s=( $propertyData[ 'Bathrooms']==='2' )? 'selected="selected"' : ''; ?>>2</option>
						<option <?php echo $s=( $propertyData[ 'Bathrooms']==='3' )? 'selected="selected"' : ''; ?>>3</option>
						<option <?php echo $s=( $propertyData[ 'Bathrooms']==='4' )? 'selected="selected"' : ''; ?>>4</option>
						<option <?php echo $s=( $propertyData[ 'Bathrooms']==='5' )? 'selected="selected"' : ''; ?>>5</option>
					</select>
				</td>
			</tr>
			<tr>
				<td> Other: </td>
				<td colspan="1"> <span>
            Wifi: <input type="checkbox" name="cb_wifi" value="" <?php echo $s = ($propertyData['WiFi'] == '1')? 'checked' :''; ?> /> |
            TV: <input type="checkbox" name="cb_tv" value="" <?php echo $s = ($propertyData['TV'] == '1')? 'checked' :''; ?>/> |
            Smoking: <input type="checkbox" name="cb_smoking" value="" <?php echo $s = ($propertyData['Smoking'] == '1')? 'checked' :''; ?> /> |
            Outdoor Space: <input type="checkbox" name="cb_outdoorSpace" value="" <?php echo $s = ($propertyData['Outdoor'] == '1')? 'checked' :''; ?>/>
          </span> </td>
			</tr>
            <?php if(isset($_GET['PropertyID'])) { ?>
			<tr>
				<td colspan="2">
					<h3>Images</h3> </td>
			</tr>
			<tr>
				<td> My Images: </td>
				<td>
					<?php
          				echo $imgClass->displayImages($propertyData['Images']); ?>
						<br />
						<input type="submit" name="deleteImages" value="Delete Selected Images" /> </td>
			</tr>
           
			<tr>
				<td>Upload Images </td>
				<td> Select image to upload:
					<br />
					<br />
					<input type="file" name="userImage" id="userImage" />
					<input type="submit" value="Upload Image" name="uploadIMGBtn" /> </td>
			</tr>
             <?php } ?>
			<tr>
				<td colspan="2">
                    <?php if(isset($_GET['PropertyID'])) { ?>
					<input type="submit" name="updateBtn" value="Update Property Details" /> 
                    <?php } else { ?>
                        <input type="submit" name="nextBtn" value="Next" /> 
                    <?php } ?>
                </td>
			</tr>
		</table>
        <?php } else {
            echo $accessDenied;
        } ?>
        
        
	</form>
	<?php include 'template/footer.php'; ?>
		