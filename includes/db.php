<?php
	$server = getenv('HOST');
	$username = getenv('USER_NAME');
	$password = getenv('PASSWORD');
	$database = getenv('DB');	
	
	$conn = mysqli_connect($server, $username, $password, $database);
?>