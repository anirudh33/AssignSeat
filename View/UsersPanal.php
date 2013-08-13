<html>
<head>
<script>
 function deleteuser(fetch)
  {
  $.ajax({
  type: "POST",
  url: 'index.php?controller=MainController&method=deleteUser&value='+fetch,
  success: function(data){

  $("#adminpanel").html(data);
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
</script>

</head>

<body>

<div style="margin:70px 280px;boder=1px solid red;">
  <a href="#" onclick="loadForm()"><h3>Create New User</h3></a>
  <div id="formpanel">
  </div>
</div>
<div style="margin:70px 280px;">

  <table border="1" cellpadding="10">
   <tr>
    <th>User Name</th>
    <th>Options</th>
   </tr>
<?php for($i=0; $i<count($data);$i++){?>
  <tr>
    <td><?php print_r($data[$i]['username']); ?></td>
    <td><a href="#">Edit</a> | <a href="#" onclick="deleteuser('<?php echo $data[$i]['id']; ?>')">Delete</a></td>
  </tr>
<?php } ?>
  </table>
</div>
</body>
</html>
