<?php
	include('../connectToDB.php');
	include('lib/core.php');
/*
[LISTINGS API] ATLAS Servlet Service RESTFUL API

Request permitted only within server.

 Standard response:
 [ALL] KEY         AUTH-REQ 
 [ALL] SECRET      AUTH-REQ
 
 [POST,DELETE,PUT] ID
 [POST] NAME
 [POST] DESCRIPTION
 [POST] TYPE
 [POST] CATEGORY
 [POST] IMAGE
 [POST] COUNTRY, PROVIDENCE, CITY    |    LAT,LONG
 [POST] AGE_FILTER
 [POST] HASH62
 
 ** [ Country, Providence, and City will be obtained automatically. ] **
 ** [ Clean Name will be generated automatically. 62-bit Clean URL identifier ] **
*/


/*/////////////////////////////////
	DATA VALIDATION CHECK
*//////////////////////////////////


	/*/////////////////////////////////
		DATA VALIDATION CHECK
	*//////////////////////////////////
	
	if($request['first_name'] != '')
	{//CHECK FOR FIRST NAME---------------------------------------
		if( strlen ( $request['first_name'] ) >= 31) { die('{"response": "error","message": "Your First name is too long, maximum 31 characters allowed."}'); }
		if(ctype_alpha($request['first_name']) === false){ die('{"response": "error","message": "Your First name may only contain Alphabet Letters."}'); }
	}
	if($request['last_name'] != '')
	{//CHECK FOR LAST NAME---------------------------------------
		if( strlen ( $request['last_name'] ) >= 31) { die('{"response": "error","message": "Your Last name is too long, maximum 31 characters allowed."}'); }
		if(ctype_alpha($request['last_name']) === false){ die('{"response": "error","message": "Your First name may only contain Alphabet Letters."}'); }
	}
	if($request['email'] != '')
	{//CHECK FOR EMAIL---------------------------------------------
		if (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) { die('{"response": "error","message": "Invalid email provided."}'); }
		$dcheck = mysqli_query($conn, "SELECT `ID` FROM `USER` WHERE `EMAIL` =  '{$request['email']}'");
		$count = mysqli_num_rows($dcheck);
		if($count > 0){ die('{"response": "error","message": "A user with this email has already been assigned."}'); }
	}
	if($request['address'] != '')
	{//CHECK FOR ADDRESS-----------------------------------------
		if( strlen ( $request['address'] ) >= 255) { die('{"response": "error","message": "Your address is too long, maximum 255 characters allowed."}'); }
		if (preg_match('/^[ \w#-]+$/', $text) == $request['address'] ){ die('{"response": "error","message": "Please provide an street-level address with a valid formate e.g. 300 Hollywood Lane Suite #110."}'); }
	}
	if($request['password'] != '')
	{//CHECK FOR PASSWORD-----------------------------------------
		//if( strlen ( $request['password'] ) != 128) { die('{"response": "error","message": "Invalid password provided too short."}'); }
		if( !preg_match('/^[0-9a-f]{128}$/i', $request['password'])  ){ die('{"response": "error","message": "Invalid password provided."}'); }
	}
	
	if($request['zipcode'] != '')
	{//CHECK FOR ZIPCODE------------------------------------------
		if(!is_numeric( $request['zipcode'] )) { die('{"response": "error","message": "The zipcode may only be numeric."}'); }
		if($request['zipcode'] > 999999999 )   { die('{"response": "error","message": "The zipcode may only be 9 digits or less."}'); }
	}
	if($request['skills'] != '')
	{//CHECK FOR SKILLS---------------------------------------------
		$s = str_replace(',','',$request['skills']);
		if(!preg_match('/([a-zA-Z0-9]|[a-zA-Z0-9\,])/', $s)){ die('{"response": "error","message": "Users skills must be in the following format: TAG,TAG,TAG,TAG "}'); }
	}
	if($request['preferences'] != '')
	{//CHECK FOR PREFERENCES-----------------------------------------
		$t = str_replace(',','',$request['preferences']);
		if(!preg_match('/([a-zA-Z0-9]|[a-zA-Z0-9\,])/', $t)){ die('{"response": "error","message": "Users preferences must be in the following format: TAG,TAG,TAG,TAG "}'); }
	}
	if($request['clean_name'] != '')
	{//CHECK FOR CLEAN_NAME------------------------------------------
		if(!ctype_alnum($request['clean_name'])){ die('{"response": "error","message": "URL Identifier must be Alphanumeric."}'); }
	}
	if($request['age'] != '')
	{//CHECK FOR AGE-------------------------------------------------
		if(!preg_match('/^[0-9]$/i', $request['age']) ){ die('{"response": "error","message": "Year of birth must be a number."}'); }
		if($request['age'] >= (date("Y")-13) ){ die('{"response": "error","message": "You must be at least 13 years of age, your account is now under inspection."}'); }
	}
	if($a['language']    != '')
	{//CHECK FOR LANGUAGE---------------------------------------------
		if($a['language'] != 'en' &&
		   $a['language'] != 'sp' &&
		   $a['language'] != 'fr' &&
		   $a['language'] != 'ch' &&
		   $a['language'] != 'jp' &&
		   $a['language'] != 'ar' )
		   die('{"response": "error","message": "Invalid language code."}');
	}
	if($a['multi_login']  != '')
	{//CHECK Multi Login Settings--------------------------------------
		     if($a['multi_login'] == 'true') $a['multi_login'] = 1;
		else if($a['multi_login'] == 'false') $a['multi_login'] = 0;
	}
	if($a['business']    != '')
	{//CHECK FOR Business-----------------------------------------------
		     if($a['business'] == 'true') $a['business'] = 1;
		else if($a['business'] == 'false')$a['business'] = 0;
	}
	if($a['trade']    != '')
	{//CHECK FOR Trade-----------------------------------------------
		if( strlen ( $request['trade'] ) > 31) { die('{"response": "error","message": "Your Profession is too long, maximum 32 characters allowed."}'); }
		if(ctype_alnum(str_replace(' ', '', $request['trade'])) === false) { die('{"response": "error","message": "[Synclis API] - The Profession of your listing may only contain Letters, and spaces."}'); }
	}
	if($a['location_setting'] != '')
	{//CHECK FOR AGE-------------------------------------------------
		if(!preg_match('/^[0-9]$/i', $request['location_setting']) ){ die('{"response": "error","message": "Location Setting setting is invalid."}'); }
		if($request['location_setting'] >= 3){ die('{"response": "error","message": "Location Setting is invalid."}'); }
	}
	if($a['timezone'] != ''){
		if(!is_float($a['timezone'])){ die('{"response": "error","message": "Timezone settings are incorrect."}'); }
	}
	
