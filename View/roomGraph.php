<?php 
// echo "<pre>";
//print_r($data);
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
<canvas id="cvs" width="480" height="250" !style="border:1px solid #ccc">[No canvas support]</canvas>
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
