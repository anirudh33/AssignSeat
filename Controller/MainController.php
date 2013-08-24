<?php
/**
 * ************************************Creation Log*******************************
 * Creation Log File Name - MainController.php
 * Description - Main Controller file
 * Version - 1.0
 * Created by - Chetan Sharma
 * Created on - July 29, 2013
 * * **************************** Update Log ********************************************************************
 Sr.NO.        Version      Updated by              Updated on          Description
 -----------------------------------------------------------------------------------------------------------------
 1		1.0         Chetan Sharma           August 1, 2013		Validation added on change reason
 *  ************************************************************************************************************
 */
class MainController extends Acontroller {
	/**
	 *
	 * @var String
	 */
	private $_username;
	/**
	 *
	 * @var String
	 */
	private $_password;
	/**
	 *
	 * @var Object InititatateUser Class
	 */
	private $_objInititateUser;
	
	/**
	 *
	 * @author : Chetan Sharma
	 *         description: This function is to handle login will redirect to mainpage.php in case
	 *         of sucessfull login and in case of unsucessful login redirect to index
	 *         request params: username and password
	 */
	public function loginClick() {
		$this->_username = $_REQUEST ['username'];
		$this->_password = $_REQUEST ['password'];
		
		// Create Object of class validate
		$obj = new validate ();
		$obj->validator ( "username", $this->_username, 'required#alphanumeric#minlength=4#maxlength=25', 'Username Required#alphanumeric Required#Enter Username atleast 4 characters long#Username should not be more than 25 characters long' );
		$obj->validator ( "password", $this->_password, 'minlength=4#maxlength=25', 'Enter password atleast 4 characters long#Password should not be more than 25 characters long' );
		$error = $obj->result ();
		
		if (! empty ( $error )) {
			
			if (isset ( $_SESSION ['msg'] )) {
				$_SESSION ['msg'] = $_SESSION ['msg'] . '<br><br>' . $obj->array2table ( $error );
			} else {
				$_SESSION ['msg'] = $obj->array2table ( $error );
			}
			
			header ( "Location:" . SITE_URL . "index.php" );
			die ();
		}
		
		/**
		 * *****object of user class **************
		 */
		$this->_objInitiateUser = $this->loadModel ( 'Users' );
		
		/**
		 * calls login function takes two arguments username and password,
		 * will return 1 in case of sucessful login else 0
		 */
		$result = $this->_objInitiateUser->login ( $this->_username, $this->_password );
		/**
		 * in case of authentic user
		 */
		if ($result == 1) {
			$this->fetchRoomData ();
			$objSecurity = new Security ();
			$objSecurity->logSessionId ( $_SESSION ['username'] );
			$objLogger = new Logger ();
			$objLogger->logLoginEntryCuurentFile ();
			header ( "Location:index.php" );
		} else {
			echo " unsucessfull login";
		}
	}
	/**
	 * Called when user logout destroy session and delete(unlink) file of user from the server
	 */
	public function logout() {
		unlink ( "./tmp/" . $_SESSION ['username'] . ".txt" );
		$objLogger = new Logger ();
		$objLogger->logLogoutEntryCuurentFile ();
		session_destroy ();
		die ();
	}
	/**
	 *
	 * @author : Chetan Sharma
	 *         called from: Mainbuilding.php()
	 *         description: handle assiging of the seats,call assignseat function of seatemployee model
	 *         passes an array to assignseat function as paramaeter.Array contains room,
	 *         row no,computerid,reson to change and assigne id
	 */
	public function assignSeat() {
		$room = $_REQUEST ['roomid'];
		$moveto = $_REQUEST ['move'];
		$a [] = explode ( "_", $room ); // Find all room,seat and computer no.
		$b [] = explode ( "_", $moveto );
		$info ['room'] = $a [0] [0];
		$info ['row'] = $a [0] [1];
		$info ['computerid'] = $a [0] [2];
		if (strrpos ( $moveto, "emp" ) === false) {
			$info ['frmroom'] = $b [0] [0];
			$info ['frmrow'] = $b [0] [1];
			$info ['frmcomputerid'] = $b [0] [2];
		} else {
			$info ['frmroom'] = "employee search box";
			$info ['frmrow'] = " ";
			$info ['frmcomputerid'] = " ";
		}
		$info ['details'] = htmlentities ( $_REQUEST ['changeComment'] );
		$info ['assigne'] = $_SESSION ['userid'];
		$info ['assignename'] = $_SESSION ['username'];
		$info ['empid'] = $_REQUEST ['employee'];
		// validating changeComment field by anirudh
		$obj = new validate ();
		$obj->validator ( "changeComment", $info ['details'], "spaceCheck=25#required#maxlength=250", 'Enter minimum 25 chars excluding spaces#Comment Required#Comment should not be more than 250 characters long' );
		$error = $obj->result ();
		if (! empty ( $error )) {
			echo $obj->array2table ( $error );
		} else {
			/**
			 * Laod a SeatEmployee Model and get it's Object
			 */
			$seatObj = $this->loadModel ( 'SeatEmployee' );
			$inserted = $seatObj->assignSeat ( $info );
			$sid = $seatObj->getSid ();
			$ename = $seatObj->getEmpName ();
			/**
			 * first time seat assignment to the user
			 */
			if ($inserted == "true") {
				$log = array ();
				$log ['empid'] = $info ['empid'];
				$log ['ename'] = $ename;
				$log ['uname'] = $info ['assignename'];
				$log ['seatid'] = $sid;
				$log ['room'] = $info ['room'];
				$log ['row'] = $info ['row'];
				$log ['computerid'] = $info ['computerid'] + 1;
				/**
				 * **** for logging seat allocation********
				 */
				$objLogger = new Logger ();
				$boolLogResult = $objLogger->logAssignSeatCuurentFile ( $log );
				if ($boolLogResult) {
					echo "1";
				} else {
					echo "there is some problem during logging the file";
				}
			}
			/**
			 * If a seat is reassigned
			 */
			if ($inserted == "true1") {
				$log = array (); // Creating Log information array
				$log ['empid'] = $info ['empid'];
				$log ['ename'] = $ename;
				$log ['uname'] = $info ['assignename'];
				$log ['seatid'] = $sid;
				$log ['room'] = $info ['room'];
				$log ['row'] = $info ['row'];
				$log ['computerid'] = $info ['computerid'] + 1;
				$log ['frmroom'] = $info ["frmroom"];
				$log ['frmrow'] = $info ["frmrow"];
				$log ['frmcomputerid'] = $info ["frmcomputerid"] + 1;
				/**
				 * For logging seat reallocation
				 */
				$objLogger = new Logger ();
				$boolLogResult = $objLogger->logUpdateSeatLocationCuurentFile ( $log );
				if ($boolLogResult) {
					echo "2";
				} else {
					echo "there is some problem during logging the file";
				}
			}
		}
	}
	/**
	 * Function to check Seat is Assign or Not
	 *
	 * @return number
	 */
	public function isAssignedSeat() {
		$seatObj = $this->loadModel ( 'SeatEmployee' );
		$info ['empid'] = $_REQUEST ['employee'];
		$isAssigned = $seatObj->checkEmpSeat ( $info ['empid'] );
		if (empty ( $isAssigned )) {
			echo "1";
		} else {
			echo "2";
		}
	}
	/**
	 * Function to search Employee.
	 *
	 * @return JSON data for Employee
	 */
	public function searchEmployee() {
		$_SESSION['SearchEmpPage']=$_REQUEST['page'];
		$employeeObj = $this->loadModel ( 'Employee' );
		$record = $employeeObj->searchEmp ( $_REQUEST ['name'], ($_REQUEST ['page'] * 10) );
		echo json_encode ( $record );
		die ();
	}
	/**
	 * Function to Maintain a log History
	 */
	public function logHistory() {
		$objLogger = new Logger ();
		$objLogger->logHistoryFile ();
	}
	/**
	 * Function to Fetch data About a room
	 *
	 * @param number $roomId        	
	 * @return array
	 */
	public function dataFetch($roomId) {
		$obj = $this->loadModel ( 'SeatEmployee' );
		$value = $obj->seatStatus ( $roomId );
		return $value;
	}
	/**
	 * Function to remove a Employee From A seat
	 *
	 * @return string
	 */
	public function trashSeat() {
		$seatObj = $this->loadModel ( 'SeatEmployee' );
		$seatObj->setEid ( $_REQUEST ['employee'] );
		$seatObj->setDetails ( htmlentities ( $_REQUEST ['changeComment'] ) );
		// validating changeComment field by anirudh
		$obj = new validate ();
		$obj->validator ( "changeComment", $_REQUEST ['changeComment'], "spaceCheck=25#required#maxlength=250", 'Enter minimum 25 chars excluding spaces#Comment Required#Comment should not be more than 250 characters long' );
		$error = $obj->result ();
		if (! empty ( $error )) {
			echo $obj->array2table ( $error );
		} else {
			$trashed = $seatObj->trashSeat ();
			
			if (substr ( $_REQUEST ['seatid'], 0, 3 ) == 'emp') {
				
				$boolLogResult = true;
			} else {
				$log = array (); // Maintain a log here
				$a [] = explode ( "_", $_REQUEST ['seatid'] );
				$log ['uname'] = $_SESSION ['username'];
				$log ['empid'] = $trashed;
				$log ['room'] = $a [0] [0];
				$log ['row'] = $a [0] [1];
				$log ['computerid'] = $a [0] [2];
				$objLogger = new Logger ();
				$boolLogResult = $objLogger->logDeleteSeatCuurentFile ( $log );
			}
			// Seat has been trashed
			if ($boolLogResult) {
				echo "1";
			}
		}
	}
	
