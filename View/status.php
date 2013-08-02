<?php
$k = 0;
$count = count($data);
echo "<div id='rows'>";
if($_REQUEST['area'] == 'Lab-1')
echo $_REQUEST['value1'];
for($i=0;$i<$_REQUEST['value2'];$i++)
{
	
	if(!empty($data))
	{
		if($data[$k]['computer_id'] == ($i) && ($data[$k]['status'] == 1))
		{
			if(($count - 1) > ($k)){
			$k ++;
            
            }
            
	?>       
	
			<div id="<?php echo $_REQUEST['area'].'_'.$_REQUEST['value1'].'_'.$i;?>" class="cols"><img id="<?php echo $data[$k]['eid'];?>" class="dragable dragged custom_tooltip" src="images/red_chair.gif" height=20 width=30 /></div>

	<?php
		}
		else
		{
		?>
				<div class="cols droppable dropped" id="<?php echo $_REQUEST['area'].'_'.$_REQUEST['value1'].'_'.$i;?>"><img src="images/green_chair.jpeg" class="custom_tooltip" height="18" width="30" /></div>
		<?php
			
		}
	}
	else
	{
	?>
			<div class="cols droppable dropped" id="<?php echo $_REQUEST['area'].'_'.$_REQUEST['value1'].'_'.$i;?>"><img src="images/green_chair.jpeg" class="custom_tooltip" height="18" width="30" /></div>
	<?php
	}
	
?>
		<script>dragdropevent();</script> 
<?php
}
echo "</div>";
	echo "<br style='clear:both'>";

?>


