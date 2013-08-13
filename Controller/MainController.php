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
	
	/* 	@author     : Avni Jain
		called from : main.php.
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
			//echo "<pre>";
			//print_r($_SESSION);
			$this->fetchRoomData();
			$objSecurity= new Security();
			$objSecurity->logSessionId( $_SESSION['username']);
			$objLogger = new Logger();
			$objLogger->logLoginEntryCuurentFile();
			header("Location:index.php");                  
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
	/*******@author    :  Avni Jain
			called from:  Mainbuilding.php()
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
		//print_r($a);die;
		$info['room']=$a[0][0];
		$info['row']=$a[0][1];
		$info['computerid']=$a[0][2];
		if(strrpos($moveto, "emp")===false) {
		$info['frmroom']=$b[0][0];
		$info['frmrow']=$b[0][1];
		$info['frmcomputerid']=$b[0][2];
		}
		else {
			$info['frmroom']="employee search box";
			$info['frmrow']=" ";
			$info['frmcomputerid']=" ";
		}
		$info['details']=htmlentities($_REQUEST['changeComment']);
		$info['assigne']=$_SESSION ['userid'];
		$info['assignename']=$_SESSION ['username'];
		$info['empid']=$_REQUEST['employee'];
		//print_r($info); die;
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
		/******* first time seat assignment to the user**************/ 
		if($inserted=="true") {
			$log = array();
			$log['empid']=$ename;
			$log['uname']=$info['assignename'];
			$log['seatid']=$sid;
			$log['room'] = $info['room'];
			$log['row'] = $info['row'];
			$log['computerid'] = $info['computerid'];
//echo"<pre>";
//			print_r($log);
//die;
			/****** for logging seat allocation*********/ 
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
		/***********if a seat is reassigned***************************/
		if($inserted=="true1") {
			$log = array();
// 						print_r($info);
// 			die;
			$log['empid']=$ename;
			$log['uname']=$info['assignename'];
			$log['seatid']=$sid;
			$log['room'] = $info['room'];
			$log['row'] = $info['row'];
			$log['computerid'] = $info['computerid'];
			$log['frmroom'] = $info ["frmroom"];
			$log['frmrow'] = $info ["frmrow"];
			$log['frmcomputerid'] = $info ["frmcomputerid"];
			echo"<pre>";
// 			print_r($log);
// die;
			/****** for logging seat reallocation*********/ 
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
	/*@author: Avni jain*/
	public function isAssignedSeat()
	{
		//echo $_REQUEST['employee'];
		$seatObj = $this->loadModel('SeatEmployee');
		$info['empid']=$_REQUEST['employee'];
		$isAssigned=$seatObj->checkEmpSeat($info['empid']);
		if (empty ( $isAssigned )) {
			echo "1"; 
			}
			else {
			echo "2";
			}
	}
	public function deleteSeat()
	{
		
	
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
	public function dataFetch($roomId)
	{
	    $obj = $this->loadModel('SeatEmployee');
	    $value = $obj->seatStatus($roomId);
	    return $value; 
	    //$this->loadView('status',$value); 
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
		
		if(substr($_REQUEST['seatid'],0,3)=='emp'){
			
			$boolLogResult=true;
			
		}else {
		$log=array();
		$a[]=explode("_", $_REQUEST['seatid']);
		$log['uname']=$_SESSION['username'];
		$log['empid']=$trashed;
		$log['room']=$a[0][0];
		$log['row']=$a[0][1];
		$log['computerid']=$a[0][2];
		$objLogger = new Logger();
		$boolLogResult = $objLogger->logDeleteSeatCuurentFile($log);
		}
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
	    echo json_encode($result);
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
	/*
	 * @author Prateek Saini
	*
	* This function will be used to reload the
	* mainBuilding Page.
	*
	* */
	public function reLoadMainBuilding()
	{
	    $this->loadView('mainBuilding');
	}
	/*
	 * @author Prateek Saini
	*
	* This will fetch Room data from Database  
	*
	* */
	private function fetchRoomData()
	{
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
		$_SESSION['roomId'] = implode(", ",array_keys($roomData));
		unset($_SESSION['totalRooms']);
		unset($_SESSION['variable']);		
	}
	/*
	 * @author Mohit K.Singh
	*
	* This function will load Admin	View
	*
	* */
	public function adminView()
	{
		$roomObj=$this->loadModel('Room');
		$roomData=$roomObj->fetchAllRooms();
		$this->loadView('adminView',$roomData);
	}
	/*
	 * @author Mohit K.Singh
	*
	* This function will get a room
	* full details
	*
	* */
	public function getRoomDetails()
	{
		$roomObj=$this->loadModel('Room');
		$roomDetails=$roomObj->fetchRoomDetails($_POST['roomId']);
		$this->loadView('adminRoomDetails',$roomDetails);
	}
	/*
	 * @author Mohit K.Singh
	*
	* This function will get a employee
	* full details
	*/
	public function getEmpDetails()
	{
		$empObj=$this->loadModel('Employee');
		$empObj->setId($_POST['empId']);
		$empDetails=$empObj->getEmployeeProfile();
		$this->loadView('adminEmpDetails',$empDetails);
	}
	/*
	 * @author Mohit K.Singh
	*
	* This function will delete a row 
	* from a room
	*/
	public function delRoomRow(){
		$roomObj=$this->loadModel('Room');
		$roomObj->deleteRow($_POST['roomId'],$_POST['rowId']);
		$this->fetchRoomData();
		echo "Row Deleted";
	}
	/*
	 * @author Mohit K.Singh
	*
	* This function will add a row
	* in a room
	*/
	public function addNewRoomRow()
	{
		$roomObj=$this->loadModel('Room');
		$roomObj->addRow($_POST['roomId'],$_POST['rowNo'],$_POST['computer']);
		$this->fetchRoomData();
		echo "Row Added";		
	}
	/*
	 * @author Mohit K.Singh
	*
	* This function will update computer
	* in a row of a room
	*/
	public function computerUpdate()
	{
		
		$roomObj=$this->loadModel('Room');
		$roomObj->updateComp($_POST['rowId'],$_POST['computer']);
		$this->fetchRoomData();
		echo "Computer Updated";
	}
	public function picUpload()
	{
		$empObj=$this->loadModel('Employee');
		$empObj->upImage();
		echo "Pic Uploaded";
	}
	/*
	 * @author Mohit Gupta
	*
	* This function will read the csv file and insert/update employee detail as per csv file
	*/
	public function csvUpload()
	{
		if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST" and $_FILES['vasPhoto_uploads']['type'] == "text/csv")
		{
			$fileName = $_FILES['vasPhoto_uploads']['name'];
			$tmpName  = $_FILES['vasPhoto_uploads']['tmp_name'];
			$fileType = $_FILES['vasPhoto_uploads']['type'];
			$chk_ext = explode(",",$fileName);
			$handle = fopen($tmpName, "r");
			if(!$handle){
				die ('Cannot open file for reading');
			}
			$employeeObj1=$this->loadModel('Employee');
			$empEmailArr =$this->employeeEmail($employeeObj1);
			
			while (($data = fgetcsv($handle, 10000, ",")) !== FALSE)
			{
				$employeeObj1->setName($data[0]);
				$employeeObj1->setDesignation($data[1]);
				$employeeObj1->setDepartment($data[2]);
				$employeeObj1->setDetails($data[3]);
				$employeeObj1->setEmail_id($data[4]);
				$employeeObj1->setStatus("1");
				
				$employeeObj1->setEmployeeProfile();
					
			}
		}
		else {
			die('Please upload a csv format file.');
		}
	}
		
	/*
	 * @author Mohit Gupta
	*
	* This function will return all employees emailid from database
	*/
	public function employeeEmail($employeeObj)
	{
		$result=$employeeObj->getEmployeeEmail();
		unset($employeeObj);
		return $result;
	}
	/*
	 * @author Mohit K.Singh
	*
	* This function will get details of a room 
	* and call a graph view
	*/
	public function roomGraph()
	{
		$roomObj=$this->loadModel('Room');
		$roomData['totalRow']=$roomObj->fetchRoomDetails($_POST['roomId']);
		$roomData['seated']=$roomObj->getRoomSeatedDetails($_POST['roomId']);
		$this->loadView('roomGraph',$roomData);
	}
	/*
	 * @author Mohit K.Singh
	*
	* This function will delete multiple seats
	* 
	*/
	public function multiDelEmp()
	{
		$objSeatEmployee=$this->loadModel('SeatEmployee');
		$objSeatEmployee->mulitDelete($_POST['multiDel'],$_POST['reason']);
		
		echo "Seat Deleted";
// 		print_r($_POST);
// 		die;
	}
	/*
	 * @author Mohit K.Singh
	*
	* This function will get
	* users panal page 
	*
	*/
	public function getUsersView()
	{
		$userObj=$this->loadModel('Users');
		$result=$userObj->fetchAllAdminUser();
		$this->loadView('UsersPanal',$result);
	}
	/*
	 * @author Mohit K.Singh
	*
	* This function will get report page
	* with all data
	*/
	public function reportFetch()
	{
		//echo "report will be here";
		$userObj=$this->loadModel('Users');
		$allData['users']=$userObj->fetchAllAdminUser();
		$roomObj=$this->loadModel('Room');
		$allData['rooms']=$roomObj->fetchAllRoomDetails();
		$empObj=$this->loadModel('Employee');
		$allData['employee']=$empObj->getAllEmployee();
		$this->loadView('Report',$allData);
	}

     public function deleteUser()
	{
        $userObj=$this->loadModel('Users');
		$del = $userObj->deleteAdminUser();
        header("Location:index.php?controller=MainController&method=getUsersView");
		
    }
       
       public function createUser()
	{
		$createUser = $userObj->createAdminUser();
		echo "User Created";
               // header("Location:index.php?controller=MainController&method=getUsersView")	
     }
        
         
}


?>
