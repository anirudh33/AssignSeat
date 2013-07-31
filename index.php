<?php
/*
 * Creation Log File Name - index.php 
 * Description - skillseeker index file
 * Version - 1.0 
 * Created by - Anirudh Pandita 
 * Created on - May 3, 2013 
 * *************************************************
 */

/* Starting session  */
ini_set("display_errors","1");
session_start();

/* Including all constants to be used */
require_once getcwd().'/libraries/constants.php';
require_once getcwd().'/libraries/Security.php';
require_once getcwd().'/libraries/Logger.php';

/* Requiring all essential files */
function __autoload($controller) {
	include SITE_PATH .'/Controller/'.$controller . '.php';
}
require_once SITE_PATH.'/libraries/initiateuser.php';

/* Method calls from views handled here */

//header ,left,right 
$options = getopt("C:M:");
if(!empty($options))
{
	$_REQUEST ['controller']=$option['C'];
	$_REQUEST ["method"]=$option['M'];
}
if (isset ( $_REQUEST ['controller'] )) {
		
		if (isset ( $_REQUEST ["method"] )) {
	
			// Creating object of controller to initiate the process
			$object = new $_REQUEST ["controller"] ();
			
			if (method_exists ( $object, $_REQUEST ["method"] )) {
				if($_REQUEST ["method"] != 'loginClick') {
				$objSecurity= new Security();
            		        $objSecurity->secureMultiLogin( $_SESSION['username']);
				}
				$object->$_REQUEST ["method"] ();
				if($_REQUEST ["method"]=='loadView')
				{
					$object->loadView("main");
				}
				if($_REQUEST ["method"]=='mainPage')
				{
					$object->loadView("mainPage");
				}
			}

	}
}
else if (isset($_SESSION ["username"]))
{
	$objSecurity= new Security();
        $objSecurity->secureMultiLogin( $_SESSION['username']);
	$objMainController = new MainController();
	$objMainController->loadView("mainPage");
}
else
{

	/* Showing the main Login view */
    $objMainController = new MainController();    
    $objMainController->loadView("main");
}
 

//footer..
?>

