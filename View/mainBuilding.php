<?php
/*
 * @author Prateek Saini Below Code block will fetch all the allocated seats
 * then it will arrange the data in array index on room
 */

$seatAllocatedInfo = $this->dataFetch ( $_SESSION ['roomId'] );
$totalRooms = count ( $_SESSION ['roomData'] );

$seatAllocatedInfoData = array ();
for($i = 0; $i < $totalRooms; $i ++) {
	$seatAllocatedInfoData [] = array ();
}

foreach ( $seatAllocatedInfo as $key => $value ) {
	$seatAllocatedInfoData [$value ['room_id']] [] = $value;
}

/*
 * @author Prateek Saini This function will called for each room individually
 * @arg1 Data allocated for the room @arg2 Room structure i.e. total rows and
 * number of computer in them. Data is broken for ease of access
 */
function createRow($allocatedData, $roomData) {
    
    $totalRows = count ( $roomData );
    $tempAllocated = array ();
    for($i = 0; $i < $totalRows; $i ++) {
        $tempAllocated [] = array ();
        if (isset ( $roomData [$i] )) {
            for($j = 0; $j < $roomData [$i] ['computer']; $j ++) {
                $tempAllocated [$i] [] = array ();
            }
        }
    }
    foreach ( $allocatedData as $key => $value ) {
        $tempAllocated [($value ['row_number'] - 1)] [$value ['computer_id']] = $value;
    }
    $displayData = "";
    foreach ( $roomData as $key => $value ) {
        for($i = 0; $i < $value ['computer']; $i ++) {
            if ((isset ( $tempAllocated [($value ['row_number'] - 1)] [$i] ['computer_id'] )) && ($tempAllocated [($value ['row_number'] - 1)] [$i] ['computer_id'] == $i)) {
                $displayData .= '<div id = "' . $value ['name'] . '_' . $value ['row_number'] . '_' . $i . '" class="cols positionTooltip seatDiv"><img id="' . $tempAllocated [($value ['row_number'] - 1)] [$i] ['eid'] . '" class="dragable dragged custom_tooltip context-menu-sub" src="images/green_chair11.png" width = "16px" height = "16px" /></div>';
            } else {
                $displayData .= '<div class="cols droppable dropped positionTooltip seatDiv" id="' . $value ['name'] . '_' . $value ['row_number'] . '_' . $i . '"><img src="images/green_seat.jpeg" class="context-menu-sub" /></div>';
            }
        }
        $displayData .= '<br style="clear:both">';
    }
    unset ( $tempAllocated );
    return $displayData;
}
?>
<script>
$changeComment = '';
$tooltipFlag = 1;
draggedElement = "";
moveid = "";
thisid= "";
var didConfirm = false;
/* Updated By Amber Sharma and Prateek Saini */
function dragdropevent() {
    /**
     * we set the dragable class to be dragable, we add the containment which
     * will be #boxdemo, so dropable and dragable object cant pass out of this
     * box 
     *
     */
    $(".dragable").draggable({
        revert : true,
        helper: "clone",
        cursor: "move", 
        cursorAt: { top: 3, left: 3 },
        start : function(event, ui) {
            draggedElement = this.id;
            moveid = $(this).parent('div').attr('id');
            //alert(draggedElement);
            dragdropevent();
            //alert(moveid);
        }
    });
    $( ".droppable" ).droppable({
        /**
         * tolerance:fit means, the moveable
         * object has to be inside the dropable
         * object area *
         */
        tolerance : 'intersect',
        over : function(event, ui) {
            thisid = this.id;
            /**
             * We add the hoverClass when the moveable object is
             * inside of the dropable object *
             */
            $('.ui-draggable-dragging').addClass('hoverClass');
        },
        out : function(event, ui) {
            prevthisid = this.id;
            /**
             * We remove the hoverClass when the moveable object
             * is outside of the dropable object area *
             */
            $('.ui-draggable-dragging').removeClass(
                    'hoverClass');
            $('#' + prevthisid).removeClass('dropClass');
        },
        /**
         * This is the drop event, when the dragable object is
         * moved on the top of the dropable object area *
         */
        drop : function(event, ui) {
            // alert(thisid);if(thisid=='trash'){
            // alert('haan');
            // }
		//alert(thisid);
           // $(".positionTooltip").tooltip("close");
            $("#changeCommentLink").fancybox({
                closeBtn : false,
                afterLoad : function() {
                    $("#changeComment").val('');
                    return;
                },
                closeClick : false, // prevents closing when
                                    // clicking INSIDE fancybox
                helpers : {
                    overlay : {
                        closeClick : false
                    }
                // prevents closing when clicking OUTSIDE
                // fancybox
                }
            });
    if (thisid == 'trash') {       	
	didConfirm = confirm("Are you sure you want to delete??");
	}
	else {
	$.ajax({
        url : 'index.php?controller=MainController&method=isAssignedSeat',
        type : 'post',
        dataType : 'html',
		async : false,
		data: { employee : draggedElement },
		
        success : function(data){
		//alert(data);
	   if(data.trim()=="1") {
			didConfirm = confirm("Are you sure you want to allocate");
        	}
    			
    		else {
    				//change chair icon to green here
    		didConfirm = confirm("Are you sure u want to reallocate");
    			}
            }
      
        });
	/*alert(draggedElement);
	 $.post('index.php?controller=MainController&method=isAssignedSeat', {
            employee : draggedElement
			
        }, function(data, status) {
		//alert(data);
        	if(data.trim()=="1") {
			didConfirm = confirm("Are you sure u wann allocate");
        	}
    			
    		else {
    				//change chair icon to green here
    		didConfirm = confirm("Are you sure u wann reallocate");
    			}
             //window.location.href = 'index.php';
        });*/
	}
	$tooltipFlag = 0;
	// alert(didConfirm);
     if (didConfirm == true) 
	{	
		$("#changeCommentLink").trigger("click"); 
	}
	else
	{
		reLoadMainBuilding();
	}
	
        }
    });
}
function closeFancyBox() {
	//$("#commentError").replace("");
    $changeComment = $("#changeComment").val();
    $.fancybox.close();
    $("#commentError").html("");
    // alert(draggedElement);
    // alert(moveid);
    // alert(thisid+'1');
    if (thisid == 'trash') {
        // alert(moveid);
       
        $.post('index.php?controller=MainController&method=trashSeat', {
            
	 seatid:moveid,
	changeComment : $changeComment,
            employee : draggedElement
        }, function(data, status) {
			if(data.indexOf('password') != -1)
			{
				location.reload();
			}		
        	if(data.trim()=="1") {
        		alert("Seat has been trashed");
        		reLoadMainBuilding();
        		$("#commentError").html("");
    			}else {
    			$("#commentError").html("");
    			$("#commentError").html(data);
                $("#changeCommentLink").trigger("click");
    			}
            //window.location.href = 'index.php';
        });

    } else {
	//alert(moveid);
        $.post('index.php?controller=MainController&method=assignSeat', {
            roomid : thisid,
	    move :moveid,
            changeComment : $changeComment,
            employee : draggedElement
        }, function(data, status) {
		if(data.indexOf('password') != -1)
			{
				location.reload();
			}
        	if(data.trim()=="1") {
        		alert("Your seat has been booked");
        		reLoadMainBuilding();
        		$("#commentError").html("");
    			}
    			else if(data.trim()=="2") {
    			alert("Your seat has been been reallocated");
    			reLoadMainBuilding();
    			$("#commentError").html("");
    			}else {
    				//change chair icon to green here
    			$("#commentError").html("");
                $("#commentError").html(data);
                $("#changeCommentLink").trigger("click");
    			}
             //window.location.href = 'index.php';
        });
	if (thisid == 'trash') 
	{
		
        }
	else
	{
		$('#' + thisid).droppable('disable')
		$("#" + thisid)
		        .html(
		                '<img src="images/green_chair11.png" id='
		                        + draggedElement
		                        + ' height="16" width="16" class="dragable dragged" />');
		$("#" + moveid).html(' ');
		if (moveid.indexOf("emp") == -1) {
		    $("#" + moveid)
		            .html(
		                    '<img src="images/green_seat.jpeg" />');
		    $("#" + moveid).addClass('droppable ui-droppable dropped');
		}
		dragdropevent();
	}
    }
    clearVariables();
}
function reLoadMainBuilding() {

    location.reload();
	/* Use when Ajax call is required */
    /*$.ajax({
        url : 'index.php?controller=MainController&method=reLoadMainBuilding',
        type : 'post',
        dataType : 'html',
        start : function() {
            $('#rightbar').fadeTo('slow',0.2);
        },
        success : function(data){
	   if(data.indexOf('password') != -1)
			{
				location.reload();
			}
            $("#rightbar").html("");
            $("#rightbar").append(data);
            startTooltip();
            },
        stop : function() {
            $('#rightbar').fadeIn(100);
        }
        });*/
}
/* Updated By Amber Sharma and Prateek Saini */

