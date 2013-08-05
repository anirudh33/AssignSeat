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
                             'conditions' => array('room.id' => 'room_row.room_id')));
		$data['conditions']=array(array('room.id = '.$roomId.' AND room.status = "1"'),true);
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
