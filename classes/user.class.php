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
    $mail->Body    = 'Please click on <a href="http://localhost/zadaci/activate.php?token='.$token.'">link to activate</a> your account';
    $mail->AltBody = 'Please click on <a href="http://localhost/zadaci/activate.php?token='.$token.'">link to activate</a> your account';

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

public function userActivation(){
    $token = $_GET['token'];
    $sql = 'SELECT * FROM users WHERE token = :token';
    $query = $this -> connect() -> prepare($sql);
    $query -> bindParam(':token', $token);
    $query -> execute();
    $result = $query -> fetch();
    
        $sql = 'update users set is_active = ? where token = ? limit 1 ';
        $query = $this -> connect() -> prepare($sql);
        $query -> execute([ 1 , $token ]);
        $msg = new \Plasticbrain\FlashMessages\FlashMessages();
        $msg -> success('Account activated');
        header('Refresh:5;URL=login.php');
  
}// userActivation


public function userLogin( string $email , string $password ){

    if ($this->validateEmailAddress($email)) {
        $sql = 'SELECT * FROM users WHERE email = :email';
        $query = $this->connect()->prepare($sql);
        $query->bindParam(':email', $email);
        $query->execute();
        $user = $query->fetch();

        if ($user && password_verify($password, $user['password'])) {
            if ($user['is_active'] == 1) {
                session_start();
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                    'phone' => $user['phone'],
                    'state' => $user['state'],
                    'city' => $user['city'],
                    'postal_code' => $user['postal_code'],
                    'address' => $user['address'],
                    'birth_date' => $user['birth_date']
                ];
                //$_SESSION['user'] = $user;
                $msg = new \Plasticbrain\FlashMessages\FlashMessages();
                $msg->success('Login successful');
                header('Location: index.php');
            } else {
                $msg = new \Plasticbrain\FlashMessages\FlashMessages();
                $msg->error('Account is not activated. Please check your email.');
            }
        } else {
            $msg = new \Plasticbrain\FlashMessages\FlashMessages();
            $msg->error('Invalid email or password.');
        }
    } else {
        $msg = new \Plasticbrain\FlashMessages\FlashMessages();
        $msg->error('Invalid email format.');
    }
    


}// userLogin
public function checkIsUserLogedIn(){

    session_start();
    if (isset($_SESSION['user'])) {
        return true;
    } else {
        return false;
    }

}// checkIsUserLogedIn

public function userLogout(){
    session_start();
    session_destroy();
    header('Location: login.php');
}// userLogout

public function passwordReset($email){

    if ($this->validateEmailAddress($email)) {
        $sql = 'SELECT * FROM users WHERE email = :email';
        $query = $this->connect()->prepare($sql);
        $query->bindParam(':email', $email);
        $query->execute();
        $user = $query->fetch();

        if ($user) {
            // Code to handle password reset process
            $token = bin2hex(random_bytes(50));
            $sql = 'UPDATE users SET reset_token = :token, reset_token_expiry = DATE_ADD(NOW(), INTERVAL 30 MINUTE) WHERE email = :email';
            $query = $this->connect()->prepare($sql);
            $query->bindParam(':token', $token);
            $query->bindParam(':email', $email);
            $query->execute();

            // Send reset email
            try {
                $mail = new PHPMailer();
                $mail->isSMTP();
                $mail->Host = PHPMAILER_HOST;
                $mail->SMTPAuth = true;
                $mail->Port = PHPMAILER_PORT;
                $mail->Username = PHPMAILER_USERNAME;
                $mail->Password = PHPMAILER_PASSWORD;

                $mail->setFrom(ADMIN_EMAIL, ADMIN_FIRST_NAME . ' ' . ADMIN_LAST_NAME);
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Password Reset';
                $mail->Body = 'Please click on <a href="http://localhost/zadaci/reset-password.php?token=' . $token . '">this link</a> to reset your password.';
                $mail->AltBody = 'Please click on the following link to reset your password: http://localhost/zadaci/reset-password.php?token=' . $token;

                $mail->send();
                $msg = new \Plasticbrain\FlashMessages\FlashMessages();
                $msg->success('Password reset email has been sent.');
            } catch (Exception $e) {
                $msg = new \Plasticbrain\FlashMessages\FlashMessages();
                $msg->error('Password reset email could not be sent. ' . $mail->ErrorInfo);
            }
        } else {
            $msg = new \Plasticbrain\FlashMessages\FlashMessages();
            $msg->error('Email does not exist.');
        }
    } else {
        $msg = new \Plasticbrain\FlashMessages\FlashMessages();
        $msg->error('Invalid email format.');
    }
    

}// passwordReset


public function resetPassword($email, $password, $passwordVerify, $token) {
    if ( $this->validateEmailAddress($email)) {
        if ( !$this->checkIfEmailExists($email)) {
            if ($this->checkIfPasswordSame($password, $passwordVerify)) {
                if ($this->checkIsPasswordStrong($password)) {
                    $sql = 'SELECT * FROM users WHERE email = :email AND reset_token = :token AND reset_token_expiry > NOW()';
                    $query = $this->connect()->prepare($sql);
                    $query->bindParam(':email', $email);
                    $query->bindParam(':token', $token);
                    $query->execute();
                    $user = $query->fetch();

                    if ($user) {
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                        $sql = 'UPDATE users SET password = :password, reset_token = NULL, reset_token_expiry = NULL WHERE email = :email';
                        $query = $this->connect()->prepare($sql);
                        $query->bindParam(':password', $hashedPassword);
                        $query->bindParam(':email', $email);
                        $query->execute();

                        $msg = new \Plasticbrain\FlashMessages\FlashMessages();
                        $msg->success('Password has been reset successfully.');
                    } else {
                        $msg = new \Plasticbrain\FlashMessages\FlashMessages();
                        $msg->error('Invalid or expired token.');
                    }
                } else {
                    $msg = new \Plasticbrain\FlashMessages\FlashMessages();
                    $msg->error('Password is not strong enough.');
                }
            } else {
                $msg = new \Plasticbrain\FlashMessages\FlashMessages();
                $msg->error('Passwords do not match.');
            }
        } else {
            $msg = new \Plasticbrain\FlashMessages\FlashMessages();
            $msg->error('Email does not exist.');
        }
    } else {
        $msg = new \Plasticbrain\FlashMessages\FlashMessages();
        $msg->error('Invalid email format.');
    }

    

}// resetPassword










}// User
