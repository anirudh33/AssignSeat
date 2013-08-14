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
		<li><a href="#"><?php echo $value['username'];?></a></li>
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
		echo "<li>".$key;
		if($value[0]['row_number'] != NULL)
		{
			echo "<ul>";
			foreach($value as $key2 => $val2)
			{
				echo "<li>Row ".$val2['row_number'];
				if($val2['computer'] > 0)
				{
					echo "<ul>";
					for($i=0;$i < $val2['computer']; $i++)
					{
						echo "<li>Computer ".($i+1)."</li>";
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
		<li><a href="#"><?php echo $value['name'];?></a></li>
	<?php 
	}
	?>	
	<li></li>
	</ul></li>
	</li>
	<li><a href="#" ><strong>Systems</strong></a>
	<ul id="system">
		<li><a href="#">Login</a></li><li><a href="#">Logout</a></li><li><a href="#">Allocation</a></li>
		<li><a href="#">Reallocation</a></li><li><a href="#">Trash</a></li><li><a href="#">Row Add</a></li>
		<li><a href="#">Row Delete</a></li><li><a href="#">Seat Add</a></li><li><a href="#">Seat Delete</a></li>
		<li><a href="#">User Add</a></li><li><a href="#">User Edit</a></li><li><a href="#">User Delete</a></li>
	</ul>
	</li>
<li></li>
</ul>
</div>
<div id="side2">
</div>
</div>
