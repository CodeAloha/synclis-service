<?php
	include('../connectToDB.php');
	include('lib/core.php');

	if($method == 'POST')
	{//[POST]: 
		if( ctype_alnum(str_replace('.', '', $request['appName'])) ){
			$apiKey = sha1 ( $request['appName'] );  
			$secretKey = md5(time() . rand());
			
			$s = mysqli_query($conn, "INSERT INTO `USER_APIAUTH` (`ID`, `USER`, `APP_NAME`, `API_KEY`, `API_SECRET`, `SALT`, `ACTIVATED`)
									  VALUES (NULL, '1', '{}', '{$apiKey}', '{$secretKey}', '". mt_rand() ."', '1');");	

			///////////// ERROR REPORTING ///////////////
			if(!$s){mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, 'API KEY GEN', '[{$_SERVER['PHP_SELF']}] [GET] Failed to forge an API KEY set.', '". str_replace("'","`",mysql_error()) ."'," . time() . ");");}
			else{ echo '{"response":"success","message":"Successfully created the API Key."}'; }
			///////////// END ERROR REPORTING ///////////	
		}else{
			echo '{"response":"error","message":"App Name is invalid, it may only contain numbers, letters, and \'.\'s "}';
		}
	}
?>