function startTooltip(){

    /*
    @author Prateek Saini
    This tooltip will display the user details from database
    after user click on the allocated Seat.
    */
    $('.custom_tooltip').tooltipster({
        timer: 6000,
        trigger: 'click',
        content: 'Loading...',
        functionBefore: function(origin, continueTooltip) {
        
           // we'll make this function asynchronous and allow the tooltip to go ahead and show the loading notification while fetching our data
           continueTooltip();
             
           // next, we want to check if our data has already been cached
           if (origin.data('ajax') !== 'cached') {
    			displayData = "";
    			$id = $(origin).attr("id");
    			if($id > 0 && $id != '') {
        			$.ajax({
        				async : false,
        				url : 'index.php?controller=MainController&method=fetchUserProfile',
        				type :'post',
        				data : 'eid='+$id,
        				dataType : "json",
        				success : function (data) {
        				    //$(".positionTooltip").tooltip("close");
        					//alert(data);
        				    displayData = '';
        					//$.each(data,function(i,value){    				    
    	                        displayData += "<img src=\""+data['uri']+"\" alt =\"User Image\" width='100px'/>";
    	                        displayData += "<br/>";
        				        displayData += "<label>Name : </label>";
            					displayData += data['name'];
            					displayData += "<br/>";
            					displayData += "<label>Designation : </label>";
            					displayData += data['designation'];
            					displayData += "<br/>";
            					displayData += "<label>Details : </label>";
            					displayData += data['details'];
//            				alert(i+"_"+value);	
            				//	});
        					//displayData = data;
        				}
        			});
        			origin.tooltipster('update', displayData).data('ajax', 'cached');
    			}
           }
        }
     })
     .on( "mouseover", function(){
    	  	if($tooltipFlag == 1){
    	  	      $( this ).tooltipster( "hide" );
    		  	}
    	    return false;
	  })
	  .on( "drag", function(){
	      //alert("dragging");
	      $( this ).tooltipster( "hide" );
    	    //return false;
	  })
     .attr( "title", "" ).css({ cursor: "pointer" });

    /* 
    @author Prateek Saini
    This tooltip will display the Room name,
    Row Number and Column Number for any Seat.
     */
    
    $('.positionTooltip').tooltipster({
        delay: 300,
        timer: 6000,
        content: 'Loading...',
        functionBefore: function(origin, continueTooltip) {
        
           // we'll make this function asynchronous and allow the tooltip to go ahead and show the loading notification while fetching our data
           continueTooltip();             
           // next, we want to check if our data has already been cached
  			displayData = "";
			$id = $(origin).attr("id");
			$roomName = $(origin).parent().prev().html();
			$rowNumber = $id.substring($id.indexOf("_")+1,$id.lastIndexOf("_"));
			$computer = $id.substring($id.lastIndexOf("_")+1);
			displayData = "Room Name: "+$roomName+
    		",<br>"+"Row Number: "+$rowNumber+
    	    ",<br>"+"Computer Number: "+(parseInt($computer)+1);
    	    
    		origin.tooltipster('update', displayData);
        }
     })
     .on( "drag", function(){
	  })
     .attr( "title", "" ).css({ cursor: "pointer" });
}

