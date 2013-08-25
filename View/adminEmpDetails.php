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
				<td>OSSCube Member Id :</td>
				<td><input type="text" name='osscubememberid' value='<?php echo isset($data['osscubememberid'])?$data['osscubememberid']:'' ?>'  class='empData'/></td>
			</tr>		
			<tr>
				<td>OSSCube Member Email Id :</td>
				<td><input type="text" name='officialemailid' value='<?php echo isset($data['officialemailid'])?$data['officialemailid']:'' ?>'  class='empData'/></td>
			</tr>	
			<tr>
				<td>Teams:</td>
				<td><input type="text" name='teams' value='<?php echo isset($data['teams'])?$data['teams']:'' ?>'  class='empData'/></td>
			</tr>
			<tr>
				<td>Cell :</td>
				<td><input type="text" name='cell' value='<?php echo isset($data['cell'])?$data['cell']:'' ?>'  class='empData'/></td>
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
				<td>Location:</td>
				<td><input type="text" name='location' value='<?php echo isset($data['location'])?$data['location']:'' ?>'  class='empData'/></td>
			</tr>			
			<tr>
				<td>Territory:</td>
				<td><input type="text" name='territory' value='<?php echo isset($data['territory'])?$data['territory']:'' ?>'  class='empData'/></td>
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
.empData {
	width: 250px;
}
#empImageDetails {
	float: left;
}
</style>
