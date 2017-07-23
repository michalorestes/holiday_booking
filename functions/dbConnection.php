<?php
class dbConnection
{
	private $servername = "mysql.cms.gre.ac.uk";
	private $username = "dm313";
	private $password = "Gr33nwich";
	private $dbname = "dm313";
    public $conn = NULL;
	public $limit = 5; 
	public $pages; 

	public function __construct()
	{
		$this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
	}

    public function addMember($username, $email, $contact, $password, $code)
		{
      //  $conn = $this->connectToServer();
		$Tools = new Tools();
        $pass = $Tools->encryptPassword($password);
        $query = "INSERT INTO members (MemberID, Username, Email, Password, Activated, Contact, ActivationCode) VALUES (NULL, '$username', '$email', '$pass', FALSE, $contact, '$code')";

        if ($this->conn->query($query) === TRUE)
		{
          return "New record created successfully";
        } else {
            //return "<br />Error:<br>" . $conn->error;
			return '<br /> Error: <br /> ' . $username . ' is already registered. Please choose a different username';
        }
			return "ERROR";
    }

    public function getLoginData($username)
		{
        //$conn = $this->connectToServer();
        $query = 'SELECT * FROM members WHERE Username= "' . $username . '"';
        $result = $this->conn->query($query);
        $userData = array();

        if ($result->num_rows > 0)
		{
            // output data of each row
            while($row = $result->fetch_assoc())
			{
                //username
                $userData[] = $row['MemberID'];         //0
                $userData[] = $row['Username'];         //1
                $userData[] = $row['Email'];            //2
                $userData[] = $row['Password'];         //3
                $userData[] = $row['Activated'];        //4
                $userData[] = $row['Contact'];          //5
                $userData[] = $row['ActivationCode'];   //6
            }
        }
		else
		{
            $userData[] = 'User not found';
        }
        return $userData;
    }

	public function activateAccount($userName){
		//$conn = $this->connectToServer();

		$query = "UPDATE members SET Activated=TRUE WHERE Username='$userName'";
		if ($this->conn->query($query) === TRUE)
		{
		}
		else
		{
			//return "<br />Error:<br>" . $conn->error;
			//	return '<br /> Error: <br /> ' . $username . ' is already registered. Please choose a different username <br />';
		}
	}

	public function addProperty($propertyData){

		$querry = 'INSERT INTO properties VALUES(NULL, '. $propertyData['Rent'] .', STR_TO_DATE("'. $propertyData['Available'] .'", "%Y-%m-%d"),"' . $propertyData['Type'] .'", "'. $propertyData['Area'] .'", "'. $propertyData['Address'] .'", "'. 
		$propertyData['PostCode'] .'",' .'"'. $propertyData['Title'] .'", "'. $propertyData['Description'] .'",' . $propertyData['Beds'] .','.$propertyData['Bathrooms'].','.$propertyData['WiFi'].','.$propertyData['TV'].','.$propertyData['Smoking'].','.$propertyData['Outdoor'].', '. $propertyData['Member'] .', "imgProperty/'. $propertyData['Images'].'");';
		
		if ($this->conn->query($querry)) {
			return TRUE;
		} else {
			//error message 
		}
	}
	
	public function getMemberProperties($member){
		$query = 'SELECT * FROM properties WHERE Member='.$member. ' ORDER BY PropertyID DESC';
		$result = $this->conn->query($query);
		if ($result->num_rows > 0)
		{
			$properties = array();
			while($row = $result->fetch_assoc())
			{
				array_push($properties, array(
				'PropertyID' => $row['PropertyID'],
				'Rent' => $row['Rent'],
				'Available' => $row['Available'],
				'Type' => $row['Type'],
				'Area' => $row['Area'],
				'Address' => $row['Address'],
				'PostCode' => $row['PostCode'],
				'Title' => $row['Title'],
				'Description' => $row['Description'],
				'Beds' => $row['Beds'],
				'Bathrooms' => $row['Bathrooms'],
				'Wifi' => $row['WiFi'],
				'TV' => $row['TV'],
				'Smoking' => $row['Smoking'],
				'Outdoor' => $row['Outdoor'],
				'Member' => $row['Member'],
				'Images' => $row['Images']
				));
			}

			return $properties;
		}
	}

	public function getAllProperties($page){
		return $this->pagenation('SELECT * FROM properties ORDER BY PropertyID DESC', $page);
	}

