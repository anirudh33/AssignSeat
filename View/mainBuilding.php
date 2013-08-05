<?php
/*
 * @author Prateek Saini Below Code block will fetch all the allocated seats
 * then it will arrange the data in array index on room
 */

$objMainController = $_SESSION ['mainController'];
$seatAllocatedInfo = $objMainController->dataFetch ( $_SESSION ['roomId'] );
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
                $displayData .= '<div id = "' . $value ['name'] . '_' . $value ['row_number'] . '_' . $i . '" class="cols"><img id="' . $tempAllocated [($value ['row_number'] - 1)] [$i] ['eid'] . '" class="dragable dragged custom_tooltip" src="images/red_chair.gif" height=20 width=30 /></div>';
            } else {
                $displayData .= '<div class="cols droppable dropped" id="' . $value ['name'] . '_' . $value ['row_number'] . '_' . $i . '"><img src="images/green_chair.jpeg" class="custom_tooltip" height="18" width="30" /></div>';
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
/* Updated By Amber Sharma */
function dragdropevent() {
    /**
     * we set the dragable class to be dragable, we add the containment which
     * will be #boxdemo, so dropable and dragable object cant pass out of this
     * box 
     *
     */
    $(".dragable").draggable({
        revert : "invalid",
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
        tolerance : 'fit',
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
            // alert(thisid);
            // $("#"+thisid).removeClass('droppable ui-droppable
            // dropped');
            if (thisid == 'trash') {
            } else {
                $('#' + thisid).droppable('disable')
                $("#" + thisid)
                        .html(
                                '<img src="images/red_chair.gif" id='
                                        + draggedElement
                                        + ' height="30" width="30" class="dragable dragged" />');
            }
            $("#" + moveid).html(' ');
            if (moveid.indexOf("emp") == -1) {
                $("#" + moveid)
                        .html(
                                '<img src="images/green_chair.jpeg" height="18" width="30" />');
                $("#" + moveid).addClass(
                        'droppable ui-droppable dropped');
            }
            dragdropevent();
        }
    });
}
function closeFancyBox() {
	//$("#commentError").replace("");
    $changeComment = $("#changeComment").val();
    $.fancybox.close();
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
        	if(data.trim()=="1") {
        		alert("Seat has been trashed");
        		$("#commentError").html("");
    			}else {
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
        	if(data.trim()=="1") {
        		alert("Your seat has been booked");
        		reLoadMainBuilding();
        		$("#commentError").html("");
    			}
    			else if(data.trim()=="2") {
    			alert("Your seat has been been reallocated");
    			$("#commentError").html("");
    			}else {
    				//change chair icon to green here
                $("#commentError").html(data);
                $("#changeCommentLink").trigger("click");
    			}
             //window.location.href = 'index.php';
        });
        $('#' + thisid).droppable('disable')
        $("#" + thisid)
                .html(
                        '<img src="images/red_chair.gif" id='
                                + draggedElement
                                + ' height="30" width="30" class="dragable dragged" />');
        $("#" + moveid).html(' ');
        if (moveid.indexOf("emp") == -1) {
            $("#" + moveid)
                    .html(
                            '<img src="images/green_chair.jpeg" height="18" width="30" />');
            $("#" + moveid).addClass('droppable ui-droppable dropped');
        }
        dragdropevent();
    }    
}
function reLoadMainBuilding() {
    $.ajax({
        url : 'index.php?controller=mainController&method=reLoadMainBuilding',
        type : 'post',
        dataType : 'html',
        success : function(data){
            $("#rightbar").html("");
            $("#rightbar").append(data);
            startTooltip();
            },
        });
}
/* Updated By Amber Sharma */
</script>
<script>
function startTooltip(){
	$( ".custom_tooltip" ).tooltip({
		items: "img",
		content : function() {
			displayData = "";
			$id = $(this).attr("id");
			if($(this).attr("id") > 0 && $(this).attr("id") != '') {
    			$.ajax({
    				async : false,
    				url : 'index.php?controller=MainController&method=fetchUserProfile',
    				type :'post',
    				data : 'eid='+$id,
    				dataType : "json",
    				success : function (data) {
    					//alert(data);
    				    displayData = '';
    					//$.each(data,function(i,value){
    				        displayData += "<label>Name : </label>";
        					displayData += data['name'];
        					displayData += "<br/>";
        					displayData += "<label>Designation : </label>";
        					displayData += data['designation'];
        					displayData += "<br/>";
        					displayData += "<label>Details : </label>";
        					displayData += data['details'];
//        				alert(i+"_"+value);	
        				//	});
    					//displayData = data;
    				}
    			});
    			return displayData;
			}
		},
		position: {
			my: "center-25 bottom-20",
			at: "center top",
			using: function( position, feedback ) {
				$( this ).css( position );
				$( "<div>" )
					.addClass( "arrow" )
					.appendTo( this );
			}
		}
	})
	.off( "mouseover" )
  	.on( "click", function(){
      $( this ).tooltip( "open" );
      return false;
    })
    .attr( "title", "" ).css({ cursor: "pointer" });
}
</script>
<style>
.rotatediv {
    width: 360px;
    height: 110px;

    /* Rotate div */
    /*transform:rotate(90deg);*/
    /*-ms-transform:rotate(90deg);*/ /* IE 9 */
    /*-webkit-transform:rotate(90deg);*/ /* Safari and Chrome */
}
</style>
<!-- Updated By Prateek Saini -->
<div class="mainContainer">
    <div style="border: 1px solid black; height: 30%; width: 100%;">
        <div class="upperLeftContainer">
            <div class="div1">
                <div class="googol">
                    <label class="writing"><?php echo $lang->GOOGOL;?></label>
                </div>
                <div class="srijjan_2">
                    <div class="roomTitle">Sirijan 2</div>
                    <div class="roomContent">
                    <?php echo createRow($seatAllocatedInfoData[7],$_SESSION['roomData'][7]); ?>
                    </div>
                </div>
            </div>
            <div class="div2">
                <div class="sofa_reception">
                    <img alt="" src="images/sofa.jpg"
                        style="float: left; height: 50%; width: 30%; margin-top: 6%;">
				<div class="roomTitle"><?php echo $lang->SOFARECEPTION;?></div>
				<img alt="" src="images/reception.jpeg" 
				    style="height: 80%; width: 45%; float: right;">
                </div>
                <div class="lobby">
                    <div class="roomTitle"><?php echo $lang->LOBBY;?></div>
                </div>
                <div class="loby2">
                    <div class="roomTitle"><?php echo $lang->LOBBY;?></div>
                </div>
            <div class="aer">
                <div class="roomTitle"><?php echo $lang->AER;?></div>
                <div class="roomContent"><?php echo createRow($seatAllocatedInfoData[8],$_SESSION['roomData'][8]); ?></div>
			</div>
            <div class="aqua">
			    <div class="roomTitle"><?php echo $lang->AQUA;?></div>
			    <div class="roomContent"><?php echo createRow($seatAllocatedInfoData[9],$_SESSION['roomData'][9]); ?></div>
		    </div>
            </div>
        </div>
        <div class="sofachess">
            <img alt="" src="images/chess.jpeg"
                style="height: 20%; width: 100%; float: right; margin-top: 50%;">
            <div
                style="border: 1px solid black; height: 13%; margin-top: 550%; width: 90%;">
            </div>
            <div
                style="border: 1px solid black; height: 13%; margin-top: 10%; width: 90%;">
            </div>
        </div>
        <div class="room">
            <div class="roomTitle"><?php echo $lang->ROOM;?></div>
        </div>
        <div class="room1">
            <div class="roomTitle"><?php echo $lang->ROOM;?></div>
        </div>
        <div class="conference">
            <div class="roomTitle"><?php echo $lang->CONFERENCE;?></div>
            <div class="roomContent"><?php echo createRow($seatAllocatedInfoData[10],$_SESSION['roomData'][10]); ?></div>
        </div>
    </div>
    <div class="div3">
        <div
            style="float: left; height: 100%; width: 20%; border: 1px solid black;">
            <div
                style="border: 1px solid black; float: left; height: 5%; width: 100%; box-shadow: inset 9px 10px 40px #769DCC;">
                <div class="roomTitle"><?php echo $lang->WASHROOM;?></div>
            </div>
            <div
                style="border: 1px solid black; float: left; height: 4%; width: 100%; box-shadow: inset 9px 10px 40px #DEB887;">
                <div class="roomTitle"><?php echo $lang->LOBBY;?></div>
            </div>
            <div
                style="float: left; height: 5%; width: 100%; border: 1px solid black; box-shadow: inset 9px 10px 40px #F4FFB5;">
                <div class="roomTitle"><?php echo $lang->CAFETERIA;?></div>
            </div>
            <div
                style="float: left; height: 20%; width: 100%; border: 1px solid black; box-shadow: inset 9px 10px 75px #FFF8DC;">
                <div class="roomTitle"><?php echo $lang->ROOM1;?></div>
				<?php echo createRow($seatAllocatedInfoData[34],$_SESSION['roomData'][34]); ?>
			</div>
            <div
                style="float: left; height: 20%; width: 100%; border: 1px solid black; box-shadow: inset 9px 10px 75px #FFF8DC;">
                <div class="roomTitle"><?php echo $lang->ROOM2;?></div>
				<?php echo createRow($seatAllocatedInfoData[35],$_SESSION['roomData'][35]); ?>
			</div>
            <div
                style="float: left; height: 22%; width: 100%; box-shadow: inset 9px 10px 75px #FFF8DC; border: 1px solid black;">
                <div class="roomTitle"><?php echo $lang->SIRIJAN;?></div>
				<?php echo createRow($seatAllocatedInfoData[20],$_SESSION['roomData'][20]); ?>
			</div>
            <div
                style="float: left; height: 15%; width: 100%; box-shadow: inset 9px 10px 75px #FFF8DC; border: 1px solid black;">
                <div class="roomTitle"><?php echo $lang->ACCOUNTS;?></div>
            <?php echo createRow($seatAllocatedInfoData[19],$_SESSION['roomData'][19]); ?>
			</div>
            <div
                style="float: left; height: 6.7%; width: 100%; border: 1px solid black; box-shadow: inset 9px 10px 40px #DEB887;">
                <div class="roomTitle"><?php echo $lang->LOBBY;?></div>
            </div>                
        </div>
        <div
            style="letter-spacing: 0.7em; word-wrap: break-word; border: 1px solid black; float: left; height: 100%; width: 4%; box-shadow: inset 9px 10px 40px #DEB887;">
            <div class="roomContent" style="padding-top: 206px;">
            <div class="roomTitle"><?php echo $lang->LOBBY;?></div>
            </div>
        </div>
        <div style="float: right; width: 75%; border: 1px solid black">
            <div class="room2">
            <?php echo createRow($seatAllocatedInfoData[11],$_SESSION['roomData'][11]); ?>
            </div>
            <div class="room2">
            <?php echo createRow($seatAllocatedInfoData[12],$_SESSION['roomData'][12]); ?>
            </div>
            <div class="room2">
            <?php echo createRow($seatAllocatedInfoData[13],$_SESSION['roomData'][13]); ?>
            </div>
            <div class="room2 ">
            <?php echo createRow($seatAllocatedInfoData[14],$_SESSION['roomData'][14]); ?>
            </div>
        </div>
        <div style = "float : right; width : 75%; height : 88%">
            <div
                style="border: 1px solid black; float: right; height: 100%; width: 9.5%;">
                <div class="cabin">
    			<?php echo createRow($seatAllocatedInfoData[3],$_SESSION['roomData'][3]); ?>
    			</div>
                <div class="cabin">
    			<?php echo createRow($seatAllocatedInfoData[4],$_SESSION['roomData'][4]); ?>
    			</div>
                <div class="cabin">
    			<?php echo createRow($seatAllocatedInfoData[5],$_SESSION['roomData'][5]); ?>
    			</div>
                <div class="cabin">
    			<?php echo createRow($seatAllocatedInfoData[6],$_SESSION['roomData'][6]); ?>
    			</div>
                <div class="cabin">
    			<?php echo createRow($seatAllocatedInfoData[21],$_SESSION['roomData'][21]); ?>
    			</div>
                <div class="cabin">
    			<?php echo createRow($seatAllocatedInfoData[22],$_SESSION['roomData'][22]); ?>
    			</div>
                <div class="cabin">
                <?php echo createRow($seatAllocatedInfoData[23],$_SESSION['roomData'][23]); ?>
    			</div>
                <div class="cabin">
    			<?php echo createRow($seatAllocatedInfoData[24],$_SESSION['roomData'][24]); ?>
    			</div>
                <div class="cabin">
    			<?php echo createRow($seatAllocatedInfoData[25],$_SESSION['roomData'][25]); ?>
    			</div>
                <div class="cabin">
    			<?php echo createRow($seatAllocatedInfoData[26],$_SESSION['roomData'][26]); ?>
    			</div>
                <div class="cabin">
    			<?php echo createRow($seatAllocatedInfoData[27],$_SESSION['roomData'][27]); ?>
    			</div>
                <div class="cabin">
    			<?php echo createRow($seatAllocatedInfoData[28],$_SESSION['roomData'][28]); ?>
    			</div>
                <div class="cabin">
    			<?php echo createRow($seatAllocatedInfoData[29],$_SESSION['roomData'][29]); ?>
    			</div>
                <div class="cabin">
    			<?php echo createRow($seatAllocatedInfoData[30],$_SESSION['roomData'][30]); ?>
    			</div>
            </div>
            <div class="lobbySirijan">
                <div class="roomContent" style="padding-top: 206px;">
                <div class="roomTitle"><?php echo $lang->LOBBY;?></div>
                </div>
            </div>
        <div
            style="border: 1px solid black; float: right; height: 100%; width: 86%; box-shadow: 9px 10px 75px #FFF8DC inset;">
            Main Lab
			<?php echo createRow($seatAllocatedInfoData[2],$_SESSION['roomData'][2]); ?>
            <div id="cabinrony"
                style="border: 1px solid black; width: 100%; height: 15%; ">
                <div
                    style="border: 1px solid black; box-shadow: inset 9px 10px 75px #FFF8DC; width: 20%; height: 75%; margin-top: 1%; float: left; margin-left: 30%;">
                    <div class="roomTitle"><?php echo $lang->CHANDERMOHAN;?></div>
                <?php echo createRow($seatAllocatedInfoData[31],$_SESSION['roomData'][31]); ?>
                </div>
                <div
                    style="border: 1px solid black; box-shadow: inset 9px 10px 75px #FFF8DC; width: 20%; height: 75%; margin-top: 1%; float: left; margin-left: 2%;">
                    <div class="roomTitle"><?php echo $lang->PRINCE;?></div>
				<?php echo createRow($seatAllocatedInfoData[32],$_SESSION['roomData'][32]); ?>
                </div>
                <div
                    style="border: 1px solid black; box-shadow: inset 9px 10px 75px #FFF8DC; width: 20%; height: 75%; margin-top: 1%; float: left; margin-left: 2%;">
                    <div class="roomTitle"><?php echo $lang->RONY;?></div>
				<?php echo createRow($seatAllocatedInfoData[33],$_SESSION['roomData'][33]); ?>
				</div>
            </div>
        </div>
        </div>
    </div>
    <div class="lastdiv"
        style="float: left; height: 10%; width: 100%; border: 1px solid black;">
        <div
            style="float: left; height: 100%; width: 19.7%; border: 1px solid black; box-shadow: inset 9px 10px 40px #769DCC;">
            <div class="roomTitle"><?php echo $lang->WASHROOM;?></div>
        </div>
        <div style="float: right; width: 80%;">
            <div class="room3">
    			<div class="roomTitle"><?php echo $lang->PRANABJYOTIDAS;?></div>
    			<?php echo createRow($seatAllocatedInfoData[15],$_SESSION['roomData'][15]); ?>
			</div>
            <div class="room3">
                <div class="roomTitle"><?php echo $lang->ARINDERSINGHSURI;?></div>
                <?php echo createRow($seatAllocatedInfoData[16],$_SESSION['roomData'][16]); ?>
            </div>
            <div class="room3">
                <div class="roomTitle"><?php echo $lang->SONALIMINOCHA;?></div>
                <?php echo createRow($seatAllocatedInfoData[17],$_SESSION['roomData'][17]); ?>
            </div>
            <div class="room3">
                <div class="roomTitle"><?php echo $lang->SAURABH;?></div>
                <?php echo createRow($seatAllocatedInfoData[18],$_SESSION['roomData'][18]); ?>
            </div>
        </div>
    </div>
</div>