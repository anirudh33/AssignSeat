<html>
<head>

<script>
var prev = "";
 function deleteuser(fetch)
  {
  $.ajax({
  type: "POST",
  url: 'index.php?controller=MainController&method=deleteUser&value='+fetch,
  success: function(data){
	if(data.indexOf('Password') != -1)
			{
				location.reload();
			}
	      alert(data);
	      getUsersPanal();
  }
  });
  }
 function loadForm(fetch)
  {
  $.ajax({
  type: "POST",
  url: 'View/createUser.php',
  success: function(data){

  $("#formpanel").html(data);
  }
  });
  }

  function changePassword(fetch)
  {
  var pass = document.getElementById(fetch).value;
  var oldpass = document.getElementById(prev).value;
  $.ajax({
  
  type: "POST",
  url: 'index.php?controller=MainController&method=changePassword&value='+fetch+'&passwd='+pass+'&old_passwd='+oldpass,
  success: function(data){
if(data.indexOf('Login') != -1)
			{
				location.reload();
			}
	      alert(data);
	      getUsersPanal();  }
  });
  }

  function editUser(fetch)
  {
  if(prev != ""){
  $("#show_"+prev).html("");
  prev = fetch; 
  }
  else{
  prev = fetch;
  }
  $("#open").html("Change Password");
  $("#show_"+fetch).html("<p>Old Password: <input type='password' name='old_password' required='required' id='"+prev+"'></p><p> New Password: <input type='password' name='password' required='required' id='"+fetch+"'></p><span style='float:center;'><input type='button' value='Confirm' onclick=changePassword('"+fetch+"')></span>");
  
  }
</script>

</head>

<body>

<div style="margin:70px 280px;boder=1px solid red;">
  <a href="#" onclick="loadForm()"><h3>Create New User</h3></a>
  <div id="formpanel">
  </div>
</div>
<div style="margin:70px 180px;">

  <table border="1" cellpadding="5" style="width:580px;">
   <tr>
    <th>User Name</th>
    <th id="open"></th>
    <th>Options</th>
   </tr>
<?php for($i=0; $i<count($data);$i++){?>
  <tr>
    <td style="text-align:center;"><?php print_r($data[$i]['username']); ?></td>
    <td id="show_<?php echo $data[$i]['id']; ?>"></td>
    <td style="text-align:center;"><a href="#" onclick="editUser('<?php echo $data[$i]['id']; ?>')">Edit</a> | <a href="#" onclick="deleteuser('<?php echo $data[$i]['id']; ?>')">Delete</a></td>
  </tr>
<?php } ?>
  </table>
</div>
</body>
</html>