	public function getProperty($propertyID){
		$query = 'SELECT * FROM properties WHERE PropertyID='.$propertyID;
		$result = $this->conn->query($query);
		if ($result->num_rows > 0)
		{
			 $properties = array();
				while($row = $result->fetch_assoc())
				{
					$properties = array('PropertyID' => $row['PropertyID'],
					'Rent' => $row['Rent'],
					'Available' => $row['Available'],
					'Type' => $row['Type'],
					'Area' => $row['Area'],
					'Address' => $row['Address'],
					'PostCode' => $row['PostCode'],
					'Title' => $row['Title'],
					'Description' => $row['Description'],
					'Beds' => $row['Beds'],
					'Bathrooms' => $row['Bathrooms'],
					'WiFi' => $row['WiFi'],
					'TV' => $row['TV'],
					'Smoking' => $row['Smoking'],
					'Outdoor' => $row['Outdoor'],
					'Member' => $row['Member'],
					'Images' => $row['Images']);
				}
				
			return $properties;
		} else {
            return false;
        }
	}

	public function updateProperty($propertyData){
		$query = 'UPDATE properties SET Rent=' . $propertyData['Rent'] . ', Available=STR_TO_DATE("'. $propertyData['Available'] .'", "%Y-%m-%d"), Type="'.$propertyData['Type'].'", Area="'.$propertyData['Area'].'", Address="'.$propertyData['Address'].'", PostCode="'.$propertyData['PostCode'].'", Title="'.$propertyData['Title'].'", Description="'.$propertyData['Description'].'", Beds='.$propertyData['Beds'].', Bathrooms='.$propertyData['Bathrooms'].', WiFi='.$propertyData['WiFi'].', TV='.$propertyData['TV'].', Smoking='.$propertyData['Smoking'].', Outdoor='.$propertyData['Outdoor'].' WHERE PropertyID='.$propertyData['PropertyID'].';';

		if ($this->conn->query($query) === TRUE)
		{
			
		}
		else
		{
			//error message 
		}
	}
	
	public function deleteProperty($propertyID, $imgDir){
		$query = 'DELETE FROM properties WHERE PropertyID=' . $propertyID;
		
		if ($this->conn->query($query) === TRUE)
		{
			$this->recursiveRemove($imgDir);
		}
		else
		{
			// error message echo $this->conn->error;
		}
	}

	public function searchProperties($searchQuery, $page){
		$searchQuery = preg_replace('#^0-9a-z#i','',$searchQuery);
		$query = 'SELECT * FROM properties WHERE Type LIKE "%'.$searchQuery.'%" OR Area LIKE "%'.$searchQuery.'%" OR Address LIKE "%'.$searchQuery.'%" OR Title LIKE'.
			'"%'.$searchQuery.'%" OR Description LIKE "%'.$searchQuery.'%" OR Rent LIKE "%'.$searchQuery.'%"';
		
		return $this->pagenation($query, $page);
	}
	
	public function getFilterProperties($area, $type, $beds, $page){
		$flag = false; 
		if($area !== ''){
			$area = 'WHERE Area="'.$area.'"';
			$flag = true; 
		}
		if($type !== ''){
			$type = ($flag) ? ' AND Type="'.$type.'"' : 'WHERE Type="'.$type.'"';
			$flag = true;
		}
		if($beds !== ''){
			$beds = ($flag) ? ' AND Beds="'.$beds.'"' : 'WHERE Beds="'.$beds.'"';
			$flag = true;
		}
		
		$query = 'SELECT * FROM properties ' . $area . $type . $beds ;
		return $this->pagenation($query, $page);
	}
	
	private function pagenation($baseQuery, $page){

		$result = $this->conn->query($baseQuery);
		$myRows = 0; 

		if($result->num_rows > 0){
			$myRows = $result->num_rows;
		}
		
		$offset = ($this->limit * $page) - $this->limit; 
		
		$this->pages = $this->calculatePages($myRows);
		$limitQuery = ' LIMIT '.$offset.','.$this->limit;
		$query = $baseQuery . $limitQuery;
		$result = $this->conn->query($query);
		
		
		if ($result->num_rows > 0)
		{
			 $properties = array();
				while($row = $result->fetch_assoc())
				{
					array_push($properties, array(
						'PropertyID' => $row['PropertyID'],
						'Rent' => $row['Rent'],
						'Available' => $row['Available'],
						'Type' => $row['Type'],
						'Area' => $row['Area'],
						'Address' => $row['Address'],
						'PostCode' => $row['PostCode'],
						'Title' => $row['Title'],
						'Description' => $row['Description'],
						'Beds' => $row['Beds'],
						'Bathrooms' => $row['Bathrooms'],
						'Wifi' => $row['WiFi'],
						'TV' => $row['TV'],
						'Smoking' => $row['Smoking'],
						'Outdoor' => $row['Outdoor'],
						'Member' => $row['Member'],
						'Images' => $row['Images']
					));
				}
				return $properties;
		}
	}
	
	public function calculatePages($rows){
		return ceil($rows / $this->limit);
	}
    
    public function recursiveRemove($dir) {
    $structure = glob(rtrim($dir, "/").'/*');
    if (is_array($structure)) {
        foreach($structure as $file) {
            if (is_dir($file)) recursiveRemove($file);
            elseif (is_file($file)) unlink($file);
        }
    }
    rmdir($dir);
}
}
?>