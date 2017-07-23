<?php
//Form validation for member's registration form 
	class FormValidation {
		
		//used for returning the final message informing 
		//the user about all errors
		public $results;

		public function validateRegistration($name, $email, $contact, $password1, $password2){
			//array where all errors are stored in
			$errors_ = array();
			//check if name if in correct format 
			if(empty($name)){
				$errors_[] = 'Missing name';
			} else {
				if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
					$errors_[] = "Only letters and white space allowed in name";
				}
			}
			//validate email 
			if(empty($email)){
				$errors_[] = 'Missing email';
			} else {
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$errors_[] = "Invalid email format";
				}
			}
			//validate phone number 
			//must contain 11 numbers 
			if(empty($contact)){
				$errors_[] = 'Contact number missin';
			} else {
				 if(!preg_match('/^[0-9]{11}$/', $_POST['txt_contact'])){
					  $errors_[] = 'Invalid Contact Number!';
				}
			}
			//check if provided password match 
			if(empty($password1) || empty($_POST['txt_password2'])){
				$errors_[] = 'Missing password field';
			} else {
				$pass1 = $_POST['txt_password1'];
				$pass2 = $_POST['txt_password2'];
				if(strcasecmp($pass1, $pass2) != 0){
					$errors_[] = 'No match!';
				}
			}
			if(empty($password2)){
				$errors[] = 'Password2';
			} 
			
			//Check if terms and contidions have been accepted 
			if(!isset($_POST['chk_terms'])){
				$errors_[] = 'You need to accept our terms and conditions';
			}
			//return NULL if no errors
			//return list of errors 
			if(empty($errors_)){
				$this->results = NULL;
			} else {
				$this->results = $errors_;
			}
			return $this->results;
		}
        
        public function validatePropertyPost($propertyData){
            $errors = false; 
            $message = '';
            if(count($propertyData) > 0){
                foreach($propertyData as $key=> $value){
                    if(trim($value) == ''){
                        $message = 'Required field is missing. <br />'; 
                        $errors = true; 
                    }
                    $pattern = '/[`~<>;\':"\/\[\]\|{}()=_+]/';
                    if(preg_match($pattern, $value) == true && $key !== 'Images'){
                        echo $value;
                        $message = 'Your input contains illegal special characters <br />';
                        $errors = true; 
                    }
                    
                    if($key === 'Rent'){
                        if(!is_numeric($value)){
                                $message = 'Rent field may only contain numbers';
                                $errors = true;
                            }
                    }
                   
                }
                
                if($errors){
                    return $message; 
                } else {
                    return true; 
                }
            }
        }

	}
?>