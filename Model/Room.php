<?php
/**
 *@author Keshi
 **************************** Creation Log *******************************
 * File Name 	- Seat.php
 * Description 	- Model class holding functionalities
 * 				  for insertion in database for seat alootment
 * Version		- 1.0
 * Created by	- Keshi Chander Yadava
 * Created on 	- Jul 30 2013
 * **********************Update Log ***************************************
 * Sr.NO. Version Updated by 		Updated on	 	Description
 * -------------------------------------------------------------------------
 *
 * ************************************************************************
 */
include 'RoomRow.php';
class Room extends RoomRow
{
	private $_name;
	private $_id;
	private $_status;
	/**
	 * @return the $_id
	 */
	public function getId() {
		return $this->_id;
	}

	/**
	 * @return the $_status
	 */
	public function getStatus() {
		return $this->_status;
	}

	/**
	 * @param field_type $_id
	 */
	public function setId($_id) {
		$this->_id = $_id;
	}

	/**
	 * @param field_type $_status
	 */
	public function setStatus($_status) {
		$this->_status = $_status;
	}

	/**
	 * @return the $_name
	 */
	public function getName() {
		return $this->_name;
	}

	/**
	 * @param field_type $_name
	 */
	public function setName($_name) {
		$this->_name = $_name;
	}
	public function roomDetail($name) {
		echo "here";
		$this->setName($name);//($_POST['name']);
		$data['columns']	= array('room.name');
		$data['conditions']=array(array('status = 1'),true);
		$data['tables']		= 'room';
		$result = $this->_db->select($data);
		$myResult=array();
		while ($row = $result->fetch(PDO::FETCH_ASSOC))
		{
			$myResult[]=$row;
		}
		echo "<pre>";
		print_r($myResult);
		die;
	}
	
	public function fetchAllRooms()
	{
		$data['conditions']=array(array('status = "1"'),true);
		$data['tables']		= 'room';
		$result = $this->_db->select($data);
		$myResult=array();
		while ($row = $result->fetch(PDO::FETCH_ASSOC))
		{
			$myResult[]=$row;
		}
		return $myResult;
	}
	
	public function fetchRoomDetails($roomId)
	{
		
		$data['columns']=array('room.id','room_row.id as row_id','room.name','room_row.row_number','room_row.computer');
		$data['tables']='room';
		$data['joins']=array(array('table' => 'room_row',
                             'type'  => 'left',
                             'conditions' => array('room.id' => 'room_row.room_id','room_row.status' => 1)));
		$data['conditions']=array(array('room.id = '.$roomId.' AND room.status = "1" '),true);
		$result=$this->_db->select($data);
		$myResult=array();
		while ($row = $result->fetch(PDO::FETCH_ASSOC))
		{
			$myResult[]=$row;
		}
		return $myResult;
	}
   public function deleteRow($roomId,$rowId) 
   {
   		$this->setStatus ( 0 );
   		$data = array ('status' => $this->getStatus () );
   		$where = array ('id' => $rowId, 'room_id' => $roomId );
   		$result = $this->_db->update ( 'room_row', $data, $where );
   }
   public function addRow($roomId,$rowNo,$computer)
   {
   	$data ['tables'] = 'room_row';
   	$insertValue = array (
   			'room_id' => $roomId,
   			'row_number' => $rowNo,
   			'computer' => $computer,
   			'status' => '1',
   			'updated_on' => time(),
   			'created_on' => time());
   	$result = $this->_db->insert ( $data ['tables'], $insertValue );
   }
   public function updateComp($rowId,$computer)
   {
   	
   		$data = array ('computer' => $computer );
   		$where = array ('id' => $rowId);
   		$result = $this->_db->update ( 'room_row', $data, $where );
   }
   
   public  function getRoomSeatedDetails($roomId)
   {
   	$data['columns']=array('seat_employee.computer_id as seatNo','employee.name as empName','employee.designation','employee.department','employee.details','employee.user_image','room.id','room_row.id as row_id','room.name','room_row.row_number','room_row.computer');
   	$data['tables']='room';
   	$data['joins']=array(array('table' => 'room_row',
   			'type'  => 'left',
   			'conditions' => array('room.id' => 'room_row.room_id','room_row.status' => 1)),
   			array('table' => 'seat_employee',
   			'type'  => 'inner',
   			'conditions' => array('room_row.id' => 'seat_employee.sid')),
   			array('table' => 'employee',
   			'type'  => 'inner',
   			'conditions' => array('employee.id' => 'seat_employee.eid')));
   	
   	$data['conditions']=array(array('room.id = '.$roomId.' AND room.status = "1" AND seat_employee.status="1"'),true);
   	$result=$this->_db->select($data);
   	$myResult=array();
   	while ($row = $result->fetch(PDO::FETCH_ASSOC))
   	{
   		$myResult[]=$row;
   	}
   	return $myResult;
   }
	
}
//  $y=new Room();
//  $y->roomDetail('googol');
