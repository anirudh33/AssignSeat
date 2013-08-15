<?php
class MessageTable{
 protected $tableForm;
	public function createTable($tableMsg,$msg="",$noOfCol=1)
	{
$this->tableForm="<table width='400'><caption>".$msg."</caption>";
		foreach($tableMsg as $key=>$value)
		{
			$this->tableForm.="<tr>";
			if($noOfCol==1)
			{
			$this->tableForm.="<td>".$value."</td>";	
			}
			else{
				//write your code according to key value pair
			}
			$this->tableForm.="</tr>";
					
		}
		$this->tableForm.="</table>";
		return $this->tableForm;
		
	}
}