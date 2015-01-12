<?php
	$username = "brosephs_servlet";
	$password = "ZbAgAZFEulD2xU}[L=";
	$host     = "localhost";/*74.52.151.194*/
	$database = "brosephs_synclis";
	$conn     = mysqli_connect($host,$username,$password,$database);
	
	if (mysqli_connect_errno($conn))
	{
		die("Failed to connect to Server: " . mysqli_connect_error());
	}
	
	unset($database);
	unset($host);
	unset($username);
	unset($password);
?>