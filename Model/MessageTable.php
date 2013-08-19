<?php
/**
 * **************************** Creation Log *******************************
 * File Name                   -  MessageTable.php
 * Project Name                -  AssignSeat
 * Description                 -  Class for creating table
 * @Version                   -  1.0
 * ***************************** Update Log ********************************
 * Sr.NO.		Version		Updated by           Updated on          Description
 * -------------------------------------------------------------------------
 *
 * *************************************************************************
 */
class MessageTable
{
    protected $tableForm;

    /**
     * 
     * @param String $tableMsg
     * @param string $msg
     * @param number $noOfCol
     * @return string
     */
    public function createTable ($tableMsg, $msg = "", $noOfCol = 1)
    {
        $this->tableForm = "<table width='400'><caption>" . $msg . "</caption>";
        foreach ($tableMsg as $key => $value) {
            $this->tableForm .= "<tr>";
            if ($noOfCol == 1) {
                $this->tableForm .= "<td>" . $value . "</td>";
            } else {
                // write your code according to key value pair
            }
            $this->tableForm .= "</tr>";
        }
        $this->tableForm .= "</table>";
        return $this->tableForm;
    }
}