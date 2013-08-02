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
 *
 * ************************************************************************
 */
//include 'Room.php';
class SeatEmployee extends DBConnection
{
	private $_eid;
	private $_sid;
	private $_computer_id;
	private $_asignee;
	private $_details;
	private $_status;
	private $_created_on;
	private $_updated_on;
	/**
	 * @return the $_eid
	 */
	public function getEid() {
		return $this->_eid;
	}

	/**
	 * @return the $_sid
	 */
	public function getSid() {
		return $this->_sid;
	}

	/**
	 * @return the $_computer_id
	 */
	public function getComputer_id() {
		return $this->_computer_id;
	}

	/**
	 * @return the $_asignee
	 */
	public function getAsignee() {
		return $this->_asignee;
	}

	/**
	 * @return the $_details
	 */
	public function getDetails() {
		return $this->_details;
	}

	/**
	 * @return the $_status
	 */
	public function getStatus() {
		return $this->_status;
	}

	/**
	 * @return the $_created_on
	 */
	public function getCreated_on() {
		return $this->_created_on;
	}

	/**
	 * @return the $_updated_on
	 */
	public function getUpdated_on() {
		return $this->_updated_on;
	}

	/**
	 * @param field_type $_eid
	 */
	public function setEid($_eid) {
		$this->_eid = $_eid;
	}

	/**
	 * @param field_type $_sid
	 */
	public function setSid($_sid) {
		$this->_sid = $_sid;
	}

	/**
	 * @param field_type $_computer_id
	 */
	public function setComputer_id($_computer_id) {
		$this->_computer_id = $_computer_id;
	}

	/**
	 * @param field_type $_asignee
	 */
	public function setAsignee($_asignee) {
		$this->_asignee = $_asignee;
	}

	/**
	 * @param field_type $_details
	 */
	public function setDetails($_details) {
		$this->_details = $_details;
	}

	/**
	 * @param field_type $_status
	 */
	public function setStatus($_status) {
		$this->_status = $_status;
	}

	/**
	 * @param field_type $_created_on
	 */
	public function setCreated_on($_created_on) {
		$this->_created_on = $_created_on;
	}

	/**
	 * @param field_type $_updated_on
	 */
	public function setUpdated_on($_updated_on) {
		$this->_updated_on = $_updated_on;
	}

	/**
	 * @return true after assigning seat to an employee
	 */
	public function assignSeat($assignInfo)
	{
//   print_r($assignInfo);
  //    die;
     $this->setEid($assignInfo['empid']);
    	//$this->setSid($assignInfo['sid']);
    	$this->setAsignee($assignInfo['assigne']);
    	$this->setComputer_id($assignInfo['computerid']);
    	//$this->setUpdated_on($assignInfo['updated_on']);
    	$this->setDetails($assignInfo['details']);
		//$this->deleteSeat();
		$this->setStatus(1);
		//echo $assignInfo['room'];die;
		$roomId=$this->findRoomId($assignInfo['room']);
		//echo "roommmmm id   .".$roomId;die;
		$sid=$this->findSid($roomId, $assignInfo['row']);
		$this->setSid($sid);
		 $data['tables'] = 'seat_employee';
		 $insertValue = array('eid'=>$this->getEid(),
		 		'sid'=>$this->getSid(),
		 		'asignee'=>$this->getAsignee(),
		 		'computer_id'=>$this->getComputer_id(),
		 		'status'=>$this->getStatus(),
		 		'updated_on'=>$this->getUpdated_on(),
		 		'details'=>$this->getDetails()
		 		);
		 $result=$this->_db->insert($data['tables'],$insertValue);
		 //var_dump($result);die;
		 return "true";
		
	}
	/**
	 * @return true after seting the status flag to 0 array
	 * 0 implies seat is not free
	 */
	public function deleteSeat()	{		
		$this->setStatus(0);
		$data = array('status' => $this->getStatus());
		$where = array('id' =>$this->getEid(), 'status'=>1);
		$result = $this->_db->update('seat_employee', $data, $where);
	}
	public function findRoomId($roomName)  {
		//$Room=new Room();
		//$Room->setName($roomName);
		//echo $Room->getName();die;
	
		$data['columns']	= array('room.id');
		$data['conditions']=array(array('name=\''.$roomName.'\''),true);
		$data['tables']		= 'room';
		$result = $this->_db->select($data);
		//var_dump($result);die;
		$myResult=array();
		while ($row = $result->fetch(PDO::FETCH_ASSOC))
		{
			$myResult[]=$row;
		}
	    //echo $myResult[0]['id'];die;
		return $myResult[0]['id'];
	}
	
	public function findSid($roomId,$rowNumber)  {
		$data['columns']	= array('id');
		$data['conditions']=array(array('(room_id ='.$roomId.' AND row_number='.$rowNumber.')'),true);
		$data['tables']		= 'room_row';
		$result = $this->_db->select($data);
		//var_dump($result);die;
		$myResult=array();
		while ($row = $result->fetch(PDO::FETCH_ASSOC))
		{
			$myResult[]=$row;
		}
		//echo($myResult[0]['id']);die;
		return $myResult[0]['id'];
	}        
        public function allSeat()
	{		
		
		$data['tables'] = 'room_row';
                $data['order_by'] = array(array('row_number'));
		$result=$this->_db->select($data);
		
		$myResult=array();
		while ($row = $result->fetch(PDO::FETCH_ASSOC))
		{
			$myResult[]=$row;
		}
		return $myResult;
	}
    public function totalRooms()
    {
        $data['tables'] = 'room';
        $data['columns'] = array('count(*) total_room');
        $result=$this->_db->select($data);        
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
         public function seatStatus($val,$val1)
	 {				
		
	       $data['columns']        = array('seat_employee.status','seat_employee.computer_id','seat_employee.eid',);
               $data['tables']=array('room');
               
               $data['joins'][] = array(
                               'table' => 'room_row',
                               'type'        => 'inner',
                               'conditions' => array('room.id' => 'room_row.room_id'));
               $data['joins'][] = array(
                               'table' => 'seat_employee',
                               'type'        => 'left',
                               'conditions' => array('room_row.id' => 'seat_employee.sid'));	       
               
               $data['conditions']=array(array('room.id='.$val.' AND room_row.room_id='.$val.' AND room_row.row_number='.$val1),true);
	       //$data['order_by'] = array(array('seat_employee.computer_id'));
               $result=$this->_db->select($data);

               $myResult=array();
               while ($row = $result->fetch(PDO::FETCH_ASSOC))
               {
                       $myResult[]=$row;
               }
               // print_r($myResult);
	       return  $myResult;

 

                
	}
	
	public function trashSeat()	{
		$this->setStatus(0);
		$data = array('status' => $this->getStatus(),'details'=>$this->getDetails());
		$where = array('eid' =>$this->getEid(), 'status'=>1);
		$result = $this->_db->update('seat_employee', $data, $where);
		return $result;
	}
        
}
