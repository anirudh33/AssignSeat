<?php

/*
 * FileName: Validation.class.php 
 * Version: 1.0 
 * Author: Keshi Chander Yadav, Tanu Trehan, Manish 
 * Date: May 03, 2013
 * Description: Validation class to server side validation
 * ***************************** Update Log ********************************
	Sr.NO.		Version		Updated by           Updated on          Description
    -------------------------------------------------------------------------
	 1			1.1			Keshi				08/05/2013			correction of pregmatch
 	 2			1.1			Keshi				08/05/2013			used lang and added comments
    *************************************************************************
 */
class validation {
	// class constructor
	function __construct() {
		$this->id = 0;
	}
	
	/*
	 * Description: function to validate fields has to first add their fields data
	 * to this function
	 * Param $controler_name field control name goes here
	 * Param $postVar field data to be validated
	 * Param $authType Type of validation required for control
	 * Param $error error message for in case of validation failed
	 */
	function addFields($controler_name, $postVar, $authType, $error) {
		$index = $this->id ++;
		
		$this->check_vars [$index] ['data'] = $postVar;	//store control field data to be validated 
		$this->check_vars [$index] ['authtype'] = $authType;	//store type of validation required
		$this->check_vars [$index] ['error'] = $error;	//store error message for in case of validation failed
		$this->check_vars [$index] ['controler_name'] = $controler_name; //store error message for in case of validation failed
	}
	
