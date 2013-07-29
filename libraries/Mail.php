<?php
/*
 **************************** Creation Log *******************************
File Name                   -  mail.php
Project Name                -  SkillSeeker
Description                 -  Class file for start
Version                     -  1.0
Created by                  -  Mohit Gupta
Created on                  -  May 10, 2013
***************************** Update Log ********************************
Sr.NO.		Version		Updated by           Updated on          Description
-------------------------------------------------------------------------

*************************************************************************

*/
require_once SITE_PATH .'/libraries/constants.php';
require_once 'class.phpmailer.php';// path to the PHPMailer class
require_once 'class.smtp.php';// path to the smtp class
class Mailer {

   function sendMail($address="skillseeker@gmail.com",$subject)
   {
	$mail = new PHPMailer();  
	$mail->IsSMTP();  // telling the class to use SMTP
	$mail->Mailer = "smtp";
	$mail->Host = "ssl://smtp.gmail.com";
	$mail->Port = 465;
	$mail->SMTPAuth = true; // turn on SMTP authentication
	$mail->Username = "skillseekeross@gmail.com"; // SMTP username
	$mail->Password = "osscube@123"; // SMTP password
 
	$mail->From     = "SkillSeeker";
	$mail->AddAddress($address);  
 
	$mail->Subject  = "SkillSeeker";
	$mail->Body     = $subject;
 
	if(!$mail->Send()) 
	{
    		return false;
	}
	else 
	{
	        return true;
	}
   }

}

?>
