<?php
/**
 * **************************** Creation Log *******************************
 * File Name                   -  Language.php
 * Project Name                -  AssignSeat
 * Description                 -  Class file for start
 * @Version                   -  1.0
 * Created by                  -  Chetan Sharma
 * Created on                  -  August 03, 2013
 * ***************************** Update Log ********************************
 * Sr.NO.		Version		Updated by           Updated on          Description
 * -------------------------------------------------------------------------
 * 
 * *************************************************************************
 */


/**
 * This class will load the language file from language folder, using the 
 * @var $language variable to fetch the current language code
 * 
 * @example en
 * */
class Language {

	private $_lang;          //store user selected language array


	public function __construct($language) {
		$this->_lang=$language;

	}

	public function __get($key){
		if(array_key_exists($key,$this->_lang))
		{
		return $this->_lang[$key];
		}
		else {
		    return $key;
		}
	}
}
if(isset($_SESSION['lang'])){
	$langType=$_SESSION['lang'];
}
else
{
	$langType='en';
}
require_once SITE_PATH .'/languages/lang.'.$langType.".php";

$lang = new Language($langArr);
?>