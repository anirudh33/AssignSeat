<?php //print_r($_SESSION);die;?>
<script type="text/javascript" src="assets/js/jquery.ui.core.js"></script>
<script type="text/javascript" src="assets/js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="assets/js/jquery.ui.mouse.js"></script>
<script type="text/javascript" src="assets/js/jquery.ui.draggable.js"></script>
<script type="text/javascript" src="assets/js/jquery.ui.droppable.js"></script>
<script>
$changeComment = '';
/* Updated By Amber Sharma */
function dragdropevent()
{
	
	/** we set the dragable class to be dragable, we add the containment which will be #boxdemo, so dropable and dragable object cant pass out of this box **/
     $( ".dragable" ).draggable({
       		
         revert: "invalid",
	start: function(event, ui) {    
    		draggedElement = this.id;
		moveid = $(this).parent('div').attr('id');
		//alert(moveid);
		dragdropevent();
	//alert(parentid);
    	}
    });
 
    $( ".droppable" ).droppable({
        /** tolerance:fit means, the moveable object has to be inside the dropable object area **/
        tolerance: 'fit',
        over: function(event, ui) {
      	thisid = this.id;
	
            /** We add the hoverClass when the moveable object is inside of the dropable object **/
            $('.ui-draggable-dragging').addClass('hoverClass');
        },
        out: function(event, ui) {
        	prevthisid = this.id;
            /** We remove the hoverClass when the moveable object is outside of the dropable object area **/
            $('.ui-draggable-dragging').removeClass('hoverClass');
            $('#'+prevthisid).removeClass('dropClass');
        },
        /** This is the drop event, when the dragable object is moved on the top of the dropable object area **/
        drop: function( event, ui ) {

         	$("#changeCommentLink").fancybox({
        		closeBtn  : false,
            	afterLoad : function(){
            	$("#changeComment").val('');
            	return;
            	},
            closeClick  : false, // prevents closing when clicking INSIDE fancybox
            helpers     : { 
                overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
            }
              
            });
        	$("#changeCommentLink").trigger("click");
		//alert(thisid);
		//$("#"+thisid).removeClass('droppable ui-droppable dropped');
		 $('#' + thisid).droppable('disable')
		$( "#"+thisid ).html('<img src="images/red_chair.png" id=' + draggedElement + ' height="30" width="30" class="dragable dragged" />');
		
		$( "#"+moveid ).html(' ');
		if(moveid.indexOf("emp") == -1)
		{
			$( "#"+moveid ).html('<img src="images/green_chair.png" height="18" width="30"  />');
			$("#"+moveid).addClass('droppable ui-droppable dropped');
		}
		dragdropevent();
        	
        }
    });
}
function closeFancyBox(){
	$changeComment = $("#changeComment").val();	
	$.fancybox.close();
	$.post('index.php?controller=MainController&method=assignSeat',{roomid:thisid,changeComment:$changeComment},function(data,status){
		//window.location.href = 'index.php';
		});
	 $('#' + thisid).droppable('disable')
		$( "#"+thisid ).html('<img src="images/red_chair.png" id=' + draggedElement + ' height="30" width="30" class="dragable dragged" />');
		
		$( "#"+moveid ).html(' ');
		if(moveid.indexOf("emp") == -1)
		{
			$( "#"+moveid ).html('<img src="images/green_chair.png" height="18" width="30"  />');
			$("#"+moveid).addClass('droppable ui-droppable dropped');
		}
		dragdropevent();
	
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
	$( document ).tooltip({
		items: "img",
		content : function() {
			displayData = "";
			$.ajax({
				async : false,
				url : 'View/tooltipContent.php',
				type :'post',				
				data : 'any data',
				success : function (data) {
					//alert(data);
					displayData = data;
				}
			});
			return displayData;
		},
		position: {
			my: "center bottom-20",
			at: "center top",
			using: function( position, feedback ) {
				$( this ).css( position );
				$( "<div>" )
					.addClass( "arrow" )
					.addClass( feedback.vertical )
					.addClass( feedback.horizontal )
					.appendTo( this );
			}
		}
	});
}
</script>
<!-- Updated By Amber Sharma -->
<div class="mainContainer">
	<div style="border: 1px solid black; height: 30%;width:100%;">
		<div class="div1">
			<div class="googol"><label class="writing">GOOGOL</label>  </div>
			<div class="srijjan_2">SRIJJAN -II</div>
		</div>
		<div class="div2">
			<div class="sofa_reception">
				<img alt="" src="images/sofa.jpg"
					style="float: left; height: 50%; width: 30%; margin-top: 6%;">
				sofa_reception <img alt="" src="images/reception.jpeg"
					style="height: 80%; width: 45%; float: right;">
			</div>
			<div class="lobby">lobby</div>
			<div class="loby2">lobby</div>
			<div class="aer">
			AER<?php
