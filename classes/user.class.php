<?php
namespace classes;
use Include\DbConnect;
require_once 'include/phpSessionMessages/src/FlashMessages.php';
require_once 'include/phpmailer/src/PHPMailer.php';
require_once 'include/phpmailer/src/SMTP.php';
require_once 'include/phpmailer/src/Exception.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class User extends DbConnect{

 
    private function validateEmailAddress($email){
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
       
    }// validateEmailAddress

    private function checkIfEmailExists($email){

        $sql = "SELECT email FROM users WHERE email = :email";
        $stmt = $this -> connect() -> prepare($sql);
        $stmt -> bindParam(':email', $email);
        $stmt -> execute();
        $result = $stmt -> fetch();
        if( $result == 0 ){
            return true;
        } else {
            return false;
        }

    }// checkIfEmailExists

    private function checkIfPasswordSame($password , $password_repeat){
        if($password == $password_repeat){
            return true;
        } else {
            return false;
        }
    }// checkIfPasswordSame
    private function checkIsPasswordStrong($password){
        if (strlen($password) < 8) {
            return false;
        }

        if (!preg_match('/[A-Z]/', $password)) {
            return false;
        }

        if (!preg_match('/[a-z]/', $password)) {
            return false;
        }

        if (!preg_match('/[0-9]/', $password)) {
            return false;
        }

        if (!preg_match('/[\W]/', $password)) {
            return false;
        }

        return true;
    }// checkIsPasswordStrong

    private function checkIsRegisterFormEmtpy( $first_name , $last_name , $username , $password , $password_repeat , 
    $gender , $state , $city , $postal_code , $birth_date , $address , $phone , $email ){
        
        if( !empty($first_name) OR !empty($last_name) OR !empty($username) OR !empty($password) OR 
        !empty($password_repeat) OR !empty($gender) OR  !empty($state) OR !empty($city) OR 
        !empty($postal_code) OR !empty($birth_date) OR !empty($address)OR !empty($phone) OR !empty($email) ){
            return true;
        } else {
            return false;
        }

    }// checkIsRegisterFormEmtpy

private function checkIsPhoneUnique($phone){
    $sql = "SELECT phone FROM users WHERE phone = :phone";
    $stmt = $this -> connect() -> prepare($sql);
    $stmt -> bindParam(':phone', $phone);
    $stmt -> execute();
    $result = $stmt -> fetch();
    if( $result == 0 ){
        return true;
    } else {
        return false;
    }
}// checkIsPhoneUnique

public function submitRegistration( $first_name , $last_name , $username , $password , $password_repeat , 
$gender , $state , $city , $postal_code , $birth_date , $address , $phone , $email){
if( $this -> checkIsRegisterFormEmtpy(  $first_name , $last_name , $username , $password , $password_repeat , 
$gender , $state , $city , $postal_code , $birth_date , $address , $phone , $email )){
if( $this -> checkIfEmailExists($email)){
if( $this -> checkIfPasswordSame($password , $password_repeat)){
if( $this -> checkIsPasswordStrong($password)){
if( $this -> checkIsPhoneUnique($phone)){

    $created_at = date('Y-m-d H:i:s');
    $updated_at = date('Y-m-d H:i:s');
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $token = bin2hex(random_bytes(50));
    
    $sql = 'insert into users( username , first_name , last_name , password , email , phone , state , city
    , postal_code , address , token , birth_date , created_at , updated_at ) values
    (  :username , :first_name , :last_name , :password , :email , :phone , :state , :city
    , :postal_code , :address , :token , :birth_date , :created_at , :updated_at )';
    $query = $this -> connect() -> prepare($sql);
    $query -> bindParam(':username', $username);
    $query -> bindParam(':first_name', $first_name);
    $query -> bindParam(':last_name', $last_name);
    $query -> bindParam(':password', $hashedPassword);
    $query -> bindParam(':email', $email);
    $query -> bindParam(':phone', $phone);
    $query -> bindParam(':state', $state);
    $query -> bindParam(':city', $city);
    $query -> bindParam(':postal_code', $postal_code);
    $query -> bindParam(':address', $address);
    $query -> bindParam(':token', $token);
    $query -> bindParam(':birth_date', $birth_date);
    $query -> bindParam(':created_at', $created_at);
    $query -> bindParam(':updated_at', $updated_at);
    $query -> execute();


try {
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = PHPMAILER_HOST;
    $mail->SMTPAuth = true;
    $mail->Port = PHPMAILER_PORT;
    $mail->Username =  PHPMAILER_USERNAME;
    $mail->Password =  PHPMAILER_PASSWORD;                                  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom( ADMIN_EMAIL, ADMIN_FIRST_NAME . ' ' . ADMIN_LAST_NAME);
    $mail->addAddress( $email , $first_name . ' ' . $last_name );     //Add a recipient


    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'User Registration';
    $mail->Body    = 'Please click on <a href="http://localhost/zadaci/activate.php?'.$token.'">link to activate</a> your account';
    $mail->AltBody = 'Please click on <a href="http://localhost/zadaci/activate.php?'.$token.'">link to activate</a> your account';

    $mail->send();
    $msg = new \Plasticbrain\FlashMessages\FlashMessages();
    $msg -> success('Message has been sent');
    header('Location:register.php');
} catch (Exception $e) {
    $msg = new \Plasticbrain\FlashMessages\FlashMessages();
    $msg -> success('Message could not be sent ' . $mail->ErrorInfo);
    
}
   


} else {
    $msg = new \Plasticbrain\FlashMessages\FlashMessages();
    $msg -> error('Phone number already exists.');
}// checkIsPhoneUnique

} else {

    $msg = new \Plasticbrain\FlashMessages\FlashMessages();
    $msg -> error('Password is not strong enough.');

    
}// checkIsPasswordStrong

} else {
    $msg = new \Plasticbrain\FlashMessages\FlashMessages();
    $msg -> error('Passwords do not match.');
}// checkIfPasswordSame
} else {
    $msg = new \Plasticbrain\FlashMessages\FlashMessages();
    $msg -> error('Email already exists');
}// checkISemailExists

} else {
    $msg = new \Plasticbrain\FlashMessages\FlashMessages();
    $msg -> error('Please fill in all required fields.');

}// cgheckIsRegisterFormEmtpy

}// submitRegistration





















}// User
