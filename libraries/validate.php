<?php
/**
 * **************************** Creation Log *******************************
 * File Name                   -  Validate.php
 * Project Name                -  AssignSeat
 * Description                 -  Model class from RoomRow Table
 * @Version                   -  1.0
 * ***************************** Update Log ********************************
 * Sr.NO.		Version		Updated by           Updated on          Description
 * -------------------------------------------------------------------------
 *
 * *************************************************************************
 */
require_once ('validation.class.php');

class validate
{

    private $obj; // Class Object Reference
    private $errorMsg = "";

    public function __construct ()
    {
        $this->obj = new validation();
    }

    /**
     * Description: function to validate fields to this function
     * 
     * @param $controler_name field
     *         control name goes here
     * @param $postVar field
     *         data to be validated
     * @param $authType Type of validation required for control
     * @param $error error message for in case of validation failed
     */
    function validator ($name, $postVar = " ", $authType, $error)
    {
        if (isset($_SERVER["REQUEST_METHOD"])) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $auth = explode('#', $authType);
                $err = explode('#', $error);
                $authLength = count($auth);
                $errLength = count($err);
                
                if ($authLength == $errLength) {
                    for ($i = 0; $i < $authLength; $i ++) {
                        $this->obj->addFields($name, $postVar, $auth[$i], $err[$i]);
                    }
                    return "here true";
                } else {
                    $this->errorMsg = "Programer's error";
                    return $this->errorMsg;
                }
            } else {
                $this->errorMsg = "Invalid request";
                return $this->errorMsg;
            }
        } 

        else {
            $this->errorMsg = "Invalid request, no request received";
            return $this->errorMsg;
        }
    }

    /**
     *
     * @return validation result with error messages
     */
    public function result ()
    {
        $this->errorMsg = $this->obj->validate();
        $flag = true;
        // if to set flag to false if any field of form has invalid value
        if (array_filter($this->errorMsg, 'trim')) {
            $flag = false;
        }
        // if to return TRUE all fields of form are valid
        if ($flag) {
            return false;
        }         // else return errorMsg[] wid all fields as key and error as value respectively! value is null if no error
        else {
            return $this->errorMsg;
        }
    }

    /**
     *
     * @param unknown $string            
     * @return mixed Helps prevent XSS attacks
     * Used for encoding before insertion in database
     */
    public function encodeXSString ($string)
    {
        // Remove dead space.
        $string = trim($string);
        
        // Prevent potential Unicode codec problems.
        $string = utf8_decode($string);
        
        // HTMLize HTML-specific characters.
        $string = htmlentities($string, ENT_QUOTES);
        $string = str_replace("#", "&#35;", $string);
        $string = str_replace("%", "&#37;", $string);
        
        return $string;
    }

    /**
     * Helps prevent XSS attacks
     * Used for denoding before displaying information on page
     */
    private function decodeXSString ($string)
    {
        // Remove dead space.
        $string = trim($string);
        
        // Prevent potential Unicode codec problems.
        $string = utf8_decode($string);
        
        // HTMLize HTML-specific characters.
        $string = htmlentities($string, ENT_QUOTES);
        $string = str_replace("&#35;", "#", $string);
        $string = str_replace("&#37;", "%", $string);
        $length = intval($length);
        
        if ($length > 0) {
            $string = substr($string, 0, $length);
        }
        return $string;
    }

    /**
     * prevent sql injection
     * @param parameter will accept array type
     */
    private function preventSQLInjection ($string)
    {
        foreach ($string as $key => $value) {
            $value = mysql_real_escape_string($value);
        }
        return $string;
    }

    /**
     *
     * @param unknown $array            
     * @param string $recursive            
     * @param string $null            
     * @return boolean string
     * @author anirudh pandita
     * usage Generates html from array in tabular format, used to display errors
     */
    function array2table ($array, $recursive = false, $null = '&nbsp;')
    {
        // Sanity check
        if (empty($array) || ! is_array($array)) {
            return false;
        }
        
        if (! isset($array[0]) || ! is_array($array[0])) {
            $array = array(
                $array
            );
        }
        
        // Start the table
        $table = "<table border='1px' class = 'customHeading'>";
        
        // The header
        $table .= "<tr>";
        // Take the keys from the first row as the headings
        foreach (array_keys($array[0]) as $heading) {
            $table .= '<th>' . $heading . '</th>';
        }
        $table .= "</tr>";
        
        // The body
        foreach ($array as $row) {
            $table .= "<tr>";
            foreach ($row as $cell) {
                $table .= '<td>';
                
                // Cast objects
                if (is_object($cell)) {
                    $cell = (array) $cell;
                }
                
                if ($recursive === true && is_array($cell) && ! empty($cell)) {
                    // Recursive mode
                    $table .= "\n" . array2table($cell, true, true) . "\n";
                } else {
                    $table .= (strlen($cell) > 0) ? htmlspecialchars((string) $cell) : $null;
                }
                
                $table .= '</td>';
            }
            
            $table .= "</tr>";
        }
        
        $table .= '</table>';
        return $table;
    }
}