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
/* Updated By Amber Sharma */
</script>


<script>

  function status(colid,row,val,area)
  {
	//alert(colid);
  $.ajax({
  type: "POST",
  url: 'index.php?controller=MainController&method=dataFetch',
  data:"value=" + colid + "&value1=" +row + "&value2=" +val + "&area=" +area,
  

  success: function(data){

  $("#display"+colid).append(data);
  }
  });
  }
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

.rotatediv{
width:360px;
height:110px;

/* Rotate div */
/*transform:rotate(90deg);*/
/*-ms-transform:rotate(90deg);*/ /* IE 9 */
/*-webkit-transform:rotate(90deg);*/ /* Safari and Chrome */
}


</style>

<!-- Updated By Amber Sharma -->
<div class="mainContainer">
	<div style="border: 1px solid black; height: 30%;width:100%;">
		<div class="div1">
			<div class="googol"><label class="writing"><?php echo $lang->GOOGOL;?></label>  </div>
			<div class="srijjan_2">
			
		
	
<?php
// $count=0;
// foreach ( $_SESSION ['variable'] as $key => $values ) {
//     if ($values ['room_id'] == 7) 
//        	{

// $count = $key;
// }


         
// }       
$i=1;  
//echo $count;
     foreach ( $_SESSION['roomData'][7] as $key => $values ) {
	
    //  if ($values ['room_id'] == 7) {
	
         ?>
         
         <script>
            $.ajax( { async : false } );
		var i = <?php echo $i ;?>;
               
                var val = <?php echo $values['computer'] ;?>;
          status('7',i,val,'sirijan2');
         </script>
          <?php $i++; ?>
         <div id='display7'></div>
<?php      
      //  }
        echo "<br style='clear:both;'/>";
         
    
    
}
?>			
			
			
			</div>
		</div>
		<div class="div2">
			<div class="sofa_reception">
				<img alt="" src="images/sofa.jpg"
					style="float: left; height: 50%; width: 30%; margin-top: 6%;">
				<?php echo $lang->SOFARECEPTION;?><img alt="" src="images/reception.jpeg"
					style="height: 80%; width: 45%; float: right;">
			</div>
			<div class="lobby"><?php echo $lang->LOBBY;?></div>
			<div class="loby2"><?php echo $lang->LOBBY;?></div>
			<div class="aer">
<?php echo $lang->AER;?>
			<?php
// $count=0;
// foreach ( $_SESSION ['variable'] as $key => $values ) {
//     if ($values ['room_id'] == 8) 
//        	{

// $count = $key;
// }


         
// }       
$i=1;  
//echo $count;
     foreach ( $_SESSION['roomData'][8] as $key => $values ) {
	echo "<div id='rows'>";	
   //   if ($values ['room_id'] == 8) {
	
         ?>
         
         <script>
            $.ajax( { async : false } );
		var i = <?php echo $i ;?>;
               
                var val = <?php echo $values['computer'] ;?>;
          status('8',i,val,'Aer');
         </script>
          <?php $i++; ?>
         <div id='display8'></div>
<?php      
  //      }
        echo "<br style='clear:both;'/>";
         echo "</div>";  
    
    
}
?>
			</div>
			<div class="aqua">
			<?php echo $lang->AQUA;?>
			<?php
// $count=0;
// foreach ( $_SESSION ['variable'] as $key => $values ) {
//     if ($values ['room_id'] == 9) 
//        	{

// $count = $key;
// }


         
// }       
$i=1;  
//echo $count;
     foreach ( $_SESSION['roomData'][9] as $key => $values ) {
	echo "<div id='rows'>";	
  //    if ($values ['room_id'] == 9) {
	
         ?>
         
         <script>
            $.ajax( { async : false } );
		var i = <?php echo $i ;?>;
               
                var val = <?php echo $values['computer'] ;?>;
          status('9',i,val,'aqua');
         </script>
          <?php $i++; ?>
         <div id='display9'></div>
<?php      
    //    }
        echo "<br style='clear:both;'/>";
         echo "</div>";  
    
    
}
?>
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

		<div class="room"><?php echo $lang->ROOM;?></div>
		<div class="room1"><?php echo $lang->ROOM;?></div>
		<div class="conference">
