<?php
	include('connectToDB.php');

	if(!$_GET['c'] || $_GET['c'] == '' || !base64_decode($_GET['c'], true)){
		echo "Unable to complete your registration, please try again<br/>Redirecting in 3 seconds..";
		echo "<script>setTimeout(function(){ window.location='https://synclis.com/Login'; },3500);</script>";
	}
	else{
		$result = mysqli_query($conn,"UPDATE `USER` SET  `ACTIVATED` =  '1' WHERE  `CLEAN_NAME` ='". $_GET['c'] ."';");
		
		if (!$result) {
			echo "Unexpected error has occured, This is a system error and has been automatically reported.<br/>
				  Unable to complete your registration, please try again<br/>Redirecting in 3 seconds..";
			echo "<script>setTimeout(function(){ window.location='https://synclis.com/Login'; },3500);</script>";
			mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $_GET['c']."', '[{$_SERVER['PHP_SELF']}] [PUT] Unable to complete your registration.', '". str_replace("'","`",mysqli_error()) ."'," . time() . ");");
		}else{
			echo "You have been successfully registered! <br/>Redirecting in 3 seconds...";
			echo "<script>setTimeout(function(){ window.location='https://synclis.com/Login'; },3500);</script>";
		}
	}
	
?>