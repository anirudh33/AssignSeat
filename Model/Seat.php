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
class Seat extends DBConnection
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
	public function assignSeat()
	{
        $this->setEid($_POST['eid']);
    	$this->setSid($_POST['sid']);
    	$this->setAsignee($_POST['asignee']);
    	$this->setComputer_id($_POST['computer_id']);
    	$this->setStatus(1);
    	$this->setUpdated_on($_POST['updated_on']);
    	$this->setDetails($_POST['details']);
		
		 $data['tables'] = 'seat_employee';
		 $insertValue = array('eid'=>$this->getEid(),
		 		'sid'=>$this->getSid(),
		 		'asignee'=>$this->getAsignee(),
		 		'computer_id'=>$this->getComputer_id(),
		 		'status'=>$this->getStatus(),
		 		'updated_on'=>$this->getUpdated_on(),
		 		'details'=>$this->getDetails()
		 		);
		 $this->_db->insert($data['tables'],$insertValue);
		 return "true";
		
	}
	/**
	 * @return true after seting the status flag to 0 array
	 * 0 implies seat is not free
	 */
	public function deleteSeat()
	{		
		$this->setStatus(0);
		$data['tables'] = 'seat_employee';
		$where = array('id' => $db->lastInsertId());
		$result = $db->update('posts', $data, $where);
		return "true";
	}
        
        public function allSeat()
	{		
		//$this->setStatus(0);
		$data['tables'] = 'room_row';
		//$where = array('id' => $db->lastInsertId());
		$result=$this->_db->select($data);
		$myResult=array();
		while ($row = $result->fetch(PDO::FETCH_ASSOC))
		{
			$myResult[]=$row;
		}
		return $myResult;
	}
        
}
