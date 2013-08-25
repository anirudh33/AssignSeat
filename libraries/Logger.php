<?php
/**
 * **************************** Creation Log *******************************
 * File Name                   -  Logger.php
 * Project Name                -  AssignSeat
 * Description                 -  class to log all history in database 
 * @Version                   -  1.0
 * Created by                  -  Chetan Sharma
 * Created on                  -  August 03, 2013
 * ***************************** Update Log ********************************
 * Sr.NO.		Version		Updated by           Updated on          Description
 * -------------------------------------------------------------------------
 * 
 * *************************************************************************
 */
include_once('DBconnect.php');
class Logger extends DBConnection
{
	/**
	 * 
	 * @var string
	 */
	private $agent = "";
	/**
	 * 
	 * @var array of logs 
	 */
	private $info = array();
	
	function __construct(){
		parent::__construct();
		$this->agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : NULL;
		$this->getBrowser(); // get user browser
		$this->getOS(); // get user OS
	}
	/**
	 * Function is used to log the entry into Log/Current folder when user logs in to the systen 
	 */
	public function logLoginEntryCuurentFile()
	{
		$logData = date('D - d/M/Y - H:i:s').' User " '.strtoupper($_SESSION['username']).' " Logged into the system '." \r\n<br/>";
		$logData .= 'From the IP '.$_SERVER['REMOTE_ADDR'].' and browser = '.$this->info['Browser']." \r\n<br/>";
		$logData .= 'Browser version = '.$this->info['Version'].', Os = '.$this->info['Operating System']." \r\n<br/>";
		$logData .= "========================= \r\n<br/>";
		$fileName = './Log/Current/CurrentHistory.txt';
		$fp = fopen($fileName,'a'); // Log Data in text file
		fwrite($fp,$logData);
		fclose($fp);
		
		//code to enter the log in the database table Log

		$data['tables'] = "log";
		$insertedValues = array (
				"user_id"	=> $_SESSION['userid'],
				"action_performed"	=> "LI",
				"date_of_log"		=> date("Y/m/d H:i:s",time()),
				"details"	=> str_replace(array("\r\n","\n","="),"",$logData),
				);
		$result = $this->_db->insert($data['tables'],$insertedValues);
		return;		
	}
	
	/**
	 * Function is used to log the entry into Log/Current Folder when user logs out from the systen
	 */
	public function logLogoutEntryCuurentFile()
	{
		$logData = date('D - d/M/Y - H:i:s').' User " '.strtoupper($_SESSION['username']).' " Logged out the system '." \r\n<br/>";
		$logData .= 'From the IP '.$_SERVER['REMOTE_ADDR'].' and browser = '.$this->info['Browser']." \r\n<br/>";
		$logData .= 'Browser version = '.$this->info['Version'].', Os = '.$this->info['Operating System']." \r\n<br/>";
		$logData .= "========================= \r\n<br/>";
		$fileName = './Log/Current/CurrentHistory.txt';
		$fp = fopen($fileName,'a'); // Log Data in text file
		fwrite($fp,$logData);
		fclose($fp);
$data['tables'] = "log";
		$insertedValues = array (
				"user_id"	=> $_SESSION['userid'],
				"action_performed"	=> "LO",
				"date_of_log"		=> date("Y/m/d H:i:s",time()),
				"details"	=> str_replace(array("\r\n","\n","="),"",$logData),
				);
		// Insert logs in database
		$result = $this->_db->insert($data['tables'],$insertedValues);
		return;
	}
	
