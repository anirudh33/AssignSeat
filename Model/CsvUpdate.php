<?php
class CsvUpdate extends DBConnection
{
public function employeeDataTable ()
{
	$data = array ();
	$data ['tables'] = array (
			"employee"
	);
	$data ['conditions'] = array (
			array (
					'status="1"'
			),
			true
	);
	$result = $this->_db->select ( $data );
//print_r($result);die;
	$myResult = array ();
	while ( $row = $result->fetch ( PDO::FETCH_ASSOC ) ) {
		$myResult[] = $row['osscubememberid'];
		
	}
return($myResult);


	//echo "hi";die;
}
public function deletedData($oldData,$newData)
{

	$result = array_diff($oldData, $newData);
	echo "<pre>";
	print_r($oldData);die;
	$data = array ();
		$data ['tables'] = array (
				"employee"
		);
		$data ['conditions'] = array (
				array (
						'status="1"'
				),
				true
		);
		$result = $this->_db->select ( $data );
		//print_r($result);die;
		
		while ( $row = $result->fetch ( PDO::FETCH_ASSOC ) ) {
			$myResult[] = $row['osscubememberid'];
		
		}
		
		
	
	
	print_r($result);die;
}

	
}