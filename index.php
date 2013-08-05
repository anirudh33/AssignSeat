<?php
/*
 * Creation Log File Name - index.php 
 * Description - AssignSeat index file
 * Version - 1.0 
 * Created by - Anirudh Pandita 
 * Created on - July 29, 2013 
 * *************************************************
 */

/* Show php errors as in development stage */
ini_set("display_errors","1");

/* Starting session  */
session_start();

/* Including all constants to be used */
require_once getcwd().'/libraries/constants.php';
require_once getcwd().'/libraries/Security.php';
require_once getcwd().'/libraries/Logger.php';
require_once(__DIR__."/libraries/validate.php");
/* Requiring all essential files */

function __autoload($controller) {

	include __DIR__ .'/Controller/'.$controller . '.php';
}

/* Method calls from views handled here */

//header ,left,right 
$options = getopt("C:M:");
if(!empty($options))
{
	$_REQUEST ['controller']=$options['C'];
	$_REQUEST ["method"]=$options['M'];
}

if (isset ( $_REQUEST ['controller'] )) {
		
		if (isset ( $_REQUEST ["method"] )) {
	
			// Creating object of controller to initiate the process
			$object = new $_REQUEST ["controller"] ();
			
			if (method_exists ( $object, $_REQUEST ["method"] )) {
				if(!in_array($_REQUEST ["method"],array('loginClick','logHistory'))) {
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
	if(!isset($_SESSION['mainController'])) {
        $_SESSION['mainController'] = $objMainController;
	}
	$objMainController->loadView("mainPage");
}
else
{

	/* Showing the main Login view */
    $objMainController = new MainController();    
    $objMainController->loadView("main");
}

/* clear error messages */
unset($_SESSION['msg']);
//footer..
?>

