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
<div class="mainContainer">
	<div class="div1">
		<div class="googol">GOOGOL</div>
		<div class="srijjan_2">srijjan_2</div>
	</div>
	<div class="div2">
		<div class="sofa_reception">sofa_reception</div>
		<div class="lobby">lobby</div>
		<div class="loby2">lobby</div>
		<div class="aer">Aer</div>
		<div class="aqua">aqua</div>
	</div>
	<div class="sofachess"></div>
	<div class="room">room</div>
	<div class="room1">room</div>
	<div class="conference">conference</div>
	<div class="div3">
		<div style="float: left; height: 100%; width: 20%; border: 1px solid pink;">
			<div style="border: 1px solid pink; float: left; height: 5%; width: 100%;">washroom</div>
			<div style="border: 1px solid pink; float: left; height: 4%; width: 100%;">lobby</div>
			<div style="float: left; height: 5%; width: 100%; border: 1px solid pink;">cafetaria</div>
			<div style="float: left; height: 20%; width: 100%; border: 1px solid pink;">room1</div>
			<div style="float: left; height: 20%; width: 100%; border: 1px solid pink;">room2</div>
			<div style="float: left; height: 22%; width: 100%; border: 1px solid pink;">sirijan 3</div>
			<div style="float: left; height: 15%; width: 100%; border: 1px solid pink;">accounts</div>
			<div style="float: left; height: 6%; width: 100%; border: 1px solid pink;">lobby</div>
		</div>
		<div style="border: 1px solid pink; float: left; height: 99%; width: 4%;">lobby</div>
		<div style="float: right; width: 75%; border: 1px solid blue">
			<div class="room2">Egnis</div>
			<div class="room2">jugraj singh bedi</div>
			<div class="room2">sachin khurana</div>
			<div class="room2 ">terra</div>
		</div>
		<div style="border: 1px solid pink; float: right; height: 88%; width: 12%;">
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
		<div style="border: 1px solid pink; float: right; height: 88%; width: 62%;">
<?php
// print_r($_SESSION['variable']);die;
foreach ( $_SESSION ['variable'] as $key => $values ) {
    if ($values ['room_id'] == 2) {
        
        for($i = 0; $i < $values ['computer']; $i ++) {
            // echo "hii";
            ?><img src="images/green_seat.jpeg" height=20 width=30 /><?php
        
        }
        echo "<br/>";
    }
    // echo "<pre/>";
    // print_r($_SESSION['variable']['3']);
}
?>
        </div>
	</div>
	<div class="lastdiv" style="float: left; height: 10%; width: 100%; border: 1px solid blue;">
		<div style="float: left; height: 92%; width: 19%; border: 1px solid pink;">washroom</div>
		<div style="float: right; width: 80%;">
			<div class="room3">Pranabdas</div>
			<div class="room3">arinder singh suri</div>
			<div class="room3">sonali minocha</div>
			<div class="room3">sourabh</div>
		</div>
	</div>
</div>