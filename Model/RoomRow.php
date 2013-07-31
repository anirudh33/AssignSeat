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
class RoomRow extends DBConnection
{
	private $_id;
	private $_room_name;
	private $_room_status;
	private $_room_id;
	private $_row_number;
	private $_computer;
	private $_status;
	/**
	 * @return the $_id
	 */
	public function getId() {
		return $this->_id;
	}

	/**
	 * @return the $_row_number
	 */
	public function getRow_number() {
		return $this->_row_number;
	}

	/**
	 * @return the $_computer
	 */
	public function getComputer() {
		return $this->_computer;
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
	 * @param field_type $_room_name
	 */
	public function setRoom_name($_room_name) {
		$this->_room_name = $_room_name;
	}

	/**
	 * @param field_type $_room_status
	 */
	public function setRoom_status($_room_status) {
		$this->_room_status = $_room_status;
	}

	/**
	 * @param field_type $_room_id
	 */
	public function setRoom_id($_room_id) {
		$this->_room_id = $_room_id;
	}

	/**
	 * @param field_type $_row_number
	 */
	public function setRow_number($_row_number) {
		$this->_row_number = $_row_number;
	}

	/**
	 * @param field_type $_computer
	 */
	public function setComputer($_computer) {
		$this->_computer = $_computer;
	}

	/**
	 * @param field_type $_status
	 */
	public function setStatus($_status) {
		$this->_status = $_status;
	}
	

	
}