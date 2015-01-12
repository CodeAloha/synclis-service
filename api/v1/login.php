<?php
	include('../connectToDB.php');
	include('lib/core.php');
	include('lib/tools.php');
/*
[LOGIN API] Synclis Service RESTFUL API

Request permitted only within server.

 
 [GET] Email       AUTH-REQ 
 [GET] Password    AUTH-REQ
 [GET] Login-Method
*/


/*/////////////////////////////////
	DATA VALIDATION CHECK
*//////////////////////////////////
	if($method == 'GET'){
		if($request['password'] == ''){
			die('{"response": "error","message": "Error with login procedure, please refer to API documentation."}'); 
		}

		if(!filter_var($request['email'], FILTER_VALIDATE_EMAIL)){ die('{"response": "error","message": "Invalid Email Address."}'); }
		
		if($request['login-method'] == ''){
			$methodd = 'Web';
		}
		else{
			$methodd = $request['login-method'];
		}

	
/*/////////////////////////////////
	LOGIN SERVICE
*//////////////////////////////////
    $t = mysqli_query($conn,"SELECT ID FROM `USER` WHERE `EMAIL`='{$request['email']}'");
		$row = mysqli_fetch_row($t);
		$uid = $row[0];
    
	if(!$t){die('{"response": "error","message": "Invalid Login."}'); }
	else
	{
      $x = mysqli_query($conn,"SELECT `PASSWORD`, `SALT`, `SLOW_HASH` FROM `USER_LOGIN` WHERE `ID`='{$uid}'");
      if(!$x){mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $request[email] ."', '[{$_SERVER['PHP_SELF']}] [GET] Unable to pull SQL data.', '". str_replace("'","`",mysqli_error()) ."'," . time() . ");"); echo '{"response": "error","message": "Synclis could not log you in, system error reported."}';}
      else{
        $q = mysqli_fetch_row($x);
			require_once('lib/PasswordHash.php');
			$hash = create_hash($q[0] . $q[1]);

			// Test vector hex output.
			$a = pbkdf2("sha1", $q[0], $q[1], 2, 20, false);
			if ($a === $q[2]) {
				if (validate_password( $q[0] . $q[1], $hash )) {

						$x = mysqli_query($conn,"UPDATE `USER_LOGIN` SET `LOGIN_METHOD` = '". $methodd ."', `IP_ADDRESS` = '". $_SERVER['REMOTE_ADDR'] ."' WHERE  `ID` =  '{$uid}'");	

						//GENERATE SESSION TOKEN
						$sessionToken = gen_uuid();
						$y = mysqli_query($conn,"INSERT INTO `AUTH_TOKEN` (`ID`,`USER_ID`, `EXPIRATION`, `HASH_KEY`) VALUES (NULL, '{$row[0]}', '" . (time() + 3600*24*30) . "', '{$sessionToken}')
												 ON DUPLICATE KEY UPDATE `HASH_KEY`='". $sessionToken ."';");
						
						///////////// ERROR REPORTING ///////////////
						if(!$x){mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $request[email]."', '[{$_SERVER['PHP_SELF']}] [GET] Failed to login the user.', '". str_replace("'","`",mysqli_error()) ."'," . time() . ");"); echo '{"response": "error","message": "Synclis could not log you in, system error reported."}';}
						///////////// END ERROR REPORTING ///////////
						else{
							echo '{"session_token":"'.$sessionToken.'"}';
						}
			
				
				} else {
					die('{"response": "error", "message": "Invalid Login."}');
				}
			} else { 
				die('{"response": "error", "message": "Invalid Login."}');
			}

			
			
      }
    }
  }else{
		_response('Invalid Method', 405);
		echo '{"response": "error","message": "Method supplied does not exist."}';
	}


?>