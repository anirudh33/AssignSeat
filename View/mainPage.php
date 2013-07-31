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
//echo "hi";die;
?>
<html lang="">
<head>  
<title></title>
<link rel="stylesheet" href="<?php echo SITE_URL;?>/assets/css/main.css" type="text/css" media="all">
</head>
<link rel = "stylesheet" href = "<?php echo SITE_URL;?>assets/css/jqueryui/jquery.ui.tooltip.css" />
<script src="<?php echo SITE_URL;?>/assets/js/jquery-1.9.1.min.js" ></script>
<script src="<?php echo SITE_URL;?>/assets/js/jquery ui/jquery.ui.core.min.js" ></script>
<script src="<?php echo SITE_URL;?>/assets/js/jquery ui/jquery.ui.widget.min.js" ></script>
<script src="<?php echo SITE_URL;?>/assets/js/jquery ui/jquery.ui.position.min.js" ></script>
<script src="<?php echo SITE_URL;?>/assets/js/jquery ui/jquery.ui.tooltip.min.js" ></script> 
<script>
$(function(){
	getData();
	startTooltip();// -- this will be enabled after seat drag testing

$("#logout").click(function(){
	$.post('index.php?controller=MainController&method=logout',function(data,status){
				window.location.href = 'index.php';
				});

		
});
});

</script>

<body>
<?php 
if(!isset($_SESSION ["username"])) { 
header("location:index.php");
}
?>
<div id="maindiv">
	<div id="header">
	<input type="button" class="btn blue" id="logout" value="logout">
	<h1>Assign Seat</h1>
	<h4>Welcome <?php echo $_SESSION ["username"];?></h4>
	
	</div>
	
	<div id="leftbar">
		
    <div id="leftsubbar">
		<h3>Search Employee</h3>
	   <?php include_once 'seat.php';?>
    </div>
    <div id="loginUser">
    <?php include_once 'loggedInusers.php';?>
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
