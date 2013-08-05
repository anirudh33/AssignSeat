<?php
// echo "<pre>";
// print_r($data);
?>
<center><h2>Employee Details</h2></center>

<div id="roomDetail">
	<div id="empTxtDetails">
	<form id="empDataForm">
		<table>
			<tr>
				<td>Name :</td>
				<td><input type="text" name='name' value='<?php echo isset($data[0]['name'])?$data[0]['name']:''?>'  class='empData'/></td>
			</tr>	
			<tr>
				<td>Designation :</td>
				<td><input type="text" name='designation' value='<?php echo isset($data[0]['designation'])?$data[0]['designation']:'' ?>'  class='empData'/></td>
			</tr>	
			<tr>
				<td>Department :</td>
				<td><input type="text" name='department' value='<?php echo isset($data[0]['department'])?$data[0]['department']:'' ?>'  class='empData'/></td>
			</tr>
			<tr>
				<td>Details :</td>
				<td><textarea  name='details' class='empData' style="width:100%; height: 140%; margin-top: 8%" ><?php echo isset($data[0]['details'])?$data[0]['details']:'' ?> </textarea></td>
			</tr>					
		</table>
	</form>
	<input type="button" id="empEditutton" value="Edit" onclick="editEmp(<?php echo isset($data[0]['id'])?$data[0]['id']:'0' ?>)">
	</div>
	<div id="empImageDetails">
		<?php if(isset($data[0]['name'])) if($data[0]['user_image']== NULL ) { ?>
		<img alt="User Image" src="assets/images/human.jpeg" />
		<?php }
		else {?>
		<!-- 		code here -->
		<?php }?>
		<form>
<!-- 		<input id="file_upload" name="file_upload" type="file" /> -->
		</form>
		<div id='errorMsg'></div>
	</div>	
</div>

<script type="text/javascript">
$('.empData').attr("disabled", "disabled"); 
function editEmp(empId)
{
	$("#empEditutton").remove();
	$(".empData").removeAttr("disabled");
	$("#empDataForm").append('<input type="button" value="Save" onclick="saveEmp('+empId+')">');
}
function saveEmp(empId) {
	if(empId==0) 
	{
		alert("add New");
	}
	else
	{
		alert("update Emp");
	}
	showEmpDetails(empId);
}

</script>
	
<style>
#empTxtDetails {
	float: left;
}
#empImageDetails {
	float: left;
}
</style>