<?php echo $lang->CONFERENCE;?>
		<?php
// $count=0;
// foreach ( $_SESSION ['variable'] as $key => $values ) {
//     if ($values ['room_id'] == 10) 
//        	{

// $count = $key;
// }


         
// }    
   $i=1;  
//echo $count;
     foreach ( $_SESSION['roomData'][10] as $key => $values ) {
	echo "<div id='rows'>";	
 //     if ($values ['room_id'] == 10) {
	
         ?>
         
         <script>
            $.ajax( { async : false } );
		var i = <?php echo $i ;?>;
               
                var val = <?php echo $values['computer'] ;?>;
          status('10',i,val,'conference');
         </script>
          <?php $i++; ?>
         <div id='display10'></div>
<?php      
    //    }
        echo "<br style='clear:both;'/>";
         echo "</div>";  
    
    
}
?>
		
</div>

	</div>
	<div class="div3">
		<div
			style="float: left; height: 100%; width: 20%; border: 1px solid black;">
			<div
				style="border: 1px solid black; float: left; height: 5%; width: 100%;box-shadow:inset 9px 10px 40px #769DCC;"><?php echo $lang->WASHROOM;?></div>
			<div
				style="border: 1px solid black; float: left; height: 4%; width: 100%;box-shadow:inset 9px 10px 40px #DEB887;"><?php echo $lang->LOBBY;?></div>
			<div
				style="float: left; height: 5%; width: 100%; border: 1px solid black;box-shadow:inset 9px 10px 40px #F4FFB5;"><?php echo $lang->CAFETERIA;?></div>
			<div
				style="float: left; height: 20%; width: 100%; border: 1px solid black;box-shadow:inset 9px 10px 75px #FFF8DC;"><?php echo $lang->ROOM1;?>
				<?php
// $count=0;
// foreach ( $_SESSION ['variable'] as $key => $values ) {
//     if ($values ['room_id'] == 34) 
//        	{

// $count = $key;
// }


         
// }      
 $i=1;  
//echo $count;
     foreach ( $_SESSION['roomData'][34] as $key => $values ) {
	echo "<div id='rows'>";	
   //   if ($values ['room_id'] == 34) {
	
         ?>
         
         <script>
            $.ajax( { async : false } );
		var i = <?php echo $i ;?>;
               
                var val = <?php echo $values['computer'] ;?>;
          status('34',i,val,'room-1');
         </script>
          <?php $i++; ?>
         <div id='display34'></div>
<?php      
   //     }
        echo "<br style='clear:both;'/>";
         echo "</div>";  
    
    
}
?>
								</div>
			<div
				style="float: left; height: 20%; width: 100%; border: 1px solid black;box-shadow:inset 9px 10px 75px #FFF8DC;"><?php echo $lang->ROOM2;?>
				<?php
// $count=0;
// foreach ( $_SESSION ['variable'] as $key => $values ) {
//     if ($values ['room_id'] == 35) 
//        	{

// $count = $key;
// }


         
// }      
 $i=1;  
//echo $count;
     foreach ( $_SESSION['roomData'][35] as $key => $values ) {
	echo "<div id='rows'>";	
  //   if ($values ['room_id'] == 35) {
	
         ?>
         
         <script>
            $.ajax( { async : false } );
		var i = <?php echo $i ;?>;
               
                var val = <?php echo $values['computer'] ;?>;
          status('35',i,val,'room-2');
         </script>
          <?php $i++; ?>
         <div id='display35'></div>
<?php      
   //     }
        echo "<br style='clear:both;'/>";
         echo "</div>";  
    
    
}
?>
				
				</div>
			<div
				style="float: left; height: 22%; width: 100%;box-shadow:inset 9px 10px 75px #FFF8DC; border: 1px solid black;"><?php echo $lang->SIRIJAN;?>
				
				 <?php
// $count=0;
// foreach ( $_SESSION ['variable'] as $key => $values ) {
//     if ($values ['room_id'] == 20) 
//        	{

// $count = $key;
// }


         
// }    
   $i=1;  