foreach ( $_SESSION ['variable'] as $key => $values ) {
    if ($values ['room_id'] == 8) {
    	for($i = 0; $i < $values ['row_number']; $i ++)
        
        {
         ?>
         
         <script>
		var i = <?php echo $i + 1 ;?>;
                var val = <?php echo $values['computer'] ;?>;
          status('8',i,val);
         </script>
         <div id='display8'></div> 
<?php      
        }
        echo "<br style='clear:both;'/>";
        
    }
    
}
?></div>
			<div class="aqua">
			AQUA<?php
foreach ( $_SESSION ['variable'] as $key => $values ) {
    if ($values ['room_id'] == 9) {
    	for($i = 0; $i < $values ['row_number']; $i ++)
        
        {
         ?>
         
         <script>
		var i = <?php echo $i + 1 ;?>;
                var val = <?php echo $values['computer'] ;?>;
          status('9',i,val);
         </script>
         <div id='display9'></div> 
<?php      
        }
        echo "<br style='clear:both;'/>";
        
    }
    
}
?></div>
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

		<div class="room">room</div>
		<div class="room1">room</div>
		<div class="conference"><?php
foreach ( $_SESSION ['variable'] as $key => $values ) {
    if ($values ['room_id'] == 10) {
    	for($i = 0; $i < $values ['row_number']; $i ++)
        
        {
         ?>
         
         <script>
		var i = <?php echo $i + 1 ;?>;
                var val = <?php echo $values['computer'] ;?>;
          status('10',i,val);
         </script>
         <div id='display10'></div> 
<?php      
        }
        echo "<br style='clear:both;'/>";
        
    }
    
}
?>

</div>

	</div>
	<div class="div3">
		<div
			style="float: left; height: 100%; width: 20%; border: 1px solid black;">
			<div
				style="border: 1px solid black; float: left; height: 5%; width: 100%;box-shadow:inset 9px 10px 40px #769DCC;">washroom</div>
			<div
				style="border: 1px solid black; float: left; height: 4%; width: 100%;box-shadow:inset 9px 10px 40px #DEB887;">lobby</div>
			<div
				style="float: left; height: 5%; width: 100%; border: 1px solid black;box-shadow:inset 9px 10px 40px #F4FFB5;">cafetaria</div>
			<div
				style="float: left; height: 20%; width: 100%; border: 1px solid black;box-shadow:inset 9px 10px 75px #FFF8DC;">room1
				<?php
foreach ( $_SESSION ['variable'] as $key => $values ) {
    if ($values ['room_id'] == 34) {
    	for($i = 0; $i < $values ['row_number']; $i ++)
        
        {
         ?>
         
         <script>
		var i = <?php echo $i + 1 ;?>;
                var val = <?php echo $values['computer'] ;?>;
          status('34',i,val);
         </script>
         <div id='display34'></div> 
<?php      
        }
        echo "<br style='clear:both;'/>";
        
    }
    
}
?>
				</div>
			<div
				style="float: left; height: 20%; width: 100%; border: 1px solid black;box-shadow:inset 9px 10px 75px #FFF8DC;">room2
				<?php
foreach ( $_SESSION ['variable'] as $key => $values ) {
    if ($values ['room_id'] == 35) {
    	for($i = 0; $i < $values ['row_number']; $i ++)
        
        {
         ?>
         
         <script>
		var i = <?php echo $i + 1 ;?>;
                var val = <?php echo $values['computer'] ;?>;
          status('35',i,val);
         </script>
         <div id='display35'></div> 
<?php      
        }
        echo "<br style='clear:both;'/>";
        
    }
    
}
?>
				</div>
			<div
				style="float: left; height: 22%; width: 100%; border: 1px solid black;">sirijan
				3
				 <?php
