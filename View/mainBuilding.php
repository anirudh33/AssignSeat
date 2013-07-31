<?php //print_r($_SESSION);die;?>
<script>
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
<style>
#rows
{
	height:20px;
	float:left;
	text-align:center;
	margin:2px;
	margin-left:auto;
}
.cols
{
	border:1px solid blue;
	
	float:left;
	
	margin-left:6px;
	margin-right:6px;
}

 
/** style for droppable content **/
.dropped {
    width: 40px;
    height: 21px;
    float: left;
    border:solid 1px gray;
   
}
 
/** style for dragable content **/
.dragged{
    
    display:table-cell;
    text-align:center;
    vertical-align:middle;
    font-size:12px;
    font-weight:bold;
    width:40px;
    height:16px;
    float: left;
}
 
/** style when an object is moving hover **/
.hoverClass{
    background:#339bfb;
    color:#444444;
}
 
/** style for droppable when the moveable object is dropped **/
.dropClass{
    background:#55d532;
}
 
/** clear the float used by other dragable and moveable objects **/
.clear{
    clear:both;
}

</style>
<!-- Updated By Amber Sharma -->
<div class="mainContainer">
<div style="border: 1px solid black; height:30%">
  <div class="div1">
   <div class="googol">GOOGOL</div>
   <div class="srijjan_2">
   		   
   
   </div>
  </div>  
<div class="div2">
   <div class="sofa_reception">sofa_reception</div>
   <div class="lobby">lobby</div>
   <div class="loby2">lobby</div>
   <div class="aer"><?php
foreach ( $_SESSION ['variable'] as $key => $values ) {
    if ($values ['room_id'] == 8) {
    	for($i = 0; $i < $values ['computer']; $i ++)
        
        {
         for($rows=0;$rows<$values['row_number'];$rows++){
            ?><div style="float: left; height: 22px; width: 32px;margin-right:25px;"><img src="images/green_seat.jpeg" height=20 width=30 /></div><?php
        
        }
        echo "<br style='clear:both;'/>";
        }
    }
    // echo "<pre/>";
    
}
?></div>
   <div class="aqua"><?php
foreach ( $_SESSION ['variable'] as $key => $values ) {
    if ($values ['room_id'] == 9) {
    	for($i = 0; $i < $values ['computer']; $i ++)
        
        {
         for($rows=0;$rows<$values['row_number'];$rows++){
            ?><div style="float: left; height: 22px; width: 32px;margin-right:25px;"><img src="images/green_seat.jpeg" height=20 width=30 /></div><?php
        
        }
        echo "<br style='clear:both;'/>";
        }
    }
    // echo "<pre/>";
    
}
?></div>
  </div>

  <div class="sofachess">
      <div style=" border: 1px solid black; height: 13%; margin-top: 550%; width: 90%;"> 
      </div>
      <div style=" border: 1px solid black; height: 13%; margin-top: 10%; width: 90%;"> 
      </div>
  </div>

  <div class="room">room</div>
  <div class="room1">room</div>
  <div class="conference"><?php
foreach ( $_SESSION ['variable'] as $key => $values ) {
    if ($values ['room_id'] == 10) {
    	for($i = 0; $i < $values ['computer']; $i ++)
        
        {
         for($rows=0;$rows<$values['row_number'];$rows++){
            ?><div style="float: left; height: 22px; width: 32px;margin-right:25px;"><img src="images/green_seat.jpeg" height=20 width=30 /></div><?php
        
        }
        echo "<br style='clear:both;'/>";
        }
    }
    // echo "<pre/>";
    
}
?></div>

</div>  
<div class="div3">
    <div style="float: left;height: 100%; width:20%; border: 1px solid black;">
        <div style="border: 1px solid black;float: left;height: 5%;width: 100%;">washroom</div>
        <div style="border: 1px solid black;float: left;height: 4%;width: 100%;">lobby</div>
        <div style="float: left;height: 5%; width:100%; border: 1px solid black;">cafetaria</div>
        <div style="float: left;height: 20%; width:100%; border: 1px solid black;">room1</div>
        <div style="float: left;height: 20%; width:100%; border: 1px solid black;">room2</div>
        <div style="float: left;height: 22%; width:100%; border: 1px solid black;">sirijan 3</div>
        <div style="float: left;height: 15%; width:100%; border: 1px solid black;">accounts</div>
        <div style="float: left;height: 6%; width:100%; border: 1px solid black;">lobby</div>
    </div>

   <div style=" border: 1px solid black;float: left;height: 99%;width: 4%;">lobby</div>
   <div style="float: right;width:75%;border: 1px solid black">
    <div class="room2"><?php
foreach ( $_SESSION ['variable'] as $key => $values ) {
    if ($values ['room_id'] == 11) {
    	for($i = 0; $i < $values ['computer']; $i ++)
        
        {
         for($rows=0;$rows<$values['row_number'];$rows++){
            ?><div style="float: left; height: 22px; width: 32px;margin-right:25px;"><img src="images/green_seat.jpeg" height=20 width=30 /></div><?php
        
        }
        echo "<br style='clear:both;'/>";
        }
    }
     echo "<pre/>";
    
}
?></div>
    <div class="room2"><?php
foreach ( $_SESSION ['variable'] as $key => $values ) {
    if ($values ['room_id'] == 12) {
    	for($i = 0; $i < $values ['computer']; $i ++)
        
        {
         for($rows=0;$rows<$values['row_number'];$rows++){
            ?><div style="float: left; height: 22px; width: 32px;margin-right:25px;"><img src="images/green_seat.jpeg" height=20 width=30 /></div><?php
        
        }
        echo "<br style='clear:both;'/>";
        }
    }
     echo "<pre/>";
    
}
?></div>
    <div class="room2"><?php
