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
			$obj = $this->loadModel('Seat'); 
                        $value = $obj->allSeat();
                        //session_start();
                        $_SESSION['variable'] = $value;
                        $objSecurity= new Security();
                        $objSecurity->logSessionId( $_SESSION['username']);
                        $objLogger = new Logger();
                        $objLogger->logLoginEntryCuurentFile(); 
                        header("location:index.php?controller=MainController&method=mainPage");
			
                       
		}
		else {
			echo " unsucessfull login";
		}
		
	}
	public function logout() {
		unlink ("./tmp/" . $_SESSION ['username'] . ".txt" );
		$objLogger = new Logger();
		$objLogger->logLogoutEntryCuurentFile();
		session_destroy ();
		die;
	
	}
	public function mainPage() 
	{
		
	}
	public function assignSeat()
	{
		$room=$_REQUEST['roomid'];
		$a[]=explode("_", $room);
		print_r($a);
		$info['room']=$a[0][0];
		$info['row']=$a[0][1];
		$info['col']=$a[0][2];
		$info['assigne']=$_SESSION ['username'];
		
	}
	public function searchEmployee()
	{
		$employeeObj = $this->loadModel('Employee');
		$record = $employeeObj->searchEmp($_REQUEST['name'],($_REQUEST['page']*10));
		echo json_encode($record);
		die;
	}

}

?>
