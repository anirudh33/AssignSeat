<?php

/* Example Config for MYSQL */
ini_set("display_errors","1");

include('PDO/cxpdo.php');
abstract class DBConnection
{
    protected $_db;
    private $_config = array();
//     $config['DATABSE_USER_NAME'] = 'root';
//     $config['DATABSE_PASSWORD'] = 'root';
//     $config['DATABASE_NAME'] = 'skillseeker';
//     $config['DATABASE_HOST'] = 'localhost';
//     $config['DATABASE_TYPE'] = 'mysql';
//     $config['DATABASE_PORT'] = null;
//     $config['DATABASE_PERSISTENT'] = true
    
    public function __construct ()
    {
        $this->_config['DATABSE_USER_NAME'] = 'root';
        $this->_config['DATABSE_PASSWORD'] = 'root';
        $this->_config['DATABASE_NAME'] = 'pollingSystem';
        $this->_config['DATABASE_HOST'] = 'localhost';
        $this->_config['DATABASE_TYPE'] = 'mysql';
        $this->_config['DATABASE_PORT'] = null;
        $this->_config['DATABASE_PERSISTENT'] = true;
        $this->_db = db::instance($this->_config);
//         ECHO '<PRE>';
//         PRINT_R($THIS->_CONFIG);
//         DIE;

    }
    
   /* public function ll()
    {
        //$data['columns']	= array('user_name', 'password');
        $data['tables']		= 'login';
        //$data['conditions']=array(array('user_name ='),true);
        $result=$this->_db->select($data);
        $myResult=array();
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $myResult[]=$row;
        }
        echo "<pre>";
        print_r($myResult);
    }*/
}
/*
$o=new DBConnection();
$o->ll();*/

/*
$result = $db->insert('mvc', array('title' => 'My First Post', 'desc' => ' DB system'));
print 'Created row '. $db->lastInsertId(). ' in the table "mvc"<br />';
$result = $db->insert('mvc', array('title' => 'My Second Post', 'desc' => 'can go relax!'));
print 'Created row '. $db->lastInsertId(). ' in the table "mvc"<br />';
$result = $db->insert('mvc', array('title' => 'My Third Post', 'desc' => 'I later'));
print 'Created row '. $db->lastInsertId(). ' in the table "mvc"<br />';*/

/* echo "<pre>";
//echo "hi";die;
$data['columns']	= array('user_name', 'password');
$data['tables']		= 'login';
//$data['conditions']=array(array('user_id ="17"'),true);
//$data['conditions']=array(array(' (user_id = 17  AND friend_id = 21) AND status = "F" '),true);
//$data['conditions']=array(array('email_primary LIKE "%loo%" '),true);
//$data['conditions']		= array('user_id' => 17);
//$data['group_by'] = array('user_id');
//$data['order_by'] = 'user_id';
//$data['limit']		= 2;
//$data['offset']		= 1;
$result = $db->select($data);

 while($row = $result->fetch(PDO::FETCH_ASSOC)) {
    if($row['user_name'] == $_POST['fieldEmail'] && $row['password'] == $_POST['fieldPassword'] )
    {
        return("1");
    }
    
	
} 
//print_r($row); */

?>
