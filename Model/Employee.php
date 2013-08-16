<?php
class Employee extends DBConnection {
	private $_osscube_member_id; // $_id;
	private $_name;
	private $_official_email_id; // $_email_id;
	private $_designation;
	private $_department;
	private $_details;
	private $_status;
	private $_create_on;
	private $_update_on;
	private $_user_image;
	private $_cell;
	private $_location;
	private $_territory;
	private $_team;
	
	/**
	 *
	 * @return the $_osscube_member_id
	 */
	public function getOsscube_member_id() {
		return $this->_osscube_member_id;
	}
	
	/**
	 *
	 * @return the $_official_email_id
	 */
	public function getOfficial_email_id() {
		return $this->_official_email_id;
	}
	
	/**
	 *
	 * @return the $_cell
	 */
	public function getCell() {
		return $this->_cell;
	}
	
	/**
	 *
	 * @return the $_location
	 */
	public function getLocation() {
		return $this->_location;
	}
	
	/**
	 *
	 * @return the $_territory
	 */
	public function getTerritory() {
		return $this->_territory;
	}
	
	/**
	 *
	 * @return the $_team
	 */
	public function getTeam() {
		return $this->_team;
	}
	
	/**
	 *
	 * @param field_type $_osscube_member_id        	
	 */
	public function setOsscube_member_id($_osscube_member_id) {
		$this->_osscube_member_id = $_osscube_member_id;
	}
	
	/**
	 *
	 * @param field_type $_official_email_id        	
	 */
	public function setOfficial_email_id($_official_email_id) {
		$this->_official_email_id = $_official_email_id;
	}
	
	/**
	 *
	 * @param field_type $_cell        	
	 */
	public function setCell($_cell) {
		$this->_cell = $_cell;
	}
	
	/**
	 *
	 * @param field_type $_location        	
	 */
	public function setLocation($_location) {
		$this->_location = $_location;
	}
	
	/**
	 *
	 * @param field_type $_territory        	
	 */
	public function setTerritory($_territory) {
		$this->_territory = $_territory;
	}
	
	/**
	 *
	 * @param field_type $_team        	
	 */
	public function setTeam($_team) {
		$this->_team = $_team;
	}
	
	/**
	 *
	 * @return the $_create_on
	 */
	public function getCreate_on() {
		return $this->_create_on;
	}
	
	/**
	 *
	 * @return the $_update_on
	 */
	public function getUpdate_on() {
		return $this->_update_on;
	}
	
	/**
	 *
	 * @return the $_user_image
	 */
	public function getUser_image() {
		return $this->_user_image;
	}
	
	/**
	 *
	 * @param field_type $_create_on        	
	 */
	public function setCreate_on($_create_on) {
		$this->_create_on = $_create_on;
	}
	
	/**
	 *
	 * @param field_type $_update_on        	
	 */
	public function setUpdate_on($_update_on) {
		$this->_update_on = $_update_on;
	}
	
	/**
	 *
	 * @param field_type $_user_image        	
	 */
	public function setUser_image($_user_image) {
		$this->_user_image = $_user_image;
	}
	
	public function getStatus() {
		return $this->_status;
	}
	
	public function setStatus($_status) {
		$this->_status = $_status;
	}
	
	public function getEmail_id() {
		return $this->_email_id;
	}
	
	public function getDesignation() {
		return $this->_designation;
	}
	
	public function getDepartment() {
		return $this->_department;
	}
	
	public function getDetails() {
		return $this->_details;
	}
	
	public function setEmail_id($_email_id) {
		$this->_email_id = $_email_id;
	}
	
	public function setDesignation($_designation) {
		$this->_designation = $_designation;
	}
	
	public function setDepartment($_department) {
		$this->_department = $_department;
	}
	
	public function setDetails($_details) {
		$this->_details = $_details;
	}
	
	/**
	 *
	 * @return the $_id
	 */
	public function getId() {
		return $this->_id;
	}
	
	/**
	 *
	 * @return the $_name
	 */
	public function getName() {
		return $this->_name;
	}
	
	/**
	 *
	 * @param field_type $_id        	
	 */
	public function setId($_id) {
		$this->_id = $_id;
	}
	
	/**
	 *
	 * @param field_type $_name        	
	 */
	public function setName($_name) {
		$this->_name = $_name;
	}
	