//echo $count;
     foreach ( $_SESSION['roomData'][20] as $key => $values ) {
	echo "<div id='rows'>";	
  //    if ($values ['room_id'] == 20) {
	
         ?>
         
         <script>
            $.ajax( { async : false } );
		var i = <?php echo $i ;?>;
               
                var val = <?php echo $values['computer'] ;?>;
          status('20',i,val,'sirijan3');
         </script>
          <?php $i++; ?>
         <div id='display20'></div>
<?php      
  //      }
        echo "<br style='clear:both;'/>";
         echo "</div>";  
    
    
}
?>
				
				
				</div>
			<div
				style="float: left; height: 15%; width: 100%;box-shadow:inset 9px 10px 75px #FFF8DC; border: 1px solid black;"><?php echo $lang->ACCOUNTS;?>
			 <?php
// $count=0;
// foreach ( $_SESSION ['variable'] as $key => $values ) {
//     if ($values ['room_id'] == 19) 
//        	{

// $count = $key;
// }


         
// }   
    $i=1;  
//echo $count;
     foreach ( $_SESSION['roomData'][19] as $key => $values ) {
	echo "<div id='rows'>";	
  //    if ($values ['room_id'] == 19) {
	
         ?>
         
         <script>
            $.ajax( { async : false } );
		var i = <?php echo $i ;?>;
               
                var val = <?php echo $values['computer'] ;?>;
          status('19',i,val,'accounts');
         </script>
          <?php $i++; ?>
         <div id='display19'></div>
<?php      
  //      }
        echo "<br style='clear:both;'/>";
         echo "</div>";  
    
    
}
?>
								
				</div>
			<div
				style="float: left; height: 6.7%; width: 100%; border: 1px solid black;box-shadow:inset 9px 10px 40px #DEB887;"><?php echo $lang->LOBBY;?></div>
		</div>
    
		<div
			style="letter-spacing: 0.7em; padding-top: 206px; word-wrap: break-word; border: 1px solid black; float: left; height: 74.5%; width: 4%;box-shadow:inset 9px 10px 40px #DEB887;"><?php echo $lang->LOBBY;?></div>
		<div style="float: right; width: 75%; border: 1px solid black">
    <div class="room2">
			 <?php
// $count=0;
// foreach ( $_SESSION ['variable'] as $key => $values ) {
//     if ($values ['room_id'] == 11) 
//        	{

// $count = $key;
// }


         
// }    
   $i=1;  
//echo $count;
     foreach ( $_SESSION['roomData'][11] as $key => $values ) {
	echo "<div id='rows'>";	
  //    if ($values ['room_id'] == 11) {
	
         ?>
         
         <script>
            $.ajax( { async : false } );
		var i = <?php echo $i ;?>;
               
                var val = <?php echo $values['computer'] ;?>;
          status('11',i,val,'Egnis');
         </script>
          <?php $i++; ?>
         <div id='display11'></div>
<?php      
  //      }
        echo "<br style='clear:both;'/>";
         echo "</div>";  
    
    
}
?>
    </div>
    <div class="room2" >
			 <?php
// $count=0;
// foreach ( $_SESSION ['variable'] as $key => $values ) {
//     if ($values ['room_id'] == 12) 
//        	{

// $count = $key;
// }


         
// }   
    $i=1;  
//echo $count;
     foreach ( $_SESSION['roomData'][12] as $key => $values ) {
	echo "<div id='rows' >";	
    //  if ($values ['room_id'] == 12) {
	
         ?>
         
         <script>
            $.ajax( { async : false } );
		var i = <?php echo $i ;?>;
               
                var val = <?php echo $values['computer'] ;?>;
          status('12',i,val,'jugrajsinghbedi');
         </script>
          <?php $i++; ?>
         <div id='display12'></div>
<?php      
   //     }
        echo "<br style='clear:both;'/>";
         echo "</div>";  
    
    
}
?>
    
</div>
    <div class="room2">
			 <?php
// $count=0;
// foreach ( $_SESSION ['variable'] as $key => $values ) {
//     if ($values ['room_id'] == 13) 
//        	{

// $count = $key;
// }


         
// }    
   $i=1;  
