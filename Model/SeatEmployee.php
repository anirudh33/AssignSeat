<?php
/**
 *@author Keshi
 **************************** Creation Log *******************************
 * File Name 	- Seat.php
 * Description 	- Model class holding functionalities
 * 				  for insertion in database for seat alootment	
 * Version		- 1.0
 * Created by	- Keshi Chander Yadava
 * Created on 	- Jul 29 2013
 * **********************Update Log ***************************************
 * Sr.NO. Version Updated by 		Updated on	 	Description
 * -------------------------------------------------------------------------
 *	1.		1.0		Avni Jain		July 30,2013	added functions assignSeat,
 *													checkEmpSeat,findSid,setEmpName,getEmpName
 * ************************************************************************
 */
// include 'Room.php';
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
     * @return the $_eid
     */
    public function getEid() {
        return $this->_eid;
    }
    
    /**
     *
     * @return the $_sid
     */
    public function getSid() {
        return $this->_sid;
    }
    
    /**
     *
     * @return the $_computer_id
     */
    public function getComputer_id() {
        return $this->_computer_id;
    }
    
    /**
     *
     * @return the $_asignee
     */
    public function getAsignee() {
        return $this->_asignee;
    }
    
    /**
     *
     * @return the $_details
     */
    public function getDetails() {
        return $this->_details;
    }
    
    /**
     *
     * @return the $_status
     */
    public function getStatus() {
        return $this->_status;
    }
    
    /**
     *
     * @return the $_created_on
     */
    public function getCreated_on() {
        return $this->_created_on;
    }
    
    /**
     *
     * @return the $_updated_on
     */
    public function getUpdated_on() {
        return $this->_updated_on;
    }
    
    /**
     *
     * @param $_eid field_type           
     */
    public function setEid($_eid) {
        $this->_eid = $_eid;
    }
    
    /**
     *
     * @param $_sid field_type           
     */
    public function setSid($_sid) {
        $this->_sid = $_sid;
    }
    
    /**
     *
     * @param $_computer_id field_type           
     */
    public function setComputer_id($_computer_id) {
        $this->_computer_id = $_computer_id;
    }
    
    /**
     *
     * @param $_asignee field_type           
     */
    public function setAsignee($_asignee) {
        $this->_asignee = $_asignee;
    }
    
    /**
     *
     * @param $_details field_type           
     */
    public function setDetails($_details) {
        $this->_details = $_details;
    }
    
    /**
     *
     * @param $_status field_type           
     */
    public function setStatus($_status) {
        $this->_status = $_status;
    }
    
    /**
     *
     * @param $_created_on field_type           
     */
    public function setCreated_on($_created_on) {
        $this->_created_on = $_created_on;
    }
    
    /**
     *
     * @param $_updated_on field_type           
     */
    public function setUpdated_on($_updated_on) {
        $this->_updated_on = $_updated_on;
    }
    public function setEmpName($name) {
        $this->_emp_name = $name;
    }
    public function getEmpName() {
        return $this->_emp_name;
    }
    
    /**
     *
     * @return true after assigning seat to an employee
     */
    public function assignSeat($assignInfo) {
        $this->setEid ( $assignInfo ['empid'] );
        $empName = $this->getEmployeeName ( $assignInfo ['empid'] );
        $isAssigned = $this->checkEmpSeat ( $assignInfo ['empid'] );
        // var_dump($isAssigned);die;
        // if(!empty)
        
        $this->setEmpName ( $empName );
        // $this->setSid($assignInfo['sid']);
        $this->setAsignee ( $assignInfo ['assigne'] );
        $this->setComputer_id ( $assignInfo ['computerid'] );
        // $this->setUpdated_on($assignInfo['updated_on']);
        $this->setDetails ( $assignInfo ['details'] );
        // $this->deleteSeat();
        $this->setStatus ( 1 );
        // echo $assignInfo['room'];die;
        $roomId = $this->findRoomId ( $assignInfo ['room'] );
        // echo "roommmmm id .".$roomId;die;
        $sid = $this->findSid ( $roomId, $assignInfo ['row'] );
        $this->setSid ( $sid );
        // $assignInfo['empid']
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
        } /**
         * **** seat is reallocated ***********
         */
        else {
            // print_r($isAssigned[0]['id']);die;
            // echo $isAssigned[0];die;
			//$frmComputerId=$this->getComputerId($isAssigned[0]['id']);
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
            // var_dump($result);die;
            /*
             * $data = array('status' => '0'); $where = array('id'
             * =>$isAssigned[0]['id'], 'status'=>1); $result =
             * $this->_db->update('seat_employee', $data, $where);
             * var_dump($result);die; $data['tables'] = 'seat_employee';
             * $insertValue = array('eid'=>$this->getEid(),
             * /'sid'=>$this->getSid(), /'asignee'=>$this->getAsignee(),
             * /'computer_id'=>$this->getComputer_id(),
             * 'status'=>$this->getStatus(),
             * 'updated_on'=>$this->getUpdated_on(),
             * /'details'=>$this->getDetails() );
             * $result=$this->_db->insert($data['tables'],$insertValue);
             */
            return "true1";
        
        }
    }
	/**@ author Avni jain*****/
	public function getComputerId($id)
	{
		$data ['columns'] = array ('computer_id');
        $data ['conditions'] = array (
                array ('id=\'' . $id . '\' AND status="1"' ), 
                true );
        $data ['tables'] = 'seat_employee';
        $result = $this->_db->select ( $data );
        //var_dump($result);die;
		  while ( $row = $result->fetch ( PDO::FETCH_ASSOC ) ) {
            $myResult [] = $row;
        }
		//$from[0]=$myResult[0]['row_number'];
        // echo $myResult[0]['id'];die;
        return $myResult[0]['computer_id'];
	
	}
	/**@ author Avni jain*****/
	public function getfrmRoom($sid)
	{
		$data ['columns'] = array ('id','row_number');
        $data ['conditions'] = array (
                array ('id=\'' . $sid . '\' AND status="1"' ), 
                true );
        $data ['tables'] = 'room_row';
        $result = $this->_db->select ( $data );
        //var_dump($result);die;
		  while ( $row = $result->fetch ( PDO::FETCH_ASSOC ) ) {
            $myResult [] = $row;
        }
		$from[0]=$myResult[0]['row_number'];
        // echo $myResult[0]['id'];die;
        //return $myResult [0] ['id'];
		//$data ['columns'] = array ('name');
		$data ['columns'] = array ('name');
        $data ['conditions'] = array (
                array ('id=\'' . $myResult[0]['id']. '\' AND status="1"' ), 
                true );
        $data ['tables'] = 'room';
        $result = $this->_db->select ( $data );
		//var_dump($result);die;
		  while ( $row = $result->fetch ( PDO::FETCH_ASSOC ) ) {
            $room [] = $row;
        }
		//print_r( $myResult);die;
		$from[1]=$room[0]['name'];
		return($from);
	}
    /**
     *
     * @return true after seting the status flag to 0 array
     *         0 implies seat is not free
     */
    public function deleteSeat() {
        $this->setStatus ( 0 );
        $data = array ('status' => $this->getStatus () );
        $where = array ('id' => $this->getEid (), 'status' => 1 );
        $result = $this->_db->update ( 'seat_employee', $data, $where );
    }
    /*
     * @author : Avni Jain called from : MainController.php. description: This
     * function is to check whether a seat is already assigned to employee or
     * not request params: employee id returns: array of result
     */
    public function checkEmpSeat($eid) {
        $data ['columns'] = array ('id' );
        $data ['conditions'] = array (
                array ('eid=\'' . $eid . '\' AND status="1"' ), 
                true );
        $data ['tables'] = 'seat_employee';
        $result = $this->_db->select ( $data );
        // var_dump($result);die;
        return $result->fetchAll ( PDO::FETCH_ASSOC );
    }
    public function findRoomId($roomName) {
        // $Room=new Room();
        // $Room->setName($roomName);
        // echo $Room->getName();die;
        
        $data ['columns'] = array ('room.id' );
        $data ['conditions'] = array (
                array ('name=\'' . $roomName . '\'' ), 
                true );
        $data ['tables'] = 'room';
        $result = $this->_db->select ( $data );
        // var_dump($result);die;
        $myResult = array ();
        while ( $row = $result->fetch ( PDO::FETCH_ASSOC ) ) {
            $myResult [] = $row;
        }
        // echo $myResult[0]['id'];die;
        return $myResult [0] ['id'];
    }
    /*
     * @author : Avni Jain called from : MainController.php. description: This
     * function is to get employee name from employee id request params:
     * employee id returns: employee name
     */
    public function getEmployeeName($eid) {
        $data ['columns'] = array ('name' );
        $data ['conditions'] = array (array ('id=\'' . $eid . '\'' ), true );
        $data ['tables'] = 'employee';
        $result = $this->_db->select ( $data );
        // var_dump($result);die;
        $myResult = array ();
        while ( $row = $result->fetch ( PDO::FETCH_ASSOC ) ) {
            $myResult [] = $row;
        }
        // echo $myResult[0]['id'];die;
        return $myResult [0] ['name'];
    }
    public function findSid($roomId, $rowNumber) {
        $data ['columns'] = array ('id' );
        $data ['conditions'] = array (
                array (
                        '(room_id =' . $roomId . ' AND row_number=' . $rowNumber . ')' ), 
                true );
        $data ['tables'] = 'room_row';
        $result = $this->_db->select ( $data );
        // var_dump($result);die;
        $myResult = array ();
        
        while ( $row = $result->fetch ( PDO::FETCH_ASSOC ) ) {
            $myResult [] = $row;
        }
        // echo($myResult[0]['id']);die;
        return $myResult [0] ['id'];
    }
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
        $data ['order_by'] = array (array ('row_number' ) );
        $result = $this->_db->select ( $data );
        
        $myResult = array ();
        while ( $row = $result->fetch ( PDO::FETCH_ASSOC ) ) {
            $myResult [] = $row;
        }
        return $myResult;
    }
    public function totalRooms() {
        $data ['tables'] = 'room';
        $data ['columns'] = array ('count(*) total_room' );
        $data ['conditions'] = array (array ('status = "1"' ),true );
        $result = $this->_db->select ( $data );
        return $result->fetchAll ( PDO::FETCH_ASSOC );
    }
    // public function seatStatus($val, $val1) {
    
    // $data ['columns'] = array (
    // 'seat_employee.status',
    // 'seat_employee.computer_id',
    // 'seat_employee.eid' );
    // $data ['tables'] = array ('room' );
    
    // $data ['joins'] [] = array (
    // 'table' => 'room_row',
    // 'type' => 'inner',
    // 'conditions' => array ('room.id' => 'room_row.room_id' ) );
    // $data ['joins'] [] = array (
    // 'table' => 'seat_employee',
    // 'type' => 'left',
    // 'conditions' => array ('room_row.id' => 'seat_employee.sid' ) );
    
    // $data ['conditions'] = array (
    // array (
    // 'room.id=' . $val . ' AND room_row.room_id=' . $val . ' AND
    // room_row.row_number=' . $val1 . ' AND
    // seat_employee.status = "1" ' ),
    // true );
    // $data ['order'] = 'seat_employee.computer_id';
    // $result = $this->_db->select ( $data );
    
    // $myResult = array ();
    // while ( $row = $result->fetch ( PDO::FETCH_ASSOC ) ) {
    // $myResult [] = $row;
    // }
    // if (! empty ( $myResult [0] ['status'] ))
    // return $myResult;
    // else {
    // return $a = array ();
    // }
    
    // }
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
        
//         $myResult = array ();
//         while ( $row = $result->fetch ( PDO::FETCH_ASSOC ) ) {
//             $myResult [] = $row;
//         }
//         if (! empty ( $myResult [0] ['status'] ))
//             return $myResult;
//         else {
//             return $a = array ();
//         }
    
    }
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
        
        // print_r($myResult[0]['name']);die;
        return $myResult [0] ['name'];
    }

}
