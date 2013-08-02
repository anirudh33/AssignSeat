<?php
/*
* Creation Log File Name - MainController.php
* Description - Main Controller file
* Version - 1.0
* Created by - Avni jain
* Created on - July 29, 2013
* * **************************** Update Log ********************************
Sr.NO.        Version        Updated by           Updated on          Description
-------------------------------------------------------------------------
1				1.0			Anirudh Pandita		August 1, 2013		Validation added on change reason
* ************************************************************************
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
	
	/* 	called from : main.php.
		description: This function is to handle login will redirect to mainpage.php in case
					of sucessfull login and in case of unsucessful login redirect to index 
		request params: username and password			
	*/
	
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
		
		/*******object of user  class  ***************/
		$this->_objInitiateUser= $this->loadModel('Users');
		
		/**** calls login function takes two arguments username and password,will return 1 in case of sucessful login else 0************/
		$result=$this->_objInitiateUser->login($this->_username,$this->_password);
	//echo $result;
		/********** in case of authentic user********/
		if($result==1) {
		//echo $result;
			$obj = $this->loadModel('SeatEmployee'); 
			$value = $obj->allSeat();
			$totalRooms = $obj->totalRooms();			
			$_SESSION['variable'] = $value;
			$roomData = array();
			for($i = 0 ; $i < $totalRooms[0]['total_room'] ; $i++) {
			    $roomData[] = array();
			}
			foreach($_SESSION['variable'] as $key => $value){
			    $roomData[$value['room_id']][] = $value;
			}
			$_SESSION['roomData'] = $roomData;
			unset($_SESSION['totalRooms']);
			unset($_SESSION['variable']);
			//echo "<pre>";
			//print_r($_SESSION);
			$objSecurity= new Security();
			$objSecurity->logSessionId( $_SESSION['username']);
			$objLogger = new Logger();
			$objLogger->logLoginEntryCuurentFile();
			header("Location:index.php?controller=MainController&method=mainPage");                  
		}
		else {
			echo " unsucessfull login";
		}
		
	}
	/******** called when user logout destroy session and delete(unlink) file of user from the server*******/
	
	public function logout() {
		unlink ("./tmp/" . $_SESSION ['username'] . ".txt" );
		$objLogger = new Logger();
		$objLogger->logLogoutEntryCuurentFile();
		session_destroy ();
		die;
	}
	public function mainPage() 
	{
// 	    echo "<pre>";
// 	    print_r($_SESSION['variable']);

//	    unset($_SESSION['variable']);
// 	    print_r($roomData);
// 	    die;
	}
	/******called from:  Mainbuilding.php()
			description: handle assiging of the seats,call assignseat function of seatemployee model
					   passes an array to assignseat function as paramaeter.Array contains room,
					   row no,computerid,reson to change and assigne id 	*****************/
	public function assignSeat()
	{
		$room=$_REQUEST['roomid'];
		$moveto=$_REQUEST['move'];
		//print_r($_REQUEST);die;
		$a[]=explode("_",$room);
		$b[]=explode("_",$moveto);
		//print_r($b);die;
		$info['room']=$a[0][0];
		$info['row']=$a[0][1];
		$info['computerid']=$a[0][2];
		$info['details']=htmlentities($_REQUEST['changeComment']);
		$info['assigne']=$_SESSION ['userid'];
		$info['assignename']=$_SESSION ['username'];
		$info['empid']=$_REQUEST['employee'];
		//validating changeComment field by anirudh
		$obj = new validate();
		$obj->validator("changeComment",$info['details'], "spaceCheck=25#required#maxlength=250",'Enter minimum 25 chars excluding spaces#Comment Required#Comment should not be more than 250 characters long');
		$error=$obj->result();
		if(!empty($error)){
			echo $obj->array2table($error);	
		}else{
		$seatObj = $this->loadModel('SeatEmployee');
		$inserted=$seatObj->assignSeat($info);
		$sid=$seatObj->getSid();
		$ename=$seatObj->getEmpName();
		if($inserted=="true") {
			$log['empid']=$ename;
			$log['uname']=$info['assignename'];
			$log['seatid']=$sid;
			$log['room'] = $info['room'];
			$log['row'] = $info['row'];
			$log['computerid'] = $info['computerid'];
			$objLogger = new Logger();
			$boolLogResult = $objLogger->logAssignSeatCuurentFile($log);
			if($boolLogResult)
			{
				echo "1";
			}
			else
			{
				echo "there is some problem during logging the file";
		}
		}
		if($inserted=="true1") {
			$log['empid']=$ename;
			$log['uname']=$info['assignename'];
			$log['seatid']=$sid;
			$log['room'] = $info['room'];
			$log['row'] = $info['row'];
			$log['computerid'] = $info['computerid'];
			$objLogger = new Logger();
			$boolLogResult = $objLogger->logUpdateSeatLocationCuurentFile($log);
			if($boolLogResult)
			{
				echo "2";
			}
			else
			{
				echo "there is some problem during logging the file";
			}
		}
		
		}
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
	    $this->loadView('status',$value); 
	}
	
	
	public function trashSeat()
	{
		$seatObj = $this->loadModel('SeatEmployee');
		$seatObj->setEid($_REQUEST['employee']);
		$seatObj->setDetails(htmlentities($_REQUEST['changeComment']));
		//validating changeComment field by anirudh
		$obj = new validate();
		$obj->validator("changeComment",$_REQUEST['changeComment'], "spaceCheck=25#required#maxlength=250",'Enter minimum 25 chars excluding spaces#Comment Required#Comment should not be more than 250 characters long');
		$error=$obj->result();
		if(!empty($error)){
			echo $obj->array2table($error);
		}else{
		$trashed=$seatObj->trashSeat();
		$log=array();
		$a[]=explode("_", $_REQUEST['seatid']);
		
		$log['uname']=$_SESSION['username'];
		$log['empid']=$trashed;
		$log['room']=$a[0][0];
		$log['row']=$a[0][1];
		$log['computerid']=$a[0][2];
		$objLogger = new Logger();
		$boolLogResult = $objLogger->logDeleteSeatCuurentFile($log);
		// Seat has been trashed
		if($boolLogResult)
		{
			echo "1";
		}
		}
	
	}
	/*
	* @author Prateek Saini
	*
	* This function will fetch data from Employee table
	* result will be display in tooltip
	* 
	* */
	public function fetchUserProfile()
	{
	    $empObj = $this->loadModel('Employee');
	    $empObj->setId($_POST['eid']);
	    $result = $empObj->getEmployeeProfile();
	    echo json_encode($result[0]);
	}
	
	/*
	 * @author Prateek Saini
	 * 
	 * This function will fetch data from log file
	 * convert it into array then sort them on 
	 * the key so we can have last data as first
	 * element then slice the array for top
	 * 10 elements 
	 * 
	 * */
	public function fetchLogData()
	{
	    $dir = getcwd();	    
	    chdir('Log/Current');
	    $someData = file_get_contents('CurrentHistory.txt');
	    if(!empty($someData)){
    	    $someData = explode("\n", $someData);
    	    $someData = array_reverse($someData);
    	    //$someData = array_slice($someData, 0,10);
    	    echo json_encode($someData);	    
    	    chdir($dir);
	    }
	    else{
	        echo json_encode("No Data in log file");
	    }
	}
}

?>
