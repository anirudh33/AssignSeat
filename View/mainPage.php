<?php 
/*
 * Creation Log File Name - main.php
* Description - Main view file
* Version - 1.0
* Created by - Avni jain
* Created on - july 29, 2013
* *************************************************
*/
?>
<html lang="">
<head>  
<title></title>
<link rel="stylesheet" href="<?php echo SITE_URL;?>/assets/css/main.css" type="text/css" media="all">
</head>

<body>
login
<div id="maindiv">
	<div id="header">
	 
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
	
	</div>
</div>
</body>

</html>
