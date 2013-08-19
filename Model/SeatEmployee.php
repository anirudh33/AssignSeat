<?php
/**
 * **************************** Creation Log *******************************
 * File Name                   -  SeatEmployee.php
 * Project Name                -  AssignSeat
 * Description                 -  Model class holding functionalities
 *                                to insert in database for seat allotment
 * @Version                   -  1.0
 * Created by                  -  Keshi
 * Created on                  -  August 03, 2013
 * ***************************** Update Log ********************************
 * Sr.NO.		Version		Updated by           Updated on          Description
 * -------------------------------------------------------------------------
 * 
 * *************************************************************************
 */
class SeatEmployee extends DBConnection {
    private $_eid;
    private $_sid;
    private $_computer_id;
    private $_asignee;
    private $_details;
    private $_status;
    private $_created_on;
    private $_updated_on;
    private $_emp_name;
    /**
     *
     * @return $_eid
     */
    public function getEid() {
        return $this->_eid;
    }
    
    /**
     *
     * @return $_sid
     */
    public function getSid() {
        return $this->_sid;
    }
    
    /**
     *
     * @return $_computer_id
     */
    public function getComputer_id() {
        return $this->_computer_id;
    }
    
    /**
     *
     * @return $_asignee
     */
    public function getAsignee() {
        return $this->_asignee;
    }
    
    /**
     *
     * @return $_details
     */
    public function getDetails() {
        return $this->_details;
    }
    
    /**
     *
     * @return $_status
     */
    public function getStatus() {
        return $this->_status;
    }
    
    /**
     *
     * @return $_created_on
     */
    public function getCreated_on() {
        return $this->_created_on;
    }
    
    /**
     *
     * @return $_updated_on
     */
    public function getUpdated_on() {
        return $this->_updated_on;
    }
    
    /**
     *
     * @param Integer $_eid It will store the employee ID
     */
    public function setEid($_eid) {
        $this->_eid = $_eid;
    }
    
    /**
     *
     * @param Integer $_sid It will store the seats ID
     */
    public function setSid($_sid) {
        $this->_sid = $_sid;
    }
    
    /**
     *
     * @param Integer $_computer_id It will store the Computer ID
     */
    public function setComputer_id($_computer_id) {
        $this->_computer_id = $_computer_id;
    }
    
    /**
     *
     * @param Integer $_asignee
     */
    public function setAsignee($_asignee) {
        $this->_asignee = $_asignee;
    }
    
    /**
     *
     * @param Integer $_details
     */
    public function setDetails($_details) {
        $this->_details = $_details;
    }
    
    /**
     *
     * @param Integer $_status           
     */
    public function setStatus($_status) {
        $this->_status = $_status;
    }
    
    /**
     *
     * @param DateTime $_created_on
     */
    public function setCreated_on($_created_on) {
        $this->_created_on = $_created_on;
    }
    
    /**
     *
     * @param DateTime $_updated_on
     */
    public function setUpdated_on($_updated_on) {
        $this->_updated_on = $_updated_on;
    }
    /**
     * 
     * @param String $name
     */
    public function setEmpName($name) {
        $this->_emp_name = $name;
    }
    /**
     * 
     * @return String
     */
    public function getEmpName() {
        return $this->_emp_name;
    }
   
