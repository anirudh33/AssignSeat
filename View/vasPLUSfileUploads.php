<?php
$upload_location = "../upload_folder/";
if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
{
	
	$fileName = $_FILES['vasPhoto_uploads']['name'];
	$tmpName  = $_FILES['vasPhoto_uploads']['tmp_name'];
	$fileType = $_FILES['vasPhoto_uploads']['type'];
	$chk_ext = explode(",",$fileName);
	$handle = fopen($tmpName, "r");
	if(!$handle){
		die ('Cannot open file for reading');
	}
	while (($data = fgetcsv($handle, 10000, ",")) !== FALSE){
		 echo "<pre>";print_r($data);
	}
}
?>
