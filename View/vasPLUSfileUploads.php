<?php
//include "Controller/MainController.php";


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
	//$ob=new MainController();
	//$emailId=$ob->emailFetch();
	while (($data = fgetcsv($handle, 10000, ",")) !== FALSE){
		 echo "<pre>";print_r($data);
		 
		 
		 
		 
		 
		 
		 
// 		$upload->setQuestionName($data[0]);
// 		$upload->setQuessetid($nQuesSetId);
// 		$upload->setOption( array ($data[1],$data[2],$data[3],$data[4]) );
// 		$upload->setAnswer($data[5]);
// 		$count ++;
	}
	/*
	$name = $_FILES['vasPhoto_uploads']['name'];
	$size = $_FILES['vasPhoto_uploads']['size'];
	
	$allowedExtensions = array("csv"); 
	foreach ($_FILES as $file) 
	{
		
		if ($file['tmp_name'] > '' && strlen($name)) 
	  {

	  	if (!in_array(end(explode(".", strtolower($file['name']))), $allowedExtensions)) 
		  {
		  	
		  	echo '<div class="info" style="width:500px;">Sorry, you attempted to upload an invalid file format. <br>Only csv files are allowed. Thanks.</div><br clear="all" />';
		  }
		  else 
		  {
		  	$actual_image_name = $name; // This could be a random name such as rand(125678,098754).'.gif';
					 
		if(move_uploaded_file($_FILES['vasPhoto_uploads']['tmp_name'], $upload_location.$actual_image_name)) 
		{
	
echo "<div class='info'> File  uploaded sucessfully. Thanks.</div><br clear='all' />";					
		}
		}
	  }
	  else 
	  {
		  echo "<div class='info' style='width:400px;'>You have just canceled your file upload process. Thanks.</div><br clear='all' />";
	  }
   }*/
}
?>
