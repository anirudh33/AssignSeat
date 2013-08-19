<?php
/**
 * **************************** Creation Log *******************************
 * File Name                   -  Mail.php
 * Project Name                -  AssignSeat
 * @Version                   -  1.0
 * Created by                  -  Chetan Sharma
 * Created on                  -  August 10, 2013
 * ***************************** Update Log ********************************
 * Sr.NO.		Version		Updated by           Updated on          Description
 * -------------------------------------------------------------------------
 *
 * *************************************************************************
 */
require_once SITE_PATH . '/libraries/constants.php';
require_once 'class.phpmailer.php'; // path to the PHPMailer class
require_once 'class.smtp.php'; // path to the smtp class
class Mailer
{

    /**
     *
     * @param string $address            
     * @param string $subject            
     * @return boolean
     * 
     * This method is used for sending mails
     */
    function sendMail ($address = "assignseat@gmail.com", $subject)
    {
        $mail = new PHPMailer();
        $mail->IsSMTP(); // telling the class to use SMTP
        $mail->Mailer = "smtp";
        $mail->Host = "ssl://smtp.gmail.com";
        $mail->Port = 465;
        $mail->SMTPAuth = true; // turn on SMTP authentication
        $mail->Username = "assignseat@gmail.com"; // SMTP username
        $mail->Password = "osscube@123"; // SMTP password
        
        $mail->From = "AssignSeat";
        $mail->AddAddress($address);
        
        $mail->Subject = "AssignSeat";
        $mail->Body = $subject;
        
        if (! $mail->Send()) {
            return false;
        } else {
            return true;
        }
    }
}
?>