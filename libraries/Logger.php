<?php
include_once('DBconnect.php');
class Logger extends DBConnection
{
	private $agent = "";
	private $info = array();
	
	function __construct(){
		parent::__construct();
		$this->agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : NULL;
		$this->getBrowser();
		$this->getOS();
		//return($this->showInfo("all"));
	}
	/*
	 * function is used to log the entry into Log/Current folder when user logs in to the systen 
	 */
	public function logLoginEntryCuurentFile()
	{
		$logData = date('D - d/M/Y - H:i:s').' User " '.strtoupper($_SESSION['username']).' " Logged into the system '." \r\n";
		$logData .= 'From the IP '.$_SERVER['REMOTE_ADDR'].' and browser = '.$this->info['Browser']." \r\n";
		$logData .= 'Browser version = '.$this->info['Version'].', Os = '.$this->info['Operating System']." \r\n";
		$logData .= "========================= \n\n";
		$fileName = './Log/Current/CurrentHistory.txt';
		$fp = fopen($fileName,'a');
		fwrite($fp,$logData);
		fclose($fp);
		//die ($logData);
		
		//code to enter the log in the database table Log

		$data['tables'] = "log";
		$insertedValues = array (
				"user_id"	=> $_SESSION['userid'],
				"action_performed"	=> "LI",
				"date_of_log"		=> date("d/m/y H:i:s",time()),
				"details"	=> str_replace(array("\r\n","\n","="),"",$logData),
				);
		$result = $this->_db->insert($data['tables'],$insertedValues);
		return;		
	}
	
	/*
	 * function is used to log the entry into Log/Current Folder when user logs out from the systen
	 */
	public function logLogoutEntryCuurentFile()
	{
		$logData = date('D - d/M/Y - H:i:s').' User " '.strtoupper($_SESSION['username']).' " Logged out the system '." \r\n";
		$logData .= 'From the IP '.$_SERVER['REMOTE_ADDR'].' and browser = '.$this->info['Browser']." \r\n";
		$logData .= 'Browser version = '.$this->info['Version'].', Os = '.$this->info['Operating System']." \r\n";
		$logData .= "========================= \n\n";
		$fileName = './Log/Current/CurrentHistory.txt';
		$fp = fopen($fileName,'a');
		fwrite($fp,$logData);
		fclose($fp);
$data['tables'] = "log";
		$insertedValues = array (
				"user_id"	=> $_SESSION['userid'],
				"action_performed"	=> "LO",
				"date_of_log"		=> date("d/m/y H:i:s",time()),
				"details"	=> str_replace(array("\r\n","\n","="),"",$logData),
				);
		$result = $this->_db->insert($data['tables'],$insertedValues);
		return;
	}
	