/*/////////////////////////////////
	API SERVICE
*//////////////////////////////////

if($method == 'POST')
{//[POST]: 
	if($request['first_name']   == ''){ die('{"response": "error","message": "Your First Name is required."}'); }
	if($request['last_name']     == ''){ die('{"response": "error","message": "Your Last Name is required."}'); }
	if($request['address']     == ''){ die('{"response": "error","message": "Your Address is required."}'); }
	if($request['zipcode']     == ''){ die('{"response": "error","message": "Your Zipcode is required."}'); }
	if($request['email']        == ''){ die('{"response": "error","message": "Your Email is required."}'); }
	if($request['password']        == ''){ die('{"response": "error","message": "A password is required."}'); }

	if($request['image'] != '')
		$imagess = "https://synclis.com/media/profileimg/". uploadImage() . ".png";
	else
		$imagess = "";
	
	//Continuously Generate unitil Unique Key
	do{
		$uniqkey = makeKey();
		$y = mysqli_query($conn,"SELECT EXISTS(SELECT 1 FROM `USER` WHERE `CLEAN_NAME`='{$uniqkey}');");
		$chk = mysqli_fetch_row($y);
	}while($chk[0]);
	
	//Receive User Geolocation and IP Data
		$json = file_get_contents("http://ipinfo.io/{$_SERVER['REMOTE_ADDR']}");
		$details = json_decode($json);

	$real_client_ip_address = $details->country;
	$visitor_location       = $details->city; 
	$real_client_ip_address =  $details->region;
	
	//Process User password with Salt and PBKDF2
	$salt = mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);
	$a = pbkdf2("sha1", $request['password'], $salt, 2, 20, false);
	
	$s = mysqli_query($conn, "INSERT INTO `USER` (`ID`, `FIRST_NAME`, `LAST_NAME`, `ADDRESS`, `COUNTRY`, `PROVIDENCE`, `CITY`, `ZIP`, `EMAIL`, `CLEAN_NAME`,`REGISTERED`,`ACTIVATED`)
	VALUES (NULL, '{$request['first_name']}', '{$request['last_name']}', '{$request['address']}','{$visitor_location['CountryName']}','{$visitor_location['RegionName']}','{$visitor_location['CityName']}','{$request['zipcode']}','{$request['email']}','" . $uniqkey . "','". time() ."','0');");	
	
	$vowels = array("`", "'","-","#");
	$salt = str_replace($vowels, "", $salt);
	
	$nextVal = mysqli_insert_id($conn);
	
	$u = mysqli_query($conn, "INSERT INTO `USER_LOGIN` (`ID`, `SALT`,`LOGIN_METHOD`,`SLOW_HASH`,`IP_ADDRESS`)
	VALUES ('". $nextVal ."', '{$salt}', 'New', '{$a}','{$real_client_ip_address}');");
	
	$t = mysqli_query($conn, "INSERT INTO `USER_PROFILE` (`ID`, `PREFERENCES`,`SKILLS`,`BUSINESS`,`TRADE`,`BIO`,`LOCSETTING`,`TIMEZONE`,`PORTFOLIO_JSON`,`SERVICES_JSON`,`EDUCATION_JSON`,`EXPERIENCE_JSON`)
	VALUES ('". $nextVal ."', '{$request['preferences']}', '{$request['skills']}', '0','Member','Hello, my name is {$request['first_name']} {$request['last_name']}.','0','-7.0','[]','[]','[]','[]');");	
	
	
	///////////// ERROR REPORTING ///////////////
	 if(!$s){mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $request[email] ."', '[{$_SERVER['PHP_SELF']}] [GET] Unable to create a users security profile.', '". str_replace("'","`",mysqli_error($conn)) ."'," . time() . ");"); echo '{"response": "error","message": "Oops. It seems that we have discovered a bug, the error report has been automatically to technical support."}';}
else if(!$t){mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $request[email] ."', '[{$_SERVER['PHP_SELF']}] [GET] Unable to create a user.', '". str_replace("'","`",mysqli_error($conn)) ."'," . time() . ");"); echo '{"response": "error","message": "Oops. It seems that we have discovered a bug, the error report has been automatically to technical support."}';}
else if(!$u){mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $request[email] ."', '[{$_SERVER['PHP_SELF']}] [GET] Unable to create a user profile.', '". str_replace("'","`",mysqli_error($conn)) ."'," . time() . ");"); echo '{"response": "error","message": "Oops. It seems that we have discovered a bug, the error report has been automatically to technical support."}';}
	else{ echo '{"response":"success","message":"Welcome to Synclis, ' . $request['first_name'] .' '. $request['last_name']  .'"}'; }
	///////////// END ERROR REPORTING ///////////		
	
	//Send Authentication Email
	
