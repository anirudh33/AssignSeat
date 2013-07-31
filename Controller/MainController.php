<?php

/*
 * Creation Log File Name - MainController.php
* Description - Main Controller file
* Version - 1.0
* Created by - Avni jain
* Created on - july 29, 2013
* *************************************************
*/
require_once(SITE_PATH."/libraries/validate.php");
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
		$this->_username=$_REQUEST['username'];
		$this->_password=$_REQUEST['password'];
		
		# Create Object of class validate
		$obj = new validate();
		$obj->validator("username",$this->_username, 'required#alphanumeric#minlength=4#maxlength=25','Username Required#alphanumeric Required#Enter Username atleast 4 characters long#Username should not be more than 25 characters long');
		$obj->validator("password",$this->_password, 'minlength=4#maxlength=25','Enter password atleast 4 characters long#Password should not be more than 25 characters long');
		$error=$obj->result();
		
		
		if(!empty($error)){
			
			if(isset($_SESSION['msg'])) {				
				$_SESSION['msg'] =$_SESSION['msg'].'<br><br>'. $obj->array2table($error);				
			}else {
				$_SESSION['msg'] =$obj->array2table($error);				
			}
			
			header ( "Location:".SITE_URL."index.php");
			die;
		 }
		
		
		$this->_objInitiateUser= new InitiateUser();
		$result=$this->_objInitiateUser->login($this->_username,$this->_password);
		if($result==1) {
			//die("jjfj");
			$obj = $this->loadModel('SeatEmployee'); 
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
// 		print_r($_POST);
// 		die;
		$a[]=explode("_", $room);
		//print_r($a);
		$info['room']=$a[0][0];
		$info['row']=$a[0][1];
		$info['computerid']=$a[0][2];
		$info['details']=$_REQUEST['changeComment'];
		$info['assigne']=$_SESSION ['username'];
		$seatObj = $this->loadModel('SeatEmployee');
		$seatObj->assignSeat($info);
	}
	public function searchEmployee()
	{
		$employeeObj = $this->loadModel('Employee');
		$record = $employeeObj->searchEmp($_REQUEST['name'],($_REQUEST['page']*10));
		echo json_encode($record);
		die;
	}
	
	public function logHistory()
	{
		$objLogger = new Logger();
		$objLogger->logHistoryFile();
	}
	public function dataFetch()
	{
	    $obj = $this->loadModel('SeatEmployee');
	    $value = $obj->seatStatus($_REQUEST['value'],$_REQUEST['value1']);
	   // print_r($value);die;
	     include('View/status.php');
	    //print_r($value);die;
	          
	}
}

?>