	/*
	 * function is used to log all the activities performed by the user while he/she is logged in
	 */
	public function logAssignSeatCuurentFile($logActivity = array())
	{
		if(!empty($logActivity))
		{
			$logData = date('D - d/M/Y - H:i:s').' User " '.strtoupper($logActivity['uname']).' " Assigned the seat number "'.$logActivity['seatid'].'" in room "'.$logActivity['room'].'"' ;
			$logData .= ' of employee "'.strtoupper($logActivity['ename']).'" at row '.$logActivity['row'].' , computer "'.$logActivity['computerid'].'"'."\r\n";
			$logData .= 'From the IP '.$_SERVER['REMOTE_ADDR'].' and browser = '.$this->info['Browser']." \r\n";
			$logData .= 'Browser version = '.$this->info['Version'].', Os = '.$this->info['Operating System']." \r\n";
			$logData .= "========================= \n\n";
			$fileName = './Log/Current/CurrentHistory.txt';
			$fp = fopen($fileName,'a');
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
				"date_of_log"		=> date("d/m/y H:i:s",time()),
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
	
	/*
	 * function is used to log all the seat Deletion performed by the user while he/she is logged in
	*/
	public function logDeleteSeatCuurentFile($logDelete = array())
	{
		if(!empty($logDelete))
		{
			$logData = date('D - d/M/Y - H:i:s').' User " '.strtoupper($logDelete['uname']).' " delete the employee "'.strtoupper($logDelete['ename']).'" from room "'.$logDelete['room'].'"' ;
			$logData .= ' from row "'.$logDelete['row'].' " , computer "'.$logDelete['computerid'].'"'."\r\n";
			$logData .= 'From the IP '.$_SERVER['REMOTE_ADDR'].' and browser = '.$this->info['Browser']." \r\n";
			$logData .= 'Browser version = '.$this->info['Version'].', Os = '.$this->info['Operating System']." \r\n";
			$logData .= "========================= \n\n";
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
			    "date_of_log"		=> date("d/m/y H:i:s",time()),
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
	
	/*
	 * function is used to log all the seat Deletion performed by the user while he/she is logged in
	*/
	public function logUpdateSeatLocationCuurentFile($logUpdateSeat = array())
	{
		if(!empty($logUpdateSeat))
		{
			$logData = date('D - d/M/Y - H:i:s').' User " '.strtoupper($logUpdateSeat['uname']).' " moved the employee "'.strtoupper($logUpdateSeat['ename']).' " From room " '.$logUpdateSeat['frmroom'].' ", Row number "'.$logUpdateSeat['frmrow'].' ", From Computer Id "'.$logUpdateSeat['frmcomputerid'].'" To seat number "'.$logUpdateSeat['seatid'].'" in room "'.$logUpdateSeat['room'].'"' ;
			$logData .= '" at row '.$logUpdateSeat['row'].' , computer "'.$logUpdateSeat['computerid'].'"'."\r\n";
			$logData .= 'From the IP '.$_SERVER['REMOTE_ADDR'].' and browser = '.$this->info['Browser']." \r\n";
			$logData .= 'Browser version = '.$this->info['Version'].', Os = '.$this->info['Operating System']." \r\n";
			$logData .= "========================= \n\n";
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
			    "date_of_log"		=> date("d/m/y H:i:s",time()),
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
	
	/*
	 * A Cron job is run by the system to call this function
	 */
	public function logHistoryFile()
	{
		$fileName = './Log/Current/CurrentHistory.txt';
		$logData = file_get_contents('./Log/Current/CurrentHistory.txt');
		$historyFile = './Log/History/'.date('d-M-y').'.txt';
		$fp = fopen($historyFile,'a');
		fwrite($fp,$logData);
		//file_put_contents($fileName, "");
		fclose($fp);
		return;
	}
	
	public function logAdminUserCreation()
	{
		$logData = $_SESSION['username']." Created A New Admin User Named ".$_REQUEST['user'];
		$this->logAdminUserAction('UA',$logData);
	   /* 
	    $data['tables'] = "log";
	    $insertedValues = array (
	        "user_id"	=> $_SESSION['userid'],
	        "action_performed"	=> "UA",
	        "date_of_log"		=> date("d/m/y H:i:s",time()),
	        "details"	=> str_replace(array("\r\n","\n","="),"",$logData),
	    );
	    $result = $this->_db->insert($data['tables'],$insertedValues);
	    return "true";*/
	    
	}
	
	public function logAdminUserPasswordChange()
	{
	    $logData = $_SESSION['username']." Changed his/her password ";
	    $this->logAdminUserAction('PC',$logData);
	    /*
	    $data['tables'] = "log";
	    $insertedValues = array (
	        "user_id"	=> $_SESSION['userid'],
	        "action_performed"	=> "PC",
	        "date_of_log"		=> date("d/m/y H:i:s",time()),
	        "details"	=> str_replace(array("\r\n","\n","="),"",$logData),
	    );
	    $result = $this->_db->insert($data['tables'],$insertedValues);
	    return "true";*/
	}
	
	public function logAdminUserDelete()
	{
		$logData = $_SESSION['username']." Deleted the user ";
	    $this->logAdminUserAction('UD',$logData);
/*		$data['tables'] = "log";
	    $insertedValues = array (
	        "user_id"	=> $_SESSION['userid'],
	        "action_performed"	=> "PC",
	        "date_of_log"		=> date("d/m/y H:i:s",time()),
	        "details"	=> str_replace(array("\r\n","\n","="),"",$logData),
	    );
	    $result = $this->_db->insert($data['tables'],$insertedValues);
	    return "true";*/
	}
	// this function is used to make an entry into the database that describes which action is performed by admin
	public function logAdminUserAction($action,$logMessage)
	{
		$data['tables'] = "log";
	    $insertedValues = array (
	        "user_id"	=> $_SESSION['userid'],
	        "action_performed"	=> $action,
	        "date_of_log"		=> date("d/m/y H:i:s",time()),
	        "details"	=> str_replace(array("\r\n","\n","="),"",$logMessage),
	    );
	    $result = $this->_db->insert($data['tables'],$insertedValues);
	    return "true";
	}
	
	
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
}
