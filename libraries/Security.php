<?php
/*
 **************************** Creation Log *******************************
File Name                   -  Security.php
Project Name                -  SkillSeeker
Description                 -  Class file for Security
Version                     -  1.0
Created by                  -  Mohit K. Singh
Created on                  -  May 03, 2013
***************************** Update Log ********************************
Sr.NO.		Version		Updated by           Updated on          Description
-------------------------------------------------------------------------

*************************************************************************

*/


class Security
{

    public function secureMultiLogin($userLoginId)
    {
        $SID=$_COOKIE['PHPSESSID'];
        $fileName="./tmp/".str_replace(" ","",$userLoginId).".txt";
	     if($data=file_get_contents($fileName))
			{
				if($data != md5($SID))
					{
					unset($_SESSION);
					session_destroy();
					header ( "location:./index.php" );	//multiple login save
					die ();
					}
			}
			else
			{
				unset($_SESSION);
				session_destroy();
				header ( "location:./index.php" );
				die ();
			}
    }
    
    public function logSessionId($userLoginId)
    {
    	$SID=$_COOKIE['PHPSESSID'];
    	$fileName="./tmp/".str_replace(" ","",$userLoginId).".txt";
    	if (file_exists($fileName)) {
    		unlink($fileName);
    	}
    	$file=fopen($fileName,"a");	//Log session id of the users
    	fwrite($file,md5($SID));
    	fclose($file);
    }
    
    public function secureMultipleRegister()
    {
    	
    }
    
    
    public function getNewSyatemError()
    {
        $file=fopen('../temp/PHP_errors_temp.log',"a");	
        $data="";
        $data1=file_get_contents('../logs/PHP_errors.log');
        $data2=file_get_contents('../temp/PHP_errors_temp.log');
        
        $data1Length = strlen($data1);
        $data2Length = strlen($data2);
        
        
        if($data1Length > $data2Length)
        {
            $data=substr($data1,$data2Length,$data1Length);
        
            fwrite($file,$data);
            fclose($file);
            //code to mail new error in the System to the Admin

        }
    }
    
    
    
}
?>