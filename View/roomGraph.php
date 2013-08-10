<?php 
// echo "<pre>";
// print_r($data['totalRow']);
//print count($data['totalRow']);
$totalSeat=0;
$emptySeat=0;
foreach($data['totalRow'] as $key=> $value)
{
	$totalSeat +=$value['computer'];
}
$emptySeat=$totalSeat - count($data['seated']);
// print $totalSeat;
// print count($data['seated']);

?>
<div id="rommFullDetails" class="roomDetails">
	<table>
		<tr>
			<td>Room Name :</td>
			<td><?php echo $data['totalRow'][0]['name'];?></td>
		</tr>
		<tr>
			<td>Total Rows :</td>
			<td><?php echo count($data['totalRow']);?></td>
		</tr>
		<tr>
			<td>Total Seat :</td>
			<td><?php echo $totalSeat?></td>
		</tr>		
		<tr>
			<td>Seated :</td>
			<td><?php echo count($data['seated'])?></td>
		</tr>
		<tr>
			<td>Empty Seat:</td>
			<td><?php echo $emptySeat?></td>
		</tr>
	</table>
</div>
<div id="graph" class="roomDetails"><canvas id="cvs" width="368" height="250" !style="border:1px solid #ccc">[No canvas support]</canvas></div>
<div id='seatedEmpDetails' class="allSeatedemp">
	<center><h4 class="seatedEmpTableHead">Seated Team Member Details</h4></center>
	<table>
		<tr>
			<td>Image</td>
			<td>Name</td>
			<td>Designation</td>
			<td>Department</td>
			<td>Row No.</td>
			<td>computer No.</td>
		</tr>
	<?php foreach($data['seated'] as $key => $val) {?>
		<tr>
			<td><img alt="Image" src="data:image/png;base64,<?php echo base64_encode ( $val['user_image'])?>" width='50px'></td>
			<td><?php echo $val['empName']?></td>
			<td><?php echo $val['designation']?></td>
			<td><?php echo $val['department']?></td>
			<td><?php echo $val['row_number']?></td>
			<td><?php echo ($val['seatNo']+1)?></td>
		</tr>
	<?php }?>
	</table>
</div>
<script>
		function CreateGradient (obj, color)
		{
		    return RGraph.RadialGradient(obj, 200, 150, 95, 200, 150, 125, color, 'white')
		}
        $( document ).ready(function ()
        {
            // Create the Pie chart
            var pie = new RGraph.Pie('cvs', [<?php echo $emptySeat?>,<?php echo count($data['seated'])?>]);
            pie.Set('chart.colors', [
                                     CreateGradient(pie, '#ABD874'),
                                     CreateGradient(pie, '#E18D87'),
                                     CreateGradient(pie, '#599FD9'),
                                     CreateGradient(pie, '#F4AD7C'),
                                     CreateGradient(pie, '#D5BBE5')
                                    ])
                .Set('labels', ['Empty', 'Seateded'])
                .Set('text.color', '#a3e')
                .Set('exploded', 5)
                .Set('radius', 90)
                .Draw();
            
                
            // Add the click listener for the third segment
            pie.onclick = function (e, shape)
            {
                if (!pie.Get('exploded') || !pie.Get('chart.exploded')[shape['index']]) {
                    pie.Explode(shape['index'], 25);
                }
                
                e.stopPropagation();
            }
            
            // Add the mousemove listener for the third segment
            pie.onmousemove = function (e, shape)
            {
                e.target.style.cursor = 'pointer';
            }

            // Add the window click listener that resets the Pie chart
            window.onmousedown = function (e)
            {
                pie.Set('exploded', 5);
                RGraph.Redraw();
            }
        });
 </script>
 
 <style>
.roomDetails {
	float: left;
	
}
.roomDetails table{
	padding: 70px 0px 0px 70px;
}
.roomDetails table td{
	color: black;
}
.allSeatedemp {
	clear: both;
	color: black;
}
.allSeatedemp table td{
	border: 1px solid black;
	text-align: center;
	color: black;
}
#roomDetailDiv {
	width: auto;
}
.seatedEmpTableHead {
	color: black;
}
</style>