//echo $count;
     foreach ( $_SESSION['roomData'][13] as $key => $values ) {
	echo "<div id='rows'>";	
   //   if ($values ['room_id'] == 13) {
	
         ?>
         
         <script>
            $.ajax( { async : false } );
		var i = <?php echo $i ;?>;
               
                var val = <?php echo $values['computer'] ;?>;
          status('13',i,val,'sachinkhurana');
         </script>
          <?php $i++; ?>
         <div id='display13'></div>
<?php      
   //     }
        echo "<br style='clear:both;'/>";
         echo "</div>";  
    
    
}
?>
    </div>
    <div class="room2 ">
			 <?php
// $count=0;
// foreach ( $_SESSION ['variable'] as $key => $values ) {
//     if ($values ['room_id'] == 14) 
//        	{

// $count = $key;
// }


         
// }    
   $i=1;  
//echo $count;
     foreach ( $_SESSION['roomData'][14] as $key => $values ) {
	echo "<div id='rows'>";	
  //    if ($values ['room_id'] == 14) {
	
         ?>
         
         <script>
            $.ajax( { async : false } );
		var i = <?php echo $i ;?>;
               
                var val = <?php echo $values['computer'] ;?>;
          status('14',i,val,'terra');
         </script>
          <?php $i++; ?>
         <div id='display14'></div>
<?php      
  //      }
        echo "<br style='clear:both;'/>";
         echo "</div>";  
    
    
}
?>
    </div>
		</div>

		<div
			style="border: 1px solid black; float: right; height: 88%; width: 9.5%;">
			<div class="cabin">
			<?php
// $count=0;
// foreach ( $_SESSION ['variable'] as $key => $values ) {
//     if ($values ['room_id'] == 3) 
//        	{

// $count = $key;
// }


         
// }    
   $i=1;  
//echo $count;
     foreach ( $_SESSION['roomData'][3] as $key => $values ) {
	echo "<div id='rows'>";	
  //    if ($values ['room_id'] == 3) {
	
         ?>
         
         <script>
            $.ajax( { async : false } );
		var i = <?php echo $i ;?>;
               
                var val = <?php echo $values['computer'] ;?>;
          status('3',i,val,'cabin-1');
         </script>
          <?php $i++; ?>
         <div id='display3'></div>
<?php      
  //      }
        echo "<br style='clear:both;'/>";
         echo "</div>";  
    
    
}
?>
			
			
			
			</div>
			<div class="cabin">
			<?php
// $count=0;
// foreach ( $_SESSION ['variable'] as $key => $values ) {
//     if ($values ['room_id'] == 4) 
//        	{

// $count = $key;
// }


         
// }    
   $i=1;  
//echo $count;
     foreach ( $_SESSION['roomData'][4] as $key => $values ) {
	echo "<div id='rows'>";	
//      if ($values ['room_id'] == 4) {
	
         ?>
         
         <script>
            $.ajax( { async : false } );
		var i = <?php echo $i ;?>;
               
                var val = <?php echo $values['computer'] ;?>;
          status('4',i,val,'cabin-2');
         </script>
          <?php $i++; ?>
         <div id='display4'></div>
<?php      
  //      }
        echo "<br style='clear:both;'/>";
         echo "</div>";  
    
    
}
?>
			
			
			</div>
			<div class="cabin">
			 <?php
// $count=0;
// foreach ( $_SESSION ['variable'] as $key => $values ) {
//     if ($values ['room_id'] == 5) 
//        	{

// $count = $key;
// }


         
// }    
   $i=1;  
//echo $count;
     foreach ( $_SESSION['roomData'][5] as $key => $values ) {
	echo "<div id='rows'>";	
    //  if ($values ['room_id'] == 5) {
	
         ?>
         
         <script>
            $.ajax( { async : false } );
		var i = <?php echo $i ;?>;
               
                var val = <?php echo $values['computer'] ;?>;
          status('5',i,val,'cabin-3');
         </script>
          <?php $i++; ?>
         <div id='display5'></div>
<?php      
  //      }
        echo "<br style='clear:both;'/>";
         echo "</div>";  
    
    
}
?>
			 
			
			</div>
			<div class="cabin">
			  <?php
// $count=0;
// foreach ( $_SESSION ['variable'] as $key => $values ) {
//     if ($values ['room_id'] == 6) 
//        	{

// $count = $key;
// }


         
// }   
    $i=1;  
