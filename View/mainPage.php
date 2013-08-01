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
<title><?php echo $lang->ASSIGNSEAT?></title>
<link rel="stylesheet"
    href="<?php echo SITE_URL;?>assets/css/jqueryui/jquery.ui.tooltip.css" />
<link rel="stylesheet" href="assets/js/fancybox/jquery.fancybox.css"
    media="screen" />
<link href="<?php echo SITE_URL;?>assets/css/style.css" rel="stylesheet"
    type="text/css" />
<script src="<?php echo SITE_URL;?>/assets/js/jquery-1.9.1.min.js"></script>
<script
    src="<?php echo SITE_URL;?>/assets/js/jquery ui/jquery.ui.core.min.js"></script>
<script
    src="<?php echo SITE_URL;?>/assets/js/jquery ui/jquery.ui.widget.min.js"></script>
<script type="text/javascript"
    src="<?php echo SITE_URL;?>/assets/js/jquery ui/jquery.ui.mouse.min.js"></script>
<script type="text/javascript"
    src="<?php echo SITE_URL;?>/assets/js/jquery ui/jquery.ui.draggable.min.js"></script>
<script type="text/javascript"
    src="<?php echo SITE_URL;?>/assets/js/jquery ui/jquery.ui.droppable.min.js"></script>
<script
    src="<?php echo SITE_URL;?>/assets/js/jquery ui/jquery.ui.position.min.js"></script>
<script
    src="<?php echo SITE_URL;?>/assets/js/jquery ui/jquery.ui.tooltip.min.js"></script>
<script type="text/javascript"
    src="assets/js/fancybox/jquery.fancybox.js"></script>
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
function showLog()
{
    displayData = '';
    
	$.ajax({
		async : false,
		url : 'index.php?controller=MainController&method=fetchLogData',
		type :'post',
		data : '',
		dataType : "json",
		success : function (data) {
			//alert(data);
		    displayData = '';
		    if(data != "No Data in log file"){
    			$.each(data,function(i,value){
    		        displayData += "<label>"+(i+1)+" </label>";
    				displayData += value;
    				displayData += "<br/>";
    				});
    			//alert(displayData);
    			$("#logData").html('');
    			$("#logData").append(displayData);
		    }
		    else {
    			$("#logData").html('');
    			$("#logData").append(data);		        
		    }
			//displayData = data;
		}
	});
	
	$("#logOverlayLink").fancybox({	    
	    closeClick : false, // prevents closing when clicking INSIDE fancybox
	    helpers : {
	    overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
	    }
	    });
	$("#logOverlayLink").attr("href","#logData");
	$("#logOverlayLink").trigger("click");
}
</script>
<body>
    <div id="bg">
        <div id="outer">
            <div id="header">
                <div id="logo">
                    <h1>
                        <a href="#"><?php echo $lang->ASSIGNSEAT?></a>
                    </h1>
                </div>
                <div id="nav">
                    <ul>
                        <li class="first active"><a href="#"><?php echo $lang->HOME?></a></li>
                        <li><a href="#" id="logout"><?php echo $lang->LOGOUT?></a></li>
                        <li><a href="#" id="logout" onClick="showLog()"><?php echo $lang->SHOWUSER?></a></li>
                    </ul>
                    <br class="clear" />
                </div>
            </div>
            <div id="main">
                <div id="sidebar">
                    <div id="leftbar">
                        <div id="leftsubbar">
                            <h3><?php echo $lang->EMPLOYEES?></h3>
                            <h3><?php echo $lang->SEARCHEMPLOYEE?></h3>
							
	   <?php include_once 'seat.php';?>
    </div>
                        <div id="loginUser">
					<?php include_once 'loggedInusers.php';?>	
					</div>
                    </div>
                    <br class="clear" />
                    <div class="droppable" id="trash">
                        <img
                            src="<?php echo SITE_URL;?>/images/trash1.png" />
                    </div>
                    <br class="clear" />
                </div>
                <div id="content">
                    <h2><?php echo $lang->BLUEPRINT?></h2>
                    <div id="box1">
                        <div id="rightbar">
        <?php
		
		include_once 'mainBuilding.php';?>
        </div>
                    </div>
                    <br class="clear" />
                </div>
                <br class="clear" />
            </div>
        </div>
        <div id="copyright"><?php echo $lang->COPYRIGHT?></br>
        </div>
    </div>
    <a id="logOverlayLink" class="doNotDisplay"></a>
    <div id="logData" class="doNotDisplay"></div>

</html>
