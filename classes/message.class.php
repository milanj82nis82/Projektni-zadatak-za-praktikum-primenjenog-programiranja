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


class Message extends DbConnect{

    private function checkIsEmailValid($email) {
        
        if( filter_var($email, FILTER_VALIDATE_EMAIL) ){
            return true;
        } else {
            return false;
        }
    
    }// checkIsEmailValid
    private function checkIsFormEmpty($full_name, $subject, $email, $message) {
        
        if( !empty($full_name) || !empty($subject) || !empty($email) || !empty($message) ){
            return true;
        } else {
            return false;
        }
    
    }// checkIsFormEmpty
    public function sendusMessage( $full_name, $subject, $email, $message, $ip_address ){

        if ($this->checkIsEmailValid($email) && $this->checkIsFormEmpty($full_name, $subject, $email, $message)) {
            // Store data in the database
            $created_at = date('Y-m-d H:i:s');
            $updated_at = date('Y-m-d H:i:s');
            $sql = 'INSERT INTO contact_messages (full_name, subject, email, message, ip_address ,
             created_at , updated_at ) 
            VALUES (:full_name, :subject, :email, :message, :ip_address , :created_at , :updated_at)';
            $query = $this -> connect() -> prepare($sql);   
            $query -> bindParam(':full_name', $full_name);
            $query -> bindParam(':subject', $subject);
            $query -> bindParam(':email', $email);
            $query -> bindParam(':message', $message);
            $query -> bindParam(':ip_address', $ip_address);
            $query -> bindParam(':created_at', $created_at);
            $query -> bindParam(':updated_at', $updated_at);
            $query -> execute();       

            // Send user message
            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->isSMTP();
                $mail->Host       = PHPMAILER_HOST;
                $mail->SMTPAuth   = true;
                $mail->Username   = PHPMAILER_USERNAME;
                $mail->Password   = PHPMAILER_PASSWORD;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = PHPMAILER_PORT;

                //Recipients
                $mail->setFrom( $email , $full_name);
                $mail->addAddress(ADMIN_EMAIL , ADMIN_FIRST_NAME . ' ' . ADMIN_LAST_NAME);

                //Content
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body    = $message;

                $mail->send();
                $msg = new \Plasticbrain\FlashMessages\FlashMessages();
                $msg->success('Message has been sent');
                header('Location: contact-us.php');
            } catch (Exception $e) {
                $msg = new \Plasticbrain\FlashMessages\FlashMessages();
                $msg->error('Message could not be sent. Mailer Error: ' . $mail->ErrorInfo);
                
            }
        } else {
            $msg = new \Plasticbrain\FlashMessages\FlashMessages();
            $msg->error('Invalid email or form is empty');
          
        }

    }// sendUsMessage






}// message