// multiple recipients
$to  = $request['email']; // note the comma

// subject
$subject = '[Synclis] Register your Account ' . $request['first_name'];

// message
$message = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html><head><title></title><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta name="viewport" content="width=320, target-densitydpi=device-dpi"><style type="text/css">/* Mobile-specific Styles */@media only screen and (max-width: 660px) { table[class=w0], td[class=w0] { width: 0 !important; }table[class=w10], td[class=w10], img[class=w10] { width:10px !important; }table[class=w15], td[class=w15], img[class=w15] { width:5px !important; }table[class=w30], td[class=w30], img[class=w30] { width:10px !important; }table[class=w60], td[class=w60], img[class=w60] { width:10px !important; }table[class=w125], td[class=w125], img[class=w125] { width:80px !important; }table[class=w130], td[class=w130], img[class=w130] { width:55px !important; }table[class=w140], td[class=w140], img[class=w140] { width:90px !important; }table[class=w160], td[class=w160], img[class=w160] { width:180px !important; }table[class=w170], td[class=w170], img[class=w170] { width:100px !important; }table[class=w180], td[class=w180], img[class=w180] { width:80px !important; }table[class=w195], td[class=w195], img[class=w195] { width:80px !important; }table[class=w220], td[class=w220], img[class=w220] { width:80px !important; }table[class=w240], td[class=w240], img[class=w240] { width:180px !important; }table[class=w255], td[class=w255], img[class=w255] { width:185px !important; }table[class=w275], td[class=w275], img[class=w275] { width:135px !important; }table[class=w280], td[class=w280], img[class=w280] { width:135px !important; }table[class=w300], td[class=w300], img[class=w300] { width:140px !important; }table[class=w325], td[class=w325], img[class=w325] { width:95px !important; }table[class=w360], td[class=w360], img[class=w360] { width:140px !important; }table[class=w410], td[class=w410], img[class=w410] { width:180px !important; }table[class=w470], td[class=w470], img[class=w470] { width:200px !important; }table[class=w580], td[class=w580], img[class=w580] { width:280px !important; }table[class=w640], td[class=w640], img[class=w640] { width:300px !important; }table[class*=hide], td[class*=hide], img[class*=hide], p[class*=hide], span[class*=hide] { display:none !important; }table[class=h0], td[class=h0] { height: 0 !important; }p[class=footer-content-left] { text-align: center !important; }#headline p { font-size: 30px !important; }.article-content, #left-sidebar{ -webkit-text-size-adjust: 90% !important; -ms-text-size-adjust: 90% !important; }.header-content, .footer-content-left {-webkit-text-size-adjust: 80% !important; -ms-text-size-adjust: 80% !important;}img { height: auto; line-height: 100%;} } /* Client-specific Styles */#outlook a { padding: 0; }/* Force Outlook to provide a "view in browser" button. */body { width: 100% !important; }.ReadMsgBody { width: 100%; }.ExternalClass { width: 100%; display:block !important; } /* Force Hotmail to display emails at full width *//* Reset Styles */body { background-color: #f9f9f9; margin: 0; padding: 0; }img { outline: none; text-decoration: none; display: block;}br, strong br, b br, em br, i br { line-height:100%; }h1, h2, h3, h4, h5, h6 { line-height: 100% !important; -webkit-font-smoothing: antialiased; }h1 a, h2 a, h3 a, h4 a, h5 a, h6 a { color: blue !important; }h1 a:active, h2 a:active, h3 a:active, h4 a:active, h5 a:active, h6 a:active {color: red !important; }h1 a:visited, h2 a:visited, h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited { color: purple !important; }table td, table tr { border-collapse: collapse; }.yshortcuts, .yshortcuts a, .yshortcuts a:link,.yshortcuts a:visited, .yshortcuts a:hover, .yshortcuts a span {color: black; text-decoration: none !important; border-bottom: none !important; background: none !important;}</style><!--[if gte mso 9]><style _tmplitem="498" >.article-content ol, .article-content ul { margin: 0 0 0 24px; padding: 0; list-style-position: inside;}</style><![endif]--></head><body style="font-family: \'Lucida Grande\', \'Lucida Sans Unicode\', Verdana, sans-serif;"><table width="100%" cellpadding="0" cellspacing="0" border="0" id="background-table"><tbody><tr><td align="center" bgcolor="#f9f9f9"> <table class="w640" style="margin:0 10px;" width="640" cellpadding="0" cellspacing="0" border="0"> <tbody><tr><td class="w640" width="640" height="20"></td></tr> <tr> <td class="w640" width="640"> <table style="border-radius:6px 6px 0px 0px; -moz-border-radius: 6px 6px 0px 0px; -webkit-border-radius:6px 6px 0px 0px; -webkit-font-smoothing: antialiased; background-color: #f1f1f1; color: #ededed;" class="w640" width="640" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff"> <tbody><tr> <td class="w15" width="15"></td> <td class="w325" width="350" valign="middle" align="left"> <table class="w325" width="350" cellpadding="0" cellspacing="0" border="0"> <tbody><tr><td class="w325" width="350" height="8"></td></tr> </tbody></table> <table class="w325" width="350" cellpadding="0" cellspacing="0" border="0"> <tbody><tr><td class="w325" width="350" height="8"></td></tr> </tbody></table> </td> <td class="w30" width="30"></td> <td class="w255" width="255" valign="middle" align="right"> <table class="w255" width="255" cellpadding="0" cellspacing="0" border="0"> <tbody><tr><td class="w255" width="255" height="8"></td></tr> </tbody></table> <table cellpadding="0" cellspacing="0" border="0"><tbody><tr><td valign="middle"><fblike likeurl="https://www.facebook.com/Synclis"><img src="https://img.createsend1.com/img/templatebuilder/like-glyph.png" border="0" width="8" height="14" alt="Facebook icon"=""></fblike></td><td width="3"></td><td valign="middle"><div style="font-size: 12px; color: #3CC1B8; -webkit-text-size-adjust: none; -ms-text-size-adjust: none;"><fblike likeurl="https://www.facebook.com/Synclis">Like</fblike></div></td><td class="w10" width="10"></td><td valign="middle"><tweet><img src="https://img.createsend1.com/img/templatebuilder/tweet-glyph.png" border="0" width="17" height="13" alt="Twitter icon"=""></tweet></td><td width="3"></td><td valign="middle"><div style="font-size: 12px; color: #3CC1B8; -webkit-text-size-adjust: none; -ms-text-size-adjust: none;"><tweet>Tweet</tweet></div></td></tr></tbody></table> <table class="w255" width="255" cellpadding="0" cellspacing="0" border="0"> <tbody><tr><td class="w255" width="255" height="8"></td></tr> </tbody></table> </td> <td class="w15" width="15"></td> </tr></tbody></table> </td> </tr> <tr><td id="header" class="w640" width="640" align="center" bgcolor="#ffffff"><div align="center" style="text-align: center"><br/><a href="https://synclis.com"><img id="customHeaderImage" label="Header Image" width="250" src="https://synclis.com/media/mlogo.png" class="w640" border="0" align="top" style="display: inline"></a></div></td> </tr> <tr><td class="w640" width="640" height="30" bgcolor="#ffffff"></td></tr> <tr id="simple-content-row"><td class="w640" width="640" bgcolor="#ffffff"> <table align="left" class="w640" width="640" cellpadding="0" cellspacing="0" border="0"> <tbody><tr> <td class="w30" width="30"></td> <td class="w580" width="580"> <table class="w580" width="580" cellpadding="0" cellspacing="0" border="0"><tbody><tr><td class="w580" width="580"><p align="left" style="font-size: 18px; line-height:24px; color: #1FB5AC; margin-top:0px; margin-bottom:18px; font-family: \'Lucida Grande\', \'Lucida Sans Unicode\', Verdana, sans-serif;">You have recently signed up for Synclis.</p><div align="left" style="font-size: 13px; line-height: 18px; color: #777777; margin-top: 0px; margin-bottom: 18px; font-family: \'Lucida Grande\', \'Lucida Sans Unicode\', Verdana, sans-serif; font-size: 13px; line-height: 18px; color: #777777;">'. $request['first_name'] .' ' . $request['last_name'] . ',<br/><br/>Thank you for signing up with Synclis,<br/>You can activate your account with following Link provided below.<br/><i style="color:#1FB5AC;">If this is a mistake,</i> then please disregard this email.<br/><br/><a style = "color: #3CC1B8; font-weight:bold; text-decoration:none;" href = "https://synclis.com/Login/Activate/'. $uniqkey .'">Click here to activate your account.</a></div></td></tr><tr><td class="w580" width="580" height="10"></td></tr></tbody></table> </td> <td class="w30" width="30"></td> </tr> </tbody></table></td></tr> <tr><td class="w640" width="640" height="15" bgcolor="#ffffff"></td></tr> <tr> <td class="w640" width="640"> <table id="footer" class="w640" width="640" cellpadding="0" cellspacing="0" border="0" bgcolor="#f1f1f1"> <tbody><tr><td class="w30" width="30"></td><td class="w580 h0" width="360" height="30"></td><td class="w0" width="60"></td><td class="w0" width="160"></td><td class="w30" width="30"></td></tr> <tr> <td class="w30" width="30"></td> <td class="w580" width="360" valign="top"> <span class="hide"><p id="permission-reminder" align="left" class="footer-content-left"></p></span> <p align="right" class="footer-content-right" style="-webkit-text-size-adjust: none; -ms-text-size-adjust: none; font-family: \'Lucida Grande\', \'Lucida Sans Unicode\', Verdana, sans-serif; background-color: #f1f1f1; color: #777777; font-size: 12px; line-height: 15px; color: #777777; margin-top: 0px; margin-bottom: 15px;">&copy; Synclis 2014. | <a style="color: #3CC1B8; text-decoration:none; font-weight:normal;" href="https://synclis.com/About" >Discover Synclis</a> </td> <td class="hide w0" width="60"></td> <td class="hide w0" width="160" valign="top"> <p id="street-address" align="right" class="footer-content-right"></p> </td> <td class="w30" width="30"></td> </tr> <tr><td class="w30" width="30"></td><td class="w580 h0" width="360" height="15"></td><td class="w0" width="60"></td><td class="w0" width="160"></td><td class="w30" width="30"></td></tr> </tbody></table></td> </tr> <tr><td class="w640" width="640" height="60"></td></tr> </tbody></table> </td></tr></tbody></table></body></html>';
// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'To: '. $request['first_name'] .' ' . $request['last_name'] . ' <'. $request['email'] .'>' . "\r\n";
$headers .= 'From: Synclis <no-reply@synclis.com>' . "\r\n";

// Mail it
mail($to, $subject, $message, $headers);
					  
}

