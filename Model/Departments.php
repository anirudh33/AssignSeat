
<?php

class Departments extends DBConnection {
    
	/*
	* @author Amber Sharma
	*
	* This function will fetch distinct departments from Database
	*
	* */
	public function deptColor()
	{
		$data = array();
		$data['tables'] = array("employee");
		$data['columns'] = array(' distinct department');
		$result=$this->_db->select($data);
		$myResult=array();
		while ($row = $result->fetch(PDO::FETCH_ASSOC))
		{
			$myResult[]=$row;
		}
		
		return  $myResult;
	}
	

	/*
	* @author Amber Sharma
	*
	* This function will save color codes in a Constant file
	*
	* */
	public function saveDeptColor($data = array())
	{
		
		$fileName = getcwd ();
		$fileName .= "/libraries/constants.php";
		foreach($data as $key => $value)
		{
			$searchfor = strtoupper($key);
			$contents = file_get_contents($fileName);
			$pattern = preg_quote($searchfor, '/');
			$pattern = "/^.*$pattern.*\$/m";
			if(preg_match_all($pattern, $contents, $matches))
			{
				$arr = array();
				$actualValue = $matches[0][0] ; 
				$matches[0][0] = str_replace("define (", "", $matches[0][0]);
				$matches[0][0] = str_replace(");", "", $matches[0][0]);
				$matches[0][0] = str_replace("'", "", $matches[0][0]);
				$matches[0][0] = str_replace('"', '', $matches[0][0]);
				$arr[] = explode("," , $matches[0][0]);
				if(strcmp($value,ltrim($arr[0][1])) != 0)
				{
					$logData = "define ('" . strtoupper($key) . "',";
					$logData .= '"' . $value . '" );' ;
					$contents=str_replace($actualValue, $logData,$contents);
					file_put_contents($fileName, $contents);
				}
			}
			else
			{
				$logData = "/*". "\r\n";
				$logData .= "*" . $key ." Identification Code" . "\r\n";
				$logData .= "*/". "\r\n";
				$logData .= "define ('" . strtoupper($key) . "',";
				$logData .= '"' . $value . '" );' . "\r\n\n\n";
				$fp = fopen($fileName,'a');
				fwrite($fp,$logData);
			}
				
		}
		return 1;

	}
}
		
		
		
?>


