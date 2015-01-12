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
    $t = mysqli_query($conn,"SELECT ID,ACTIVATED FROM `USER` WHERE `EMAIL`='{$request['email']}'");
		$row = mysqli_fetch_row($t);
    
	if($row[1] == '') die('{"response": "error","message": "Invalid Login."}');
	else if($row[1] != 1) die('{"response": "error","message": "You must activate your account before logging in."}');
	$uid = $row[0];
	
	if(!$t){die('{"response": "error","message": "Invalid Login."}'); }
	else
	{
      $x = mysqli_query($conn,"SELECT `SALT`, `SLOW_HASH`,`MULTI_LOGIN` FROM `USER_LOGIN` WHERE `ID`='{$uid}'");
      if(!$x){mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $request[email] ."', '[{$_SERVER['PHP_SELF']}] [GET] Unable to pull SQL data.', '". str_replace("'","`",mysqli_error($conn)) ."'," . time() . ");"); echo '{"response": "error","message": "Synclis could not log you in, system error reported."}';}
      else{
        $q = mysqli_fetch_row($x);
			require_once('lib/PasswordHash.php');
			$hash = create_hash($request['password'] . $q[1]);

			$a = pbkdf2("sha1", $request['password'], $q[0], 2, 20, false);
			if ($a === $q[1]) {
				if (validate_password( $request['password'] . $q[1], $hash )) {
						
						$x = mysqli_query($conn,"UPDATE `USER_LOGIN` SET `LOGIN_METHOD` = '". $methodd ."', `IP_ADDRESS` = '". $_SERVER['REMOTE_ADDR'] ."' WHERE  `ID` =  '{$uid}'");	

						if($q[2] ==0)
						{//IF THE USER HAS MULTI LOGIN DISABLED.
								mysqli_query($conn, "DELETE FROM `AUTH_TOKEN` WHERE USER_ID='{$row[0]}'");
								$count = 0;
								//GENERATE SESSION TOKEN -> Redundant Collion check				
								do{
									$sessionToken = gen_uuid();
									$y = mysqli_query($conn,"SELECT EXISTS(SELECT 1 FROM `AUTH_TOKEN` WHERE `HASH_KEY`='{$sessionToken}');");
									$chk = mysqli_fetch_row($y);
									
									$count ++;
									if($count >= 4)
										mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $request[email]."', '[{$_SERVER['PHP_SELF']}] [GET] Severe UUID Collision counter at {$count}. Update UUID Version in login API.', '". str_replace("'","`",mysqli_error($conn)) ."'," . time() . ");");
								}while($chk[0]);
								$z = mysqli_query($conn,"INSERT INTO `AUTH_TOKEN` (`ID`,`USER_ID`, `EXPIRATION`, `HASH_KEY`) VALUES (NULL, '{$row[0]}', '" . (time() + 3600*24*30) . "', '{$sessionToken}')
														 ON DUPLICATE KEY UPDATE `HASH_KEY`='". $sessionToken ."';");
								
								///////////// ERROR REPORTING ///////////////
								if(!$x){mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $request[email]."', '[{$_SERVER['PHP_SELF']}] [GET] Failed to update the user login data in login API.', '". str_replace("'","`",mysqli_error($conn)) ."'," . time() . ");"); echo '{"response": "error","message": "Synclis could not log you in, system error reported."}';}
								else if(!$y){mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $request[email]."', '[{$_SERVER['PHP_SELF']}] [GET] SEVERE: Unable to verify redundant session ID check in login API.', '". str_replace("'","`",mysqli_error($conn)) ."'," . time() . ");"); die('{"response": "error","message": "Synclis could not log you in, system error reported."}');}
								else if(!$z){mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $request[email]."', '[{$_SERVER['PHP_SELF']}] [GET] SEVERE: Unable to process session ID for user in login API.', '". str_replace("'","`",mysqli_error($conn)) ."'," . time() . ");"); die('{"response": "error","message": "Synclis could not log you in, system error reported."}');}
								else{
									echo '{"session_token":"'.$sessionToken.'"}';
								}
						}
						else
						{//THE USER HAS MULTI LOGIN ENABLED.
								$o = mysqli_query($conn,"SELECT `HASH_KEY` FROM `AUTH_TOKEN` WHERE `USER_ID`='{$row[0]}' LIMIT 1");
								
								$sess = mysqli_fetch_row($o);
								
								///////////// ERROR REPORTING ///////////////
								if(!$o){mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $request[email]."', '[{$_SERVER['PHP_SELF']}] [GET] Failed to update the user login data in login API.', '". str_replace("'","`",mysqli_error($conn)) ."'," . time() . ");"); echo '{"response": "error","message": "Synclis could not log you in, system error reported."}';}
								else{echo '{"session_token":"'.$sess[0].'"}';}
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