	/**
	 * Function is used to log all the activities performed by the user while he/she is logged in
	 */
	public function logAssignSeatCuurentFile($logActivity = array())
	{
		if(!empty($logActivity))
		{
			$logData = date('D - d/M/Y - H:i:s').' User " '.strtoupper($logActivity['uname']).' " Assigned the seat number "'.$logActivity['seatid'].'" in room "'.$logActivity['room'].'"' ;
			$logData .= ' of employee "'.strtoupper($logActivity['ename']).'" at row '.$logActivity['row'].' , computer "'.$logActivity['computerid'].'"'."\r\n<br/>";
			$logData .= 'From the IP '.$_SERVER['REMOTE_ADDR'].' and browser = '.$this->info['Browser']." \r\n<br/>";
			$logData .= 'Browser version = '.$this->info['Version'].', Os = '.$this->info['Operating System']." \r\n<br/>";
			$logData .= 'Reason is :- '.$logActivity['reason'].'\r\n<br/>';
			$logData .= "========================= \r\n<br/>";
			$fileName = './Log/Current/CurrentHistory.txt';
			$fp = fopen($fileName,'a'); // Log data in text file
			fwrite($fp,$logData);
			fclose($fp);
			$assigneFile = './Log/Current/SeatChangeBy'.ucfirst($logActivity['uname']).'.txt';
			$fileData = fopen($assigneFile,'a');
			fwrite($fileData,$logData);
			fclose($fileData);
		// code to log the entry in database
		$data['tables'] = "log";
		$insertedValues = array (
				"user_id"	=> $_SESSION['userid'],
				"emp_id"	=> $logActivity['empid'],
				"room_name"	=> $logActivity['room'],
				"row_id"	=> $logActivity['row'],
				"computer_id"	=> $logActivity['computerid'],
				"action_performed"	=> "SA",
				"date_of_log"		=> date("Y/m/d H:i:s",time()),
				"details"	=> str_replace(array("\r\n","\n","="),"",$logData),
				);
		$result = $this->_db->insert($data['tables'],$insertedValues);
			return "true";
		}
		else
		{
			return "false";
		}
	}
	
	/**
	* function is used to log all the seat Deletion performed by the user while he/she is logged in
	*/
	public function logDeleteSeatCuurentFile($logDelete = array())
	{
		if(!empty($logDelete))
		{
			$logData = date('D - d/M/Y - H:i:s').' User " '.strtoupper($logDelete['uname']).' " delete the employee "'.strtoupper($logDelete['ename']).'" from room "'.$logDelete['room'].'"' ;
			$logData .= ' from row "'.$logDelete['row'].' " , computer "'.$logDelete['computerid'].'"'."<br/>";
			$logData .= 'From the IP '.$_SERVER['REMOTE_ADDR'].' and browser = '.$this->info['Browser']." <br/>";
			$logData .= 'Browser version = '.$this->info['Version'].', Os = '.$this->info['Operating System']." <br/>";
			$logData .= 'Reason is:- '.$logDelete['reason'].' <br/>';
			$logData .= "========================= <br/>";
			$fileName = './Log/Current/CurrentHistory.txt';
			$fp = fopen($fileName,'a');
			fwrite($fp,$logData);
			fclose($fp);
			$assigneFile = './Log/Current/SeatChangeBy'.ucfirst($logDelete['uname']).'.txt';
			$fileData = fopen($assigneFile,'a');
			fwrite($fileData,$logData);
			fclose($fileData);
			// code to log the delete seat
			$data['tables'] = "log";
			$insertedValues = array (
			    "user_id"	=> $_SESSION['userid'],
			    "emp_id"	=> $logDelete['empid'],
			    "room_name"	=> $logDelete['room'],
			    "row_id"	=> $logDelete['row'],
			    "computer_id"	=> $logDelete['computerid'],
			    "action_performed"	=> "SD",
			    "date_of_log"		=> date("Y/m/d H:i:s",time()),
			    "details"	=> str_replace(array("\r\n","\n","="),"",$logData),
			);
			$result = $this->_db->insert($data['tables'],$insertedValues);
			return "true";
		}
		else
		{
			return "false";
		}
	}
	
