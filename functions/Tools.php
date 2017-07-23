<?php
  class Tools
  {
    public function encryptPassword($password) {
        return crypt($password,'st');
    }

    public function activationCode() {
        $charString = '1234567890qQwWeErRtTyYuUiIoOpPaAsSdDfFgGhHjJkKlLzZxXcCvVbBnNmM'; //62 items
        $activationCode = '';

        for($i = 0; $i < 5; $i++){
            $activationCode = $activationCode . substr($charString, rand(0,61), 1);
        }
        return $activationCode;
    }

    public function activationEmail($email, $code) {
        $to = $email;
        $subject = 'Brighton Holiday account activation ';
        $txt = "Your activation key is: " . $code;
        $headers = "From: noreply@brightonholiday.com";
        mail($to,$subject,$txt,$headers);
    }

    public function verifyPassword($username, $password){
      include 'dbConnection.php';
      $dbConnection = new dbConnection();
      $userData = $dbConnection->getLoginData($username);
      if (count($userData) <= 1) {
        return NULL;
      }
      if (password_verify($password, $userData[3])) {
        return $userData;
      } else {
        return NULL;
      }
    }






  }
 ?>