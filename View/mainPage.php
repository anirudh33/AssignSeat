<?php 
/*
 * Creation Log File Name - main.php
* Description - Main view file
* Version - 1.0
* Created by - Avni jain
* Created on - july 29, 2013
* *************************************************
*/
echo $_SESSION ["username"];
echo $_SESSION ["userid"];
?>
<html lang="">
<head>  
<title></title>
<link rel="stylesheet" href="<?php echo SITE_URL;?>/assets/css/main.css" type="text/css" media="all">
</head>
<script type="text/javascript" src="<?php echo SITE_URL;?>/assets/js/jquery-1.9.1.min.js"></script>
<script>
$(document).ready(function () {
$("#logout").click(function(){

	alert("session will end");
	$.post('index.php?controller=MainController&method=logout',function(data,status){
				});

		
});
});
</script>

<body>

<div id="maindiv">
	<div id="header">
	<input type="button" class="btn blue" id="logout" value="logout" onclick="logout()">
	<h1>Assign Seat</h1>
	<h4>Welcome <?php echo $_SESSION ["username"];?></h4>
	
	</div>
	
	<div id="leftbar">
		
    <div id="leftsubbar">
		<h3>Search Employee</h3>
	   <?php include_once 'seat.php';?>
    </div>
	</div>
	
    <div id="rightbar">
        <?php include_once 'mainBuilding.php';?>
    </div>
	<div id="footer">
		<center>Copyright Batch1 OssCube Pvt Ltd</center>
	</div>
</div>
</body>

</html>
