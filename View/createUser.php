<script type="text/javascript">
function createUser()
{
	$.ajax( {
	    type: "POST",
	    url: 'index.php?controller=MainController&method=createUser',
	    data: $("#userCreateForm").find(":input").serialize(),
	    success: function( data ) {
				if(data.indexOf('Reset') != -1)
			{
				location.reload();
			}
	      alert(data);
	      getUsersPanal();
	    }
	  } );
}
  
</script>
<html>
<head>
</head>

<body>
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
</body>
</html>