foreach ( $_SESSION ['variable'] as $key => $values ) {
    if ($values ['room_id'] == 20) {
    	for($i = 0; $i < $values ['row_number']; $i ++)
        
        {
         ?>
         
         <script>
		var i = <?php echo $i + 1 ;?>;
                var val = <?php echo $values['computer'] ;?>;
          status('20',i,val);
         </script>
         <div id='display20'></div> 
<?php      
        }
        echo "<br style='clear:both;'/>";
        
    }
    
}
?>
				
				</div>
			<div
				style="float: left; height: 15%; width: 100%; border: 1px solid black;">accounts
				<?php
foreach ( $_SESSION ['variable'] as $key => $values ) {
    if ($values ['room_id'] == 19) {
    	for($i = 0; $i < $values ['row_number']; $i ++)
        
        {
         ?>
         
         <script>
		var i = <?php echo $i + 1 ;?>;
                var val = <?php echo $values['computer'] ;?>;
          status('19',i,val);
         </script>
         <div id='display19'></div> 
<?php      
        }
        echo "<br style='clear:both;'/>";
        
    }
    
}
?>
				
				</div>
			<div
				style="float: left; height: 6%; width: 100%; border: 1px solid black;box-shadow:inset 9px 10px 40px #DEB887;">lobby</div>
		</div>

		<div
			style="border: 1px solid black; float: left; height: 99%; width: 4%;box-shadow:inset 9px 10px 40px #DEB887;">lobby</div>
		<div style="float: right; width: 75%; border: 1px solid black">
    <div class="room2">

<?php
foreach ( $_SESSION ['variable'] as $key => $values ) {
    if ($values ['room_id'] == 11) {
    	for($i = 0; $i < $values ['row_number']; $i ++)
        
        {
         ?>
         
         <script>
		var i = <?php echo $i + 1 ;?>;
                var val = <?php echo $values['computer'] ;?>;
          status('11',i,val);
         </script>
         <div id='display11'></div> 
<?php      
        }
        echo "<br style='clear:both;'/>";
        
    }
    
}
?>
</div>
    <div class="room2">
<?php
foreach ( $_SESSION ['variable'] as $key => $values ) {
    if ($values ['room_id'] == 12) {
    	for($i = 0; $i < $values ['row_number']; $i ++)
        
        {
         ?>
         
         <script>
		var i = <?php echo $i + 1 ;?>;
                var val = <?php echo $values['computer'] ;?>;
          status('12',i,val);
         </script>
         <div id='display12'></div> 
<?php      
        }
        echo "<br style='clear:both;'/>";
        
    }
    
}
?>

</div>
    <div class="room2">
<?php
foreach ( $_SESSION ['variable'] as $key => $values ) {
    if ($values ['room_id'] == 13) {
    	for($i = 0; $i < $values ['row_number']; $i ++)
        
        {
         ?>
         
         <script>
		var i = <?php echo $i + 1 ;?>;
                var val = <?php echo $values['computer'] ;?>;
          status('13',i,val);
         </script>
         <div id='display13'></div> 
<?php      
        }
        echo "<br style='clear:both;'/>";
        
    }
    
}
?>
</div>
    <div class="room2 ">
<?php
foreach ( $_SESSION ['variable'] as $key => $values ) {
    if ($values ['room_id'] == 14) {
    	for($i = 0; $i < $values ['row_number']; $i ++)
        
        {
         ?>
         
         <script>
		var i = <?php echo $i + 1 ;?>;
                var val = <?php echo $values['computer'] ;?>;
          status('14',i,val);
         </script>
         <div id='display14'></div> 
<?php      
        }
        echo "<br style='clear:both;'/>";
        
    }
    
}
?>
</div>
		</div>
		<div
			style="border: 1px solid black; float: right; height: 88%; width: 12%;">
			<div class="cabin">cabin-1</div>
			<div class="cabin">cabin-2</div>
			<div class="cabin">cabin-3</div>
			<div class="cabin">cabin-4</div>
			<div class="cabin">cabin-5</div>
			<div class="cabin">cabin-6</div>
			<div class="cabin">cabin-7</div>
			<div class="cabin">cabin-8</div>
			<div class="cabin">cabin-9</div>
			<div class="cabin">cabin-10</div>
			<div class="cabin">cabin-11</div>
			<div class="cabin">cabin-12</div>
			<div class="cabin">cabin-13</div>
			<div class="cabin">cabin-14</div>
		</div>
		<div
			style="border: 1px solid black; float: right; height: 88%; width: 62%;">
			<!-- Updated By Amber Sharma -->
