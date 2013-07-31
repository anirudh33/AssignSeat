<?php
class Logger
{
	/*
	 * function is used to log the entry into Log/Current folder when user logs in to the systen 
	 */
	public function logLoginEntryCuurentFile()
	{
		$logData = '-->User " '.strtoupper($_SESSION['username']).' " Logged into the system at '.date('D - d/M/Y - H:i:s');
		$logData .= ' From the IP '.$_SERVER['REMOTE_ADDR'].' and browser = '.$_SERVER['HTTP_USER_AGENT']." \r\n";
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
		$logData = '-->User " '.strtoupper($_SESSION['username']).' " Logged Out from the system at '.date('D - d/M/Y - H:i:s');
		$logData .= ' From the IP '.$_SERVER['REMOTE_ADDR'].' and browser = '.$_SERVER['HTTP_USER_AGENT']." \r\n";
		$fileName = './Log/Current/CurrentHistory.txt';
		$fp = fopen($fileName,'a');
		fwrite($fp,$logData);
		fclose($fp);
		return;
	}
	
	/*
	 * function is used to log all the activities performed by the user while he/she is logged in
	 */
	public function logAllActivityCuurentFile()
	{
	
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
}