	/**
	* function is used to log all the seat Deletion performed by the user while he/she is logged in
	*/
	public function logUpdateSeatLocationCuurentFile($logUpdateSeat = array())
	{
		if(!empty($logUpdateSeat))
		{
			$logData = date('D - d/M/Y - H:i:s').' User " '.strtoupper($logUpdateSeat['uname']).' " moved the employee "'.strtoupper($logUpdateSeat['ename']).' " From room " '.$logUpdateSeat['frmroom'].' ", Row number "'.$logUpdateSeat['frmrow'].' ", From Computer Id "'.$logUpdateSeat['frmcomputerid'].'" To seat number "'.$logUpdateSeat['seatid'].'" in room "'.$logUpdateSeat['room'].'"' ;
			$logData .= '" at row '.$logUpdateSeat['row'].' , computer "'.$logUpdateSeat['computerid'].'"'."\r\n<br/>";
			$logData .= 'From the IP '.$_SERVER['REMOTE_ADDR'].' and browser = '.$this->info['Browser']." \r\n<br/>";
			$logData .= 'Browser version = '.$this->info['Version'].', Os = '.$this->info['Operating System']." \r\n<br/>";
			$logData .= 'Reason is :- '.$logUpdateSeat['reason'].'\r\n<br/>';
			$logData .= "========================= \r\n<br/>";
			$fileName = './Log/Current/CurrentHistory.txt';
			$fp = fopen($fileName,'a');
			fwrite($fp,$logData);
			fclose($fp);
			$assigneFile = './Log/Current/SeatChangeBy'.ucfirst($logUpdateSeat['uname']).'.txt';
			$fileData = fopen($assigneFile,'a');
			fwrite($fileData,$logData);
			fclose($fileData);
			// code to reallocate the seat
			
			$data['tables'] = "log";
			$insertedValues = array (
			    "user_id"	=> $_SESSION['userid'],
			    "emp_id"	=> $logUpdateSeat['empid'],
			    "room_name"	=> $logUpdateSeat['room'],
			    "row_id"	=> $logUpdateSeat['row'],
			    "computer_id"	=> $logUpdateSeat['computerid'],
			    "action_performed"	=> "SR",
			    "date_of_log"		=> date("Y/m/d H:i:s",time()),
			    "details"	=> str_replace(array("\r\n","\n","="),"",$logData),
			);
			$result = $this->_db->insert($data['tables'],$insertedValues);
			return "true";
			
		}
		else
		{
			return "false";
		}
	}
	
	/**
	 * A Cron job is run by the system to call this function
	 */
	public function logHistoryFile()
	{
		$fileName = './Log/Current/CurrentHistory.txt';
		$logData = file_get_contents('./Log/Current/CurrentHistory.txt');
		$historyFile = './Log/History/'.date('d-M-y').'.txt';
		$fp = fopen($historyFile,'a');
		fwrite($fp,$logData);		
		fclose($fp);
		return;
	}
	/**
	 * Function to log Admin user creation log
	 */
	public function logAdminUserCreation()
	{
		$logData = $_SESSION['username']." Created A New Admin User Named ".$_REQUEST['user'];
		$this->logAdminUserAction('UA',$logData);   
	}
	/**
	 * Function to log Admin user password change
	 */
	public function logAdminUserPasswordChange()
	{
	    $logData = $_SESSION['username']." Changed his/her password ";
	    $this->logAdminUserAction('PC',$logData);
	}
	/**
	 * Function to log Admin user delete
	 */
	public function logAdminUserDelete()
	{
		$logData = $_SESSION['username']." Deleted the user ";
	    $this->logAdminUserAction('UD',$logData);
	}
	/**
	 *  This function is used to make an entry into the 
	 *  database that describes which action is performed by admin
	 */
	public function logAdminUserAction($action,$logMessage)
	{
		$data['tables'] = "log";
	    $insertedValues = array (
	        "user_id"	=> $_SESSION['userid'],
	        "action_performed"	=> $action,
	        "date_of_log"		=> date("Y/m/d H:i:s",time()),
	        "details"	=> str_replace(array("\r\n","\n","="),"",$logMessage),
	    );
	    $result = $this->_db->insert($data['tables'],$insertedValues);
	    return "true";
	}
	