//echo $count;
     foreach ( $_SESSION['roomData'][6] as $key => $values ) {
	echo "<div id='rows'>";	
 //     if ($values ['room_id'] == 6) {
	
         ?>
         
         <script>
            $.ajax( { async : false } );
		var i = <?php echo $i ;?>;
               
                var val = <?php echo $values['computer'] ;?>;
          status('6',i,val,'cabin-4');
         </script>
          <?php $i++; ?>
         <div id='display6'></div>
<?php      
   //     }
        echo "<br style='clear:both;'/>";
         echo "</div>";  
    
    
}
?>
			  
			</div>
			<div class="cabin">
			 <?php
// $count=0;
// foreach ( $_SESSION ['variable'] as $key => $values ) {
//     if ($values ['room_id'] == 21) 
//        	{

// $count = $key;
// }


         
// }  
     $i=1;  
//echo $count;
     foreach ( $_SESSION['roomData'][21] as $key => $values ) {
	echo "<div id='rows'>";	
  //    if ($values ['room_id'] == 21) {
	
         ?>
         
         <script>
            $.ajax( { async : false } );
		var i = <?php echo $i ;?>;;
               
                var val = <?php echo $values['computer'] ;?>;
          status('21',i,val,'cabin-5');
         </script>
          <?php $i++; ?>
         <div id='display21'></div>
<?php      
 //       }
        echo "<br style='clear:both;'/>";
         echo "</div>";  
    
    
}
?>
			 
			
			</div>
			<div class="cabin">
			 <?php
// $count=0;
// foreach ( $_SESSION ['variable'] as $key => $values ) {
//     if ($values ['room_id'] == 22) 
//        	{

// $count = $key;
// }


         
// }     
  $i=1;  
//echo $count;
     foreach ( $_SESSION['roomData'][22] as $key => $values ) {
	echo "<div id='rows'>";	
  //    if ($values ['room_id'] == 22) {
	
         ?>
         
         <script>
            $.ajax( { async : false } );
		var i = <?php echo $i ;?>;
               
                var val = <?php echo $values['computer'] ;?>;
          status('22',i,val,'cabin-6');
         </script>
          <?php $i++; ?>
         <div id='display22'></div>
<?php      
  //      }
        echo "<br style='clear:both;'/>";
         echo "</div>";  
    
    
}
?>
			 
			
			
			</div>
			<div class="cabin">
			  <?php
// $count=0;
// foreach ( $_SESSION ['variable'] as $key => $values ) {
//     if ($values ['room_id'] == 23) 
//        	{

// $count = $key;
// }


         
// }    
   $i=1;  
//echo $count;
     foreach ($_SESSION['roomData'][23] as $key => $values ) {
	echo "<div id='rows'>";	
   //   if ($values ['room_id'] == 23) {
	
         ?>
         
         <script>
            $.ajax( { async : false } );
		var i = <?php echo $i ;?>;
               
                var val = <?php echo $values['computer'] ;?>;
          status('23',i,val,'cabin-7');
         </script>
          <?php $i++; ?>
         <div id='display23'></div>
<?php      
 //       }
        echo "<br style='clear:both;'/>";
         echo "</div>";  
    
    
}
?>
			  
			
			</div>
			<div class="cabin">
			 <?php
// $count=0;
// foreach ( $_SESSION ['variable'] as $key => $values ) {
//     if ($values ['room_id'] == 24) 
//        	{

// $count = $key;
// }


         
// }    
  $i=1;  
//echo $count;
     foreach ( $_SESSION['roomData'][24] as $key => $values ) {
	echo "<div id='rows'>";	
  //    if ($values ['room_id'] == 24) {
	
         ?>
         
         <script>
            $.ajax( { async : false } );
		var i = <?php echo $i ;?>;
               
                var val = <?php echo $values['computer'] ;?>;
          status('24',i,val,'cabin-8');
         </script>
          <?php $i++; ?>
         <div id='display24'></div>
<?php      
   //     }
        echo "<br style='clear:both;'/>";
         echo "</div>";  
    
    
}
?>
			 
			
			</div>
			<div class="cabin">
			 <?php
// $count=0;
// foreach ( $_SESSION ['variable'] as $key => $values ) {
//     if ($values ['room_id'] == 25) 
//        	{

