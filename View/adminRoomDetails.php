<center><h2>Room Details</h2></center>

<div id="roomDetail">
<table>
	<tr>
		<td>Room Name : </td>
		<td id='roomName'><?php echo $data[0]['name'];?></td>
	</tr>
		<tr>
		<td>Total Rows : </td>
		<td><?php echo (isset($data[0]['row_number'])) ? count($data) :  '0' ;?></td>
		<td id='addRowButton'><input  type="button" value="Add Row" onClick='addNewRow(<?php echo $data[0]['id']?>,<?php echo (isset($data[0]['row_number'])) ? count($data) :  '0' ;?>)'>
	</tr>
</table>
<div id='newRowEntry' style='display:none'>

</div>
<table id='roomRowTable'>
 <tr>
 	<td>Row No.</td>
 	<td>Total Computer</td>
 </tr>
<?php 
$row=0;
if(isset($data[0]['row_number'])) {
foreach ($data as $key=>$val) {
	$row++;
?>
 <tr id="roomRow<?php  echo $val['row_id']?>">
 	<td>Row <?php echo $row?></td>
 	<td ><div id="row<?php  echo $val['row_id']?>"><?php echo $val['computer']?></div></td>
 	<td onclick='editComputer(<?php echo $val['row_id']?>)' class='editComputer'>Edit</td>
 	<td onclick='DeleteRow(<?php echo $val['row_id']?>,<?php echo $val['id']?>)' class='editComputer'>Delete</td>
 </tr>
<?php 
  }
}
?>
</table>
</div>

<script>

function addNewRow(roomId,rowCount)
{
	$("#addRowButton").remove();
	selectButton="<select id='newSelectRow'>";
	for(i=1;i<=20;i++)
	{
		selectButton+="<option ";
		selectButton+=" value="+i+">"+i+" Computer</option>";
	}
	selectButton+="</select> ";
	saveButton="<input type='button' value='Save' onclick=saveNewRow("+roomId+","+(rowCount+1)+")>";
	$("#newRowEntry").html('<label id="newRowCount">Row '+(rowCount+1)+'<label> '+selectButton+saveButton);
	$("#newRowEntry").show();
}
function saveNewRow(roomId,rowCount) 
{
	computer=$("#newSelectRow").val();
	roomName=$('#roomName').html();
	/*
	*
	*add to database
	*/
	$.post('index.php?controller=MainController&method=addNewRoomRow',
			{'roomId':roomId,'rowNo':rowCount,'computer':computer,'roomName':roomName},function(data){
				if(data.indexOf('password') != -1)
				{
					location.reload();
				}
				alert(data);
				});
	
	showRoomDetails(roomId);
}
function DeleteRow(rowId,roomId)
{
	chk=confirm("Are You Sure");
	if(chk)
	{
		$("#roomRow"+rowId).remove();
		/*
		*Data base entry here
		*/
		$.post('index.php?controller=MainController&method=delRoomRow',
				{'roomId':roomId,'rowId':rowId},function(data){
					if(data.indexOf('password') != -1)
					{
						location.reload();
					}
					alert(data);
					});
		showRoomDetails(roomId);
	}
}
function editComputer(rowId)
{
	computer=$("#row"+rowId).html();
	//alert(computer);
	selectButton="<select id='selectRow"+rowId+"' onChange='submitComputerChange("+rowId+")'>";
	for(i=1;i<=20;i++)
	{
		selectButton+="<option ";
		if(computer.trim() == i)
		{
			selectButton+="selected";
		}
		selectButton+=" value="+i+">"+i+" Computer</option>";
	}
	selectButton+="</select>";
	$("#row"+rowId).html(selectButton);
	
}
function submitComputerChange(rowId)
{
	computer=$("#selectRow"+rowId).val();
	/*
	*change in database
	*/
	$.post('index.php?controller=MainController&method=computerUpdate',
			{'computer':computer,'rowId':rowId},function(data){
				if(data.indexOf('password') != -1)
				{
					location.reload();
				}
				alert(data);
				});
	$("#row"+rowId).html(computer);
}
</script>