    /**
     * 
     * @param unknown $assignInfo
     * @return string true after assigning seat to an employee
     * 
     * This method is used for assigning seat to employees
     */
    public function assignSeat($assignInfo) {
        $this->setEid ( $assignInfo ['empid'] );
        $empName = $this->getEmployeeName ( $assignInfo ['empid'] );
        $isAssigned = $this->checkEmpSeat ( $assignInfo ['empid'] );
        $this->setEmpName ( $empName );
        $this->setAsignee ( $assignInfo ['assigne'] );
        $this->setComputer_id ( $assignInfo ['computerid'] );
        $this->setDetails ( $assignInfo ['details'] );
        $this->setStatus ( 1 );
        $roomId = $this->findRoomId ( $assignInfo ['room'] );
        $sid = $this->findSid ( $roomId, $assignInfo ['row'] );
        $this->setSid ( $sid );
        /**
         * **** seat is not assigned to employee before***********
         */
        if (empty ( $isAssigned )) {
            $data ['tables'] = 'seat_employee';
            $insertValue = array (
                    'eid' => $this->getEid (), 
                    'sid' => $this->getSid (), 
                    'asignee' => $this->getAsignee (), 
                    'computer_id' => $this->getComputer_id (), 
                    'status' => $this->getStatus (), 
                    'updated_on' => $this->getUpdated_on (), 
                    'details' => $this->getDetails () );
            $result = $this->_db->insert ( $data ['tables'], $insertValue );
            return "true";
        }
        /**
         * **** seat is reallocated ***********
         */
        else {
			$frmRoom=$this->getfrmRoom($isAssigned[0]['id']);
			$frmRoom[]=$this->getComputerId($isAssigned[0]['id']);
			$_SESSION ["frmrow"]=$frmRoom[0];
			$_SESSION ["frmroom"]=$frmRoom[1];
			$_SESSION ["frmcomp"]=$frmRoom[2];
            $data = array (
                    'sid' => $this->getSid (), 
                    'computer_id' => $this->getComputer_id (), 
                    'details' => $this->getDetails () );
            $where = array ('id' => $isAssigned [0] ['id'], 'status' => 1 );
            $result = $this->_db->update ( 'seat_employee', $data, $where );
            return "true1";        
        }
    }
	/**
	 * 
	 * @author Avni jain 
	 * @return Integer This will return the Computer ID of
	 * particular seat.
	 * */
	public function getComputerId($id)
	{
		$data ['columns'] = array ('computer_id');
        $data ['conditions'] = array (
                array ('id=\'' . $id . '\' AND status="1"' ), 
                true );
        $data ['tables'] = 'seat_employee';
        $result = $this->_db->select ( $data );
		  while ( $row = $result->fetch ( PDO::FETCH_ASSOC ) ) {
            $myResult [] = $row;
        }
        return $myResult[0]['computer_id'];
	
	}
	/**
	 * @author Avni jain
	 * @param Integer $sid
	 * @return Array
	 * 
	 * This method will fetch the rows from table
	 */
	public function getfrmRoom($sid)
	{
		$data ['columns'] = array ('id','row_number');
        $data ['conditions'] = array (
                array ('id=\'' . $sid . '\' AND status="1"' ), 
                true );
        $data ['tables'] = 'room_row';
        $result = $this->_db->select ( $data );
		while ( $row = $result->fetch ( PDO::FETCH_ASSOC ) ) {
            $myResult [] = $row;
        }
		$from[0]=$myResult[0]['row_number'];
		$data ['columns'] = array ('name');
        $data ['conditions'] = array (
                array ('id=\'' . $myResult[0]['id']. '\' AND status="1"' ), 
                true );
        $data ['tables'] = 'room';
        $result = $this->_db->select ( $data );
		while ( $row = $result->fetch ( PDO::FETCH_ASSOC ) ) {
            $room [] = $row;
        }
		$from[1]=$room[0]['name'];
		return($from);
	}
	/**
	 * This method will de-allocate the seat
	 */
    public function deleteSeat() {
        $this->setStatus ( 0 );
        $data = array ('status' => $this->getStatus () );
        $where = array ('id' => $this->getEid (), 'status' => 1 );
        $result = $this->_db->update ( 'seat_employee', $data, $where );
    }
    /**
     * 
     * @author : Avni Jain 
     * called from : MainController.php.
     * description: This function is to check whether a seat is already 
     * assigned to employee or not request 
     * @param: $eid 
     * @return: Array
     */
    public function checkEmpSeat($eid) {
        $data ['columns'] = array ('id' );
        $data ['conditions'] = array (
                array ('eid=\'' . $eid . '\' AND status="1"' ), 
                true );
        $data ['tables'] = 'seat_employee';
        $result = $this->_db->select ( $data );
        return $result->fetchAll ( PDO::FETCH_ASSOC );
    }
    /**
     * 
     * @param String $roomName
     */
    public function findRoomId($roomName) {
        $data ['columns'] = array ('room.id' );
        $data ['conditions'] = array (
                array ('name=\'' . $roomName . '\' AND status="1"' ), 
                true );
        $data ['tables'] = 'room';
        $result = $this->_db->select ( $data );
        $myResult = array ();
        while ( $row = $result->fetch ( PDO::FETCH_ASSOC ) ) {
            $myResult [] = $row;
        }
        return $myResult [0] ['id'];
    }
    /**
     * 
     * @author : Avni Jain called from : MainController.php. 
     * description: This function is to get employee name 
     * from employee id request
     *  
     * @param: employee id 
     * @return: employee name
     */
    public function getEmployeeName($eid) {
        $data ['columns'] = array ('name' );
        $data ['conditions'] = array (array ('id=\'' . $eid . '\' AND status="1"' ), true );
        $data ['tables'] = 'employee';
        $result = $this->_db->select ( $data );
        $myResult = array ();
        while ( $row = $result->fetch ( PDO::FETCH_ASSOC ) ) {
            $myResult [] = $row;
        }
        return $myResult [0] ['name'];
    }
    /**
     * 
     * @param Integer $roomId
     * @param Integer $rowNumber
     */
    public function findSid($roomId, $rowNumber) {
        $data ['columns'] = array ('id' );
        $data ['conditions'] = array (
                array (
                        '(room_id =' . $roomId . ' AND row_number=' . $rowNumber . ') AND room_row.status="1"' ), 
                true );
        $data ['tables'] = 'room_row';
        $result = $this->_db->select ( $data );
        $myResult = array ();
        
        while ( $row = $result->fetch ( PDO::FETCH_ASSOC ) ) {
            $myResult [] = $row;
        }
        return $myResult [0] ['id'];
    }
    /**
     * 
     * @return ResultSet
     */
    public function allSeat() {
        $data ['columns'] = array (
                'room_row.id',
                'room_row.computer',
                'room_row.row_number',
                'room_row.room_id',
                'room.name'
        );
        $data ['tables'] = 'room_row';
        $data ['joins'] [] = array (
                'table' => 'room',
                'type' => 'inner',
                'conditions' => array ('room.id' => 'room_row.room_id' ) );
        $data['conditions']= array(array('room_row.status="1"'),true);
        $data ['order_by'] = array (array ('row_number' ) );
        $result = $this->_db->select ( $data );
        
        $myResult = array ();
        while ( $row = $result->fetch ( PDO::FETCH_ASSOC ) ) {
            $myResult [] = $row;
        }
        return $myResult;
    }
    /**
     * @return Object This will give the result set in Object form
     */
    public function totalRooms() {
        $data ['tables'] = 'room';
        $data ['columns'] = array ('count(*) total_room' );
        $data ['conditions'] = array (array ('status = "1"' ),true );
        $result = $this->_db->select ( $data );
        return $result->fetchAll ( PDO::FETCH_ASSOC );
    }
    /**
     * 
     * @param Integer $roomId
     * This method will fetch data corresponding to particular room
     */
    public function seatStatus($roomId) {
        
        $data ['columns'] = array (
                'seat_employee.status', 
                'seat_employee.computer_id', 
                'seat_employee.eid',
                'room_row.row_number',
                'room_row.room_id'
                );
        $data ['tables'] = array ('room' );
        
        $data ['joins'] [] = array (
                'table' => 'room_row', 
                'type' => 'inner', 
                'conditions' => array ('room.id' => 'room_row.room_id' ) );
        $data ['joins'] [] = array (
                'table' => 'seat_employee', 
                'type' => 'left', 
                'conditions' => array ('room_row.id' => 'seat_employee.sid' ) );
        
        $data ['conditions'] = array (
                array (
                        'room.id in (' . $roomId . ' ) '.
                        ' AND seat_employee.status = "1" ' ), 
                true );
        $data ['order'] = 'seat_employee.computer_id';
        $result = $this->_db->select ( $data );
        
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * This funciton will remove the seat allocated to employee.
     */    
    public function trashSeat() {
        $this->setStatus ( 0 );
        $data = array (
                'status' => $this->getStatus (), 
                'details' => $this->getDetails () );
        $where = array ('eid' => $this->getEid (), 'status' => 1 );
        $result = $this->_db->update ( 'seat_employee', $data, $where );
        $data ['columns'] = array ('employee.name' );
        $data ['conditions'] = array (
                array ('id=\'' . $this->getEid () . '\'' ), 
                true );
        $data ['tables'] = 'employee';
        $result = $this->_db->select ( $data );
        $myResult = array ();
        while ( $row = $result->fetch ( PDO::FETCH_ASSOC ) ) {
            $myResult [] = $row;
        }
        return $myResult [0] ['name'];
    }
    /**
     * 
     * @param Array $Ids
     * @param String $reason
     * 
     * This method is used for multiple deletion
     */
    public function mulitDelete($Ids=array(),$reason)
    {
    	$data=array('status' => "0",'details' => $reason);
    	$where =array('id' => $Ids);
    	$this->_db->update ( 'seat_employee', $data, $where );
    }
}