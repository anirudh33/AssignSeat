<?php
/**
 * **************************** Creation Log *******************************
 * File Name                   -  RoomRow.php
 * Project Name                -  AssignSeat
 * Description                 -  Model class from RoomRow Table
 * @Version                   -  1.0
 * Created by                  -  Keshi
 * Created on                  -  August 03, 2013
 * ***************************** Update Log ********************************
 * Sr.NO.		Version		Updated by           Updated on          Description
 * -------------------------------------------------------------------------
 *
 * *************************************************************************
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
	 * @param Integer $_id
	 */
	public function setId($_id) {
		$this->_id = $_id;
	}

	/**
	 * @param String $_room_name
	 */
	public function setRoom_name($_room_name) {
		$this->_room_name = $_room_name;
	}

	/**
	 * @param Character $_room_status
	 */
	public function setRoom_status($_room_status) {
		$this->_room_status = $_room_status;
	}

	/**
	 * @param Integer $_room_id
	 */
	public function setRoom_id($_room_id) {
		$this->_room_id = $_room_id;
	}

	/**
	 * @param Integer $_row_number
	 */
	public function setRow_number($_row_number) {
		$this->_row_number = $_row_number;
	}

	/**
	 * @param Integer $_computer
	 */
	public function setComputer($_computer) {
		$this->_computer = $_computer;
	}

	/**
	 * @param Character $_status
	 */
	public function setStatus($_status) {
		$this->_status = $_status;
	}	
}