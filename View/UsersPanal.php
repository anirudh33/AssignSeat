<script>
var prev = "";
 function deleteuser(fetch)
  {
	var r=confirm("Are u Sure???");
	if (r == true)
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
	
  
  }
 $(function(){
		$("#newUserForm").fancybox({	    
		    closeClick : false, // prevents closing when clicking INSIDE fancybox
		    helpers : {
		    overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
		    }
		    });
	 });

  function changePassword(fetch)
  {
  var pass = document.getElementById("new").value;
  var oldpass = document.getElementById("old").value;
  
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
  function hideDiv(fetch)
  {
  $("#open").html("");
  $("#show_"+fetch).html("");
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
  $("#show_"+fetch).html("<p>Old Password: <input type='password' name='old_passd' required='required' id='old'></p><p> New Password: <input type='password' name='new_passd' required='required' id='new'></p><span style='margin:60px;'><input type='button' value='Confirm' onclick=changePassword('"+fetch+"')></span><input type='button' value='Cancel' onclick=hideDiv('"+fetch+"')>");
  
  }

  function createUser()
  {
  	$.ajax( {
  	    type: "POST",
  	    url: 'index.php?controller=MainController&method=createUser',
  	    data: $("#userCreateForm").find(":input").serialize(),
  	    success: function( data ) {
  				if(data.indexOf('Password') != -1)
  			{
  				location.reload();
  			}
  	      alert(data);
  	      getUsersPanal();
  	    }
  	  } );
  }
    
</script>
<div style="margin:70px 280px;boder=1px solid red;">
  <a href="#createNewUsers"  id='newUserForm' ><h3>Create New User</h3></a>
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
  <?php $val = $data[$i]['username'];?>
  
  <tr>
    <td style="text-align:center;"><?php print_r($data[$i]['username']); ?></td>
    <td id="show_<?php echo $data[$i]['id']; ?>"></td>
    <?php if($_SESSION ["username"] !=  $val ){?>
    <td style="text-align:center;"><a href="#" onclick="editUser('<?php echo $data[$i]['id']; ?>')">Edit</a> | <a href="#" onclick="deleteuser('<?php echo $data[$i]['id']; ?>')">Delete</a></td>
    <?php } 
   else{?>
   <td style="text-align:center;"><a href="#" onclick="editUser('<?php echo $data[$i]['id']; ?>')">Edit</a></td>
  <?php } ?>
  </tr>
<?php } ?>
  </table>
</div>

<div id='createNewUsers' style='display: none'>
<form action="" id="userCreateForm" method="Post">
  <table>
   <tr>
    <td>Login Id : </td> <td><input type="text" name="user" required="required"></td>
   </tr>
   <tr>
    <td>Password : </td> <td><input type="password" name="password" required="required"></td>
   </tr>
   <tr>
    <td>Confirm Password : </td> <td><input type="password" name="c_password" required="required"></td>
   </tr>
   <tr>
    <td></td> <td><input type="button" value="Create User" onclick="createUser()"></td>
   </tr>
  </table>
</form>
</div>

