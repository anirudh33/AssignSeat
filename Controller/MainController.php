<?php

/*
 * Creation Log File Name - MainController.php
* Description - Main Controller file
* Version - 1.0
* Created by - Avni jain
* Created on - july 29, 2013
* *************************************************
*/
class MainController extends Acontroller
{
	private $_username;
	private $_password;
	private $_objInititateUser;
	
	public function MainController()
	{
		//$this->_objInitiateUser= new InitiateUser();
	}
	public function loginClick() {
		$_username=$_REQUEST['username'];
		$_password=$_REQUEST['password'];
		$this->_objInititateUser= new InitiateUser();
		$result=$this->_objInititateUser->login($_username,$_password);
		if($result==1) {
			//login sucessfull
			echo "login done";
			header("location:index.php?controller=MainController&method=mainPage");
		}
		else {
			echo " unsucessfull login";
		}
		
	}
	public function mainPage() 
	{
		
	}

}

?>