	/*
	 * Description: function to validate fields common for all
	 */
	function validate() {
		$errorMsg = array ();	//variable store error messages
		$result =1;
		
		for($i = 0; $i < $this->id; $i ++) {
			$errorMsg [$this->check_vars [$i] ['controler_name']] = "";
		}
		
		for($i = 0; $i < $this->id; $i ++) {
			if(strlen($errorMsg [$this->check_vars [$i] ['controler_name']]))
			{
				continue;
			}
			$postVar = $this->check_vars [$i] ['data'];
			$authType = $this->check_vars [$i] ['authtype'];
			
			if ($this->check_vars [$i] ['error'] == "" || $this->check_vars [$i] ['error'] == " ") {
				$error = $lang->INVALID;
			} else {
				$error = $this->check_vars [$i] ['error'];
			}
			
			$pos = strpos ( $authType, '=' );
			if ($pos !== false) {
				$authType = substr ( $this->check_vars [$i] ['authtype'], 0, $pos );
				$value = substr ( $this->check_vars [$i] ['authtype'], $pos + 1 );
			}
			
			switch ($authType) {
				//check whether field is required or not
				case "required" :
					{
						if (is_array ( $postVar )) {
							$count = count ( $postVar );
							
							for($j = 0; $j < $count; $j ++) {
								$length = strlen ( trim ( $postVar [$j] ) );
								if (! $length) {
									$errorMsg [$this->check_vars [$i] ['controler_name']] .= $error . " :File " . ($j + 1);
								}
							}
						} elseif (isset ( $postVar ) && empty ( $postVar )) {
							$length = strlen ( trim ( $postVar ) );
							
							if (! $length) {
								$errorMsg [$this->check_vars [$i] ['controler_name']] .= $error ;
							}
						} else {
							$length = strlen ( trim ( $postVar ) );
							
							if (! $length) {
								$errorMsg [$this->check_vars [$i] ['controler_name']] .= $error ;
							}
						}
						break;
					}
				
				//validate field only contains alpha characters only
				case "alphabets" :
					{
						$regexp = '/^[A-za-z]*$/';
						if (! preg_match ( $regexp, trim ( $postVar ) )) {
							$length = strlen ( trim ( $postVar ) );
							
							if ($length)
								$errorMsg [$this->check_vars [$i] ['controler_name']] .= $error;
						}
						break;
					}
				
				//validate field only contains alphanumeric characters only
				case "alphanumeric" :
					{
						$regexp = '/^[A-za-z0-9]*$/';
						if (! preg_match ( $regexp, trim ( $postVar ) )) {
							$length = strlen ( trim ( $postVar ) );
							
							if ($length)
								$errorMsg [$this->check_vars [$i] ['controler_name']] .= $error;
						}
						break;
					}
				
				//validate field only contains numeric characters only	
				case "numeric" :
					{
						$regexp = '/^[0-9]*$/';
						if (! preg_match ( $regexp, trim ( $postVar ) )) {
							$length = strlen ( trim ( $postVar ) );
							
							if ($length)
								$errorMsg [$this->check_vars [$i] ['controler_name']] .= $error;
						}
						break;
					}
				
				//validate field max character limit	
				case "maxlength" :
					{
						$length = strlen ( trim ( $postVar ) );
						
						if ($length > $value)
							$errorMsg [$this->check_vars [$i] ['controler_name']] .= $error;
						
						break;
					}
				
				//validate field min character limit
				case "minlength" :
					{
						$length = strlen ( trim ( $postVar ) );
						
						if ($length < $value && $length != 0)
							$errorMsg [$this->check_vars [$i] ['controler_name']] .= $error;
						
						break;
					}

				//validate username field ...it can contain alphanumeric without any spaces
				case "username" :
					{
						$regexp1 = '/^[0-9]$/';
						$regexp2 = '/^[a-zA-Z]+[a-zA-Z0-9\.\_]*[a-zA-Z0-9]+$/';
						
						if (! preg_match ( $regexp1, trim ( $postVar ) ) && ! preg_match ( $regexp2, trim ( $postVar ) )) {
							$length = strlen ( trim ( $postVar ) );
							
							if ($length)
								$errorMsg [$this->check_vars [$i] ['controler_name']] .= $error;
						}
						break;
					}
				
				//checks for script tags
				case "script" :
					{
						$regexp1 = '/(<([^>]+)>)/i';
						if (! preg_match ( $regexp1, trim ( $postVar ) )) {
							$length = strlen ( trim ( $postVar ) );
							
							if ($length)
								$errorMsg [$this->check_vars [$i] ['controler_name']] .= $error;
						}
						break;
					}
				
				//validates form address field
				case "address" :
					{
						$regexp = '/^[a-zA-Z0-9]+.*$/';
						if (! preg_match ( $regexp, trim ( $postVar ) )) {
							$length = strlen ( trim ( $postVar ) );
							
							if ($length)
								$errorMsg [$this->check_vars [$i] ['controler_name']] .= $error ;
						}
						break;
					}
				
				//validates phone field
				case "phone" :
					{
						if (isset ( $value )) {
							$found = strpos ( $value, ',' );
							
							if ($found === false) {
								$options [0] = $value;
							} else {
								$options = explode ( ",", $value );
							}
						}
						
						$patternMatch = 0;
						foreach ( $options as $opt ) {
							$type = $this->availablePhoneType ( $opt );
							
							foreach ( $type as $regexp ) {
								if (preg_match ( $regexp, $postVar )) {
									$patternMatch = 1;
								}
							}
							if ($patternMatch)
								break;
						}
						
						if (! $patternMatch) {
							$length = strlen ( trim ( $postVar ) );
							if ($length) {
								$errorMsg [$this->check_vars [$i] ['controler_name']] .= $error ;
							}
						}
						break;
					}
				
				//validates mobile field	
				case "mobile" :
					{
						$regexp1 = '/^[0-9]{10}$/';
						// (+91)1111111111
						$regexp2 = '/^[\(][\+][0-9]{2}[\)][0-9]{10}$/';
						// +911111111111
						$regexp3 = '/^[\+][0-9]{2}[0-9]{10}$/';
						// 1-1111111111
						$regexp4 = '/^[0-9]{2}[\-][0-9]{10}$/';
						
						if (! preg_match ( $regexp1, trim ( $postVar ) ) && ! preg_match ( $regexp2, trim ( $postVar ) ) && ! preg_match ( $regexp3, trim ( $postVar ) ) && ! preg_match ( $regexp4, trim ( $postVar ) )) {
							$length = strlen ( trim ( $postVar ) );
							
							if ($length)
								$errorMsg [$this->check_vars [$i] ['controler_name']] .= $error;
						}
						break;
					}
				
				//validates emial field	
				case "email" :
					{
						$regexp = '/^[A-Za-z]+((\.|\_){1}[a-zA-Z0-9]+)*@([a-zA-Z0-9]+([\-]{1}[a-zA-Z0-9]+)*[\.]{1})+[a-zA-Z]{2,4}$/';
						if (! preg_match ( $regexp, trim ( $postVar ) )) {
							$length = strlen ( trim ( $postVar ) );
							
							if ($length) {
								$errorMsg [$this->check_vars [$i] ['controler_name']] .= $error ;
							}
						}
						break;
					}
				
				//validates url field
				case "url" :
					{
						$regexp = '|^http(s)?://[a-z0-9-]+(\.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i';
						if (! preg_match ( $regexp, trim ( $postVar ) )) {
							$length = strlen ( trim ( $postVar ) );
							
							if ($length) {
								$errorMsg [$this->check_vars [$i] ['controler_name']] .= $error ;
							}
						}
						break;
					}
				
				//validates date field
				case "date" :
					{
						$errorMsg [$this->check_vars [$i] ['controler_name']] .= $this->validateDate ( trim ( $postVar ), $value, $error );
						break;
					}
					
				//validates password match
				case "match" :
						{
							$data = explode("#", $postVar);
							if(count($data) == 2) {
								if($data[0] != $data[1]) {
									$errorMsg [$this->check_vars [$i] ['controler_name']] .= $error ;
									break;
								}
							}
						}
				
				//validates datatype of field
				case "datatype" :
					{
						$limit=explode(',',$value);
						if ($limit[0] == "int") {	
							$regexp  = '/^[0-9]{'.$limit[1].'}$/';
							
							if (! preg_match ( $regexp, trim ( $postVar ) )) {
								$length = strlen ( trim ( $postVar ) );
								
								if ($length){
									$errorMsg [$this->check_vars [$i] ['controler_name']] .= $error ;
								}
							}
						}
						
						if ($limit[0] == "float") {
							$regexp  = '/^[0-9]{'.$limit[1].'}.[0-9]{'.$limit[2].'}$/';
							if (! preg_match ( $regexp, trim ( $postVar ) )) {
								$length = strlen ( trim ( $postVar ) );
								if ($length){
									$errorMsg [$this->check_vars [$i] ['controler_name']] .= $error;
								}
							}
						}
						
					if ($limit[0] == "bool") {
							$result = is_bool ( $postVar );
					}
						
					if ($limit[0] == "null") {
							$result = is_null ( $postVar );
					}
						
					if (!$result) {
							$errorMsg [$this->check_vars [$i] ['controler_name']] .= $error ;
						}	
						break;
					}
					
					case "ftype":{
						$errorMsg .= $this->validateFileType($postVar, $value, $error);
						break;
					}
					
					case "fsize":{
						$errorMsg .= $this->validateFileSize($postVar, $value, $error);
						break;
					}
					
				case "custom" :
					{
						if (! preg_match ( $value, trim ( $postVar ) )) {
							$length = strlen ( trim ( $postVar ) );
							if ($length)
								$errorMsg [$this->check_vars [$i] ['controler_name']] .= $error ;
						}
						break;
					}
			default:
				{
					echo"you entered a wrong choice";
					break;
				}
			}
		}
		
		return $errorMsg;
	}
	
