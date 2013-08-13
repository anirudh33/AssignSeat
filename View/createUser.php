<html>
<head>
</head>

<body>
 <form action="index.php?controller=MainController&method=createUser" method="Post">
  <table>
   <tr>
    <td>User Login Id : </td> <td><input type="text" name="user" required="required"></td>
   </tr>
   <tr>
    <td>Password : </td> <td><input type="password" name="password" required="required"></td>
   </tr>
   <tr>
    <td>Confirm Password : </td> <td><input type="password" name="c_password" required="required"></td>
   </tr>
   <tr>
    <td></td> <td><input type="submit" value="Create User"></td>
   </tr>
  </table>
</form>
</body>
</html>
