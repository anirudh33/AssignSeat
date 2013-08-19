<?php
/**
 * **************************** Creation Log *******************************
 * File Name                   -  Departments.php
 * Project Name                -  AssignSeat
 * Description                 -  Model class from RoomRow Table
 * @Version                   -  1.0
 * ***************************** Update Log ********************************
 * Sr.NO.		Version		Updated by           Updated on          Description
 * -------------------------------------------------------------------------
 *
 * *************************************************************************
 */
class CsvUpdate extends DBConnection
{
    /**
     * 
     * @return Array ResultSet
     * 
     * Fetch all the data from employee table
     */
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
    	$myResult = array ();
    	while ( $row = $result->fetch ( PDO::FETCH_ASSOC ) ) {
    		$myResult[] = $row['osscubememberid'];
    		
    	}
        return($myResult);
    }
    /**
     * 
     * @param $oldData
     * @param $newData
     * 
     * This will update the data in employee as per the CSV file
     */
    public function deletedData($oldData,$newData)
    {    
    	$result = array_diff($oldData, $newData);
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
    		while ( $row = $result->fetch ( PDO::FETCH_ASSOC ) ) {
    			$myResult[] = $row['osscubememberid'];
    		
    		}
    	print_r($result);die;
    }	
}