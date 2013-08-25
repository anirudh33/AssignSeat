<html lang="">
<head>
<title>Assign Seat</title>
<link rel="stylesheet" href="<?php echo SITE_URL;?>/assets/css/main.css"
    type="text/css" media="all">
</head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?php echo $lang->ASSIGNSEAT?></title>
<link rel="stylesheet"
    href="<?php echo SITE_URL;?>assets/css/tooltipster.css" />
<link rel="stylesheet" href="assets/js/fancybox/jquery.fancybox.css"
    media="screen" />
<link href="<?php echo SITE_URL;?>assets/css/style.css" rel="stylesheet"
    type="text/css" />   
<link href="<?php echo SITE_URL;?>assets/css/jquery.contextMenu.css" rel="stylesheet" 
    type="text/css" />
<script src="<?php echo SITE_URL;?>/assets/js/jquery-1.9.1.min.js"></script>
    <script src="<?php echo SITE_URL;?>assets/js/js1/datepicker.js" ></script>

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
    src="<?php echo SITE_URL;?>/assets/js/jquery.tooltipster.min.js"></script>
<script    src="<?php echo SITE_URL;?>/assets/js/contextmenu/jquery.contextMenu.js"></script>
    
<script type="text/javascript"  src="assets/js/fancybox/jquery.fancybox.js"></script>
<script src="<?php echo SITE_URL;?>assets/js/RGraph.common.core.js" ></script>
<script src="<?php echo SITE_URL;?>assets/js/RGraph.common.tooltips.js" ></script>
<script src="<?php echo SITE_URL;?>assets/js/RGraph.common.dynamic.js" ></script>
<script src="<?php echo SITE_URL;?>assets/js/RGraph.common.effects.js" ></script>
<script src="<?php echo SITE_URL;?>assets/js/RGraph.pie.js" ></script>

<link rel="stylesheet" href="assets/css/jquery.treeview.css" />
<link rel="stylesheet" href="assets/css/screen.css" />
<script src="assets/js/jquery.cookie.js" type="text/javascript"></script>
<script src="assets/js/jquery.treeview.js" type="text/javascript"></script>

<link rel="stylesheet"
    href="<?php echo SITE_URL;?>assets/css/datepicker.css" />


<script>
var stickDivTopMargin=0;
var windowPosition=265;
$(function(){
	getData();
	startTooltip();// -- this will be enabled after seat drag testing
	startContextMenu();	
	$("#roomFillDetails").fancybox({	    
	    closeClick : false, // prevents closing when clicking INSIDE fancybox
        beforeLoad : function() {
            roomId=$("#hiddenRoomId").val();
            $.post('index.php?controller=MainController&method=roomGraph',{
				roomId:roomId
                },function(data){
        			if(data.indexOf('password') != -1)
        			{
        				location.reload();
        			}
       			$("#roomDetailDiv").html(data);
                    });
           
            return;
        },
	    helpers : {
	    overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
	    },
	    minWidth: '600',
	    minHeight: '550'	    	    
	    });
	    
		$("#report").fancybox({	    
		    closeClick : false, // prevents closing when clicking INSIDE fancybox
		    beforeLoad : function() {
	            $.post('index.php?controller=MainController&method=reportFetch',
	    	            function(data){
	        			if(data.indexOf('Reset') != -1)
	        			{
	        				location.reload();
	        			}
	        			$("#reportData").html(data);
	                    });
	           
	            return;			    
		    
		    },
		    helpers : {
		    overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
		    },
		    minWidth: '1024',
		    minHeight: '580'		      	    
		    });	    
    
$("#logout").click(function(){
	$.post('index.php?controller=MainController&method=logout',function(data,status){
				window.location.href = 'index.php';
				});		
});
 $("#changeComment").on("keyup",function(){
	commentStr=$("#changeComment").val();

    $("#commentCount").html('Word Count: '+commentStr.length);        
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
    				displayData += value;
    				displayData += "<br/>";
    				});
    			$("#logData").html('');
    			$("#logData").append(displayData);
		    }
		    else {
    			$("#logData").html('');
    			$("#logData").append(data);		        
		    }
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
                        <a href="index"><?php echo $lang->ASSIGNSEAT?></a>
                    </h1>
                </div>
                <div id="nav">
                    <ul>
                        <li class="first active"><a href="index.php"><?php echo $lang->HOME?></a></li>
                        <li ><a href="admin" >Admin</a></li>
                        <li ><a href="#reportData" id="report" >Report</a></li>
                        <li><a href="#" id="logout"><?php echo $lang->LOGOUT?></a></li>
                        <!--  <li><a href="#" id="logout" onClick="showLog()"><?php echo $lang->SHOWLOG?></a></li>-->
                    </ul>
                    <br class="clear" />
                </div>
            </div>
            <div id="main">
                <div id="sidebar" class="roundedBorder">
                    <div id="leftbar">
                        <div id="leftsubbar">
                         <a href='index.php?controller=MainController&method=picUpload'>User Pic</a>   
                            <h3><?php echo $lang->EMPLOYEES?></h3>
                            <?php echo $lang->SEARCHEMPLOYEE?>
							
	   <?php include_once 'seat.php';?>
    </div>
                        <div id="loginUser">
					<?php include_once 'loggedInusers.php';?>	
					</div>
			<div id="deptColorList">
					<?php include_once 'departmentColorList.php';?>	
					</div>
                    </div>
                    <br class="clear" />
                    <div class="droppable" id="trash">
                        <img
                            src="<?php echo SITE_URL;?>/images/trash1.png" />
                    </div>
                    <br class="clear" />
                </div>
                <div id="content" class="roundedBorder alignCenter">
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
        <div id="copyright">
        <?php include_once 'footer.php';?>
        <div id = "companyCopyright"><?php echo $lang->COPYRIGHT?></div>
        </div>
    </div>
    <a id="logOverlayLink" class="doNotDisplay"></a>
    <div id="logData" class="doNotDisplay"></div>
    <div id="reportData" class="doNotDisplay"></div>
	<a id="roomFillDetails" href="#roomDetailDiv"></a>
	<div id="roomDetailDiv" style='display: none;'></div>
	<input type="hidden" value='' id='hiddenRoomId'>
</html>
