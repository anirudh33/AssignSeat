<?php
/*
 * Creation Log File Name - main.php Description - Main view file Version - 1.0 Created by - Avni jain Created on - july 29, 2013 *************************************************
 */
// echo $_SESSION ["username"];
// echo $_SESSION ["userid"];
//echo "hi";die;
?>
<html lang="">
<head>
<title></title>
<link rel="stylesheet" href="<?php echo SITE_URL;?>/assets/css/main.css"
	type="text/css" media="all">
</head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Assign Seat</title>
<link rel="stylesheet"
	href="<?php echo SITE_URL;?>assets/css/jqueryui/jquery.ui.tooltip.css" />
<link href="<?php echo SITE_URL;?>assets/css/style.css" rel="stylesheet"
	type="text/css" />
<script src="<?php echo SITE_URL;?>/assets/js/jquery-1.9.1.min.js"></script>
<script
	src="<?php echo SITE_URL;?>/assets/js/jquery ui/jquery.ui.core.min.js"></script>
<script
	src="<?php echo SITE_URL;?>/assets/js/jquery ui/jquery.ui.widget.min.js"></script>
<script
	src="<?php echo SITE_URL;?>/assets/js/jquery ui/jquery.ui.position.min.js"></script>
<script
	src="<?php echo SITE_URL;?>/assets/js/jquery ui/jquery.ui.tooltip.min.js"></script>
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
	<div id="bg">
		<div id="outer">
			<div id="header">
				<div id="logo">
					<h1>
						<a href="#">Assign Seat</a>
					</h1>
				</div>
				<div id="nav">
					<ul>
						<li class="first active"><a href="#">Home</a></li>
						<li><a href="#" id="logout">Logout</a></li>

					</ul>
					<br class="clear" />
				</div>
			</div>
			<div id="main">
				<div id="sidebar">
					<div id="leftbar">

						<div id="leftsubbar">
						<h3>Employees</h3>
							<h3>Search Employee</h3>
							
	   <?php include_once 'seat.php';?>
    </div>
					<div id="loginUser">
					<?php include_once 'loggedInusers.php';?>	
					</div>
					
					
					</div>
					<br class="clear" />
					<div class="droppable" >
						<img src="<?php echo SITE_URL;?>/images/trash1.png" />
					</div>
					<br class="clear" />
				</div>
				<div id="content">
					<h2>Blue Print</h2>
					<div id="box1">
						<div id="rightbar">
        <?php include_once 'mainBuilding.php';?>
        </div>
					</div>


					<br class="clear" />
				</div>
				<br class="clear" />
			</div>
		</div>
		<div id="copyright">Osscube: Kawal ,Raman </br>
		<h3> Burraaraaahhhhhhhhhhhh </h3></div>
	</div>

</html>