else if($method == 'PUT')
{//[PUT]: 
	if($request['id']        == ''){ die('{"response": "error","message": "[Synclis API] - Listing ID is required."}'); }
	
	$a = json_decode($file, true);
	
	if(!$a){ die('{"response": "error","message": "[Synclis API] - Invalid JSON Object received. '. $file .'"}'); }
	else{//JSON String is VALID =========================================================================================
		$output = "";  $badResult = false;
		
		$USER_ID = checkSession($conn, $a['session']);
		if($USER_ID === false){ die('{"response": "error","message": "Account validation failed, try logging in again."}'); }
		
		if($a['first_name']  != '') $output .= "`FIRST_NAME` =  '{$a['first_name']}',";
		if($a['last_name']   != '') $output .= "`LAST_NAME` =  '{$a['last_name']}',";
		if($a['address']     != '') $output .= "`ADDRESS` =  '{$a['address']}',";
		if($a['country']     != '') $output .= "`COUNTRY` =  '{$a['country']}',";
		if($a['providence']  != '') $output .= "`PROVIDENCE` =  '{$a['providence']}',";
		if($a['city']        != '') $output .= "`CITY` =  '{$a['city']}',";
		if($a['lng']         != '') $output .= "`LONG` =  '{$a['lng']}',";
		if($a['lat']         != '') $output .= "`LAT` =  '{$a['lat']}',";
		if($a['clean_name']  != '') $output .= "`CLEAN_NAME` =  '{$a['clean_name']}',";
		if($a['age']         != '') $output .= "`AGE_YEAR` =  '{$a['age']}',";
		if($a['language']    != '') $output .= "`LANGUAGE` =  '{$a['language']}',";
		if($a['image']       != '')
		{//USER IS UPDATING PROFILE IMAGE
			if(substr($a['image'], 0, 3) != 'http')
			{
				try{
					$img = $a['image'];
					$img = str_replace('data:image/png;base64,', '', $img);
					$img = str_replace('data:image/jpeg;base64,', '', $img);
					$img = str_replace(' ', '+', $img);
					
					// Decode image from base64
					$image=base64_decode($img);

					// Create Imagick object
					$thumb = new Imagick();

					// Convert image into Imagick
					$thumb->readimageblob($image);

					$thumb->resizeImage(300,300,Imagick::FILTER_CATROM,1,true);
					$key = makeKey();
					$thumb->writeImage('../../media/profileimg/thumb_' . $key . '.png');
					$thumb->clear();
					$thumb->destroy(); 
					
					$output .= "`PROFILE_IMG` =  'https://synclis.com/media/profileimg/thumb_". $key .".png'";
				}catch(Exception $e)
				{//Error with ImageMagik
					mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $USER_ID ."', '[{$_SERVER['PHP_SELF']}] [GET] Failed to upload a profile thumbnail photo. ImageMagik', '". $e->getMessage() ."'," . time() . ");");
					die('{"response": "error","message": "Oops. It seems that we have discovered a bug, the error report has been automatically to technical support.'. $e->getMessage() .'"}');
				}
			}			
		}
		$output = trim($output, ",");
		if($output != ''){
			$w = mysqli_query($conn, "UPDATE  `USER` SET {$output} WHERE  `ID` =  '{$USER_ID}'");
			if(!$w){mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $USER_ID ."', '[{$_SERVER['PHP_SELF']}] [GET] Failed to update the user preferences.', '". str_replace("'","`",mysqli_error($conn)) ."'," . time() . ");"); echo '{"response": "error","message": "Oops. It seems that we have discovered a bug, the error report has been automatically to technical support."}'; $badResult = true;}
		}
		
		/*Settings for Multi Login*/
		if($a['multi_login']       != ''){
			//Sanitize Inputs.
			$output = "`MULTI_LOGIN` =  '{$a['title']}'";
			$x = mysqli_query($conn, "UPDATE  `USER_LOGIN` SET {$output} WHERE  `ID` =  '{$USER_ID}'") or die("Unable to set login preference.");		
			if(!$x){mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $USER_ID ."', '[{$_SERVER['PHP_SELF']}] [GET] Failed to login the user.', '". str_replace("'","`",mysqli_error($conn)) ."'," . time() . ");"); echo '{"response": "error","message": "Oops. It seems that we have discovered a bug, the error report has been automatically to technical support."}'; $badResult = true;}
		}
		
		/*Settings for User Profile preferences */
		$output = "";
		
		if($a['preferences']      != '') $output .= "`PREFERENCES` =  '{$a['preferences']}',";/*Intrests*/
		if($a['skills']           != '') $output .= "`SKILLS` =  '{$a['skills']}',";
		if($a['business']         != '') $output .= "`BUSINESS` =  '{$a['business']}',";
		if($a['trade']            != '') $output .= "`TRADE` =  '{$a['trade']}',";
		if($a['biography']        != '') $output .= "`BIO` =  '{$a['biography']}',";
		if($a['location_setting'] != '') $output .= "`LOCSETTING` =  '{$a['location_setting']}',";
		if($a['show_location']    != '') $output .= "`SHOW_LOCATION` = '{$a['show_location']}',";
		if($a['timezone']         != '') $output .= "`TIMEZONE` =  '{$a['timezone']}',";
		if($a['portfolio']        != '') $output .= "`PORTFOLIO_JSON` =  '{$a['portfolio']}',";
		if($a['services']         != '') $output .= "`SERVICES_JSON` =  '{$a['services']}',";
		if($a['education']        != '') $output .= "`EDUCATION_JSON` =  '{$a['education']}',";
		if($a['experience']       != '') $output .= "`EXPERIENCE_JSON` =  '{$a['experience']}',";
		$output = trim($output, ",");
		if($output != ''){
			$v = mysqli_query($conn, "UPDATE  `USER_PROFILE` SET {$output} WHERE  `ID` =  '{$USER_ID}'");
			if(!$v){mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $USER_ID ."', '[{$_SERVER['PHP_SELF']}] [GET] Failed to update the user listing data.', '". str_replace("'","`",mysqli_error($conn)) ."'," . time() . ");"); echo '{"response": "error","message": "Oops. It seems that we have discovered a bug, the error report has been automatically to technical support."}'; $badResult = true;}
		}

		///////////// ERROR REPORTING ///////////////
		if(!$badResult){ echo '{"response": "success","message": "Successfully updated your personal settings."}'; }
		///////////// END ERROR REPORTING //////////

	}
	
}
else if($method == 'DELETE')
{//[DELETE]: You can only delete listing if API key matches user
	/*if($request['id']        == ''){ print_r($request); die('{"response": "error","message": "[Synclis API] - Listing ID is required."}'); }
	
	mysqli_query($conn, "DELETE FROM `USER` WHERE `ID` = '{$USER_ID}'");	
	mysqli_query($conn, "DELETE FROM `USER_APIAUTH` WHERE `ID` = '{$USER_ID}'");	
	mysqli_query($conn, "DELETE FROM `USER_LOGIN` WHERE `ID` = '{$USER_ID}'");	
	mysqli_query($conn, "DELETE FROM `USER_NOTIFICATIONS` WHERE `ID` = '{$USER_ID}'");	
	mysqli_query($conn, "DELETE FROM `USER_PROFILEIMG` WHERE `ID` = '{$USER_ID}'");
	mysqli_query($conn, "DELETE FROM `USER_REPORTREP` WHERE `ID` = '{$USER_ID}'");	
	mysqli_query($conn, "DELETE FROM `USER_PROFILEIMG` WHERE `ID` = '{$USER_ID}'");
	mysqli_query($conn, "DELETE FROM `BOOKMARK` WHERE `USER` = '{$USER_ID}'");
	mysqli_query($conn, "DELETE FROM `AUTH_TOKEN` WHERE `USER` = '{$USER_ID}'");
	
	
	///////////// ERROR REPORTING ///////////////
	if(!$u){
		mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $request[email] ."', '[{$_SERVER['PHP_SELF']}] [GET] Failed to login the user.', '". str_replace("'","`",mysql_error()) ."'," . time() . ");"); echo '{"response": "error","message": "Synclis could not delete your post, system error reported."}';		
		echo '{"response": "error","message": "Oops. It seems that we have discovered a bug, the error report has been automatically to technical support."}';
	}*/
	echo '{"response": "success","message": "You do not have permission to remove this user. - Synclis Admin"}';
	///////////// END ERROR REPORTING ///////////
}