// $count = $key;
// }


         
// }    
   $i=1;  
//echo $count;
     foreach ($_SESSION['roomData'][25] as $key => $values ) {
	echo "<div id='rows'>";	
   //   if ($values ['room_id'] == 25) {
	
         ?>
         
         <script>
            $.ajax( { async : false } );
		var i = <?php echo $i ;?>;
               
                var val = <?php echo $values['computer'] ;?>;
          status('25',i,val,'cabin-9');
         </script>
          <?php $i++; ?>
         <div id='display25'></div>
<?php      
  //      }
        echo "<br style='clear:both;'/>";
         echo "</div>";  
    
    
}
?>
			 
			
			</div>
			<div class="cabin">
			  <?php
// $count=0;
// foreach ( $_SESSION ['variable'] as $key => $values ) {
//     if ($values ['room_id'] == 26) 
//        	{

// $count = $key;
// }


         
// }   
    $i=1;  
//echo $count;
     foreach ( $_SESSION['roomData'][26] as $key => $values ) {
	echo "<div id='rows'>";	
  //    if ($values ['room_id'] == 26) {
	
         ?>
         
         <script>
            $.ajax( { async : false } );
		var i = <?php echo $i ;?>;
               
                var val = <?php echo $values['computer'] ;?>;
          status('26',i,val,'cabin-10');
         </script>
          <?php $i++; ?>
         <div id='display26'></div>
<?php      
  //      }
        echo "<br style='clear:both;'/>";
         echo "</div>";  
    
    
}
?>
			  
			
			</div>
			<div class="cabin">
			<?php
// $count=0;
// foreach ( $_SESSION ['variable'] as $key => $values ) {
//     if ($values ['room_id'] == 27) 
//        	{

// $count = $key;
// }


         
// }     
  $i=1;  
//echo $count;
     foreach ( $_SESSION['roomData'][27] as $key => $values ) {
	echo "<div id='rows'>";	
   //   if ($values ['room_id'] == 27) {
	
         ?>
         
         <script>
            $.ajax( { async : false } );
		var i = <?php echo $i ;?>;
               
                var val = <?php echo $values['computer'] ;?>;
          status('27',i,val,'cabin-11');
         </script>
          <?php $i++; ?>
         <div id='display27'></div>
<?php      
   //     }
        echo "<br style='clear:both;'/>";
         echo "</div>";  
    
    
}
?>
			
			
			</div>
			<div class="cabin">
			  <?php
// $count=0;
// foreach ( $_SESSION ['variable'] as $key => $values ) {
//     if ($values ['room_id'] == 28) 
//        	{

// $count = $key;
// }


         
// }      
 $i=1;  
//echo $count;
     foreach ( $_SESSION['roomData'][28] as $key => $values ) {
	echo "<div id='rows'>";	
 //     if ($values ['room_id'] == 28) {
	
         ?>
         
         <script>
            $.ajax( { async : false } );
		var i = <?php echo $i ;?>;
               
                var val = <?php echo $values['computer'] ;?>;
          status('28',i,val,'cabin-12');
         </script>
          <?php $i++; ?>
         <div id='display28'></div>
<?php      
  //      }
        echo "<br style='clear:both;'/>";
         echo "</div>";  
    
    
}
?>
			  
			
			</div>
			<div class="cabin">
			 <?php
// $count=0;
// foreach ( $_SESSION ['variable'] as $key => $values ) {
//     if ($values ['room_id'] == 29) 
//        	{

// $count = $key;
// }


         
// }     
  $i=1;  
//echo $count;
     foreach ( $_SESSION['roomData'][29] as $key => $values ) {
	echo "<div id='rows'>";	
   //   if ($values ['room_id'] == 29) {
	
         ?>
         
         <script>
            $.ajax( { async : false } );
		var i = <?php echo $i ;?>;
               
                var val = <?php echo $values['computer'] ;?>;
          status('29',i,val,'cabin-13');
         </script>
          <?php $i++; ?>
         <div id='display29'></div>
<?php      
 //       }
        echo "<br style='clear:both;'/>";
         echo "</div>";  
    
    
}
?>
			 
			
			</div>
			<div class="cabin">
			<?php