function clearVariables()
{
    draggedElement = "";
    moveid = "";
    thisid= "";
}


function startContextMenu() {

	    $.contextMenu({
	        selector: '.context-menu-sub', 
	        callback: function(key, options) {

		        switch(key) 
		        {
		        case "pick" : 
			        {
    		            clearVariables();
    			        //alert($(this).attr("id"));
    			        if($(this).attr("id") > 0 ) {	
    			            draggedElement = $(this).attr("id");
    			            moveid = $(this).parent('div').attr('id');
    			        }
    			        else {
    				        alert("No Employee is allocated to this seat");
    			        }
		            }
			        break;
		        case "drop" : 
		        {
		            if($(this).attr("id") > 0 ) {
		                alert("Seat is already allocated");
		                return;
		            }
			        if(draggedElement != "" && moveid != ""  ) {
				        
			            thisid = $(this).parent().attr("id");
			            
			            $("#changeCommentLink").fancybox({
			                closeBtn : false,
			                afterLoad : function() {
			                    $("#changeComment").val('');
			                    return;
			                },
			                closeClick : false, // prevents closing when
			                                    // clicking INSIDE fancybox
			                helpers : {
			                    overlay : {
			                        closeClick : false
		                    }
			                // prevents closing when clicking OUTSIDE
			                // fancybox
			                }
			            });
			    		$("#changeCommentLink").trigger("click");
			        }
			        else {
			            if($(this).attr("id") > 0 ) {
			                alert("Seat is already allocated");
			                return;
			            }
				        alert("No Employee is Selected");
			        }
	            }
		        break;
		        case 'history' :
		        {
			        alert("No code is written!!! Work in progress :-)");
		        }
		        }
// 	            var m = "clicked: " + key;
// 	            window.console && console.log(m) || alert(m); 
	        },
	        items: {
	            "drop": {"name": "Drop", "icon": "paste"},
	            "pick": {"name": "Pick", "icon": "cut"},
	            "sep1": "---------",
	            "history": {"name": "History", "icon": "quit"},
	            "sep2": "---------",
	        }
	    });
}
</script>
<style>
.rotatediv {
/*     width: 230px; */
/*     height: 168px; */

	/* Rotate div */
	/*transform:rotate(90deg);*/
	/*-ms-transform:rotate(90deg);*/ /* IE 9 */
	/*-webkit-transform:rotate(90deg);*/ /* Safari and Chrome */
}
</style>
<!-- Updated By Prateek Saini -->
<div class="mainContainer roundedBorder">
    <div style="border: 1px solid black; height: 30%; width: 100%;">
        <div class="upperLeftContainer roundedBorder">
            <div class="div1 roundedBorder">
                <div class="googol roundedBorder">
                    <label class="writing roundedBorder"><?php echo $lang->GOOGOL;?></label>
                </div>
                <div class="srijjan_2 roundedBorder">
                    <div class="roomTitle">Srijan 2</div>
                    <div class="roomContent">
                    <?php echo createRow($seatAllocatedInfoData[7],$_SESSION['roomData'][7]); ?>
                    </div>
                </div>
            </div>
            <div class="div2 roundedBorder">
                <div class="sofa_reception roundedBorder">
                    <img alt="" src="images/sofa.jpg"
                        style="float: left; height: 50%; width: 30%; margin-top: 6%;">
				<div class="roomTitle"><?php echo $lang->SOFARECEPTION;?></div>
				<img alt="" src="images/reception.jpeg" 
				    style="height: 80%; width: 45%; float: right;">
                </div>
                <div class="lobby roundedBorder">
                    <div class="roomTitle"><?php echo $lang->LOBBY;?></div>
                </div>
                <div class="loby2 roundedBorder">
                    <div class="roomTitle"><?php echo $lang->LOBBY;?></div>
                </div>
            <div class="aer roundedBorder">
                <div class="roomTitle"><?php echo $lang->AER;?></div>
                <div class="roomContent"><?php //echo createRow($seatAllocatedInfoData[8],$_SESSION['roomData'][8]); ?></div>
			</div>
            <div class="aqua roundedBorder">
			    <div class="roomTitle"><?php echo $lang->AQUA;?></div>
			    <div class="roomContent"><?php //echo createRow($seatAllocatedInfoData[9],$_SESSION['roomData'][9]); ?></div>
		    </div>
            </div>
        </div>
        <div class="sofachess roundedBorder">
            <img alt="" src="images/chess.jpeg"
                style="height: 20%; width: 100%; float: right; margin-top: 50%;">
            <div
                style="border: 1px solid black; height: 13%; margin-top: 550%; width: 90%;">
            </div>
            <div
                style="border: 1px solid black; height: 13%; margin-top: 10%; width: 90%;">
            </div>
        </div>
        <div class="room roundedBorder">
            <div class="roomTitle"><?php echo $lang->ROOM;?></div>
        </div>
        <div class="room1 roundedBorder">
            <div class="roomTitle"><?php echo $lang->ROOM;?></div>
        </div>
        <div class="conference roundedBorder">
            <div class="roomTitle"><?php echo $lang->CONFERENCE;?></div>
            <div class="roomContent"><?php //echo createRow($seatAllocatedInfoData[10],$_SESSION['roomData'][10]); ?></div>
        </div>
    </div>
    <div class="div3 roundedBorder">
        <div
            style="float: left; height: 100%; width: 20%; border: 1px solid black;">
            <div class="roundedBorder"
                style="border: 1px solid black; float: left; height: 5%; width: 100%; box-shadow: inset 9px 10px 40px #769DCC;">
                <div class="roomTitle"><?php echo $lang->WASHROOM;?></div>
            </div>
            <div class="roundedBorder"
                style="border: 1px solid black; float: left; height: 4%; width: 100%; box-shadow: inset 9px 10px 40px #DEB887;">
                <div class="roomTitle"><?php echo $lang->LOBBY;?></div>
            </div>
            <div class="roundedBorder"
                style="float: left; height: 5%; width: 100%; border: 1px solid black; box-shadow: inset 9px 10px 40px #F4FFB5;">
                <div class="roomTitle"><?php echo $lang->CAFETERIA;?></div>
            </div>
            <div class="roundedBorder"
                style="float: left; height: 20%; width: 100%; border: 1px solid black; box-shadow: inset 9px 10px 75px #FFF8DC;">
                <div class="roomTitle"><?php echo $lang->ROOM1;?></div>
				<div class="roomContent"><?php echo createRow($seatAllocatedInfoData[34],$_SESSION['roomData'][34]); ?></div>
			</div>
            <div class="roundedBorder"
                style="float: left; height: 20%; width: 100%; border: 1px solid black; box-shadow: inset 9px 10px 75px #FFF8DC;">
                <div class="roomTitle"><?php echo $lang->ROOM2;?></div>
				<div class="roomContent"><?php echo createRow($seatAllocatedInfoData[35],$_SESSION['roomData'][35]); ?></div>
			</div>
            <div class="roundedBorder"
                style="float: left; height: 22%; width: 100%; box-shadow: inset 9px 10px 75px #FFF8DC; border: 1px solid black;">
                <div class="roomTitle"><?php echo $lang->SRIJAN;?></div>
				<div class="roomContent"><?php echo createRow($seatAllocatedInfoData[20],$_SESSION['roomData'][20]); ?></div>
			</div>
            <div class="roundedBorder"
                style="float: left; height: 15%; width: 100%; box-shadow: inset 9px 10px 75px #FFF8DC; border: 1px solid black;">
                <div class="roomTitle"><?php echo $lang->ACCOUNTS;?></div>
                <div class="roomContent"><?php echo createRow($seatAllocatedInfoData[19],$_SESSION['roomData'][19]); ?></div>
			</div>
            <div class="roundedBorder"
                style="float: left; height: 6.7%; width: 100%; border: 1px solid black; box-shadow: inset 9px 10px 40px #DEB887;">
                <div class="roomTitle"><?php echo $lang->LOBBY;?></div>
            </div>                
        </div>
        <div class="roundedBorder"
            style="letter-spacing: 0.7em; word-wrap: break-word; border: 1px solid black; float: left; height: 100%; width: 4%; box-shadow: inset 9px 10px 40px #DEB887;">
            <div class="roomTitle" style="padding-top: 206px;"><?php echo $lang->LOBBY;?></div>
        </div>
        <div class="roundedBorder" style="float: right; width: 75%; border: 1px solid black">
            <div class="room2 roundedBorder" id="meeting">
            <div class="roomTitle" ><?php echo $lang->MEETING;?></div>
            <div class="roomContent"><?php //echo createRow($seatAllocatedInfoData[11],$_SESSION['roomData'][11]); ?></div>
            </div>
            <div class="room2 roundedBorder">
            <div class="roomTitle"><?php echo $lang->ROOM;?></div>
            <div class="roomContent"><?php echo createRow($seatAllocatedInfoData[12],$_SESSION['roomData'][12]); ?></div>
            </div>
            <div class="room2 roundedBorder">
            <div class="roomTitle"><?php echo $lang->SACHINKHURANA;?></div>
            <div class="roomContent"><?php echo createRow($seatAllocatedInfoData[13],$_SESSION['roomData'][13]); ?></div>
            </div>
            <div class="room2 roundedBorder" id="meeting1">
            <div class="roomTitle" ><?php echo $lang->MEETING;?></div>
            <div class="roomContent"><?php //echo createRow($seatAllocatedInfoData[14],$_SESSION['roomData'][14]); ?></div>
            </div>
        </div>
        <div style = "float : right; width : 75.4%; height : 88%">
            <div class="roundedBorder"
                style="border: 1px solid black; float: right; height: 100%; width: 11%;">
                <div class="cabin roundedBorder">
                <div class="roomTitle"><?php echo $lang->CABIN1;?></div>
    			<div class="roomContent"><?php echo createRow($seatAllocatedInfoData[3],$_SESSION['roomData'][3]); ?></div>
    			</div>
                <div class="cabin roundedBorder">
                <div class="roomTitle"><?php echo $lang->CABIN2;?></div>
    			<div class="roomContent"><?php echo createRow($seatAllocatedInfoData[4],$_SESSION['roomData'][4]); ?></div>
    			</div>
                <div class="cabin roundedBorder">
                <div class="roomTitle"><?php echo $lang->CABIN3;?></div>
    			<div class="roomContent"><?php echo createRow($seatAllocatedInfoData[5],$_SESSION['roomData'][5]); ?></div>
    			</div>
                <div class="cabin roundedBorder">
                <div class="roomTitle"><?php echo $lang->CABIN4;?></div>
    			<div class="roomContent"><?php echo createRow($seatAllocatedInfoData[6],$_SESSION['roomData'][6]); ?></div>
    			</div>
                <div class="cabin roundedBorder">
                <div class="roomTitle"><?php echo $lang->CABIN5;?></div>
    			<div class="roomContent"><?php echo createRow($seatAllocatedInfoData[21],$_SESSION['roomData'][21]); ?></div>
    			</div>
                <div class="cabin roundedBorder">
                <div class="roomTitle"><?php echo $lang->CABIN6;?></div>
    			<div class="roomContent"><?php echo createRow($seatAllocatedInfoData[22],$_SESSION['roomData'][22]); ?></div>
    			</div>
                <div class="cabin roundedBorder">
                <div class="roomTitle"><?php echo $lang->CABIN7;?></div>
                <div class="roomContent"><?php echo createRow($seatAllocatedInfoData[23],$_SESSION['roomData'][23]); ?></div>
    			</div>
                <div class="cabin roundedBorder">
                <div class="roomTitle"><?php echo $lang->CABIN8;?></div>
    			<div class="roomContent"><?php echo createRow($seatAllocatedInfoData[24],$_SESSION['roomData'][24]); ?></div>
    			</div>
                <div class="cabin roundedBorder">
                <div class="roomTitle"><?php echo $lang->CABIN9;?></div>
    			<div class="roomContent"><?php echo createRow($seatAllocatedInfoData[25],$_SESSION['roomData'][25]); ?></div>
    			</div>
                <div class="cabin roundedBorder">
                <div class="roomTitle"><?php echo $lang->CABIN10;?></div>
    			<div class="roomContent"><?php echo createRow($seatAllocatedInfoData[26],$_SESSION['roomData'][26]); ?></div>
    			</div>
                <div class="cabin roundedBorder">
                <div class="roomTitle"><?php echo $lang->CABIN11;?></div>
    			<div class="roomContent"><?php echo createRow($seatAllocatedInfoData[27],$_SESSION['roomData'][27]); ?></div>
    			</div>
                <div class="cabin roundedBorder">
                <div class="roomTitle"><?php echo $lang->CABIN12;?></div>
    			<div class="roomContent"><?php echo createRow($seatAllocatedInfoData[28],$_SESSION['roomData'][28]); ?></div>
    			</div>
                <div class="cabin roundedBorder">
                <div class="roomTitle"><?php echo $lang->CABIN13;?></div>
    			<div class="roomContent"><?php echo createRow($seatAllocatedInfoData[29],$_SESSION['roomData'][29]); ?></div>
    			</div>
                <div class="cabin roundedBorder">
                <div class="roomTitle"><?php echo $lang->CABIN14;?></div>
    			<div class="roomContent"><?php echo createRow($seatAllocatedInfoData[30],$_SESSION['roomData'][30]); ?></div>
    			</div>
            </div>
            <div class="lobbySirijan roundedBorder">
                <div class="roomTitle" style="padding-top: 206px;"><?php echo $lang->LOBBY;?></div>
            </div>
        <div class="roundedBorder"
            style="border: 1px solid black; float: right; height: 100%; width: 84.9%; box-shadow: 9px 10px 75px #FFF8DC inset;">
            <div class="roomTitle"><?php echo $lang->MAINLAB;?></div>
			<div class="roomContent"><?php echo createRow($seatAllocatedInfoData[2],$_SESSION['roomData'][2]); ?></div>
            <div id="cabinrony roundedBorder"
                style="border: 1px solid black; width: 100%; height: 15%; ">
                <div class="roundedBorder"
                    style="border: 1px solid black; box-shadow: inset 9px 10px 75px #FFF8DC; width: 20%; height: 75%; margin-top: 1%; float: left; margin-left: 30%;">
                    <div class="roomTitle"><?php echo $lang->CHANDERMOHAN;?></div>
                <div class="roomContent"><?php echo createRow($seatAllocatedInfoData[31],$_SESSION['roomData'][31]); ?></div>
                </div>
                <div class="roundedBorder"
                    style="border: 1px solid black; box-shadow: inset 9px 10px 75px #FFF8DC; width: 20%; height: 75%; margin-top: 1%; float: left; margin-left: 2%;">
                    <div class="roomTitle"><?php echo $lang->PRINCE;?></div>
				<div class="roomContent"><?php echo createRow($seatAllocatedInfoData[32],$_SESSION['roomData'][32]); ?></div>
                </div>
                <div class="roundedBorder"
                    style="border: 1px solid black; box-shadow: inset 9px 10px 75px #FFF8DC; width: 20%; height: 75%; margin-top: 1%; float: left; margin-left: 2%;">
                    <div class="roomTitle"><?php echo $lang->RONY;?></div>
				<div class="roomContent"><?php echo createRow($seatAllocatedInfoData[33],$_SESSION['roomData'][33]); ?></div>
				</div>
            </div>
        </div>
        </div>
    </div>
    <div class="lastdiv roundedBorder"
        style="float: left; height: 10%; width: 100%; border: 1px solid black;">
        <div class="roundedBorder"
            style="float: left; height: 100%; width: 19.7%; border: 1px solid black; box-shadow: inset 9px 10px 40px #769DCC;">
            <div class="roomTitle"><?php echo $lang->WASHROOM;?></div>
        </div>
        <div style="float: right; width: 80%;">
            <div class="room3 roundedBorder">
    			<div class="roomTitle"><?php echo $lang->PRANABJYOTIDAS;?></div>
    			<div class="roomContent"><?php echo createRow($seatAllocatedInfoData[15],$_SESSION['roomData'][15]); ?></div>
			</div>
            <div class="room3 roundedBorder">
                <div class="roomTitle"><?php echo $lang->ARINDERSINGHSURI;?></div>
                <div class="roomContent"><?php echo createRow($seatAllocatedInfoData[16],$_SESSION['roomData'][16]); ?></div>
            </div>
            <div class="room3 roundedBorder">
                <div class="roomTitle"><?php echo $lang->SONALIMINOCHA;?></div>
                <div class="roomContent"><?php echo createRow($seatAllocatedInfoData[17],$_SESSION['roomData'][17]); ?></div>
            </div>
            <div class="room3 roundedBorder">
                <div class="roomTitle"><?php echo $lang->SAURABH;?></div>
                <div class="roomContent"><?php echo createRow($seatAllocatedInfoData[18],$_SESSION['roomData'][18]); ?></div>
            </div>
		</div>
	</div>
</div>