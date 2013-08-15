<?php
class MessageTable{
 protected $tableForm;
	public function createTable($tableMsg,$msg="",$noOfCol)
	{
$this->tableForm="<table width='400'><caption>".$msg."</caption>";
		foreach($tableMsg as $key=>$value)
		{
			$this->tableForm.="<tr><td>".$value."</td></tr>";			
		}
		$this->tableForm.="</table>";
		return $this->tableForm;
		
	}
}