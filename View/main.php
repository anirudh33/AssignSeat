<!DOCTYPE html>
<html lang="">
<head>  
<title></title>
<link rel="stylesheet" href="<?php echo SITE_URL;?>/assets/css/main.css" type="text/css" media="all">
</head>

<body>

<form id="form1" action="index.php?controller=MainController&method=loginClick" method="post">
  <fieldset>
    <legend>Login</legend>
    <ol>
      <li><label for="field1">User Name</label></li>
      <li><input type="text" id="field1" name="username" /></li>
    </ol>
    <ol>

      <li><label for="field2">Password</label></li>
      <li><input type="password" id="field2" name="password" /></li>
    </ol>
  
    <ol class="buttons">
      <li><input type="submit" class="button" value="Login" /></li>
      <li><input type="reset" class="button" value="Reset" /></li>
    </ol>
  </fieldset>

</form>

</body>

</html>
