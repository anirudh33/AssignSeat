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
	color:#ffffff;
	margin:5px;
}
.form-item
{
	margin:10px;
	padding:10px;
	border:1px;
}
</style>
<script type="text/javascript" charset="utf-8">
var dept;
var deptvalue;
var deptarr = new Array("corephp");
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
		else
		{
			if(deptvalue != deptvaluearr[jQuery.inArray(dept, deptarr)])
			alert(deptvaluearr[jQuery.inArray(dept, deptarr)]);
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
 </script>
</head>
<div style="width: 500px;">
  <div id="picker" style="float: right;"></div>
<?php
$departments = array("drupal" , "sugarcrm" , "zend" , "corephp");
for($i = 0 ; $i < count($departments) ; $i ++)
{
?>
	<div class="form-item">
		<span> <?php echo $departments[$i] ; ?></span>
		<input type="text" id="<?php echo $departments[$i] ; ?>" class="colorwell" value="#123456" />
	</div>
	
<?php
}
?>
  
</div>