	//function to validate date field 
	function validateDate($postVar, $value, $error) {$errorMsg = "";
        $length = strlen ( trim ( $postVar ) );
        
        if ($length) {
            if (isset ( $value )) {
                $found = strpos ( $value, ',' );
                if ($found === false) {
                    $options [0] = $value;
                } else {
                    $options = explode ( ",", $value );
                }
            } else {
                $options [0] = 'dd-mm-yyyy';
            }
           
            $patternMatch = 0;
            
            foreach ( $options as $opt ) {
                $pos1 = strpos ( $opt, '-' );
                $pos2 = strpos ( $opt, '/' );
                $pos3 = strpos ( $opt, '.' );
               
                if ($pos1 !== false) {
                    if ($pos1 == 2) {
                        if (strlen ( $opt ) == 8)
                            $regexp = '/^[0-9]{2}[\-][0-9]{2}[\-][0-9]{2}$/';
                        else
                            $regexp = '/^[0-9]{2}[\-][0-9]{2}[\-][0-9]{4}$/';
                    }
                    if ($pos1 == 4)
                        $regexp = '/^[0-9]{4}[\-][0-9]{2}[\-][0-9]{2}$/';

                }
               
                if ($pos2 !== false) {
                    if ($pos2 == 2) {
                        if (strlen ( $opt ) == 8)
                            $regexp = '/^[0-9]{2}[\/][0-9]{2}[\/][0-9]{2}$/';
                        else
                            $regexp = '/^[0-9]{2}[\/][0-9]{2}[\/][0-9]{4}$/';
                    }
                    if ($pos2 == 4)
                        $regexp = '/^[0-9]{4}[\/][0-9]{2}[\/][0-9]{2}$/';
                }
               
                if ($pos3 !== false) {
                    if ($pos3 == 2) {
                        if (strlen ( $opt ) == 8)
                            $regexp = '/^[0-9]{2}[\.][0-9]{2}[\.][0-9]{2}$/';
                        else
                            $regexp = '/^[0-9]{2}[\.][0-9]{2}[\.][0-9]{4}$/';
                    }
                    if ($pos3 == 4)
                        $regexp = '/^[0-9]{4}[\.][0-9]{2}[\.][0-9]{2}$/';
                }
               
                if (preg_match ( $regexp, $postVar )) {
                    $patternMatch = 1;
                    if ((isset ( $pos1 ) && $pos1 == 2) || (isset ( $pos2 ) && $pos2 == 2) || (isset ( $pos3 ) && $pos3 == 2)) {
                        $str1 = substr ( $opt, 0, 2 );
                        $str2 = substr ( $opt, 3, 2 );
                       
                        if ($str1 == 'dd') {
                            $DD = substr ( $postVar, 0, 2 );
                            $MM = substr ( $postVar, 3, 2 );
                            $YY = substr ( $postVar, 6 );
                        }
                        if ($str1 == 'mm') {
                            $MM = substr ( $postVar, 0, 2 );
                            $DD = substr ( $postVar, 3, 2 );
                            $YY = substr ( $postVar, 6 );
                        }
                        if ($str1 == 'yy') {
                            if ($str2 == 'mm') {
                                $YY = substr ( $postVar, 0, 2 );
                                $MM = substr ( $postVar, 3, 2 );
                                $DD = substr ( $postVar, 6 );
                            } else {
                                $MM = substr ( $postVar, 0, 2 );
                                $DD = substr ( $postVar, 3, 2 );
                                $YY = substr ( $postVar, 6 );
                            }
                        }
                    }
                   
                    if ((isset ( $pos1 ) && $pos1 == 4) || (isset ( $pos2 ) && $pos2 == 4) || (isset ( $pos3 ) && $pos3 == 4)) {
                        $str = substr ( $opt, 5, 2 );
                       
                        if ($str == 'dd') {
                            $YY = substr ( $postVar, 0, 4 );
                            $DD = substr ( $postVar, 5, 2 );
                            $MM = substr ( $postVar, 8, 2 );
                        }
                        if ($str == 'mm') {
                            $YY = substr ( $postVar, 0, 4 );
                            $MM = substr ( $postVar, 5, 2 );
                            $DD = substr ( $postVar, 8, 2 );
                        }
                    }
                   
                    if ($DD == 0 || $MM == 0 || $YY == 0) {
                        $errorMsg .= "Invalid Date...<br>";
                    }
                   
                    if ($MM <= 12) {
                        switch ($MM) {
                            case 4 :
                            case 6 :
                            case 9 :
                            case 11 :
                                if ($DD > 30) {
                                    $errorMsg .= "Selected month has maximum 30 days.<br>";
                                }
                            default :
                                if ($DD > 31) {
                                    $errorMsg .= "Selected month has maximum 31 days.<br>";
                                }
                                break;
                        }
                    } else  {
                        $errorMsg .= "Selected month more than 12 month.<br>";
                    }
                   
                    if (($YY % 4) == 0) {
                        if (($MM == 2) && ($DD > 29)) {
                            $errorMsg .= "Invalid days in February for leap year.<br>";
                        }
                    } else {
                        if (($MM == 2) && ($DD > 28)) {
                            $errorMsg .= "Invalid days in February for non leap year.<br>";
                        }
                    }
                }
               
                if ($patternMatch)
                    break;
            }
           
            if (! $patternMatch)
                $errorMsg .= $error ;
        }
        return $errorMsg;
	}
	