	/**
	 *
	 * @author Chetan Sharma This function will fetch data
	 *         from Employee table result will be display in tooltip
	 * @return JSON user data
	 */
	public function fetchUserProfile() {
		$empObj = $this->loadModel ( 'Employee' );
		$empObj->setId ( $_POST ['eid'] );
		$result = $empObj->getEmployeeProfile ();
		echo json_encode ( $result );
	}
	
	/**
	 *
	 * @author Chetan Sharma This function will fetch data from log
	 *         file convert it into array then sort them on the key so we can have
	 *         last data as first element then slice the array for top 10 elements
	 * @return string
	 */
	public function fetchLogData() {
		$dir = getcwd ();
		chdir ( 'Log/Current' );
		$someData = file_get_contents ( 'CurrentHistory.txt' ); // Get log data from File
		if (! empty ( $someData )) {
			$someData = explode ( "\n", $someData );
			$someData = array_reverse ( $someData );
			echo json_encode ( $someData );
			chdir ( $dir );
		} else {
			echo json_encode ( "No Data in log file" );
		}
	}
	/**
	 * Function to render Main Builging page
	 *
	 * @author Chetan Sharma This function
	 *         will be used to reload the mainBuilding Page.
	 *        
	 */
	public function reLoadMainBuilding() {
		$this->loadView ( 'mainBuilding' );
	}
	/**
	 * Function to get all room data and set it to
	 * session
	 *
	 * @author Chetan Sharma This will fetch
	 *         Room data from Database
	 */
	private function fetchRoomData() {
		$obj = $this->loadModel ( 'SeatEmployee' );
		$value = $obj->allSeat ();
		$totalRooms = $obj->totalRooms ();
		$_SESSION ['variable'] = $value;
		$roomData = array ();
		for($i = 0; $i < $totalRooms [0] ['total_room']; $i ++) {
			$roomData [] = array ();
		}
		foreach ( $_SESSION ['variable'] as $key => $value ) {
			$roomData [$value ['room_id']] [] = $value;
		}
		$_SESSION ['roomData'] = $roomData; // Set room data to session
		$_SESSION ['roomId'] = implode ( ", ", array_keys ( $roomData ) ); // Set all room id to session
		unset ( $_SESSION ['totalRooms'] );
		unset ( $_SESSION ['variable'] );
	}
	/**
	 *
	 * @author Chetan Sharma
	 *         This function will load Admin View
	 */
	public function adminView() {
		$roomObj = $this->loadModel ( 'Room' );
		$roomData = $roomObj->fetchAllRooms (); // Fetch All room data
		$this->loadView ( 'adminView', $roomData );
	}
	/**
	 *
	 * @author Chetan Sharma
	 *         This function will get a
	 *         room full details
	 */
	public function getRoomDetails() {
		$roomObj = $this->loadModel ( 'Room' );
		$roomDetails = $roomObj->fetchRoomDetails ( $_POST ['roomId'] ); // fetch data of a pirticular room
		$this->loadView ( 'adminRoomDetails', $roomDetails );
	}
	/**
	 *
	 * @author Chetan Sharma
	 *         This function will get a employee full details
	 */
	public function getEmpDetails() {
		$empObj = $this->loadModel ( 'Employee' );
		$empObj->setId ( $_POST ['empId'] );
		$empDetails = $empObj->getEmployeeProfile (); // Fetch Employee data on id
		$this->loadView ( 'adminEmpDetails', $empDetails );
	}
	/**
	 *
	 * @author Chetan Sharma
	 *         This function will delete a row from a room
	 */
	public function delRoomRow() {
		$roomObj = $this->loadModel ( 'Room' );
		$roomObj->deleteRow ( $_POST ['roomId'], $_POST ['rowId'] );
		$this->fetchRoomData ();
		echo "Row Deleted";
	}
	/**
	 *
	 * @author Chetan Sharma
	 *         This function will add a row in a room
	 */
	public function addNewRoomRow() {
		$roomObj = $this->loadModel ( 'Room' );
		$roomObj->addRow ( $_POST ['roomId'], $_POST ['rowNo'], $_POST ['computer'] );
		$this->fetchRoomData ();
		echo "Row Added";
	}
	/**
	 *
	 * @author Chetan Sharma
	 *         This function will update computer in a row of a room
	 */
	public function computerUpdate() {
		$roomObj = $this->loadModel ( 'Room' );
		$roomObj->updateComp ( $_POST ['rowId'], $_POST ['computer'] );
		$this->fetchRoomData ();
		echo "Computer Updated";
	}
	/**
	 * Function to load default picture of employee
	 */
	public function picUpload() {
		$empObj = $this->loadModel ( 'Employee' );
		$empObj->upImage ();
		echo "Pic Uploaded";
	}
	/**
	 *
	 * @author Chetan Sharma
	 *         This function will read the csv file and insert/update employee detail as per csv file
	 */
	public function csvUpload() {
		$errorMessage = array ();
		if (isset ( $_POST ) and $_SERVER ['REQUEST_METHOD'] == "POST" and $_FILES ['vasPhoto_uploads'] ['type'] == "text/csv") {
			$fileName = $_FILES ['vasPhoto_uploads'] ['name'];
			$tmpName = $_FILES ['vasPhoto_uploads'] ['tmp_name'];
			$fileType = $_FILES ['vasPhoto_uploads'] ['type'];
			$chk_ext = explode ( ",", $fileName );
			$value = 0;
			$handle = fopen ( $tmpName, "r" );
			if (! $handle) {
				die ( 'Cannot open file for reading' );
			}
			$employeeObj1 = $this->loadModel ( 'Employee' );
			$employeeObj1->truncateTable ();
			$data = fgets ( $handle );
			while ( ! feof ( $handle ) ) {
				$data = fgets ( $handle );
				$csv_array = explode ( ",", $data ); // Get all data in array of Employee
				if (isset ( $csv_array [0], $csv_array [1], $csv_array [2], $csv_array [3], $csv_array [4], $csv_array [5], $csv_array [6], $csv_array [7], $csv_array [8] )) {
					$employeeObj1->setName ( $csv_array [0] );
					$employeeObj1->setOsscube_member_id ( $csv_array [1] );
					$employeeObj1->setOfficial_email_id ( $csv_array [2] );
					$employeeObj1->setDesignation ( $csv_array [3] );
					$employeeObj1->setDepartment ( $csv_array [4] );
					$employeeObj1->setTeam ( $csv_array [5] );
					$employeeObj1->setCell ( $csv_array [6] );
					$employeeObj1->setLocation ( $csv_array [7] );
					$employeeObj1->setTerritory ( $csv_array [8] );
					$result = $employeeObj1->setEmployeeProfile ();
					if (! empty ( $result )) {
						$errorMessage [$value ++] = $result;
					}
				}
			}
		} else {
			die ( 'Please upload a csv format file.' );
		}
		if (! empty ( $errorMessage )) {
			$tableObj = $this->loadModel ( 'MessageTable' );
			$table = $tableObj->createTable ( $errorMessage, "Data is not inserted having following Employee-id" );
			echo $table;
			die ();
		} else {
			echo "Data inserted sucessfully";
			die ();
		}
	}
	
