
<?php 

$k = 0;

$count = count($value);
for($i=0;$i<$_REQUEST['value2'];$i++){
if($value[$k]['computer_id'] == ($i + 1)){
if($count < $k)
$k ++;

?>
<div id="<?php echo $_REQUEST['area'].'_'.$_REQUEST['value1'].'_'.$i;?>" class="cols"><img id="<?php echo $value[$k]['eid'];?>"class="dragable dragged" src="images/red_chair.png" height=20 width=30 /></div>


<?php } 

else {?>

<div class="cols droppable dropped" id="<?php echo $_REQUEST['area'].'_'.$_REQUEST['value1'].'_'.$i;?>"><img src="images/green_chair.png" height="18" width="30" /></div>
<?php } ?><script>dragdropevent();</script> 
<?php
}
echo "<br/>";
?>