	//function to validate File type
	function validateFileType($postVar, $value, $error)
	{
		$errorMsg = "";
		if(isset($value)){
			$found = strpos($value, ',');
			if($found === false){
				$options[0] = $value;
			}
			else{
				$options = explode(",", $value);
			}
		}
	
		if(is_array($postVar['name'])){
			$totalFiles = count($postVar['name']);
	
			for($i=0; $i < $totalFiles; $i++){
				if($postVar['name'][$i]){
					$fileTypeMatch = 0;
					foreach($options as $id => $type){
						$typeArray = $this->availableFileTypes($type);
						if(in_array($postVar['type'][$i], $typeArray)){
							$fileTypeMatch = 1;
						}
						if($fileTypeMatch)	break;
					}
	
					if(!$fileTypeMatch){
						$errorMsg .= $error." (".$postVar['name'][$i].")<br>";
					}
				}
			}
		}
		else {
			if($postVar['name']){
				$fileTypeMatch = 0;
				foreach($options as $id => $type){
					$typeArray = $this->availableFileTypes($type);
					if(in_array($postVar['type'], $typeArray)){
						$fileTypeMatch = 1;
					}
					if($fileTypeMatch)  break;
				}
	
				if(!$fileTypeMatch){
					$errorMsg .= $error." (".$postVar['name'].")<br>";
				}
			}
		}
	
		return $errorMsg;
	}
	
