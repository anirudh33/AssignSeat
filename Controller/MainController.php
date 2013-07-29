<?php


class MainController extends Acontroller
{
	private $_username;
	private $_password;
	private $_objInititateUser;
	
	public function MainController()
	{
		//$this->_objInitiateUser= new InitiateUser();
	}
	public function loginClick() {
		$_username=$_REQUEST['username'];
		$_password=$_REQUEST['password'];
		$this->_objInititateUser= new InitiateUser();
		$result=$this->_objInititateUser->login($_username,$_password);
		if($result==1) {
			//login sucessfull
			echo "login done";
		}
		else {
			echo " unsucessfull login";
		}
		
	}

}

?>
