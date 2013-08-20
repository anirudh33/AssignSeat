<?php
/**
 * **************************** Creation Log *******************************
 * File Name                   -  Users.php
 * Project Name                -  AssignSeat
 * Description                 -  Model Class file for User
 * @Version                   -  1.0
 * Created by                  -  Chetan Sharma
 * Created on                  -  August 03, 2013
 * ***************************** Update Log ********************************
 * Sr.NO.		Version		Updated by           Updated on          Description
 * -------------------------------------------------------------------------
 *
 * *************************************************************************
 */
class Users extends DBConnection
{

    /**
     *
     * @var String Store the password in md5 format
     */
    private $_password;

    /**
     *
     * @var Integer User ID from Database
     */
    private $_id;

    /**
     *
     * @var String Store the username
     */
    private $_username;

    /**
     * return $password
     */
    private function getPassword ()
    {
        return $this->_password;
    }

    /**
     *
     * @param String $password            
     */
    private function setPassword ($password)
    {
        $this->_password = $password;
    }

    /**
     * return $username
     */
    private function getUsername ()
    {
        return $this->_username;
    }

    /**
     *
     * @param String $username            
     */
    private function setUsername ($username)
    {
        $this->_username = $username;
    }

    /**
     *
     * @param Int $userid            
     */
    private function setUserId ($id)
    {
        $this->_id = $id;
    }

    /**
     * return $userid
     */
    private function getUserId ()
    {
        return $this->_id;
    }

    /**
     * Called from login method when user credentials in the system
     * have been checked
     *
     * Usage: Sets userid and username of user in session
     * for further usage
     */
    private function setSession ()
    {
        $_SESSION["username"] = $this->getUsername();
        $_SESSION["userid"] = $this->getUserId();
        $_SESSION['isAdmin'] = "1";
    }

    /**
     *
     * @param
     *            Email id of user trying to log in: $fieldEmail
     * @param
     *            Password of user trying to log in: $fieldPassword
     *            Called by: initiateLogin in MainController
     * @return number 1 if entry exists by calling exists function
     * Usage: Checks for valid login information
     */
    public function login ($fieldUsername, $fieldPassword)
    {
        $this->setPassword($fieldPassword);
        $this->setUsername($fieldUsername);
        
        if ($this->exists($this->encryptPassword($this->getPassword()), $this->getUsername()) == 1) {
            $this->setSession();
            return 1;
        } else {
            $_SESSION['msg'] = "";
            $_SESSION['msg'] = $_SESSION['msg'] . '<br>' . "Login Failed username or password does not exist";
            header("Location:index.php");
            die();
        }
    }

    /**
     *
     * @param $email entered
     *            by user
     * @param $password entered
     *            by use after encryption
     * @return 1 if user exists in system, 0 if doesn't
     * Usage: Checks for user exists or not in system
     */
    private function exists ($password, $username)
    {
        if ($this->fetchUser($username, $password) == true) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     *
     * @param $email of
     *            user logging in
     * @param $password encrypted of user logging in as
     *         we have store encrypted versions while registration
     * @return number 1 if user exists with active status else 0
     * Usage: fetches the user if exists who is logging in
     */
    private function fetchUser ($username, $password)
    {
        $data['tables'] = 'login';
        $data['columns'] = array(
            'id',
            'username',
            'password'
        );
        $data['conditions'] = array(
            array(
                'username ="' . $this->getUsername() . '" AND status="1"'
            ),
            true
        );
        $result = $this->_db->select($data);
        $myResult = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $myResult[] = $row;
        }
        if (! empty($myResult)) {
            if (md5($myResult[0]['password']) === md5($password)) {
                
                $this->setUserId($myResult[0]['id']); // if login is sucessfull,setting userid
                
                return 1;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
        return $myResult;
    }

    /**
     * Called from within login($fieldEmail, $fieldPassword)
     * 
     * @param $password Received
     *            from user logging in
     * @return encrypted password
     * Usage: Converts the password to encrypted one
     */
    private function encryptPassword ($password)
    {
        return md5($password);
    }
    /**
     * 
     * @return ResultSet|errorNumber
     * 
     * This function is used to fetch all Admin User data
     */
    public function fetchAllAdminUser ()
    {
        $data['tables'] = 'login';
        $data['columns'] = array(
            'id',
            'username',
            'is_admin',
            'password'
        );
        $data['conditions'] = array(
            array(
                'status="1"'
            ),
            true
        );
        $result = $this->_db->select($data);
        $myResult = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $myResult[] = $row;
        }
        return $myResult;
    }
    /**
     * 
     * @return ResultSet|errorNumber
     * 
     * This function is used to delete new Admin User
     */
    public function deleteAdminUser ()
    {
        $id = $_REQUEST['value'];
        $data = array(
            'status' => "0"
        );
        $where = array(
            'id' => $id
        );
        
        $result = $this->_db->update('login', $data, $where);
        return $result;
    }
    /**
     * 
     * @return number
     * 
     * This function is used to create new Admin User
     */
    public function createAdminUser ()
    {
        $userid = $_REQUEST['user'];
        $password = md5($_REQUEST['password']);
        $c_password = md5($_REQUEST['c_password']);
        if ($userid != NULL || $_REQUEST['password'] != NULL) {
            if ($password == $c_password) {
                
                $result = $this->_db->insert('login', array(
                    'username' => $userid,
                    'password' => $password,
                    'status' => "1",
                    'is_admin' => NULL,
                    'created_on' => 'now()',
                    'updated_on' => NULL
                ));
                return $result;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }
    /**
     * 
     * @return number
     * This function is used to change the admin password
     */
    public function changeAdminPassword ()
    {
        $userid = $_REQUEST['value'];
        $old_password = md5($_REQUEST['old_passwd']);
        
        $data['tables'] = 'login';
        $data['columns'] = array(
            'password'
        );
        $data['conditions'] = array(
            array(
                'id=' . $userid
            ),
            true
        );
        $result = $this->_db->select($data);
        $myResult = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $myResult[] = $row;
        }
        if ($myResult[0]['password'] == $old_password) {
            if ($_REQUEST['passwd'] == "" || (md5($_REQUEST['passwd']) == md5($_REQUEST['old_passwd']))) {
                return 1;
            } else {
                $password = md5($_REQUEST['passwd']);
                $data = array(
                    'password' => $password
                );
                $where = array(
                    'id' => $userid
                );
                
                $result = $this->_db->update('login', $data, $where);
                return 2;
            }
        } else {
            return 0;
        }
    }
}