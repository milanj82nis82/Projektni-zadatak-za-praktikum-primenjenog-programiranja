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
    public function sendusMessage( $full_name, $subject, $email, $message ){

        



    }// sendUsMessage






}// message