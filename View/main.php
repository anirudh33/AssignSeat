<html lang="">
<head>  
<title></title>
<link rel="stylesheet" href="<?php echo SITE_URL;?>/assets/css/main.css" type="text/css" media="all">
<?php
if(!isset($_SESSION['loginStatus']))
{
	$_SESSION['loginStatus']="true"	;
?>
<script>
window.location.reload();
</script>
<?php
}
?>
</head>

<body>

<form id="form1" action="index.php?controller=MainController&method=loginClick" method="post">
  <fieldset>
    <legend><?php echo $lang->LOGIN?></legend>
    <ol>
      <li><label for="field1"><?php echo $lang->USERNAME?></label></li>
      <li><input type="text" id="field1" name="username" /></li>
    </ol>
    <ol>

      <li><label for="field2"><?php echo $lang->PASSWORD?></label></li>
      <li><input type="password" id="field2" name="password" /></li>
    </ol>
  
    <ol class="buttons">
      <li><input type="submit" class="button" value="<?php echo $lang->LOGIN?>"/></li>
      <li><input type="reset" class="button" value="<?php echo $lang->RESET?>"/></li>
    </ol>
  </fieldset>

</form>
<div id="errors">
<?php if(isset($_SESSION['msg'])) { ?>
	<h3 style = "text-align:center;"><?php echo $lang->ERRORMSG?></h3>
<center>
<?php echo $_SESSION['msg'];
}?>
</center>
</div>
</body>
</html>