<?php
$count=0;
foreach ( $_SESSION ['variable'] as $key => $values ) {
    if ($values ['room_id'] == 2) 
       	{

$count = $key;
}


         
}       $i=1;  
//echo $count;
     foreach ( $_SESSION ['variable'] as $key => $values ) {
	echo "<div id='rows'>";	
      if ($values ['room_id'] == 2) {
	
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
        }
        echo "<br style='clear:both;'/>";
         echo "</div>";  
    
    
}
?>
	<!-- Updated By Amber Sharma -->
			<div id="cabinrony"
				style="border: 1px solid black; width: 100%; height: 10%; margin-top: 100%">
				<div
					style="border: 1px solid black; width: 15%; height: 50%; margin-top: 1%; float: left; margin-left: 30%;">

					chander mohan</div>
				<div
					style="border: 1px solid black; width: 15%; height: 50%; margin-top: 1%; float: left; margin-left: 2%;">
					prince</div>
				<div
					style="border: 1px solid black; width: 15%; height: 50%; margin-top: 1%; float: left; margin-left: 2%;">

					rony</div>
			</div>
		</div>
	</div>

	<div class="lastdiv"
		style="float: left; height: 10%; width: 100%; border: 1px solid black;">
		<div
			style="float: left; height: 92%; width: 19%; border: 1px solid black;box-shadow:inset 9px 10px 40px #769DCC;">washroom</div>
		<div style="float: right; width: 80%;">
			<div class="room3"><?php
foreach ( $_SESSION ['variable'] as $key => $values ) {
    if ($values ['room_id'] == 15) {
    	for($i = 0; $i < $values ['row_number']; $i ++)
        
        {
         ?>
         
         <script>
		var i = <?php echo $i + 1 ;?>;
                var val = <?php echo $values['computer'] ;?>;
          status('15',i,val);
         </script>
         <div id='display15'></div> 
<?php      
        }
        echo "<br style='clear:both;'/>";
        
    }
    
}
?></div>
        <div class="room3">

<?php
foreach ( $_SESSION ['variable'] as $key => $values ) {
    if ($values ['room_id'] == 16) {
    	for($i = 0; $i < $values ['row_number']; $i ++)
        
        {
         ?>
         
         <script>
		var i = <?php echo $i + 1 ;?>;
                var val = <?php echo $values['computer'] ;?>;
          status('16',i,val);
         </script>
         <div id='display16'></div> 
<?php      
        }
        echo "<br style='clear:both;'/>";
        
    }
    
}
?>
</div>
        <div class="room3">

<?php
foreach ( $_SESSION ['variable'] as $key => $values ) {
    if ($values ['room_id'] == 17) {
    	for($i = 0; $i < $values ['row_number']; $i ++)
        
        {
         ?>
         
         <script>
		var i = <?php echo $i + 1 ;?>;
                var val = <?php echo $values['computer'] ;?>;
          status('17',i,val);
         </script>
         <div id='display17'></div> 
<?php      
        }
        echo "<br style='clear:both;'/>";
        
    }
    
}
?></div>
        <div class="room3">

<?php
foreach ( $_SESSION ['variable'] as $key => $values ) {
    if ($values ['room_id'] == 18) {
    	for($i = 0; $i < $values ['row_number']; $i ++)
        
        {
         ?>
         
         <script>
		var i = <?php echo $i + 1 ;?>;
                var val = <?php echo $values['computer'] ;?>;
          status('18',i,val);
         </script>
         <div id='display18'></div> 
<?php      
        }
        echo "<br style='clear:both;'/>";
        
    }
    
}
?></div>
		</div>
	</div>
</div>