	/**
	 *
	 * @author Chetan Sharma
	 *         This function will return all employees emailid from database
	 */
	public function employeeEmail($employeeObj) {
		$result = $employeeObj->getEmployeeEmail ();
		unset ( $employeeObj );
		return $result;
	}
	/**
	 *
	 * @author Chetan Sharma
	 *         This function will get details of a room and call a graph view
	 */
	public function roomGraph() {
		$roomObj = $this->loadModel ( 'Room' );
		$roomData ['totalRow'] = $roomObj->fetchRoomDetails ( $_POST ['roomId'] );
		$roomData ['seated'] = $roomObj->getRoomSeatedDetails ( $_POST ['roomId'] );
		$this->loadView ( 'roomGraph', $roomData );
	}
	/**
	 *
	 * @author Chetan Sharma
	 *         This function will delete multiple seats
	 */
	public function multiDelEmp() {
		$objSeatEmployee = $this->loadModel ( 'SeatEmployee' );
		$objSeatEmployee->mulitDelete ( $_POST ['multiDel'], $_POST ['reason'] );
		echo "Seat Deleted";
	}
	/**
	 *
	 * @author Chetan Sharma
	 *         This function will get users panal page
	 */
	public function getUsersView() {
		$userObj = $this->loadModel ( 'Users' );
		$result = $userObj->fetchAllAdminUser ();
		$this->loadView ( 'UsersPanal', $result );
	}
	/**
	 *
	 * @author Chetan Sharma
	 *         This function will get report page with all data
	 */
	public function reportFetch() {
		$userObj = $this->loadModel ( 'Users' );
		$allData ['users'] = $userObj->fetchAllAdminUser (); // Get user Details
		$roomObj = $this->loadModel ( 'Room' );
		$allData ['rooms'] = $roomObj->fetchAllRoomDetails (); // Get Room Details
		$empObj = $this->loadModel ( 'Employee' );
		$allData ['employee'] = $empObj->getAllEmployee (); // Get Employee Details
		$this->loadView ( 'Report', $allData ); // Render Report page
	}
	/**
	 * Function to Delete a Users
	 */
	public function deleteUser() {
		$userObj = $this->loadModel ( 'Users' );
		$del = $userObj->deleteAdminUser ();
		echo "User Deleted";
	}
	/**
	 * Function To craete a new users
	 */
	public function createUser() {
		$validate = new validate ();
		$validate->validator ( "UserName", $_REQUEST ['user'], 'required#alphanumeric#minlength=4#maxlength=25', 'UserName Required#UserName must be alphanumeric Required#Enter UserName atleast 4 characters long#UserName should not be more than 25 characters long' );
		$validate->validator ( "Password", $_REQUEST ['password'], 'required#alphanumeric#minlength=4#maxlength=25', 'Password Required#Password must be alphanumeric Required#Enter Password atleast 4 characters long#Password should not be more than 25 characters long' );
		$error = $validate->result ();
		
		if (empty ( $error )) {
			$userObj = $this->loadModel ( 'Users' );
			$createUser = $userObj->createAdminUser ();
			if ($createUser) {
				$objLogger = new Logger (); // Maintain a log here
				$boolLogResult = $objLogger->logAdminUserCreation ();
				echo "User Created";
			} else {
				echo "Sorry Try Again!!!!";
			}
		} else {
			if ($error ['UserName']) {
				echo $error ['UserName'];
			}
			if ($error ['Password']) {
				echo $error ['Password'];
			}
		}
	}
	/**
	 * Function to change password
	 */
	public function changePassword() {
		$validate = new validate (); // Validate User password
		$validate->validator ( "Password", $_REQUEST ['passwd'], 'required#alphanumeric#minlength=4#maxlength=25', 'Password Required#alphanumeric Required#Enter Password atleast 4 characters long#Password should not be more than 25 characters long' );
		$error = $validate->result ();
		
		if (empty ( $error )) {
			$userObj = $this->loadModel ( 'Users' );
			$createUser = $userObj->changeAdminPassword (); // Change User Password
			if ($createUser == 1) {
				echo "New Password Cannot Be Null";
			} elseif ($createUser == 0) {
				echo "Old Password Does Not Match";
			} else {
				$objLogger = new Logger ();
				$boolLogResult = $objLogger->logAdminUserPasswordChange (); // Log Password change
				echo "Password Changed";
			}
		} else {
			echo $error ['Password'];
		}
	}
	/**
	 *
	 * @author Chetan Sharma
	 *         This function will load Department Seat Color Select Panel
	 */
	public function deptColor() {
		$roomObj = $this->loadModel ( 'Departments' );
		$departments = $roomObj->deptColor ();
		$this->loadView ( 'deptcolor', $departments );
	}
	/**
	 *
	 * @author Chetan Sharma
	 * @return string This function will save Department Colors in a Constant File
	 */
	public function saveDeptColor() {
		$error = "";
		$validate = new validate (); // Validate color
		foreach ( $_REQUEST as $key => $value ) {
			if ($key !== "controller" && $key !== "method") {
				$departments [$key] = $value;
			}
		}
		// Set Department wise color
		foreach ( $departments as $key => $value ) {
			$validate->validator ( "colorCode", $value, 'colorCode', 'Not A Valid Color Code' );
		}
		$error = $validate->result ();
		if (empty ( $error )) {
			$roomObj = $this->loadModel ( 'Departments' );
			$dept = $roomObj->saveDeptColor ( $departments ); // Save color for department
			if ($dept) {
				echo "Colour Updated !!!!!";
			}
		} else {
			echo $error ['colorCode'];
		}
	}
	/**
	 * Function to Fetch logs for report
	 */
	public function fetchLogs()
	{
		
		$logFor=$_POST['logFor'];
		$objLogger = new Logger ();
		
		switch ($logFor) 
		{
			case 'admin' :
				
				$logs=$objLogger->adminReportFetch($this->convertDate($_POST['fromDate']),$this->convertDate($_POST['toDate']),$_POST['adminId']);
				echo json_encode($logs);
				break;
			case 'rooms' :
				$logs=$objLogger->roomReportFetch($this->convertDate($_POST['fromDate']),$this->convertDate($_POST['toDate']),$_POST['roomName']);
				echo json_encode($logs);
				break;
			case 'row' :
				$logs=$objLogger->rowReportFetch($this->convertDate($_POST['fromDate']),$this->convertDate($_POST['toDate']),$_POST['roomName'],$_POST['rowId']);
				echo json_encode($logs);
				break;
			case 'computer' :
				$logs=$objLogger->computerReportFetch($this->convertDate($_POST['fromDate']),$this->convertDate($_POST['toDate']),$_POST['roomName'],$_POST['rowId'],(intval($_POST['computer'])+1));
				echo json_encode($logs);
				break;
			case 'employee' :
				$logs=$objLogger->empReportFetch($this->convertDate($_POST['fromDate']),$this->convertDate($_POST['toDate']),$_POST['empId']);
				echo json_encode($logs);
				break;
			case 'system' :
				$logs=$objLogger->sysReportFetch($this->convertDate($_POST['fromDate']),$this->convertDate($_POST['toDate']),$_POST['sysAction']);
				echo json_encode($logs);
				break;
		}
		die;
	}
	/**
	 * 
	 * @param string $date
	 * @return string
	 */
	public function convertDate($date)
	{
		$dateArr=explode('/', $date);
		return $dateArr[2].'-'.$dateArr[0].'-'.$dateArr[1];
	}
	/**
	 * Function to load Upload csv file view
	 */
	public function loadUploadView()
	{
		$this->loadView('uploadcsv');
	}
	/**
	 * Function to load Upload csv file view
	 */
	public function errorView()
	{
		$this->loadView('error404');
	}
	
}
