<?php //echo "<pre>";/
//print_r($data);die;
?>
<style>
#side2, #side1
{
	height:400px;
}
#side1{
	margin-left: 2%;
padding-left:15px;
padding-top:15px;
width: 30%;
border:1px solid black;
float:left;
overflow:scroll;
}
#side2{
	margin-left: 2%;
padding-top:15px;
width: 60%;
border:1px solid black;
float:left;
overflow:scroll;
}

</style>

<script type="text/javascript">
		$(function() {
			$("#tree").treeview({
				collapsed: true,
				animated: "medium",
				control:"#sidetreecontrol",
				persist: "location"
			});
		})
		

</script>

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
	$last_id=0; 
	foreach($data['rooms'] as $key => $value)
	{
		if($last_id == 0)
		{
			echo "<li>".$value['name']."</li>";
			if($value['row_number']==NULL)
			{
				$last_id=1;
				echo "<ul>";
			}
		}
		else 
		{
			
		}
	}
	?>	
	</ul>
	</li>
	<li>
	</li>
</ul>
</div>
<div id="side2">
</div>
</div>