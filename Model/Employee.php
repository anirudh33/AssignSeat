<?php
class Employee extends DBConnection
{
	private $_id;
	private $_name;
	
	/**
     * @return the $_id
     */
    public function getId() {
        return $this->_id;
    }

	/**
     * @return the $_name
     */
    public function getName() {
        return $this->_name;
    }

	/**
     * @param field_type $_id
     */
    public function setId($_id) {
        $this->_id = $_id;
    }

	/**
     * @param field_type $_name
     */
    public function setName($_name) {
        $this->_name = $_name;
    }

	public function searchEmp($name,$page)
	{
		$data = array();
		$data['tables'] = array("employee");
		$data['columns'] = array('SQL_CALC_FOUND_ROWS name','id');
		$data['conditions']=array(array('name LIKE "%'.$name
				.'%" LIMIT '.
				$page.',10 UNION SELECT FOUND_ROWS(),"NA" '),true);
		$result=$this->_db->select($data);
		
		$myResult=array();
		while ($row = $result->fetch(PDO::FETCH_ASSOC))
		{
			$myResult[]=$row;
		}
		return  $myResult;
	}
	public function getEmployeeProfile()
	{
	    $data = array();
	    $data['tables'] = array("employee");
	    $data['conditions'] = array(array('id ='.$this->getId().' AND status="1"'), true);
	    $result = $this->_db->select($data);

	    $myResult = array();
	    while ($row = $result->fetch(PDO::FETCH_ASSOC))
	    {
	    	$myResult[]=$row;
	    	$myResult['uri']='data:image/png;base64,' .base64_encode ( $row['user_image']);
	    }
	    return  $myResult;	    
	}
	public function upImage()
	{
		
		$tmpName="./assets/images/User.png";
		$fp = fopen($tmpName, 'r');
		$imageData = fread($fp, filesize($tmpName));
		
		fclose($fp);
		$data = array ('user_image' => $imageData );
		$where = array ('status' => '1');
		$result = $this->_db->update ( 'employee', $data, $where );
	}
}
