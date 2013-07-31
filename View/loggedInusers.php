<h3><u>Login Users</u></h3>
<table>
<?php
$loggedInUsers = array ();
$files = glob ( "./tmp/*.txt" );
foreach ( $files as $key => $values ) {
	if (basename ( $values, ".txt" ) != 'README' && basename ( $values, ".txt" ) != $_SESSION ['username']) {
		?>
  	
	
		<tr>
			<td><img src='./images/loggedin' height="20" width="20" /></td>
			<td><?php echo basename($values,".txt");?></td>
		</tr>
  	
  <?php
	
}
}

?>
</table>