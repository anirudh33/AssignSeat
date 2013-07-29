<?php
require_once SITE_PATH .'/libraries/DBconnect.php';
class Employee extends DBConnection
{
	private $_id;
	private $_name;
	
	public function searchEmp($name,$page)
	{
		$data = array();
		$data['tables'] = array("employee");
		$data['columns'] = array('SQL_CALC_FOUND_ROWS Name','ID');
		$data['conditions']=array(array('Name LIKE "%'.$name
				.'%" LIMIT '.
				$page.',10 UNION SELECT FOUND_ROWS(),"NA" '),true);
		$result=$this->_db->select($data);
		
		$myResult=array();
		while ($row = $result->fetch(PDO::FETCH_ASSOC))
		{
			$myResult[]=$row;
		}
		return  $myResult;
	}
}