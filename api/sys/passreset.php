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
	if($method == 'POST'){
		if(!filter_var($request['email'], FILTER_VALIDATE_EMAIL)){ die('{"response": "error","message": "Invalid Email Address."}'); }

		/*/////////////////////////////////
		Password Reset Service
		*//////////////////////////////////
		$t = mysqli_query($conn,"SELECT CLEAN_NAME,ACTIVATED,FIRST_NAME,LAST_NAME,ID FROM `USER` WHERE `EMAIL`='{$request['email']}'");
		$row = mysqli_fetch_row($t);

		if(!$t){die('{"response": "error","message": "User does not exist."}'); }
		else
		{
			if(!$row[1]) die('{"response": "error","message": "You must activate your account before requesting a password."}');
			$random_key = hash("whirlpool", microtime(). $row[0]);
			
			mysqli_query($conn,"UPDATE `USER_LOGIN` SET  `P_RESET`='{$random_key}' WHERE `ID` ='{$row[4]}'");
			
// multiple recipients
$to  = $request['email']; // note the comma

// subject
$subject = '[Synclis] Password Reset';

// message
$message = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html><head><title></title><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta name="viewport" content="width=320, target-densitydpi=device-dpi"><style type="text/css">/* Mobile-specific Styles */@media only screen and (max-width: 660px) { table[class=w0], td[class=w0] { width: 0 !important; }table[class=w10], td[class=w10], img[class=w10] { width:10px !important; }table[class=w15], td[class=w15], img[class=w15] { width:5px !important; }table[class=w30], td[class=w30], img[class=w30] { width:10px !important; }table[class=w60], td[class=w60], img[class=w60] { width:10px !important; }table[class=w125], td[class=w125], img[class=w125] { width:80px !important; }table[class=w130], td[class=w130], img[class=w130] { width:55px !important; }table[class=w140], td[class=w140], img[class=w140] { width:90px !important; }table[class=w160], td[class=w160], img[class=w160] { width:180px !important; }table[class=w170], td[class=w170], img[class=w170] { width:100px !important; }table[class=w180], td[class=w180], img[class=w180] { width:80px !important; }table[class=w195], td[class=w195], img[class=w195] { width:80px !important; }table[class=w220], td[class=w220], img[class=w220] { width:80px !important; }table[class=w240], td[class=w240], img[class=w240] { width:180px !important; }table[class=w255], td[class=w255], img[class=w255] { width:185px !important; }table[class=w275], td[class=w275], img[class=w275] { width:135px !important; }table[class=w280], td[class=w280], img[class=w280] { width:135px !important; }table[class=w300], td[class=w300], img[class=w300] { width:140px !important; }table[class=w325], td[class=w325], img[class=w325] { width:95px !important; }table[class=w360], td[class=w360], img[class=w360] { width:140px !important; }table[class=w410], td[class=w410], img[class=w410] { width:180px !important; }table[class=w470], td[class=w470], img[class=w470] { width:200px !important; }table[class=w580], td[class=w580], img[class=w580] { width:280px !important; }table[class=w640], td[class=w640], img[class=w640] { width:300px !important; }table[class*=hide], td[class*=hide], img[class*=hide], p[class*=hide], span[class*=hide] { display:none !important; }table[class=h0], td[class=h0] { height: 0 !important; }p[class=footer-content-left] { text-align: center !important; }#headline p { font-size: 30px !important; }.article-content, #left-sidebar{ -webkit-text-size-adjust: 90% !important; -ms-text-size-adjust: 90% !important; }.header-content, .footer-content-left {-webkit-text-size-adjust: 80% !important; -ms-text-size-adjust: 80% !important;}img { height: auto; line-height: 100%;} } /* Client-specific Styles */#outlook a { padding: 0; }/* Force Outlook to provide a "view in browser" button. */body { width: 100% !important; }.ReadMsgBody { width: 100%; }.ExternalClass { width: 100%; display:block !important; } /* Force Hotmail to display emails at full width *//* Reset Styles */body { background-color: #f9f9f9; margin: 0; padding: 0; }img { outline: none; text-decoration: none; display: block;}br, strong br, b br, em br, i br { line-height:100%; }h1, h2, h3, h4, h5, h6 { line-height: 100% !important; -webkit-font-smoothing: antialiased; }h1 a, h2 a, h3 a, h4 a, h5 a, h6 a { color: blue !important; }h1 a:active, h2 a:active, h3 a:active, h4 a:active, h5 a:active, h6 a:active {color: red !important; }h1 a:visited, h2 a:visited, h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited { color: purple !important; }table td, table tr { border-collapse: collapse; }.yshortcuts, .yshortcuts a, .yshortcuts a:link,.yshortcuts a:visited, .yshortcuts a:hover, .yshortcuts a span {color: black; text-decoration: none !important; border-bottom: none !important; background: none !important;}</style><!--[if gte mso 9]><style _tmplitem="498" >.article-content ol, .article-content ul { margin: 0 0 0 24px; padding: 0; list-style-position: inside;}</style><![endif]--></head><body style="font-family: \'Lucida Grande\', \'Lucida Sans Unicode\', Verdana, sans-serif;"><table width="100%" cellpadding="0" cellspacing="0" border="0" id="background-table"><tbody><tr><td align="center" bgcolor="#f9f9f9"> <table class="w640" style="margin:0 10px;" width="640" cellpadding="0" cellspacing="0" border="0"> <tbody><tr><td class="w640" width="640" height="20"></td></tr> <tr> <td class="w640" width="640"> <table style="border-radius:6px 6px 0px 0px; -moz-border-radius: 6px 6px 0px 0px; -webkit-border-radius:6px 6px 0px 0px; -webkit-font-smoothing: antialiased; background-color: #f1f1f1; color: #ededed;" class="w640" width="640" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff"> <tbody><tr> <td class="w15" width="15"></td> <td class="w325" width="350" valign="middle" align="left"> <table class="w325" width="350" cellpadding="0" cellspacing="0" border="0"> <tbody><tr><td class="w325" width="350" height="8"></td></tr> </tbody></table> <table class="w325" width="350" cellpadding="0" cellspacing="0" border="0"> <tbody><tr><td class="w325" width="350" height="8"></td></tr> </tbody></table> </td> <td class="w30" width="30"></td> <td class="w255" width="255" valign="middle" align="right"> <table class="w255" width="255" cellpadding="0" cellspacing="0" border="0"> <tbody><tr><td class="w255" width="255" height="8"></td></tr> </tbody></table> <table cellpadding="0" cellspacing="0" border="0"><tbody><tr><td valign="middle"><fblike likeurl="https://www.facebook.com/Synclis"><img src="https://img.createsend1.com/img/templatebuilder/like-glyph.png" border="0" width="8" height="14" alt="Facebook icon"=""></fblike></td><td width="3"></td><td valign="middle"><div style="font-size: 12px; color: #3CC1B8; -webkit-text-size-adjust: none; -ms-text-size-adjust: none;"><fblike likeurl="https://www.facebook.com/Synclis">Like</fblike></div></td><td class="w10" width="10"></td><td valign="middle"><tweet><img src="https://img.createsend1.com/img/templatebuilder/tweet-glyph.png" border="0" width="17" height="13" alt="Twitter icon"=""></tweet></td><td width="3"></td><td valign="middle"><div style="font-size: 12px; color: #3CC1B8; -webkit-text-size-adjust: none; -ms-text-size-adjust: none;"><tweet>Tweet</tweet></div></td></tr></tbody></table> <table class="w255" width="255" cellpadding="0" cellspacing="0" border="0"> <tbody><tr><td class="w255" width="255" height="8"></td></tr> </tbody></table> </td> <td class="w15" width="15"></td> </tr></tbody></table> </td> </tr> <tr><td id="header" class="w640" width="640" align="center" bgcolor="#ffffff"><div align="center" style="text-align: center"><br/><a href="https://synclis.com"><img id="customHeaderImage" label="Header Image" width="250" src="https://synclis.com/media/mlogo.png" class="w640" border="0" align="top" style="display: inline"></a></div></td> </tr> <tr><td class="w640" width="640" height="30" bgcolor="#ffffff"></td></tr> <tr id="simple-content-row"><td class="w640" width="640" bgcolor="#ffffff"> <table align="left" class="w640" width="640" cellpadding="0" cellspacing="0" border="0"> <tbody><tr> <td class="w30" width="30"></td> <td class="w580" width="580"> <table class="w580" width="580" cellpadding="0" cellspacing="0" border="0"><tbody><tr><td class="w580" width="580"><p align="left" style="font-size: 18px; line-height:24px; color: #1FB5AC; margin-top:0px; margin-bottom:18px; font-family: \'Lucida Grande\', \'Lucida Sans Unicode\', Verdana, sans-serif;">Looking to reset your password?</p><div align="left" style="font-size: 13px; line-height: 18px; color: #777777; margin-top: 0px; margin-bottom: 18px; font-family: \'Lucida Grande\', \'Lucida Sans Unicode\', Verdana, sans-serif; font-size: 13px; line-height: 18px; color: #777777;">It appears that you have forgotten your password.<br/>Hey, it happens.<br/>You can change your password with following link provided below.<br/><i style="color:#1FB5AC;">If this is a mistake,</i> then please disregard this email.<br/><br/><a style = "color: #3CC1B8; font-weight:bold; text-decoration:none;" href = "https://synclis.com/Login/ResetPass/'. $random_key .'">Click here to reset your password.</a></div></td></tr><tr><td class="w580" width="580" height="10"></td></tr></tbody></table> </td> <td class="w30" width="30"></td> </tr> </tbody></table></td></tr> <tr><td class="w640" width="640" height="15" bgcolor="#ffffff"></td></tr> <tr> <td class="w640" width="640"> <table id="footer" class="w640" width="640" cellpadding="0" cellspacing="0" border="0" bgcolor="#f1f1f1"> <tbody><tr><td class="w30" width="30"></td><td class="w580 h0" width="360" height="30"></td><td class="w0" width="60"></td><td class="w0" width="160"></td><td class="w30" width="30"></td></tr> <tr> <td class="w30" width="30"></td> <td class="w580" width="360" valign="top"> <span class="hide"><p id="permission-reminder" align="left" class="footer-content-left"></p></span> <p align="right" class="footer-content-right" style="-webkit-text-size-adjust: none; -ms-text-size-adjust: none; font-family: \'Lucida Grande\', \'Lucida Sans Unicode\', Verdana, sans-serif; background-color: #f1f1f1; color: #777777; font-size: 12px; line-height: 15px; color: #777777; margin-top: 0px; margin-bottom: 15px;">&copy; Synclis 2014. | <a style="color: #3CC1B8; text-decoration:none; font-weight:normal;" href="https://synclis.com/About" >Discover Synclis</a> </td> <td class="hide w0" width="60"></td> <td class="hide w0" width="160" valign="top"> <p id="street-address" align="right" class="footer-content-right"></p> </td> <td class="w30" width="30"></td> </tr> <tr><td class="w30" width="30"></td><td class="w580 h0" width="360" height="15"></td><td class="w0" width="60"></td><td class="w0" width="160"></td><td class="w30" width="30"></td></tr> </tbody></table></td> </tr> <tr><td class="w640" width="640" height="60"></td></tr> </tbody></table> </td></tr></tbody></table></body></html>';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers 
$headers .= 'To: '. $row[2] .' ' . $row[3] . ' <'. $request['email'] .'>' . "\r\n";
$headers .= 'From: Synclis <no-reply@synclis.com>' . "\r\n";

// Mail it
mail($to, $subject, $message, $headers);
		echo '{"response":"success","message":"An email has been sent to you containing instructions."}';
		}
	}
	else if($method == 'PUT')
	{//[PUT]: FOR CHANGING PASSWORD
		if($request['id']        == ''){ die('{"response": "error","message": "[Synclis API] - User Name is required."}'); }
		
		$a = json_decode($file, true);

		if(!$a){ die('{"response": "error","message": "[Synclis API] - Invalid JSON Object received."}'); }
		else{//JSON String is VALID =========================================================================================
			if($a['password'] == ''){ die('{"response": "error","message": "[Synclis API] - No Changes made."}'); }	
			require_once('lib/PasswordHash.php');
			//Process User password with Salt and PBKDF2
			$salt = mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);
			$a = pbkdf2("sha1", $a['password'], $salt, 2, 20, false);
			$t = mysqli_query($conn, "SELECT `ID` FROM `USER` WHERE `CLEAN_NAME`='{$request['id']}'");
			$x = mysqli_fetch_row($t);
			$v = mysqli_query($conn, "UPDATE  `USER_LOGIN` SET `SALT`='{$salt}', `SLOW_HASH`='{$a}' WHERE  `ID` =  '{$x[0]}'");	
							  
			///////////// ERROR REPORTING ///////////////
			if(!$v){mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $USER_ID ."', '[{$_SERVER['PHP_SELF']}] [GET] Failed to login the user.', '". str_replace("'","`",mysql_error()) ."'," . time() . ");"); echo '{"response": "error","message": "Oops. It seems that we have discovered a bug, the error report has been automatically to technical support."}';}
			else{ echo '{"response": "success","message": "Successfully updated your password."}'; }
			///////////// END ERROR REPORTING //////////

		}
	}
	else{
		_response('Invalid Method', 405);
		echo '{"response": "error","message": "Method supplied does not exist."}';
	}


?>