// $count=0;
// foreach ( $_SESSION ['variable'] as $key => $values ) {
//     if ($values ['room_id'] == 30) 
//        	{

// $count = $key;
// }


         
// }    
   $i=1;  
//echo $count;
     foreach ( $_SESSION['roomData'][30] as $key => $values ) {
	echo "<div id='rows'>";	
//      if ($values ['room_id'] == 30) {
	
         ?>
         
         <script>
            $.ajax( { async : false } );
		var i = <?php echo $i ;?>;
               
                var val = <?php echo $values['computer'] ;?>;
          status('30',i,val,'cabin-14');
         </script>
          <?php $i++; ?>
         <div id='display30'></div>
<?php      
 //       }
        echo "<br style='clear:both;'/>";
         echo "</div>";  
    
    
}
?>
					
			</div>
			
		</div>
			<div class="lobbySirijan"><?php echo $lang->LOBBY;?></div>
		<div
			style="border: 1px solid black; float: right; height: 88%; width: 62%;box-shadow: 9px 10px 75px #FFF8DC inset;">
			Main Lab
			<!-- Updated By Amber Sharma -->
<?php
    
  $i=1;  
//echo $count;
     foreach ( $_SESSION['roomData'][2] as $key => $values ) {
		
      //if ($values ['room_id'] == 2) {
	
         ?>
         
         <script>
            $.ajax( { async : false } );
		 var i = <?php echo $i ;?>;
               
                var val = <?php echo $values['computer'] ;?>;
          status('2',i,val,'Lab-1');
         </script>
          <?php $i++; ?>
         <div id='display2'></div>
<?php      
     //   }
        echo "<br style='clear:both;'/>";
          
    
    
}
?>
	<!-- Updated By Amber Sharma -->
			<div id="cabinrony"
				style="border: 1px solid black; width: 100%; height: 15%; margin-top: -63%">
				<div style="border: 1px solid black; box-shadow:inset 9px 10px 75px #FFF8DC;width: 20%; height: 75%; margin-top: 1%; float: left; margin-left: 30%;"><?php echo $lang->CHANDERMOHAN;?>

					<?php
 
 $i=1;  

     foreach ( $_SESSION['roomData'][31] as $key => $values ) {
	echo "<div id='rows'>";	
 	
         ?>
         
         <script>
            $.ajax( { async : false } );
		var i = <?php echo $i ;?>;
               
                var val = <?php echo $values['computer'] ;?>;
          status('31',i,val,'cabin-15');
         </script>
          <?php $i++; ?>
         <div id='display31' ></div>
<?php      
 //       }
        echo "<br style='clear:both;'/>";
         echo "</div>";  
    
    
}
?></div>
				<div style="border: 1px solid black; box-shadow:inset 9px 10px 75px #FFF8DC; width: 20%; height: 75%; margin-top: 1%; float: left; margin-left: 2%;"><?php echo $lang->PRINCE;?>
					<?php
   
  $i=1;  
     foreach ($_SESSION['roomData'][32] as $key => $values ) {
	echo "<div id='rows'>";	
	
         ?>
         
         <script>
            $.ajax( { async : false } );
		var i = <?php echo $i ;?>;
               
                var val = <?php echo $values['computer'] ;?>;
          status('32',i,val,'cabin-16');
         </script>
          <?php $i++; ?>
         <div id='display32' ></div>
<?php      
  //      }
        echo "<br style='clear:both;'/>";
         echo "</div>";  
    
    
}
?></div>
				<div style="border: 1px solid black;box-shadow:inset 9px 10px 75px #FFF8DC; width: 20%; height: 75%; margin-top: 1%; float: left; margin-left: 2%;"><?php echo $lang->RONY;?>

					<?php
     
  $i=1;  
     foreach ( $_SESSION['roomData'][33] as $key => $values ) {
	echo "<div id='rows'>";	
	
         ?>
         
         <script>
            $.ajax( { async : false } );
		var i = <?php echo $i ;?>;
               
                var val = <?php echo $values['computer'] ;?>;
          status('33',i,val,'cabin-17');
         </script>
          <?php $i++; ?>
         <div id='display33'></div>
<?php      
  //      }
        echo "<br style='clear:both;'/>";
         echo "</div>";  
    
    
}
?></div>
			</div>
		</div>
	</div>

	<div class="lastdiv"
		style="float: left; height: 10%; width: 100%; border: 1px solid black;">
		<div
			style="float: left; height: 92%; width: 19%; border: 1px solid black;box-shadow:inset 9px 10px 40px #769DCC;"><?php echo $lang->WASHROOM;?></div>
		<div style="float: right; width: 80%;">
			<div class="room3">
			<?php echo $lang->PRANABJYOTIDAS;?>
						 <?php