	/**
	 * Function to get user browser details
	 * @return multitype:
	 */
	public function getBrowser(){
		$browser = array("Navigator"            => "/Navigator(.*)/i",
				"Firefox"              => "/Firefox(.*)/i",
				"Internet Explorer"    => "/MSIE(.*)/i",
				"Google Chrome"        => "/chrome(.*)/i",
				"MAXTHON"              => "/MAXTHON(.*)/i",
				"Opera"                => "/Opera(.*)/i",
		);
		foreach($browser as $key => $value){
			if(preg_match($value, $this->agent)){
				$this->info = array_merge($this->info,array("Browser" => $key));
				$this->info = array_merge($this->info,array("Version" => $this->getVersion($key, $value, $this->agent)));
				break;
			}else{
				$this->info = array_merge($this->info,array("Browser" => "UnKnown"));
				$this->info = array_merge($this->info,array("Version" => "UnKnown"));
			}
		}
		return $this->info['Browser'];
	}
	/**
	 * Function to get user OS details
	 * @return multitype:
	 */
	public function getOS(){
		$OS = array("Windows"   =>   "/Windows/i",
				"Linux"     =>   "/Linux/i",
				"Unix"      =>   "/Unix/i",
				"Mac"       =>   "/Mac/i"
		);
	
		foreach($OS as $key => $value){
			if(preg_match($value, $this->agent)){
				$this->info = array_merge($this->info,array("Operating System" => $key));
				break;
			}
		}
		return $this->info['Operating System'];
	}
	/**
	 * Function to get user browser version
	 * @param string $browser
	 * @param string $search
	 * @param string $string
	 * @return string
	 */
	public function getVersion($browser, $search, $string){
		$browser = $this->info['Browser'];
		$version = "";
		$browser = strtolower($browser);
		preg_match_all($search,$string,$match);
		switch($browser){
			case "firefox": $version = str_replace("/","",$match[1][0]);
			break;
	
			case "internet explorer": $version = substr($match[1][0],0,4);
			break;
	
			case "opera": $version = str_replace("/","",substr($match[1][0],0,5));
			break;
	
			case "navigator": $version = substr($match[1][0],1,7);
			break;
	
			case "maxthon": $version = str_replace(")","",$match[1][0]);
			break;
	
			case "google chrome": $version = substr($match[1][0],1,10);
		}
		return $version;
	}
	/**
	 * Function to create Browser information
	 * @param string $switch
	 * @return multitype:|multitype:multitype: |string
	 */
	public function showInfo($switch){
		$switch = strtolower($switch);
		switch($switch){
			case "browser": return $this->info['Browser'];
			break;
	
			case "os": return $this->info['Operating System'];
			break;
	
			case "version": return $this->info['Version'];
			break;
	
			case "all" : return array($this->info["Version"], $this->info['Operating System'], $this->info['Browser']);
			break;
	
			default: return "Unkonw";
			break;
	
		}
	}
	/**
	 * Function to Fetch Admin logs
	 * @param string $fromDate
	 * @param string $toDate
	 * @param number $adminId
	 * @return multitype:array of logs
	 */
	public function adminReportFetch($fromDate,$toDate,$adminId)
	{
		
		$data ['columns'] = array (
				'details' 
		);
		$data ['tables'] = array (
				"log" 
		);
		$data ['conditions'] = array (array (
				'user_id='.$adminId.' AND date_of_log BETWEEN "'.$fromDate.'" AND "'.$toDate.'" ORDER BY date_of_log DESC'
				
			),true	);
		$result = $this->_db->select($data);
		$myResult = array();
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$myResult[] = $row;
		}
		return array_reverse($myResult);
		
	} 
	/**
	 * Function to fetch Room logs
	 * @param string $fromDate
	 * @param string $toDate
	 * @param string $roomName
	 * @return multitype:array of logs
	 */
	public function roomReportFetch($fromDate,$toDate,$roomName)
	{
	
		$data ['columns'] = array (
				'details'
		);
		$data ['tables'] = array (
				"log"
		);
		$data ['conditions'] = array (array (
				'room_name="'.$roomName.'" AND date_of_log BETWEEN "'.$fromDate.'" AND "'.$toDate.'" ORDER BY date_of_log DESC'
	
		),true	);
		$result = $this->_db->select($data);
		$myResult = array();
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$myResult[] = $row;
		}
		return array_reverse($myResult);
	
	}
	/**
	 * Function to Fetch Room's Row logs
	 * @param string $fromDate
	 * @param string $toDate
	 * @param string $roomName
	 * @param string $rowId
	 * @return multitype:array of logs
	 */
	public function rowReportFetch($fromDate,$toDate,$roomName,$rowId)
	{
	
		$data ['columns'] = array (
				'details'
		);
		$data ['tables'] = array (
				"log"
		);
		$data ['conditions'] = array (array (
				'room_name="'.$roomName.'" AND row_id='.$rowId.' AND date_of_log BETWEEN "'.$fromDate.'" AND "'.$toDate.'" ORDER BY date_of_log DESC'
	
		),true	);
		$result = $this->_db->select($data);
		$myResult = array();
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$myResult[] = $row;
		}
		return array_reverse($myResult);
	
	}
	/**
	 * Function  Fetch Room's Row's Computer logs
	 * @param string_type $fromDate
	 * @param string_type $toDate
	 * @param string_type $roomName
	 * @param numeric_type $rowId
	 * @param numaric_type $computer
	 * @return text array $myResult
	 */
	public function computerReportFetch($fromDate,$toDate,$roomName,$rowId,$computer)
	{
	
		$data ['columns'] = array (
				'details'
		);
		$data ['tables'] = array (
				"log"
		);
		$data ['conditions'] = array (array (
				'room_name="'.$roomName.'" AND row_id='.$rowId.' AND computer_id='.$computer.' AND date_of_log BETWEEN "'.$fromDate.'" AND "'.$toDate.'" ORDER BY date_of_log DESC'
	
		),true	);
		$result = $this->_db->select($data);
		$myResult = array();
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$myResult[] = $row;
		}
		return array_reverse($myResult);
	
	}
	/**
	 * Function to fetch employee logs
	 * @param string_type $fromDate
	 * @param string_type $toDate
	 * @param numeric_type $empId
	 * @return text array $myResult
	 */
	public function empReportFetch($fromDate,$toDate,$empId)
	{
	
		$data ['columns'] = array (
				'details'
		);
		$data ['tables'] = array (
				"log"
		);
		$data ['conditions'] = array (array (
				'emp_id="'.$empId.'" AND date_of_log BETWEEN "'.$fromDate.'" AND "'.$toDate.'" ORDER BY date_of_log DESC',
	
		),true	);
		$result = $this->_db->select($data);
		$myResult = array();
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$myResult[] = $row;
		}
		return array_reverse($myResult);
	
	}
	/**
	 * Function to Fetch system logs 
	 * @param string_type $fromDate
	 * @param string_type $toDate
	 * @param string_type $sysAction
	 * @return text array $myResult
	 */
	public function sysReportFetch($fromDate,$toDate,$sysAction)
	{
	
		$data ['columns'] = array (
				'details'
		);
		$data ['tables'] = array (
				"log"
		);
		$data ['conditions'] = array (array (
				'action_performed="'.$sysAction.'" AND date_of_log BETWEEN "'.$fromDate.'" AND "'.$toDate.'" ORDER BY date_of_log DESC',
	
		),true	);
		$result = $this->_db->select($data);
		$myResult = array();
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$myResult[] = $row;
		}
		return array_reverse($myResult);
	
	}
	
	
}