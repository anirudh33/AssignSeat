<?php
class Logger
{
	private $agent = "";
	private $info = array();
	
	function __construct(){
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
		return;		
	}
	
	/*
	 * function is used to log the entry into Log/Current Folder when user logs out from the systen
	 */
	public function logLogoutEntryCuurentFile()
	{
		$logData = date('D - d/M/Y - H:i:s').' User " '.strtoupper($_SESSION['username']).' " Logged into the system '." \r\n";
		$logData .= 'From the IP '.$_SERVER['REMOTE_ADDR'].' and browser = '.$this->info['Browser']." \r\n";
		$logData .= 'Browser version = '.$this->info['Version'].', Os = '.$this->info['Operating System']." \r\n";
		$logData .= "========================= \n\n";
		$fileName = './Log/Current/CurrentHistory.txt';
		$fp = fopen($fileName,'a');
		fwrite($fp,$logData);
		fclose($fp);
		return;
	}
	
	/*
	 * function is used to log all the activities performed by the user while he/she is logged in
	 */
	public function logAllActivityCuurentFile($logActivity = array())
	{
		if(!empty($logActivity))
		{
			$logData = date('D - d/M/Y - H:i:s').' User " '.strtoupper($logActivity['uname']).' " Assigned the seat number "'.$logActivity['seatid'].'" in room "'.$logActivity['room'].'"' ;
			$logData .= ' of employee "'.strtoupper($logActivity['empid']).'" at row '.$logActivity['row'].' , computer "'.$logActivity['computerid'].'"'."\r\n";
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