	public function searchEmp($name, $page) {
		$data = array ();
		$data ['tables'] = array (
				"employee" 
		);
		$data ['columns'] = array (
				'SQL_CALC_FOUND_ROWS name',
				'id' 
		);
		$data ['conditions'] = array (
				array (
						'name LIKE "%' . $name . '%" LIMIT ' . $page . ',10 UNION SELECT FOUND_ROWS(),"NA" ' 
				),
				true 
		);
		$result = $this->_db->select ( $data );
		
		$myResult = array ();
		while ( $row = $result->fetch ( PDO::FETCH_ASSOC ) ) {
			$myResult [] = $row;
		}
		return $myResult;
	}
	public function getEmployeeProfile() {
		$data = array ();
		$data ['tables'] = array (
				"employee" 
		);
		$data ['conditions'] = array (
				array (
						'id =' . $this->getId () . ' AND status="1"' 
				),
				true 
		);
		$result = $this->_db->select ( $data );
		
		$myResult = array ();
		while ( $row = $result->fetch ( PDO::FETCH_ASSOC ) ) {
			$myResult = $row;
			$myResult ['uri'] = 'data:image/png;base64,' . base64_encode ( $row ['user_image'] );
		}
		return $myResult;
	}
	public function upImage() {
		// $this->_db->truncate('seat_employee');
		$tmpName = "./assets/images/User.png";
		$fp = fopen ( $tmpName, 'r' );
		$imageData = fread ( $fp, filesize ( $tmpName ) );
		
		fclose ( $fp );
		$data = array (
				'user_image' => $imageData 
		);
		$where = array (
				'status' => '1' 
		);
		$result = $this->_db->update ( 'employee', $data, $where );
	}
	
	public function getEmployeeEmail() {
		$data = array ();
		$data ['columns'] = array (
				'id' 
		);
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
			array_push ( $myResult, $row ['id'] );
		}
		return $myResult;
	}
	
	public function truncateTable() {
		$this->_db->truncate ( 'employee1' );
	}
	public function setEmployeeProfile() {
		static $statusrun = 0;
		
		$obj = new validate ();
		// echo $this->getName();die;
		// $name='"'.$this->getName().'"';
		// echo $name.$this->getName();die;
		$obj->validator ( "user_name", $this->getName (), 'custom=/^[a-zA-Z ]+[a-zA-Z]*$/', 'Name Contains Only alphabets' );
		$obj->validator ( "Member_id", $this->getOsscube_member_id (), 'custom=/^OSS\/IN\/[0-9]*$/', 'Name Contains should not contain special character' );
		$obj->validator ( "Cell", $this->getCell (), 'custom=/^[a-zA-Z ]+[-.&a-zA-Z ]+[a-zA-Z]*$/', 'Cell name should be in alphabets' );
		$obj->validator ( "Designation", $this->getDesignation (), 'custom=/^[a-zA-Z ]+[-.&a-zA-Z ]+[a-zA-Z]*$/', 'Designation should not contain special character' );
		$obj->validator ( "email", $this->getOfficial_email_id (), "email", "Email ID is not valid" );
		$obj->validator ( "Department", $this->getDepartment (), 'custom=/^[a-zA-Z ]+[a-zA-Z]*$/', 'Department name should be in alphabets' );
		$obj->validator ( "Location", $this->getLocation (), 'custom=/^[a-zA-Z ]+[a-zA-Z]*$/', 'Location name should be in alphabets' );
		$obj->validator ( "Team", $this->getTeam (), 'custom=/^[a-zA-Z ]+[-.&a-zA-Z ]+[a-zA-Z]*$/', 'Team name should be in alphabets' );
		$obj->validator ( "Territory", $this->getTerritory (), 'alphabets', 'Territory name should be in alphabets' );
		$error = $obj->result ();
		// print_r($error);die;
		if (empty ( $error )) {
			if ($statusrun == 0) {
				$data ['tables'] = 'employee1';
				$insertValue = array (
						'name' => $this->getName (),
						'osscubememberid' => $this->getOsscube_member_id (),
						'cell' => $this->getCell (),
						'designation' => $this->getDesignation (),
						'department' => $this->getDepartment (),
						'officialemailid' => $this->getOfficial_email_id (),
						'teams' => $this->getTeam (),
						'location' => $this->getLocation (),
						'territory' => $this->getTerritory () 
				);
				$this->_db->insert ( $data ['tables'], $insertValue );
				$statusrun ++;
			} else {
				$data1 = array ();
				$data1 ['columns'] = array (
						'id' 
				);
				$data1 ['tables'] = array (
						"employee1" 
				);
				$data1 ['conditions'] = array (
						array (
								'osscubememberid="' . $this->getOsscube_member_id () . '"' 
						),
						true 
				);
				$result1 = $this->_db->select ( $data1 );
				// print_r($result1);
				$myResult = array ();
				while ( $row = $result1->fetch ( PDO::FETCH_ASSOC ) ) {
					$myResult [] = $row;
				}
				
				if (empty ( $myResult )) {
					
					$data ['tables'] = 'employee1';
					$insertValue = array (
							'name' => $this->getName (),
							'osscubememberid' => $this->getOsscube_member_id (),
							'cell' => $this->getCell (),
							'designation' => $this->getDesignation (),
							'department' => $this->getDepartment (),
							'officialemailid' => $this->getOfficial_email_id (),
							'teams' => $this->getTeam (),
							'location' => $this->getLocation (),
							'territory' => $this->getTerritory () 
					);
					$this->_db->insert ( $data ['tables'], $insertValue );
				}
			
			}
		} else {
			return $this->getOsscube_member_id ();
		}
	
	}
	public function getAllEmployee() {
		$data ['columns'] = array (
				'id',
				'name' 
		);
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
			$myResult [] = $row;
		}
		return $myResult;
	}
}
