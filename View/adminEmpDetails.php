<center><h2>Employee Details</h2></center>

<div id="roomDetail">
	<div id="empTxtDetails">
	<form id="empDataForm">
		<table>
			<tr>
				<td>Name :</td>
				<td><input type="text" name='name' value="<?php echo isset($data['name'])?$data['name']:''?>"  class='empData'/></td>
			</tr>	
			<tr>
				<td>Designation :</td>
				<td><input type="text" name='designation' value='<?php echo isset($data['designation'])?$data['designation']:'' ?>'  class='empData'/></td>
			</tr>	
			<tr>
				<td>Department :</td>
				<td><input type="text" name='department' value='<?php echo isset($data['department'])?$data['department']:'' ?>'  class='empData'/></td>
			</tr>
			<tr>
				<td>Details :</td>
				<td><textarea  name='details' class='empData' style="width:100%; height: 140%; margin-top: 8%" ><?php echo isset($data['details'])?$data['details']:'' ?> </textarea></td>
			</tr>					
		</table>
	</form>
	</div>
	<div id="empImageDetails">
		<?php if(isset($data['user_image'])) if($data['user_image']== NULL ) { ?>
		<img alt="User Image" src="assets/images/human.jpeg" />
		<?php }
		else {?>
		<!-- 		code here -->
		<img alt="User Image" src="data:image/png;base64,<?php echo base64_encode( $data['user_image']);?>" width='250px'>
		<?php }?>
		<form>
<!-- 		<input id="file_upload" name="file_upload" type="file" /> -->
		</form>
		<div id='errorMsg'></div>
	</div>	
</div>

<script type="text/javascript">
$('.empData').attr("disabled", "disabled"); 
</script>
	
<style>
#empTxtDetails {
	float: left;
}
#empImageDetails {
	float: left;
}
</style>
