<?php 
//echo "<pre>";

$last_id=0;
foreach($data['rooms'] as $key => $value)
{
	if ($last_id!=$value['id'])
	{
	$i=0;
	$last_id=$value['id'];
	$room[$value['name']][$i]=$value;
	}
	else
	{
	$room[$value['name']][++$i]=$value;
	}
}
//print_r($room);die;

?>
<style>
#side2, #side1
{
	height:532px;
}
#side1{
	margin-left: 2%;
padding-left:15px;
padding-top:15px;
width: 30%;
border:1px solid black;
float:left;
overflow:scroll;
	margin-left:20px;
}
#side2{
	margin-left: 2%;
padding-top:15px;
width: 60%;
border:1px solid black;
float:left;
overflow:scroll;
	margin-left:20px;
}
#datepicker{
	
	height:30px;
	margin-left: 20px;
    width: 100%;
	
}
.myHover {

	cursor: pointer;
}

</style>

    
<script type="text/javascript">
		$(function() {
			$("#tree").treeview({
				animated: "medium",
				control:"#sidetreecontrol",
				collapsed:true
			});

			 $( "#from" ).datepicker({
				 defaultDate: "+1w",
				 changeMonth: true,
				 numberOfMonths: 3,
				 onClose: function( selectedDate ) {
				 $( "#to" ).datepicker( "option", "minDate", selectedDate );
				 }
				 });
				 $( "#to" ).datepicker({
				 defaultDate: "+1w",
				 changeMonth: true,
				 numberOfMonths: 3,
				 onClose: function( selectedDate ) {
				 $( "#from" ).datepicker( "option", "maxDate", selectedDate );
				 }
				 });
			
		})
	
	
	/**
	*
	* Function to handle adminLogs
	*/
	function adminLogs(id)
	{
		alert(id);
	}
	/**
	*
	* Function to handle roomLogs
	*/
	function roomLogs(name)
	{
		alert(name);
	}
	/**
	*
	* Function to handle rowLogs
	*/
	function rowLogs(name,rowId)
	{
		alert(name+' '+rowId);
	}
	/**
	*
	* Function to handle computerLogs
	*/
	function computerLogs(name,rowId,computerId)
	{
		alert(name+" "+rowId+" "+computerId );
	}
	/**
	*
	* Function to handle empLogs
	*/
	function empLogs(id)
	{
		alert(id);
	}
	/**
	*
	* Function to handle systemLogs
	*/
	function systemLogs(id)
	{
		alert(id);
	}

	

</script>


<!-- Updated for datepicker  -->
<!-- kawaljeet -->
<div id="datepicker">
<label for="from">From</label>
<input type="text" id="from" name="from" />
<label for="to">to</label>
<input type="text" id="to" name="to" />
</div>
<div id="main">

<div id="side1" >
<ul id="tree">
	<li><a href="#" ><strong>Admin</strong></a>
	<ul id="admin">
	<?php 
	foreach($data['users'] as $key => $value)
	{
	?>
		<li><span onclick='adminLogs(<?php echo $value['id']?>)' class='myHover'><?php echo $value['username'];?></span></li>
	<?php 
	}
	?>	
	</ul>
	</li>
	<li><span><strong>Rooms</strong></span>
	<ul id="rooms">
	<?php
	$flag=0;
	$last_id=0; 
	foreach($room as $key => $value)
	{
		//echo "<ul>";
		echo "<li> <span onclick=roomLogs('".$key."') class='myHover'>".$key."</span>";
		if($value[0]['row_number'] != NULL)
		{
			echo "<ul>";
			foreach($value as $key2 => $val2)
			{
				echo "<li><span onclick=rowLogs('".$key."',".$val2['row_id'].") class='myHover'>Row ".$val2['row_number']."</span>";
				if($val2['computer'] > 0)
				{
					echo "<ul>";
					for($i=0;$i < $val2['computer']; $i++)
					{
						echo "<li><span class='myHover' onclick=computerLogs('".$key."',".$val2['row_id'].",".$i.")>Computer ".($i+1)."</span></li>";
					}
					echo "<li></li></ul>";
				}
				echo "</li>";

			}
			echo "<li></li></ul>";
		}
		echo "</li>";
	}
	?>
	<li></li>	
	</ul>
	</li>
	<li><a href="#" ><strong>Team Members</strong></a>
	<ul id="team">
	<?php 
	foreach($data['employee'] as $key => $value)
	{
	?>
		<li><span class='myHover' onclick="empLogs(<?php echo $value['id'] ?>)"><?php echo $value['name'];?></span></li>
	<?php 
	}
	?>	
	<li></li>
	</ul></li>
	</li>
	<li><a href="#" ><strong>Systems</strong></a>
	<ul id="system">
		<li><span class='myHover' onclick="systemLogs('LI')">Login</span></li>
		<li><span class='myHover' onclick="systemLogs('LO')">Logout</span></li>
		<li><span class='myHover' onclick="systemLogs('SA')">Allocation</span></li>
		<li><span class='myHover' onclick="systemLogs('SR')">Reallocation</span></li>
		<li><span class='myHover' onclick="systemLogs('SD')">Trash</span></li>
		<li><span class='myHover' onclick="systemLogs('IR')">Row Add</span></li>
		<li><span class='myHover' onclick="systemLogs('DR')">Row Delete</span></li>
		<li><span class='myHover' onclick="systemLogs('SA')">Seat Add</span></li>
		<li><span class='myHover' onclick="systemLogs('DS')">Seat Delete</span></li>
		<li><span class='myHover' onclick="systemLogs('UA')">User Add</span></li>
		<li><span class='myHover' onclick="systemLogs('PC')"> Edit</span></li>
		<li><span class='myHover' onclick="systemLogs('UD')">User Delete</span></li>
	</ul>
	</li>
<li></li>
</ul>
</div>
<div id="side2">
</div>
</div>
