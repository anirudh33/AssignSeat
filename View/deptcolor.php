<script type="text/javascript" src="assets/js/farbtastic.js"></script>
<link rel="stylesheet" href="assets/css/farbtastic.css" type="text/css" />
<style type="text/css" media="screen">
.colorwell
{
	border: 2px solid #fff;
	width: 6em;
	text-align: center;
	cursor: pointer;
}
span
{
	color:#000000;
	margin:5px;
}
.form-item
{
	margin:10px;
	padding:10px;
	border:1px;
}

.vpb_main_wrapper
{
	
	margin: 200px;
	border: solid 1px #cbcbcb;
	 background-color: #FFF;
	 box-shadow: 0 0 15px #cbcbcb;
	-moz-box-shadow: 0 0 15px #cbcbcb;
	-webkit-box-shadow: 0 0 15px #cbcbcb;
	-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;
	padding:10px;
	font-family:Verdana, Geneva, sans-serif;
	font-size:11px;
}
</style>
<script type="text/javascript" charset="utf-8">
var dept;
var deptvalue;
var deptarr = new Array();
var deptvaluearr = new Array();
var k = 0;
$(document).ready(function()
{
	var f = $.farbtastic('#picker');
	var p = $('#picker').css('opacity', 0.25);
	var selected;
	$('.colorwell').each(function () 
	{
		
		f.linkTo(this);
		$(this).css('opacity', 0.75);
	}).focus(function() 
	{
		
		dept = this.id;
		deptvalue = this.value;
		
		if($.inArray(dept, deptarr) === -1)
		{
			deptarr[k] = dept;
			deptvaluearr[k] = deptvalue;
			k ++;			
		}
		
		if (selected) 
		{
			$(selected).css('opacity', 0.75).removeClass('colorwell-selected');
        	}
        	f.linkTo(this);
        	p.css('opacity', 1);
        	$(selected = this).css('opacity', 1).addClass('colorwell-selected');
      	});
});
function saveDeptColor()
{
	$.ajax
	({
		type: "POST",
		data: $('#frmid').serialize(),
		url: 'index.php?controller=MainController&method=saveDeptColor',
		success: function(data)
		{
			alert(data);
		}
	});
}
</script>
</head>
<form  action="#" id="frmid" class="vpb_main_wrapper">
<table cellpadding="15">
<?php
$count =1;
for($i = 0 ; $i < count($data) ; $i ++)
{
?>
	<tr class="form-item">
		<td>
			<span> <?php echo ucfirst($data[$i]['department']) ; ?></span>
		</td>
		<td>
		<?php if(defined(strtoupper(str_replace(' ', '',$data[$i]['department'])))) 
		{		
		?>
		
			<input type="text" id="<?php echo $data[$i]['department']; ?>" class="colorwell" value="<?php echo constant(strtoupper(str_replace(' ', '',$data[$i]['department']))) ; ?>" name="<?php echo str_replace(' ', '',$data[$i]['department']); ?>" maxlength="7"/>
		<?php
		}
		else
		{
		?>
			<input type="text" id="<?php echo $data[$i]['department']; ?>" class="colorwell" value="#000000" name="<?php echo str_replace(' ', '',$data[$i]['department']); ?>" size="7"/>
		<?php
		}
		?>
		</td>
		<?php
		if($count == 1)
		{
		?>
			<td id="picker" rowspan="<?php echo count($data) + 1; ?>">
			</td>
		<?php
		$count = 0;
		}
		?>
	</tr>
<?php
}
?>
<tr>
<td colspan="2" align="center">
<input type="button"  onclick="saveDeptColor()" value="save"/>
</td>
</tr>
</table> 
</form>
