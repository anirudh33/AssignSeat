<?php

require_once './libraries/DBconnect.php';
class InitiateUser extends DBConnection {
    
/**
* @var unknown
*/
private $_password;

/**
* @var unknown
*/
private $_id;



/**
* @var unknown
*/
private $_username;


/**
* return $password
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
* return $username
*/
private function getUsername() {
    return $this->_username;
}

/**
 * @param unknown $username
 */
private function setUsername($username) {
    $this->_username = $username;
}
/**
 * @param unknown $userid
 */
private function setUserId($id) {
 $this->_id = $id;
}
/**
* return $userid
*/
private function getUserId() {
 return $this->_id;
}
/**
* Called from login method when user credentials in the system
* have been checked
*
* Usage: Sets userid and username of user in session
* for further usage
*/
private function setSession() {

$_SESSION ["username"] = $this->getUsername ();
$_SESSION ["userid"] = $this->getUserId ();
}

/**
* @param Email id of user trying to log in: $fieldEmail
* @param Password of user trying to log in: $fieldPassword
* Called by: initiateLogin in MainController
* @return number 1 if entry exists by calling exists function
* Usage: Checks for valid login information
*/
public function login($fieldUsername,$fieldPassword ) {

$this->setPassword ( $fieldPassword );
$this->setUsername ( $fieldUsername );

if ($this->exists ( $this->encryptPassword ( $this->getPassword () ) , $this->getUsername ()) == 1) {
$this->setSession ();
return 1;

} else {
	$_SESSION['msg']="";
$_SESSION['msg'] =$_SESSION['msg'].'<br>'. "Login Failed username or password does not exist";
header ( "Location:index.php");
die;	
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
        
        
        $data['tables']		= 'login';
        $data['columns']	= array('id','username', 'password');
        $data['conditions']=array(array('username ="'.$this->getUsername ().'"'),true);
        $result=$this->_db->select($data);
        $myResult=array();
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $myResult[]=$row;
        }
        if(!empty($myResult))
        {
            if(md5($myResult[0]['password']) === md5($password))
            {
//             	echo md5($myResult[0]['password']);
//             	echo "<br/>";
//             	echo md5($password);die;
				$this->setUserId($myResult[0]['id']);  //if login is sucessfull,setting userid
                 /*** security
				 $objSecurity= new Security();
                 $objSecurity->logSessionId($username);***********/
				return 1;
            }
            else
            {
            	return 0;
            }
        }
        else
        {
            return 0;
        }
        return $myResult;
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
/***************logout***/

public function logout() 
	{
		//unlink ("./tmp/" . $_SESSION ['username'] . ".txt" );
		
		session_destroy ();
		//header ( "Location:index.php" );
		header ( "Location:index.php?controller=Acontroller&method=loadView" );
	}
}
?>


