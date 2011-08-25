<?php include("head.html"); ?>
    <h2>Account management - Login</h2>
	<form action="main.php" method="post">
	<table>
	<tr><td>Username:</td><td><input type="text" name="uid" /></td></tr>
	<tr><td><input type="checkbox" name="rdn" value="y" /></td><td>User ID is distinguished name</td></tr>
	<tr><td>Password:</td><td><input type="password" name="pw" /></td></tr>
	<tr><td /><td><input type="submit" value="Login" /></td></tr>
	</table>
	</form>
<?php include("foot.html"); ?>    