// $count=0;
// foreach ( $_SESSION ['variable'] as $key => $values ) {
//     if ($values ['room_id'] == 15) 
//        	{

// $count = $key;
// }
         
// }    
   $i=1;  
//echo $count;
     foreach ( $_SESSION['roomData'][15] as $key => $values ) {
	echo "<div id='rows'>";	
   //   if ($values ['room_id'] == 15) {
	
         ?>
         
         <script>
            $.ajax( { async : false } );
		var i = <?php echo $i ;?>;
               
                var val = <?php echo $values['computer'] ;?>;
          status('15',i,val,'Pranabdas');
         </script>
          <?php $i++; ?>
         <div id='display15' style='margin-top:20px;'></div>
<?php      
   //     }
        echo "<br style='clear:both;'/>";
         echo "</div>";  
    
    
}
?>
			</div>
        <div class="room3">
        <?php echo $lang->ARINDERSINGHSURI;?>
			 <?php
// $count=0;
// foreach ( $_SESSION ['variable'] as $key => $values ) {
//     if ($values ['room_id'] == 16) 
//        	{

// $count = $key;
// }


         
// }     
  $i=1;  
//echo $count;
     foreach ( $_SESSION['roomData'][16] as $key => $values ) {
	echo "<div id='rows'>";	
 //     if ($values ['room_id'] == 16) {
	
         ?>
         
         <script>
            $.ajax( { async : false } );
		var i = <?php echo $i ;?>;
               
                var val = <?php echo $values['computer'] ;?>;
          status('16',i,val,'arindersinghsuri');
         </script>
          <?php $i++; ?>
         <div id='display16' style='margin-top:20px;'></div>
<?php      
   //     }
        echo "<br style='clear:both;'/>";
         echo "</div>";  
    
    
}
?>
        
</div>
        <div class="room3">
<?php echo $lang->SONALIMINOCHA;?>
			 <?php
// $count=0;
// foreach ( $_SESSION ['variable'] as $key => $values ) {
//     if ($values ['room_id'] == 17) 
//        	{

// $count = $key;
// }


         
// }    
   $i=1;  
//echo $count;
     foreach ( $_SESSION['roomData'][17] as $key => $values ) {
	echo "<div id='rows'>";	
 //     if ($values ['room_id'] == 17) {
	
         ?>
         
         <script>
            $.ajax( { async : false } );
		var i = <?php echo $i ;?>;
               
                var val = <?php echo $values['computer'] ;?>;
          status('17',i,val,'sonaliminocha');
         </script>
          <?php $i++; ?>
         <div id='display17'></div>
<?php      
    //    }
        echo "<br style='clear:both;'/>";
         echo "</div>";  
    
    
}
?>
        </div>
        <div class="room3">
        <?php echo $lang->SAURABH;?> 
			 <?php
// $count=0;
// foreach ( $_SESSION ['variable'] as $key => $values ) {
//     if ($values ['room_id'] == 18) 
//        	{

// $count = $key;
// }


         
// }     
  $i=1;  
//echo $count;
     foreach ( $_SESSION['roomData'][18] as $key => $values ) {
	echo "<div id='rows'>";	
  //    if ($values ['room_id'] == 18) {
	
         ?>
         
         <script>
            $.ajax( { async : false } );
		var i = <?php echo $i ;?>;
               
                var val = <?php echo $values['computer'] ;?>;
          status('18',i,val,'sourabh');
         </script>
          <?php $i++; ?>
         <div id='display18' style='margin-top:20px;'></div>
<?php      
  //     };
        echo "<br style='clear:both;'/>";
         echo "</div>";  
    
    
}
?>
        </div>
		</div>
	</div>
</div>
