<?php
include('PDO/cxpdo.php');
abstract class DBConnection
{
    protected $_db;
    private $_config = array();
    /**
     *  Set all database paremeters
     */ 
    public function __construct ()
    {
        $this->_config['DATABSE_USER_NAME'] = 'root';
        $this->_config['DATABSE_PASSWORD'] = 'root';
        $this->_config['DATABASE_NAME'] = 'assign_seat';
        $this->_config['DATABASE_HOST'] = 'localhost';
        $this->_config['DATABASE_TYPE'] = 'mysql';
        $this->_config['DATABASE_PORT'] = null;
        $this->_config['DATABASE_PERSISTENT'] = true;
        $this->_db = db::instance($this->_config);
    }

}