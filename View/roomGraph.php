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
	<div id='delImage' class='multiDelImag'></div>
	<form id="multiDelForm">
	<table>
		<tr>
			<td><input type="checkbox" id="masterChk" onchange='masterChkBox()' value='0' style="display: block; margin: 10px"></td>
			<td>Image</td>
			<td>Name</td>
			<td>Designation</td>
			<td>Department</td>
			<td>Row No.</td>
			<td>computer No.</td>
		</tr>
	<?php foreach($data['seated'] as $key => $val) {?>
		<tr>
			<td><input type="checkbox" onchange='childChkBox(this)'  style="display: block; margin: 10px" name='multiDel[]' class='empIdMultiDel' value='<?php echo $val['seatedEmpId'];?>'></td>
			<td><img alt="Image" src="data:image/png;base64,<?php echo base64_encode ( $val['user_image'])?>" width='42px' height='39px'></td>
			<td><?php echo $val['empName']?></td>
			<td><?php echo $val['designation']?></td>
			<td><?php echo $val['department']?></td>
			<td><?php echo $val['row_number']?></td>
			<td><?php echo ($val['seatNo']+1)?></td>
		</tr>
	<?php }?>
	</table>
	</form>
</div>
<script>
			function masterChkBox()
			{
				arrChkBox=$('.empIdMultiDel');
				getVal=$("#masterChk").val();
				if(getVal==0 && arrChkBox.length > 0)
				{
					
					$("#masterChk").val('1');
					for(i=0; i < arrChkBox.length ; i++)
					{
						arrChkBox[i].checked=1;
					}
					$('.masterChk').attr('Checked','Checked');
					$('#delImage').html('<img src="assets/images/bin.png" width="45px" height="45px" onclick="delMultipleEmp()" style="cursor: pointer;">');
				}
				else
				{
					$("#masterChk").val('0');
					for(i=0; i < arrChkBox.length ; i++)
					{
						arrChkBox[i].checked=0;
					}
					$('.masterChk').removeAttr('Checked'); 	
					$('#delImage').html('');				
				}
					
			}

			function delMultipleEmp()
			{
				var multiChk=confirm('Are Sure to delete');
				if(multiChk)
				{
					var msg=prompt("Please give some valid reason:","")
					if((msg.trim()).length >25 && (msg.trim()).length < 250)
					{
						var validReason=htmlEscape(msg);
						
						$.ajax( {
					        type: "POST",
					        url: 'index.php?controller=MainController&method=multiDelEmp',
					        data: $("#multiDelForm").find(":input").serialize()+"&reason="+validReason,
					        success: function( data ) {
				      			if(data.indexOf('Reset') != -1)
			        			{
			        				location.reload();
			        			}
					          alert(data);
					          location.reload();
					        }
					      } );
					}
					else
					{
						alert('Error in Reason Words grater than 25 and less than 250');
					}
				}
			    
			}

			function htmlEscape(str) {
			    return String(str)
			            .replace(/&/g, '&amp;')
			            .replace(/"/g, '&quot;')
			            .replace(/'/g, '&#39;')
			            .replace(/</g, '&lt;')
			            .replace(/>/g, '&gt;');
			}

			function childChkBox(obj)
			{
				var i=0,j=0;
				arrChkBox=$('.empIdMultiDel');
				for(i=0; i < arrChkBox.length ; i++)
				{
					if(arrChkBox[i].checked)
					{
						break;
					}
				}

				for(j=0; j < arrChkBox.length ; j++)
				{
					if(!(arrChkBox[j].checked))
					{
						break;
					}
				}
				
				if(i < arrChkBox.length) 
				{
					$('#delImage').html('<img src="assets/images/bin.png" width="45px" height="45px" onclick="delMultipleEmp()" style="cursor: pointer;">');
					if( j == arrChkBox.length)
					{
						$("#masterChk").val('1');
						masertChkBox=document.getElementById("masterChk");
						masertChkBox.checked=1;						
					}
				}
				else
				{
					$('#delImage').html('');
				}
				if(!(obj.checked))
				{
					$(obj).removeAttr('Checked');
					$("#masterChk").val('0');
					masertChkBox=document.getElementById("masterChk");
					masertChkBox.checked=0;
				}
			}
		 


		
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
.multiDelImag {
	padding-left: 50px;
}
.roomDetails table{
	padding: 50px 0px 0px 50px;
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
