<?php 
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
/*border:1px solid black;*/
float:left;
overflow-y:scroll;
	margin-left:20px;
}
#side2{
	margin-left: 2%;
padding-top:15px;
width: 60%;
/*border:1px solid black;*/
float:left;
overflow-y:scroll;
	margin-left:20px;
}
.sysLogs {
	height: auto;
	width: auto; 
	padding: 20px;
	margin: 1px;
	background-color: white; 

	/* outer shadows  (note the rgba is red, green, blue, alpha) */
	-webkit-box-shadow: 0px 0px 12px rgba(0, 0, 0, 0.4); 
	-moz-box-shadow: 0px 1px 6px rgba(23, 69, 88, .5);

	/* rounded corners */
	-webkit-border-radius: 12px;
	-moz-border-radius: 7px; 
	border-radius: 7px;
	
	/* gradients */
	background: -webkit-gradient(linear, left top, left bottom, 
	color-stop(0%, white), color-stop(15%, white), color-stop(100%, #D7E9F5)); 
	background: -moz-linear-gradient(top, white 0%, white 55%, #D5E4F3 130%); 
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
				 maxDate: "+0D",
				 onClose: function( selectedDate ) {
				 $( "#to" ).datepicker( "option", "minDate", selectedDate );
				 }
				 });
				 $( "#to" ).datepicker({
				 defaultDate: "+1w",
				 changeMonth: true,
				 numberOfMonths: 3,
				 maxDate: "+0D",
				 onClose: function( selectedDate ) {
				 $( "#from" ).datepicker( "option", "maxDate", selectedDate );
				 }
				 });
			
		});

		$(function(){
			var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1; //January is 0!

			var yyyy = today.getFullYear();
			if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} today = mm+'/'+dd+'/'+yyyy;
						
			$('#from').val(today);
			$('#to').val(today);
			})
	
	
	/**
	*
	* Function to handle adminLogs
	*/
	function adminLogs(id)
	{
		//alert(id);
		fromDate=$('#from').val();
		toDate=$('#to').val();
		logFor='admin';
		$.post('index.php?controller=MainController&method=fetchLogs',
				{
			'fromDate':fromDate,
			'toDate': toDate,
			'logFor': logFor,
			'adminId': id
			},function(data){
				if(data.indexOf('Password') != -1)
				{
					location.reload();
				}
					allLogs=jQuery.parseJSON(data);
					$('#side2').html('');
					$.each(allLogs ,function(key,value){
						$.each(value,function(key2,val2){
							$('#side2').append("<div class='sysLogs'>"+val2+"</div>");
							$('#side2').append('<br\>');
							});
						});
				});
	}
	/**
	*
	* Function to handle roomLogs
	*/
	function roomLogs(name)
	{
		fromDate=$('#from').val();
		toDate=$('#to').val();
		logFor='rooms';
		$.post('index.php?controller=MainController&method=fetchLogs',
				{
			'fromDate':fromDate,
			'toDate': toDate,
			'logFor': logFor,
			'roomName': name
			},function(data){
				if(data.indexOf('Password') != -1)
				{
					location.reload();
				}
					allLogs=jQuery.parseJSON(data);
					$('#side2').html('');
					$.each(allLogs ,function(key,value){
						$.each(value,function(key2,val2){
							$('#side2').append("<div class='sysLogs'>"+val2+"</div>");
							$('#side2').append('<br\>');
							});
						});
				});
	}
	/**
	*
	* Function to handle rowLogs
	*/
	function rowLogs(name,rowId)
	{
		fromDate=$('#from').val();
		toDate=$('#to').val();
		logFor='row';
		$.post('index.php?controller=MainController&method=fetchLogs',
				{
			'fromDate':fromDate,
			'toDate': toDate,
			'logFor': logFor,
			'roomName': name,
			'rowId' : rowId
			},function(data){
				if(data.indexOf('Password') != -1)
				{
					location.reload();
				}
					allLogs=jQuery.parseJSON(data);
					$('#side2').html('');
					$.each(allLogs ,function(key,value){
						$.each(value,function(key2,val2){
							$('#side2').append("<div class='sysLogs'>"+val2+"</div>");
							$('#side2').append('<br\>');
							});
						});
				});
	}
	/**
	*
	* Function to handle computerLogs
	*/
	function computerLogs(name,rowId,computerId)
	{
		fromDate=$('#from').val();
		toDate=$('#to').val();
		logFor='computer';
		$.post('index.php?controller=MainController&method=fetchLogs',
				{
			'fromDate':fromDate,
			'toDate': toDate,
			'logFor': logFor,
			'roomName': name,
			'rowId' : rowId,
			'computer' : computerId
			},function(data){
				if(data.indexOf('Password') != -1)
				{
					location.reload();
				}
					allLogs=jQuery.parseJSON(data);
					$('#side2').html('');
					$.each(allLogs ,function(key,value){
						$.each(value,function(key2,val2){
							$('#side2').append("<div class='sysLogs'>"+val2+"</div>");
							$('#side2').append('<br\>');
							});
						});
				});
	}
	/**
	*
	* Function to handle empLogs
	*/
	function empLogs(id)
	{
		fromDate=$('#from').val();
		toDate=$('#to').val();
		logFor='employee';
		$.post('index.php?controller=MainController&method=fetchLogs',
				{
			'fromDate':fromDate,
			'toDate': toDate,
			'logFor': logFor,
			'empId': id,
			},function(data){
				if(data.indexOf('Password') != -1)
				{
					location.reload();
				}
					allLogs=jQuery.parseJSON(data);
					$('#side2').html('');
					$.each(allLogs ,function(key,value){
						$.each(value,function(key2,val2){
							$('#side2').append("<div class='sysLogs'>"+val2+"</div>");
							$('#side2').append('<br\>');
							});
						});
				});
	}
	/**
	*
	* Function to handle systemLogs
	*/
	function systemLogs(id)
	{
		fromDate=$('#from').val();
		toDate=$('#to').val();
		logFor='system';
		$.post('index.php?controller=MainController&method=fetchLogs',
				{
			'fromDate':fromDate,
			'toDate': toDate,
			'logFor': logFor,
			'sysAction': id,
			},function(data){
				if(data.indexOf('Password') != -1)
				{
					location.reload();
				}
					allLogs=jQuery.parseJSON(data);
					$('#side2').html('');
					$.each(allLogs ,function(key,value){
						$.each(value,function(key2,val2){
							$('#side2').append("<div class='sysLogs'>"+val2+"</div>");
							$('#side2').append('<br\>');
							});
						});
				});
	}
</script>
<!-- Updated for datepicker  -->
<!-- kawaljeet -->
<center><h1>System Report</h1></center>
<div id="datepicker">
<label for="from">From</label>
<input type="text" id="from" name="from" readonly/>
<label for="to">to</label>
<input type="text" id="to" name="to" readonly/>
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
			$rowCount=0;
			foreach($value as $key2 => $val2)
			{
				$rowCount++;
				echo "<li><span onclick=rowLogs('".$key."',".$rowCount.") class='myHover'>Row ".$val2['row_number']."</span>";
				if($val2['computer'] > 0)
				{
					echo "<ul>";
					for($i=0;$i < $val2['computer']; $i++)
					{
						echo "<li><span class='myHover' onclick=computerLogs('".$key."',".$rowCount.",".$i.")>Computer ".($i+1)."</span></li>";
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
		<li><span class='myHover' onclick="systemLogs('IS')">Seat Add</span></li>
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