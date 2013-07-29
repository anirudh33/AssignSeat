<?php
/*
* *************************** Creation Log *******************************
* File Name - InitiateUser.php
* Description - Class file for initiating login of users
* Version - 1.0
* Created by - Anirudh Pandita
* Created on - March 01, 2013
* ***************************************************************************
* Sr.NO. Version Updated by Updated on Description
* -------------------------------------------------------------------------
* 1 1.0 Anirudh Pandita March 02, 2013
* 2 1.0 Anirudh Pandita March 08, 2013 Paths set
* ***************************************************************************
*/
require_once './libraries/DBconnect.php';
class InitiateUser extends DBConnection {
    
/**
* @var unknown
*/
private $_password;

/**
* @var unknown
*/
private $_result = array ();

/**
* @var unknown
*/
private $_userID;

/**
* @var unknown
*/
private $_userType;

/**
* @var unknown
*/
private $_emailID;


private $_username;

/**
* @return unknown
*/
private function getPassword() {
return $this->_password;
}

/**
* @param unknown $password
*/
private function setPassword($password) {
$this->_password = $password;
}

/**
* @return unknown
*/
private function getResult() {
return $this->_result;
}

/**
* @param unknown $result
*/
private function setResult($result) {
$this->_result = $result;
}

/**
* @return unknown
*/
private function getUserID() {
return $this->_userID;
}

/**
* @param unknown $userID
*/
private function setUserID($userID) {
$this->_userID = $userID;
}

/**
* @return unknown
*/
private function getUserType() {
return $this->_userType;
}

/**
* @param unknown $userType
*/
private function setUserType($userType) {
$this->_userType = $userType;
}

/**
* @return unknown
*/
private function getEmailID() {
return $this->_emailID;
}

/**
* @param unknown $emailID
*/
private function setEmailID($emailID) {
$this->_emailID = $emailID;
}

private function getUsername() {
    return $this->_username;
}

/**
 * @param unknown $emailID
 */
private function setUsername($username) {
    $this->_username = $username;
}
/**
* Called from login method when user credentials in the system
* have been checked
*
* Usage: Sets userid, user type and email id of user in session
* for further usage
*/
private function setSession() {
$_SESSION ["userType"] = "test";

$_SESSION ["username"] = $this->getUsername ();
//$_SESSION ["password"] = $this->getPassword ();
//$_SESSION ["email"] = $this->getEmailID ();
}


/**
* @author anirudh pandita
* @param Email id of user trying to log in: $fieldEmail
* @param Password of user trying to log in: $fieldPassword
* Called by: initiateLogin in MainController
* @return number 1 if entry exists by calling exists function
* Usage: Checks for valid login information
*/
public function login($fieldUsername,$fieldPassword ) {
   //echo "login";die;
//$this->setEmailID ( $fieldEmail );
$this->setPassword ( $fieldPassword );
$this->setUsername ( $fieldUsername );

if ($this->exists ( $this->encryptPassword ( $this->getPassword () ) , $this->getUsername ()) == 1) {
$this->setSession ();
//echo "me";die;
return 1;

} else {
$msg = "Login Failed username or password does not exist";
//$this->setCustomMessage ( "ErrorMessage", $msg );
header ( "Location:" . $_SESSION ["DOMAIN_PATH"] . "/index.php?msg=$msg" );	
}	
}

/**
* @param $email entered by user
* @param $password entered by use after encryption
* @return 1 if user exists in system, 0 if doesn't
* Usage: Checks for user exists or not in system
*/
private function exists($password , $username) {

if ($this->fetchUser ( $username, $password ) == true) {
return 1;
} else {
return 0;
}
}

/**
* @param $email of user logging in
* @param $password encrypted of user logging in as
* we have store encrypted versions while registration
* @return number 1 if user exists with active status else 0
* Usage: fetches the user if exists who is logging in
*/
private function fetchUser($username, $password) {
        
        
        $data['tables']		= 'users';
        $data['columns']	= array('user_name', 'password');
        $data['conditions']=array(array('user_name ="'.$this->getUsername ().'"'),true);
        $result=$this->_db->select($data);
        $myResult=array();
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $myResult[]=$row;
        }
        if(!empty($myResult))
        {
            if(md5($myResult[0]['password']) === md5($password))
            {
        
                return 1;
            }
            else
            {
                
            }
        }
        else
        {
            return 0;
        }
        return $myResult;
}	

/**
* @param $table to fetch the status from like studentdetails if student logs in
* @param $uid User id of user loggin in
* @return True if status active False otherwise
* Usage: Fetches the status of user activated or deleted from database
*/
private function fetchStatus($table, $uid) {
$this->db->Fields ( array (
"status"
) );
$this->db->Where ( array (
"user_id" => $uid,
"status" => "1"
) );
$this->db->From ( $table );
$bool = $this->db->select ();
$result = $this->db->resultArray ();

if (empty ( $result [0] ["status"] )) {
return false;
} else {
return true;
}
}

/**
* Called from within login($fieldEmail, $fieldPassword)
* @param $password Received from user logging in
* @return encrypted password
* Usage: Converts the password to encrypted one
*/
private function encryptPassword($password) {	
return md5($password);	
}	

/**
* @param $value: Language selected by user
* Usage: Sets the language as received
*/
public function setLanguage($languageChosen) {
$_SESSION ["lang"] = $languageChosen;
}	
}
?>


