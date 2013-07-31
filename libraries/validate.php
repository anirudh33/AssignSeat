<?php
/*
 * FileName: Validate.php
* Version: 1.0
* Author: Keshi Chander Yadav, Tanu Trehan, Manish
* Date: May 03, 2013
* Description: Validate class
* ***************************** Update Log ********************************
	Sr.NO.		Version		Updated by           Updated on          Description
    -------------------------------------------------------------------------
	 1			1.1			Keshi				08/05/2013			improved result methode
    *************************************************************************
 */

require_once('validation.class.php');
class validate
{
    private  $obj;	//Class Object Reference
    private $errorMsg="";
    
    public function __construct()
    {
        $this->obj = new validation();
    }
    
    /*
	 * Description: function to validate fields
	 * to this function
	 * Param $controler_name field control name goes here
	 * Param $postVar field data to be validated
	 * Param $authType Type of validation required for control
	 * Param $error error message for in case of validation failed
	 */
    function validator($name,$postVar=" ", $authType, $error)
    {
    	
    	if (isset ( $_SERVER ["REQUEST_METHOD"] )) {
    		if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
    			$auth=explode('#', $authType);
    			$err=explode('#', $error);
    			$authLength=count($auth);
    			$errLength=count($err);
    			
    			if($authLength==$errLength)
    			{
    				for($i=0;$i<$authLength;$i++)
    				{
    				$this->obj->addFields($name,$postVar, $auth[$i], $err[$i]);
    				}
    				return  "here true";
    			}
    			else
    			{
    			$this->errorMsg="Programer's error";
    			return $this->errorMsg;
    			}
    			 
    			}
    	 else {
         	$this->errorMsg = "Invalid request";
         	return $this->errorMsg;
         }
    		}
    		
    		
         else {
         	$this->errorMsg = "Invalid request, no request received";
         	return $this->errorMsg;
         }

    }
    
    
    /**
     * return validation result with error messages
     */
    public function result()
    {
        $this->errorMsg=$this->obj->validate();
        $flag =true;
        //if to set flag to false if any field of form has invalid value
        if (array_filter( $this->errorMsg,'trim')){
            $flag = false;
        }
        //if to return TRUE all fields of form are valid
        if($flag){
            return false;
        }
        //else return errorMsg[] wid all fields as key and error as value respectively! value is null if no error
        else{
            return $this->errorMsg;
        }   }
    
    /**
     *  Helps prevent XSS attacks
     *  Used for encoding before insertion in database
     */
    public function encodeXSString($string)
    {
    	// Remove dead space.
    	$string = trim ( $string );
    		
    	// Prevent potential Unicode codec problems.
    	$string = utf8_decode ( $string );
    		
    	// HTMLize HTML-specific characters.
    	$string = htmlentities ( $string, ENT_QUOTES );
    	$string = str_replace ( "#", "&#35;", $string );
    	$string = str_replace ( "%", "&#37;", $string );
    
    	return $string;
    }
    
    
    /**
     * Helps prevent XSS attacks
     * Used for denoding before displaying information on page
     */
    private function decodeXSString($string) 
    {
    	// Remove dead space.
    	$string = trim ( $string );
    		
    	// Prevent potential Unicode codec problems.
    	$string = utf8_decode ( $string );
    		
    	// HTMLize HTML-specific characters.
    	$string = htmlentities ( $string, ENT_QUOTES );
    	$string = str_replace ( "&#35;", "#", $string );
    	$string = str_replace ( "&#37;", "%", $string );
    	$length = intval ( $length );
    		
    	if ($length > 0)
    	{
    		$string = substr ( $string, 0, $length );
    	}
    	return $string;
    }
    
    
    /**
     * prevent sql injection
     * $param parameter will accept array type
     */
    private function preventSQLInjection($string) {
    	foreach ( $string as $key => $value ) {
    		$value = mysql_real_escape_string ( $value );
    	}
    	return $string;
    }   
}
		/* $obj = new validate();
		$obj->validator('pass#cnfpass','123#123','match','password not match');
		$error=$obj->result();
		print_r($error); */
// 		//$obj->validator("zip","12345", 'datatype=int,5','data');
// 		var_dump($error);
// 		if($error==true){
// 		$error=$obj->result();
// 		}

// 		print_r($error);



/* public function checkValidation()
{
	echo "i am here";
	$obj = new validate();
	$c=$obj->validator("Username","raj42", 'required#alphanumeric#minlength=4#maxlength=25','Username Required#alphanumeric Required#Enter Username atleast 4 characters long#Username should not be more than 25 characters long');
	//$c=$obj->validator("zip","12345", 'datatype=int,5','data');
	if($c==true){
		$error=$obj->result();
		print_r($error);
	}else {
		echo $c;
	}
} */