else if($method == 'GET')
{//[GET]: 
	if($request['q']        == ''){ die('{"response": "error","message": "[Synclis API] - Search Query is required."}'); }
	
	$u = mysqli_query($conn, "SELECT `FIRST_NAME` FROM `USER`");	
	
	///////////// ERROR REPORTING ///////////////
	if(!$u){
		mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $request[email] ."', '[{$_SERVER['PHP_SELF']}] [GET] Failed to login the user.', '". str_replace("'","`",mysql_error()) ."'," . time() . ");");
		echo '{"response": "error","message": "Oops. It seems that we have discovered a bug, the error report has been automatically to technical support."}';}
	else{ echo '{"response": "success","message": "Successfully received the listing"}'; }
	///////////// END ERROR REPORTING ///////////
}

else{
	die('{"response": "error","message": "[Synclis API] - Invalid Request Type."}');
}

function uploadImage(){
	$str = substr($request['image'], 0, 4);
	$success= true;
	$leCODE = uniqid();
	$subdir = substr(dirname(__FILE__), 0, -11);
	$subdir .= 'media/listingimg';
	
	if($str == "http")//first 4 characters are http://
	{
		$content = file_get_contents($request['image']);
		//Store in the filesystem.
		$fp = fopen($subdir . '/'. $leCODE .'.png', "w");
		fwrite($fp, $content);
		fclose($fp);
	}
	else if ($str == "data") //first 4 characters are blob
	{					
		$img = $request['image'];
		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace('data:image/jpeg;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$content = file_put_contents($subdir . '/'. $leCODE .'.png', base64_decode($img));
		if(!$content)
			$success = false;
	}
	else
	{
		die('{"response": "error","message": "Your Image could not be uploaded to the server."}');
		$success = false;
	}
	if($success)
		return $leCODE;
	else
		return '';
}

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

?>