	//manage available file type that are valid
	function availableFileTypes($ext)
	{
		switch($ext) {
			case "txt":
				$type[0] = "text/plain";
				break;
	
			case "xml":
				$type[0] = "text/xml";
				$type[1] = "application/xml";
				break;
	
			case "csv":
				$type[0] = "text/x-comma-separated-values";
				$type[1] = "application/octet-stream";
				$type[2] = "text/plain";
				break;
	
			case "zip":
				$type[0] = "application/zip";
				break;
	
			case "tar":
				$type[0] = "application/x-gzip";
				break;
	
			case "ctar":
				$type[0] = "application/x-compressed-tar";
				break;
	
			case "pdf":
				$type[0] = "application/pdf";
				break;
	
			case "doc":
				$type[0] = "application/msword";
				$type[1] = "application/octet-stream";
				break;
	
			case "xls":
				$type[0] = "application/vnd.ms-excel";
				$type[1] = "application/vnd.oasis.opendocument.spreadsheet";
				break;
	
			case "ppt":
				$type[0] = "application/vnd.ms-powerpoint";
				break;
	
			case "jpg":
				$type[0] = "image/jpg";
				$type[1] = "image/jpeg";
				$type[2] = "image/pjpeg";
				break;
	
			case "gif":
				$type[0] = "image/gif";
				break;
	
			case "png":
				$type[0] = "image/png";
				break;
	
			case "bmp":
				$type[0] = "image/bmp";
				break;
	
			case "icon":
				$type[0] = "image/x-ico";
				break;
	
			case "font":
				$type[0] = "application/x-font-ttf";
				break;
		}
	
		return $type;
	}
	
