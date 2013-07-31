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
					for($i = 0; $i < $values ['computer']; $i ++) 

{
						for($rows = 0; $rows < $values ['row_number']; $rows ++) {
							?><div style="float: left; height: 22px; width: 32px; margin-right: 25px;">
					<img src="images/green_seat.jpeg" height=20 width=30 />
				</div><?php
						}
						echo "<br style='clear:both;'/>";
					}
				}
				// echo "<pre/>";
			}
			?></div>
			<div class="aqua">
			AQUA<?php
			foreach ( $_SESSION ['variable'] as $key => $values ) {
				if ($values ['room_id'] == 9) {
					for($i = 0; $i < $values ['computer']; $i ++) 

					{
						for($rows = 0; $rows < $values ['row_number']; $rows ++) {
							?><div
					style="float: left; height: 22px; width: 32px; margin-right: 25px;">
					<img src="images/green_seat.jpeg" height=20 width=30 />
				</div><?php
						}
						echo "<br style='clear:both;'/>";
					}
				}
				// echo "<pre/>";
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
				for($i = 0; $i < $values ['computer']; $i ++) 

				{
					for($rows = 0; $rows < $values ['row_number']; $rows ++) {
						?><div
				style="float: left; height: 22px; width: 32px; margin-right: 25px;">
				<img src="images/green_seat.jpeg" height=20 width=30 />
			</div><?php
					}
					echo "<br style='clear:both;'/>";
				}
			}
			// echo "<pre/>";
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
				style="float: left; height: 20%; width: 100%; border: 1px solid black;box-shadow:inset 9px 10px 75px #FFF8DC;">room1</div>
			<div
				style="float: left; height: 20%; width: 100%; border: 1px solid black;box-shadow:inset 9px 10px 75px #FFF8DC;">room2</div>
			<div
				style="float: left; height: 22%; width: 100%; border: 1px solid black;">sirijan
				3</div>
			<div
				style="float: left; height: 15%; width: 100%; border: 1px solid black;">accounts</div>
			<div
				style="float: left; height: 6%; width: 100%; border: 1px solid black;box-shadow:inset 9px 10px 40px #DEB887;">lobby</div>
		</div>

		<div
			style="border: 1px solid black; float: left; height: 99%; width: 4%;box-shadow:inset 9px 10px 40px #DEB887;">lobby</div>
		<div style="float: right; width: 75%; border: 1px solid black">
			<div class="room2"><?php
			foreach ( $_SESSION ['variable'] as $key => $values ) {
				if ($values ['room_id'] == 11) {
					for($i = 0; $i < $values ['computer']; $i ++) 

					{
						for($rows = 0; $rows < $values ['row_number']; $rows ++) {
							?><div
					style="float: left; height: 22px; width: 32px; margin-right: 25px;">
					<img src="images/green_seat.jpeg" height=20 width=30 />
				</div><?php
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
						for($rows = 0; $rows < $values ['row_number']; $rows ++) {
							?><div
					style="float: left; height: 22px; width: 32px; margin-right: 25px;">
					<img src="images/green_seat.jpeg" height=20 width=30 />
				</div><?php
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
						for($rows = 0; $rows < $values ['row_number']; $rows ++) {
							?><div
					style="float: left; height: 22px; width: 32px; margin-right: 25px;">
					<img src="images/green_seat.jpeg" height=20 width=30 />
				</div><?php
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
						for($rows = 0; $rows < $values ['row_number']; $rows ++) {
							?><div
					style="float: left; height: 22px; width: 32px; margin-right: 25px;">
					<img src="images/green_seat.jpeg" height=20 width=30 />
				</div><?php
						}
						echo "<br style='clear:both;'/>";
					}
				}
				echo "<pre/>";
			}
			?></div>
		</div>
		<div
			style="border: 1px solid black; float: right; height: 88%; width: 12%;">
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
		<div
			style="border: 1px solid black; float: right; height: 88%; width: 62%;">
			<!-- Updated By Amber Sharma -->
        <?php
								foreach ( $_SESSION ['variable'] as $key => $values ) {
									echo "<div id='rows'>";
									$rand = rand ( 1, 9 );
									if ($values ['room_id'] == 2) {
										for($i = 0; $i < $values ['computer']; $i ++) {
											if ($i != $rand) {
												?>
								<div class="cols" id="<?php echo 'main_'.$key . '_'. $i; ?>">
				<img class='dragable dragged' id="<?php echo  $key . '_'. $i; ?>"
					src="images/redvoid.gif" height="35" width="45" />
			</div>
			<?php
											} else {
												?>				
								<div id="<?php echo 'main_'. $key . '_'. $i; ?>"
				class="cols droppable dropped">
				<img id="<?php echo $key . '_'. $i; ?>" src="images/blackvoid.jpeg"
					height="25" width="35" />
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
					for($i = 0; $i < $values ['computer']; $i ++) 

					{
						for($rows = 0; $rows < $values ['row_number']; $rows ++) {
							?><div
					style="float: left; height: 22px; width: 32px; margin-right: 25px;">
					<img src="images/green_seat.jpeg" height=20 width=30 />
				</div><?php
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
						for($rows = 0; $rows < $values ['row_number']; $rows ++) {
							?><div
					style="float: left; height: 22px; width: 32px; margin-right: 25px;">
					<img src="images/green_seat.jpeg" height=20 width=30 />
				</div><?php
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
						for($rows = 0; $rows < $values ['row_number']; $rows ++) {
							?><div
					style="float: left; height: 22px; width: 32px; margin-right: 25px;">
					<img src="images/green_seat.jpeg" height=20 width=30 />
				</div><?php
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
						for($rows = 0; $rows < $values ['row_number']; $rows ++) {
							?><div
					style="float: left; height: 22px; width: 32px; margin-right: 25px;">
					<img src="images/green_seat.jpeg" height=20 width=30 />
				</div><?php
        
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
