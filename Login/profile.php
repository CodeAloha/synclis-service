<?php
	// config and whatnot
    $config = dirname(__FILE__) . '/hybridauth/config.php';
    require_once( "hybridauth/Hybrid/Auth.php" );
	include( "connectToDB.php" );

	$user_data = NULL;

	// try to get the user profile from an authenticated provider
	try{
		$hybridauth = new Hybrid_Auth( $config );

		// selected provider name 
		$provider = @ trim( strip_tags( $_GET["provider"] ) );

		// check if the user is currently connected to the selected provider
		if( !  $hybridauth->isConnectedWith( $provider ) ){ 
			// redirect him back to login page
			header( "Location: login.php?error=Your are not connected to $provider or your session has expired" );
		}

		// call back the requested provider adapter instance (no need to use authenticate() as we already did on login page)
		$adapter = $hybridauth->getAdapter( $provider );

		// grab the user profile
		$user_data = $adapter->getUserProfile();
    }
	catch( Exception $e ){  
		// In case we have errors 6 or 7, then we have to use Hybrid_Provider_Adapter::logout() to 
		// let hybridauth forget all about the user so we can try to authenticate again.

		// Display the recived error, 
		// to know more please refer to Exceptions handling section on the userguide
		switch( $e->getCode() ){ 
			case 0 : echo "Unspecified error."; break;
			case 1 : echo "Hybriauth configuration error."; break;
			case 2 : echo "Provider not properly configured."; break;
			case 3 : echo "Unknown or disabled provider."; break;
			case 4 : echo "Missing provider application credentials."; break;
			case 5 : echo "Authentication failed. " 
					  . "The user has canceled the authentication or the provider refused the connection."; 
			case 6 : echo "User profile request failed. Most likely the user is not connected "
					  . "to the provider and he should to authenticate again."; 
				   $adapter->logout(); 
				   break;
			case 7 : echo "User not connected to the provider."; 
				   $adapter->logout(); 
				   break;
		} 

		mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)
		VALUES (NULL, '0', '[{$_SERVER['PHP_SELF']}] [GET] Failed to create a bookmark for a listing.', '". 'oAuth Sign Up Error:' . $e->getMessage() . $e->getTraceAsString() ."'," . time() . ");");
		
		header('Location: https://synclis.com/Login?msg=Error');
		echo '<script>window.location="https://synclis.com/Login?msg=Error";</script>';
		
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en">
<head> 
</head>
<body>  
<?php
	if( $user_data && ($user_data->email !='') && !$_COOKIE['SYNCLIS_AUTH'] )
	{

				
					$sample_res = mysqli_query($conn, "SELECT `ID` FROM `USER` WHERE `EMAIL`='". $user_data->email ."' LIMIT 1");
					if(mysqli_num_rows($sample_res) >= 1)
					{//Auto Login
						do{
							$sessionToken = gen_uuid();
							$y = mysqli_query($conn,"SELECT EXISTS(SELECT 1 FROM `AUTH_TOKEN` WHERE `HASH_KEY`='{$sessionToken}');");
							$chk = mysqli_fetch_row($y);
							
							$count ++;
							if($count >= 4)
								mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $user_data->email ."', '[{$_SERVER['PHP_SELF']}] [GET] Severe UUID Collision counter at {$count}. Update UUID Version in login API.', '". str_replace("'","`",mysqli_error()) ."'," . time() . ");");
						}while($chk[0]);
						
						$USER_ID = mysqli_fetch_row($sample_res);
						
						$z = mysqli_query($conn,"INSERT INTO `AUTH_TOKEN` (`ID`,`USER_ID`, `EXPIRATION`, `HASH_KEY`) VALUES (NULL, '{$USER_ID[0]}', '" . (time() + 3600*24*30) . "', '{$sessionToken}')
												 ON DUPLICATE KEY UPDATE `HASH_KEY`='". $sessionToken ."';");
						
						if(!$z){mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $user_data->email ."', '[{$_SERVER['PHP_SELF']}] [GET] SEVERE: Unable to process session ID for user in login API.', '". str_replace("'","`",mysqli_error()) ."'," . time() . ");"); echo '<script>window.location="https://synclis.com/Login/?msg=BadLogin";</script>';}
						else{
							?>
								<script>
									document.cookie = "SYNCLIS_TOKEN" + "=<?php echo $sessionToken; ?>; max-age=" + 60 * 60 * 24 * 90 + "; path=/";
									document.cookie = "SYNCLIS_TOKEN" + "=<?php echo $sessionToken; ?>; max-age=" + 60 * 60 * 24 * 90 + "; path=/Sections";
									document.cookie = "SYNCLIS_TOKEN" + "=<?php echo $sessionToken; ?>; max-age=" + 60 * 60 * 24 * 90 + "; path=/Listings";
									document.cookie = "SYNCLIS_TOKEN" + "=<?php echo $sessionToken; ?>; max-age=" + 60 * 60 * 24 * 90 + "; path=/ViewListing";
									document.cookie = "SYNCLIS_TOKEN" + "=<?php echo $sessionToken; ?>; max-age=" + 60 * 60 * 24 * 90 + "; path=/Profile";
									document.cookie = "SYNCLIS_TOKEN" + "=<?php echo $sessionToken; ?>; max-age=" + 60 * 60 * 24 * 90 + "; path=/CreateListings";
									window.location="https://synclis.com/Sections/";
								</script>
								<p style = "font-family: 'Lucida Grande','Lucida Sans Unicode',Verdana,sans-serif; color: #333; font-size: 18px; margin:0 auto;">
								If you had Javascript enabled, we wouldn't be having this problem now wouldn't we?</p>
							<?php
						}
					}
					else
					{/*User has not signed up for an account with Synclis and we're inputting their appropriate fields into the server.*/

	do{
		$uniqkey = makeKey();
		$y = mysqli_query($conn,"SELECT EXISTS(SELECT 1 FROM `USER` WHERE `CLEAN_NAME`='{$uniqkey}');");
		$chk = mysqli_fetch_row($y);
	}while($chk[0]);
	
	//Receive User Geolocation and IP Data

	$_ip = new ip_codehelper();
	$real_client_ip_address = $_SERVER['REMOTE_ADDR'];
	$json = file_get_contents("http://ipinfo.io/{$_SERVER['REMOTE_ADDR']}");
	$details = json_decode($json);
	
	$CountryName = $details->country;
	$CityName  = $details->city; 
	$RegionName = $details->region;
	
	//Process User password with Salt and PBKDF2
	$salt = mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);
	$a = pbkdf2("sha1", $user_data->identifier, $salt, 2, 20, false);
	$random_key = hash("whirlpool", microtime(). $user_data->identifier);
	$vowels = array("`", "'","-","#",'"');
	$salt = str_replace($vowels, "", $salt);
	
	
	$s = mysqli_query($conn, "INSERT INTO `USER` (`ID`, `FIRST_NAME`, `LAST_NAME`, `ADDRESS`, `COUNTRY`, `PROVIDENCE`, `CITY`, `ZIP`, `EMAIL`, `CLEAN_NAME`,`REGISTERED`,`ACTIVATED`,`PROFILE_IMG`,`AGE_YEAR`,`LANGUAGE`)
	VALUES (NULL, '". $user_data->firstName ."', '". $user_data->lastName ."', '". $user_data->address ."','{$CountryName}','{$RegionName}','{$CityName}','" . $user_data->zip . "','". $user_data->email ."','" . $uniqkey . "','". time() ."','1','". $user_data->photoURL ."','". $user_data->birthYear ."','". $user_data->language ."');");	
	
	$next =mysqli_insert_id($conn);
	
	$t = mysqli_query($conn, "INSERT INTO `USER_LOGIN` (`ID`, `SALT`,`LOGIN_METHOD`,`SLOW_HASH`,`IP_ADDRESS`,`P_RESET`)
	VALUES ('". $next ."', '{$salt}', 'New', '{$a}','{$real_client_ip_address}','{$random_key}');");	
	
	
	$u = mysqli_query($conn, "INSERT INTO `USER_PROFILE` (`ID`, `PREFERENCES`,`SKILLS`,`BUSINESS`,`TRADE`,`BIO`,`LOCSETTING`,`TIMEZONE`,`PORTFOLIO_JSON`,`SERVICES_JSON`,`EDUCATION_JSON`,`EXPERIENCE_JSON`)
	VALUES ('". $next ."', '', '', '0','Member','Hello, my name is ". $user_data->firstName ." ". $user_data->lastName .".','0','-7.0','[]','[]','[]','[]');");	
	
	//Send Authentication Email
	
// multiple recipients
$to  = $user_data->email; // note the comma

// subject
$subject = '[Synclis] Set a password for your account ' . $user_data->firstName;

// message
$message = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html><head><title></title><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta name="viewport" content="width=320, target-densitydpi=device-dpi"><style type="text/css">/* Mobile-specific Styles */@media only screen and (max-width: 660px) { table[class=w0], td[class=w0] { width: 0 !important; }table[class=w10], td[class=w10], img[class=w10] { width:10px !important; }table[class=w15], td[class=w15], img[class=w15] { width:5px !important; }table[class=w30], td[class=w30], img[class=w30] { width:10px !important; }table[class=w60], td[class=w60], img[class=w60] { width:10px !important; }table[class=w125], td[class=w125], img[class=w125] { width:80px !important; }table[class=w130], td[class=w130], img[class=w130] { width:55px !important; }table[class=w140], td[class=w140], img[class=w140] { width:90px !important; }table[class=w160], td[class=w160], img[class=w160] { width:180px !important; }table[class=w170], td[class=w170], img[class=w170] { width:100px !important; }table[class=w180], td[class=w180], img[class=w180] { width:80px !important; }table[class=w195], td[class=w195], img[class=w195] { width:80px !important; }table[class=w220], td[class=w220], img[class=w220] { width:80px !important; }table[class=w240], td[class=w240], img[class=w240] { width:180px !important; }table[class=w255], td[class=w255], img[class=w255] { width:185px !important; }table[class=w275], td[class=w275], img[class=w275] { width:135px !important; }table[class=w280], td[class=w280], img[class=w280] { width:135px !important; }table[class=w300], td[class=w300], img[class=w300] { width:140px !important; }table[class=w325], td[class=w325], img[class=w325] { width:95px !important; }table[class=w360], td[class=w360], img[class=w360] { width:140px !important; }table[class=w410], td[class=w410], img[class=w410] { width:180px !important; }table[class=w470], td[class=w470], img[class=w470] { width:200px !important; }table[class=w580], td[class=w580], img[class=w580] { width:280px !important; }table[class=w640], td[class=w640], img[class=w640] { width:300px !important; }table[class*=hide], td[class*=hide], img[class*=hide], p[class*=hide], span[class*=hide] { display:none !important; }table[class=h0], td[class=h0] { height: 0 !important; }p[class=footer-content-left] { text-align: center !important; }#headline p { font-size: 30px !important; }.article-content, #left-sidebar{ -webkit-text-size-adjust: 90% !important; -ms-text-size-adjust: 90% !important; }.header-content, .footer-content-left {-webkit-text-size-adjust: 80% !important; -ms-text-size-adjust: 80% !important;}img { height: auto; line-height: 100%;} } /* Client-specific Styles */#outlook a { padding: 0; }/* Force Outlook to provide a "view in browser" button. */body { width: 100% !important; }.ReadMsgBody { width: 100%; }.ExternalClass { width: 100%; display:block !important; } /* Force Hotmail to display emails at full width *//* Reset Styles */body { background-color: #f9f9f9; margin: 0; padding: 0; }img { outline: none; text-decoration: none; display: block;}br, strong br, b br, em br, i br { line-height:100%; }h1, h2, h3, h4, h5, h6 { line-height: 100% !important; -webkit-font-smoothing: antialiased; }h1 a, h2 a, h3 a, h4 a, h5 a, h6 a { color: blue !important; }h1 a:active, h2 a:active, h3 a:active, h4 a:active, h5 a:active, h6 a:active {color: red !important; }h1 a:visited, h2 a:visited, h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited { color: purple !important; }table td, table tr { border-collapse: collapse; }.yshortcuts, .yshortcuts a, .yshortcuts a:link,.yshortcuts a:visited, .yshortcuts a:hover, .yshortcuts a span {color: black; text-decoration: none !important; border-bottom: none !important; background: none !important;}</style><!--[if gte mso 9]><style _tmplitem="498" >.article-content ol, .article-content ul { margin: 0 0 0 24px; padding: 0; list-style-position: inside;}</style><![endif]--></head><body style="font-family: \'Lucida Grande\', \'Lucida Sans Unicode\', Verdana, sans-serif;"><table width="100%" cellpadding="0" cellspacing="0" border="0" id="background-table"><tbody><tr><td align="center" bgcolor="#f9f9f9"> <table class="w640" style="margin:0 10px;" width="640" cellpadding="0" cellspacing="0" border="0"> <tbody><tr><td class="w640" width="640" height="20"></td></tr> <tr> <td class="w640" width="640"> <table style="border-radius:6px 6px 0px 0px; -moz-border-radius: 6px 6px 0px 0px; -webkit-border-radius:6px 6px 0px 0px; -webkit-font-smoothing: antialiased; background-color: #f1f1f1; color: #ededed;" class="w640" width="640" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff"> <tbody><tr> <td class="w15" width="15"></td> <td class="w325" width="350" valign="middle" align="left"> <table class="w325" width="350" cellpadding="0" cellspacing="0" border="0"> <tbody><tr><td class="w325" width="350" height="8"></td></tr> </tbody></table> <table class="w325" width="350" cellpadding="0" cellspacing="0" border="0"> <tbody><tr><td class="w325" width="350" height="8"></td></tr> </tbody></table> </td> <td class="w30" width="30"></td> <td class="w255" width="255" valign="middle" align="right"> <table class="w255" width="255" cellpadding="0" cellspacing="0" border="0"> <tbody><tr><td class="w255" width="255" height="8"></td></tr> </tbody></table> <table cellpadding="0" cellspacing="0" border="0"><tbody><tr><td valign="middle"><fblike likeurl="https://www.facebook.com/Synclis"><img src="https://img.createsend1.com/img/templatebuilder/like-glyph.png" border="0" width="8" height="14" alt="Facebook icon"=""></fblike></td><td width="3"></td><td valign="middle"><div style="font-size: 12px; color: #3CC1B8; -webkit-text-size-adjust: none; -ms-text-size-adjust: none;"><fblike likeurl="https://www.facebook.com/Synclis">Like</fblike></div></td><td class="w10" width="10"></td><td valign="middle"><tweet><img src="https://img.createsend1.com/img/templatebuilder/tweet-glyph.png" border="0" width="17" height="13" alt="Twitter icon"=""></tweet></td><td width="3"></td><td valign="middle"><div style="font-size: 12px; color: #3CC1B8; -webkit-text-size-adjust: none; -ms-text-size-adjust: none;"><tweet>Tweet</tweet></div></td></tr></tbody></table> <table class="w255" width="255" cellpadding="0" cellspacing="0" border="0"> <tbody><tr><td class="w255" width="255" height="8"></td></tr> </tbody></table> </td> <td class="w15" width="15"></td> </tr></tbody></table> </td> </tr> <tr><td id="header" class="w640" width="640" align="center" bgcolor="#ffffff"><div align="center" style="text-align: center"><br/><a href="https://synclis.com"><img id="customHeaderImage" label="Header Image" width="250" src="https://synclis.com/media/mlogo.png" class="w640" border="0" align="top" style="display: inline"></a></div></td> </tr> <tr><td class="w640" width="640" height="30" bgcolor="#ffffff"></td></tr> <tr id="simple-content-row"><td class="w640" width="640" bgcolor="#ffffff"> <table align="left" class="w640" width="640" cellpadding="0" cellspacing="0" border="0"> <tbody><tr> <td class="w30" width="30"></td> <td class="w580" width="580"> <table class="w580" width="580" cellpadding="0" cellspacing="0" border="0"><tbody><tr><td class="w580" width="580"><p align="left" style="font-size: 18px; line-height:24px; color: #1FB5AC; margin-top:0px; margin-bottom:18px; font-family: \'Lucida Grande\', \'Lucida Sans Unicode\', Verdana, sans-serif;">You have recently signed up for Synclis.</p><div align="left" style="font-size: 13px; line-height: 18px; color: #777777; margin-top: 0px; margin-bottom: 18px; font-family: \'Lucida Grande\', \'Lucida Sans Unicode\', Verdana, sans-serif; font-size: 13px; line-height: 18px; color: #777777;">'. $user_data->firstName . ' ' . $user_data->lastName . ',<br/><br/>Thank you for signing up with Synclis through '. $adapter->id .',<br/>You can set a password for your account with following link provided below in the case that you have not yet.<br/><i style="color:#1FB5AC;">If this is a mistake,</i> then please disregard this email.<br/><br/><a style = "color: #3CC1B8; font-weight:bold; text-decoration:none;" href = "https://synclis.com/Login/ResetPass/'. $random_key .'">Click here to activate your account.</a></div></td></tr><tr><td class="w580" width="580" height="10"></td></tr></tbody></table> </td> <td class="w30" width="30"></td> </tr> </tbody></table></td></tr> <tr><td class="w640" width="640" height="15" bgcolor="#ffffff"></td></tr> <tr> <td class="w640" width="640"> <table id="footer" class="w640" width="640" cellpadding="0" cellspacing="0" border="0" bgcolor="#f1f1f1"> <tbody><tr><td class="w30" width="30"></td><td class="w580 h0" width="360" height="30"></td><td class="w0" width="60"></td><td class="w0" width="160"></td><td class="w30" width="30"></td></tr> <tr> <td class="w30" width="30"></td> <td class="w580" width="360" valign="top"> <span class="hide"><p id="permission-reminder" align="left" class="footer-content-left"></p></span> <p align="right" class="footer-content-right" style="-webkit-text-size-adjust: none; -ms-text-size-adjust: none; font-family: \'Lucida Grande\', \'Lucida Sans Unicode\', Verdana, sans-serif; background-color: #f1f1f1; color: #777777; font-size: 12px; line-height: 15px; color: #777777; margin-top: 0px; margin-bottom: 15px;">&copy; Synclis 2014. | <a style="color: #3CC1B8; text-decoration:none; font-weight:normal;" href="https://synclis.com/About" >Discover Synclis</a> </td> <td class="hide w0" width="60"></td> <td class="hide w0" width="160" valign="top"> <p id="street-address" align="right" class="footer-content-right"></p> </td> <td class="w30" width="30"></td> </tr> <tr><td class="w30" width="30"></td><td class="w580 h0" width="360" height="15"></td><td class="w0" width="60"></td><td class="w0" width="160"></td><td class="w30" width="30"></td></tr> </tbody></table></td> </tr> <tr><td class="w640" width="640" height="60"></td></tr> </tbody></table> </td></tr></tbody></table></body></html>';
// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'To: '. $user_data->firstName .' ' . $user_data->lastName . ' <'. $user_data->email .'>' . "\r\n";
$headers .= 'From: Synclis <no-reply@synclis.com>' . "\r\n";

// Mail it
mail($to, $subject, $message, $headers);
	
	///////////// ERROR REPORTING ///////////////
	if(!$s){mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $user_data->email ."', '[{$_SERVER['PHP_SELF']}] [GET] Unable to create a users security profile.', '". str_replace("'","`",mysqli_error($conn)) ."'," . time() . ");");}
else if(!$t){mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $user_data->email ."', '[{$_SERVER['PHP_SELF']}] [GET] Unable to create a user.', '". str_replace("'","`",mysqli_error($conn)) ."'," . time() . ");"); }
else{ 
	echo '<script>window.location="https://synclis.com/Login/ResetPass/' . $random_key . '";</script>';
}
	///////////// END ERROR REPORTING ///////////					
						
					}
					
	}
	else
	{/*No User Data Found*/
		echo '<script>window.location="https://synclis.com/Login?msg=NoLogin";</script>';
	}


	
/*PHP TOOLS*/
	
function makeKey()
{
	$chars = str_split("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ");
	$index = mt_rand(0, 6);
	for ($i = $index; $i < 15; $i++)
	{
		$randNum = mt_rand(0, 61);
		$key .= $chars[$randNum];
	}
	return $key;
} 
function gen_uuid()
{//GENERATE A UNIVERSALLY UNIQUE IDENTIFIER FOR SESSION-ID
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

        // 16 bits for "time_mid"
        mt_rand( 0, 0xffff ),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand( 0, 0x0fff ) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand( 0, 0x3fff ) | 0x8000,

        // 48 bits for "node"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
}

				?>

</body>
</html>