foreach ( $_SESSION ['variable'] as $key => $values ) {
    if ($values ['room_id'] == 13) {
    	for($i = 0; $i < $values ['computer']; $i ++)
        
        {
         for($rows=0;$rows<$values['row_number'];$rows++){
            ?><div style="float: left; height: 22px; width: 32px;margin-right:25px;"><img src="images/green_seat.jpeg" height=20 width=30 /></div><?php
        
        }
        echo "<br style='clear:both;'/>";
        }
    }
     echo "<pre/>";
    
}
?></div>
    <div class="room2 "><?php
foreach ( $_SESSION ['variable'] as $key => $values ) {
    if ($values ['room_id'] == 14) {
    	for($i = 0; $i < $values ['computer']; $i ++)
        
        {
         for($rows=0;$rows<$values['row_number'];$rows++){
            ?><div style="float: left; height: 22px; width: 32px;margin-right:25px;"><img src="images/green_seat.jpeg" height=20 width=30 /></div><?php
        
        }
        echo "<br style='clear:both;'/>";
        }
    }
     echo "<pre/>";
    
}
?></div>
   </div>
   <div style=" border: 1px solid black;float: right;height: 88%;width: 12%;">
        <div class="cabin"></div>
        <div class="cabin"></div>
        <div class="cabin"></div>
        <div class="cabin"></div>
        <div class="cabin"></div>
        <div class="cabin"></div>
        <div class="cabin"></div>
        <div class="cabin"></div>
        <div class="cabin"></div>
        <div class="cabin"></div>
        <div class="cabin"></div>
        <div class="cabin"></div>
        <div class="cabin"></div>
        <div class="cabin"></div>
   </div>
   <div style="border: 1px solid black;float: right;height: 88%;width: 62%;">
	<!-- Updated By Amber Sharma -->
        <?php 
                                foreach($_SESSION['variable'] as $key=>$values)
				{
					echo "<div id='rows'>";	
					$rand = rand(1,9);
					if($values['room_id']==2)
					{
						for($i=0;$i<$values['computer'];$i++)
						{
							if($i != $rand)
							{
			?>
								<div class="cols"  id="<?php echo 'main'.$key . '_'. $i; ?>" >
								<img class='dragable dragged' id="<?php echo  $key . '_'. $i; ?>" src="images/red_chair.png"/>
								</div>
			<?php
							}
							else
							{
			?>				
								<div id="<?php echo 'main'. $key . '_'. $i; ?>" class="cols droppable dropped">
								<img id="<?php echo $key . '_'. $i; ?>" src="images/green_chair.png" height="18" width="30"/>
								</div>
			<?php
							}
							
                                         		echo "<script>dragdropevent();</script>";
						}
					}
					echo "</div>";
                         	}
                        ?>
	<!-- Updated By Amber Sharma -->
   </div>   
</div>

  <div class="lastdiv" style="float: left;height: 10%; width:100%; border: 1px solid black;">
      <div style="float: left;height: 92%; width:19%; border: 1px solid black;">washroom</div>
      <div style="float: right;width:80%;">
        <div class="room3"><?php
foreach ( $_SESSION ['variable'] as $key => $values ) {
    if ($values ['room_id'] == 15) {
    	for($i = 0; $i < $values ['computer']; $i ++)
        
        {
         for($rows=0;$rows<$values['row_number'];$rows++){
            ?><div style="float: left; height: 22px; width: 32px;margin-right:25px;"><img src="images/green_seat.jpeg" height=20 width=30 /></div><?php
        
        }
        echo "<br style='clear:both;'/>";
        }
    }
     echo "<pre/>";
    
}
?></div>
        <div class="room3"><?php
foreach ( $_SESSION ['variable'] as $key => $values ) {
    if ($values ['room_id'] == 16) {
    	for($i = 0; $i < $values ['computer']; $i ++)
        
        {
         for($rows=0;$rows<$values['row_number'];$rows++){
            ?><div style="float: left; height: 22px; width: 32px;margin-right:25px;"><img src="images/green_seat.jpeg" height=20 width=30 /></div><?php
        
        }
        echo "<br style='clear:both;'/>";
        }
    }
    // echo "<pre/>";
    
}
?></div>
        <div class="room3"><?php
foreach ( $_SESSION ['variable'] as $key => $values ) {
    if ($values ['room_id'] == 17) {
    	for($i = 0; $i < $values ['computer']; $i ++)
        
        {
         for($rows=0;$rows<$values['row_number'];$rows++){
            ?><div style="float: left; height: 22px; width: 32px;margin-right:25px;"><img src="images/green_seat.jpeg" height=20 width=30 /></div><?php
        
        }
        echo "<br style='clear:both;'/>";
        }
    }
    // echo "<pre/>";
    
}
?></div>
        <div class="room3"><?php
foreach ( $_SESSION ['variable'] as $key => $values ) {
    if ($values ['room_id'] == 18) {
    	for($i = 0; $i < $values ['computer']; $i ++)
        
        {
         for($rows=0;$rows<$values['row_number'];$rows++){
            ?><div style="float: left; height: 22px; width: 32px;margin-right:25px;"><img src="images/green_seat.jpeg" height=20 width=30 /></div><?php
        
        }
        echo "<br style='clear:both;'/>";
        }
    }
    // echo "<pre/>";
    
}
?></div>
      </div>
  </div>
</div>