	//function to check size of file 
	function validateFileSize($postVar, $value, $error)
	{
		$errorMsg = "";
		if(is_array($postVar['name'])){
			$totalFiles = count($postVar['name']);
	
			for($i=0; $i < $totalFiles; $i++){
				if($postVar['name'][$i]){
					if($postVar['size'][$i] > $value){
						$errorMsg .= $error." (".$postVar['name'][$i].")<br>";
					}
				}
			}
		}
		else {
			if($postVar['size'] > $value){
				$errorMsg .= $error." (".$postVar['name'].")<br>";
			}
		}
	
		return $errorMsg;
	}

	 //function to manage availble phone type
	 function availablePhoneType($country) {
	
		switch($country) {
	
		case "in": # India
			$type[0]  = '/^[0-9]{6,10}$/';
			# (+91)[022]111111
			$type[1]  = '/^[\(][\+][0-9]{2}[\)][\[][0-9]{3,5}[\]][0-9]{6,10}$/';
			# +91022111111
			$type[2]  = '/^[\+][0-9]{2}[0-9]{3,5}[0-9]{6,10}$/';
			# 91-111111
			$type[3]  = '/^[0-9]{2}[\-][0-9]{6,10}$/';
			break;
	
		case "br": # Brazil
			$type[0] = '/^([0-9]{2})?(\([0-9]{2})\)([0-9]{3}|[0-9]{4})-[0-9]{4}$/';
			break;
	
		case "fr": # France
			$type[0] = '/^([0-9]{2})?(\([0-9]{2})\)([0-9]{3}|[0-9]{4})-[0-9]{4}$/';
			break;
	
		case "us": # US
			$type[0] = '/^[\(][0-9]{3}[\)][0-9]{3}[\-][0-9]{4}$/';
			break;
	
		case "sw": # Swedish
			$type[0] = '/^(([+][0-9]{2}[ ][1-9][0-9]{0,2}[ ])|([0][0-9]{1,3}[-]))(([0-9]{2}([ ][0-9]{2}){2})|([0-9]{3}([ ][0-9]{3})*([ ][0-9]{2})+))$/';
			break;
		}
	
		return $type;
	    }
		
		// Helps prevent XSS attacks
		function encodeXSString($string) {
			// Remove dead space.
			$string = trim ( $string );
			
			// Prevent potential Unicode codec problems.
			$string = utf8_decode ( $string );
			
			// HTMLize HTML-specific characters.
			$string = htmlentities ( $string, ENT_QUOTES );
			$string = str_replace ( "#", "&#35;", $string );
			$string = str_replace ( "%", "&#37;", $string );
	
			return $string;
		}
	
		// Helps prevent XSS attacks
		private function decodeXSString($string) {
			// Remove dead space.
			$string = trim ( $string );
			
			// Prevent potential Unicode codec problems.
			$string = utf8_decode ( $string );
			
			// HTMLize HTML-specific characters.
			$string = htmlentities ( $string, ENT_QUOTES );
			$string = str_replace ( "&#35;", "#", $string );
			$string = str_replace ( "&#37;", "%", $string );
			$length = intval ( $length );
			
			if ($length > 0) {
				$string = substr ( $string, 0, $length );
			}
			return $string;
		}
	
		// prevent sql injection
		// $param parameter will accept array type
		private function preventSQLInjection($string) {
			foreach ( $string as $key => $value ) {
				$value = mysql_real_escape_string ( $value );
			}
			return $string;
		}
}