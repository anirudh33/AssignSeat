<?php
/**
 * Creation Log File Name - Acontroller.php
 * Description - Abstract Controller file
 * Version - 1.0
 * Created by - Chetan Sharma
 * Created on - July 29, 2013
 * * **************************** Update Log ********************************
 *Sr.NO.        Version        Updated by           Updated on          Description
 *-------------------------------------------------------------------------
 *
 * ************************************************************************
 */
abstract class Acontroller {
	/**
	 * Function to load a model class 
	 * @param string $modelName
	 * @return Object of model class
	 */
	function loadModel($modelName = "") {
		include_once SITE_PATH . '/libraries/DBconnect.php';
		include SITE_PATH . '/Model/' . $modelName . '.php';
		return new $modelName ();
	}
	/**
	 * Function to load view in MVC
	 * @param string $viewName
	 * @param $data
	 */
	function loadView($viewName = "", $data = array()) {
		include_once SITE_PATH . '/libraries/Language.php';
		include SITE_PATH . '/View/' . $viewName . '.php';
	}
}