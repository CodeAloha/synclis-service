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
*/

	 $SINGLE_USER_LISTING_LIMIT = 200;
/*/////////////////////////////////
	DATA VALIDATION CHECK
*//////////////////////////////////

	/*if($request['key']  == '' || $request['secret']  == ''){ die('{"response": "error","message": "[Synclis API] API Key set is required."}'); }
	else
	{
		$res = mysqli_query($conn, "SELECT `NAME` FROM `CATEGORY` WHERE `ID`='{$request['cat-id']}'");
		if(mysqli_num_rows($res) === 0)
			die('{"response": "error","message": "[Synclis API] Category ID does not exist."}');
	}*/


	/*/////////////////////////////////
		DATA VALIDATION CHECK
	*//////////////////////////////////
	if($request['title'] != '')
	{
		if( strlen ( $request['title'] ) >= 64){ die('{"response": "error","message": "[Synclis API] - Title is too long, maximum 64 characters allowed."}'); }
		$wantedChars = array(',', '!', '?','.', ' ');
		if(ctype_alnum(str_replace($wantedChars, '', $request['title'])) === false) { die('{"response": "error","message": "[Synclis API] - The title of your listing may only contain Letters, General Punctuation (!,?,. and ,), and spaces."}'); }
	}
	if($request['description'] != '')
	{
		$healthy = array("'", '"', "<",">","-");
		$yummy   = array("&lsquo;", "&quot;", "&lt;","&gt;","&ndash;");
		$request['description'] = str_replace($healthy, $yummy, $request['description']);
	}
	
	if($request['type'] != '')
	{
		//Convert the string to a tiemstamp
		if( $request['type'] != 'house' &&
			$request['type'] != 'car' &&
			$request['type'] != 'market' &&
			$request['type'] != 'freelance' &&
			$request['type'] != 'job' &&
			$request['type'] != '')
		{
			die('{"response": "error","message": "[Synclis API] Listings Type is invalid."}');
		}
	}
	if( $request['image'] != '' )
	{	
		if(!filter_var($request['image'], FILTER_VALIDATE_URL)) die('{"response": "error","message": "[Synclis API] Image must reference a valid URL."}');
	}
	
	if( $request['ap_twitter'] != '' )
	{	
		if($request['ap_twitter'] == 1 || $request['ap_twitter'] == 'true') $request['ap_twitter'] = true;
		else $request['ap_twitter'] = false;
	}
	if( $request['ap_facebook'] != '' )
	{	
		if($request['ap_facebook'] == 1 || $request['ap_facebook'] == 'true') $request['ap_facebook'] = true;
		else if($request['facebook_group'] != '') $request['ap_facebook'] = false;
		else $request['ap_facebook'] = false;
	}

/*/////////////////////////////////
	API SERVICE
*//////////////////////////////////

if($method == 'POST')
{//[POST]: 

	if($request['title']           == ''){ die('{"response": "error","message": "[Synclis API] - Title is required."}'); }
	if($request['description']     == ''){ die('{"response": "error","message": "[Synclis API] - Description is required."}'); }
	
	if(($request['country'] == '' && $request['city'] == '' && $request['providence'] == ''))
	{ die('{"response": "error","message": "[Synclis API] - Location parameters must be supplied, either a Geolocation coordinate, or country,providence,city are acceptable."}'); }
	
	if($USER_ID)
	{//If user is not anonymous
		$checkNumLists = mysqli_query($conn, "SELECT COUNT(`HASH62`) FROM `LISTING` WHERE `USER`=" . $USER_ID . " LIMIT 1");
		$c = mysqli_fetch_row($checkNumLists);
	}
	else
	{
		if($request['email'] == '' || !filter_var($request['email'], FILTER_VALIDATE_EMAIL)){ die('{"response": "error","message": "You\'re posting anonymously, so an e-mail is required."}'); }
		$USER_ID = $request['email'];
	}
	
	
	if($c[0] < $SINGLE_USER_LISTING_LIMIT || $USER_ID == '')//Check amount of listings created by the user, 
	{/*If user has less than max listing limit, Create Actual Listing.*/
	
		if($request['id'] == '')
		{/*if ID is empty, Generate Key until a unique Key is generated*/
			do{$tkp = makeKey();$y = mysqli_query($conn,"SELECT EXISTS(SELECT 1 FROM `LISTING` WHERE `HASH62`='{$tkp}');");$chk = mysqli_fetch_row($y);}while($chk[0]);}else{$tkp = $request['id'];
		}
		
		if($request['json_data'] != ''){
			$request['json_data'] = str_replace('@SYNCJECT@', "{$tkp}", $request['json_data']);
			$healthy = array("'", "<",">","-");
			$yummy   = array("&lsquo;", "&lt;","&gt;","&ndash;");
			$request['json_data'] = str_replace($healthy, $yummy, $request['json_data']);
		}
		else $request['json_data'] = '{}';
		
		if(!$request['vid'] == '')
		{/*If Video is not empty, generate video ID.*/
			$vi= mysqli_query($conn, "INSERT INTO `LISTING_VIDEO` (`ID`, `LISTING`, `VIDEO_TYPE`, `VIDEO_URL`, `VIDEO_COVER`) VALUES (NULL, '". $tkp ."', 'YouTube', '{$request['vid']}', '');");
			if(!$vi){mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $USER_ID ."', '[{$_SERVER['PHP_SELF']}] [GET] Failed to upload video for listing.', '". str_replace("'","`",mysqli_error($conn)) ."'," . time() . ");"); echo '{"response": "error","message": "Oops. It seems that we have discovered a bug, the error report has been automatically to technical support."}';}
		}
	
		$s = mysqli_query($conn, "INSERT INTO `LISTING` (`ID`, `NAME`, `DESCRIPTION`, `TYPE`, `CATEGORY`, `IMAGE`, `COUNTRY`, `PROVIDENCE`, `CITY`, `LONG`, `LAT`, `INQUIRIES`, `USER`, `TIMESTAMP`, `TOGGLE`, `AGE_FILTER`,`HASH62`)
		VALUES (NULL, '{$request['title']}', '{$request['description']}', '{$request['type']}', '{$request['cat-id']}', '{$request['image']}', '{$request['country']}', '{$request['providence']}', '{$request['city']}', '{$request['lng']}', '{$request['lat']}', '0', '{$USER_ID}', '". time() ."', '1', '0', '". $tkp ."');");	
		$k = mysqli_query($conn, "INSERT INTO `LISTING_LAYOUT` (`ID`, `LISTING`, `DATA`, `SHOW_MAP`)
		VALUES (NULL, '". $tkp ."', '". $request['json_data'] ."', '{$request['show_map']}');");	
		
		
		///////////////////////////////////////////////////////////////////////////////
		////////////////////FACEBOOK / TWITTER AUTOPOSTER /////////////////////////////
		///////////////////////////////////////////////////////////////////////////////
		$append = "";
		$config = dirname(__FILE__) . '/../../Login/hybridauth/config.php';
		require_once( "../../Login/hybridauth/Hybrid/Auth.php" );

		// initialise hybridauth
		$hybridauth = new Hybrid_Auth( $config );

		$provider = @ "Twitter";
		if( $hybridauth->isConnectedWith( $provider ) && $request['ap_twitter'] )
		{//Is Connected with Twitter
			try{
					// call back the requested provider adapter instance 
					$adapter = $hybridauth->getAdapter( $provider );

					$status = array($request['title'] , $request['image'], "https://synclis.com/ViewListing/".$tkp );
					
					// update user staus
					$adapter->setUserStatus( $status );
					$append .= " Successfully posted to Twitter.";
			}
			catch( Exception $e ){

				if( $e->getCode() == 8 ){
					$append .= " Twitter no longer allows Automated tweets.";
				}
				else{
					$append .= " Unable to post to Twitter, please Log in through the provider to try again.";
				} 
			}
		}
		
		$provider = @ "Facebook";
		if( $hybridauth->isConnectedWith( $provider ) && $request['ap_facebook'] && $request['facebook_group'] != '')
		{//Is Connected with Facebook
			try{
					// call back the requested provider adapter instance 
					$adapter = $hybridauth->getAdapter( $provider );

					$status = array( "https://synclis.com/ViewListing/".$tkp."" , $request['image'], $request['title'], $request['description'], $request['facebook_group'] );
					
					// update user staus
					$adapter->setUserStatus( $status );
					$append .= "Successfully posted to Facebook.";
			}
			catch( Exception $e ){

				if( $e->getCode() == 8 ){
					$append .= " Facebook no longer allows Automated posts.";
				}
				else{
					$append .= " Unable to post to Facebook, please Log in through the provider to try again.";
				} 
			}
		}
		
		///////////////////////////////////////////////////////////////////////////////////
		////////////////////END FACEBOOK / TWITTER AUTOPOSTER /////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////
		
	}
	else
	{/*User has more than defined limit of listings.*/
		die('{"response":"error","message":"You may not have more than 200 listings to your account."}');
	}
	
	
	///////////// ERROR REPORTING ///////////////
	if(!$s){mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $USER_ID ."', '[{$_SERVER['PHP_SELF']}] [GET] Failed to create listing.', '". str_replace("'","`",mysqli_error($conn)) ."'," . time() . ");"); echo '{"response": "error","message": "Oops. It seems that we have discovered a bug, the error report has been automatically to technical support."}';}
	else if(!$k){mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $USER_ID ."', '[{$_SERVER['PHP_SELF']}] [GET] Failed to create listing layout.', '". str_replace("'","`",mysqli_error($conn)) ."'," . time() . ");"); echo '{"response": "error","message": "Oops. It seems that we have discovered a bug, the error report has been automatically to technical support."}';}
	else{ echo '{"response":"success","message":"Successfully created the listing, ' . $request['title'] .' '. $append .'"}'; }
	///////////// END ERROR REPORTING ///////////						  
}

else if($method == 'PUT')
{//[PUT]: 
	$a = json_decode(str_replace("\n", "[br/]", $file), true);
	//die("Good so far: " . $file);
	if(!$a){ die('{"response": "error","message": "[Synclis API] - Invalid JSON Object received."}'); }
	else{//JSON String is VALID =========================================================================================
		if($a['id']  == ''){ die('{"response": "error","message": "[Synclis API] - Listing ID is required."}'); }
		$output = '';
		//die($file);
		$USER_ID = checkSession($conn, $a['session']);
		if($USER_ID === false){ die('{"response": "error","message": "Account validation failed, try logging in again."}'); }
		if($a['title']        != '')
			$output .= "`NAME` =  '{$a['title']}',";
		if($a['description'] != ''){
			$healthy = array("'",'"', "<",">","-");
			$yummy   = array("&lsquo;", "&quot;", "&lt;","&gt;","&ndash;");
			$a['description'] = str_replace($healthy, $yummy, $a['description']);
			$a['description'] = str_replace("[br/]", "\n", $a['description']);
			$output .= "`DESCRIPTION` =  '{$a['description']}',";
		}
		if($a['country'] != '' && $a['providence'] != '' && $a['city'] != '')
			$output .= "`COUNTRY` =  '{$a['country']}',`PROVIDENCE` = '{$a['providence']}',`CITY` =  '{$a['city']}',";
		if($a['lng'] != '' && $a['lat'] != '')
			$output .= "`LONG` =  '{$a['lng']}', `LAT` =  '{$a['lat']}',";
		if($a['image']        != '')
			$output .= "`IMAGE` =  '{$a['image']}',";
			
		$output = trim($output, ",");
		if($output != ''){ 
			$v = mysqli_query($conn, "UPDATE  `LISTING` SET {$output} WHERE `LISTING`.`HASH62`='". $a['id'] ."'");	
			if(!$v){mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $USER_ID ."', '[{$_SERVER['PHP_SELF']}] [GET] Failed to login the user.', '". str_replace("'","`",mysqli_error($conn)) ."'," . time() . ");"); die('{"response": "error","message": "Oops. It seems that we have discovered a bug, the error report has been automatically to technical support."}');}
		}	
		
		//UPDATE LISTING_LAYOUT TABLE
		
		$output = '';
		
		if($a['show_map'] != '')
			$output .= "`SHOW_MAP` = '{$a['show_map']}',";
		if($a['json_data'] != ''){
			$healthy = array("'", "<",">","-");
			$yummy   = array("&lsquo;", "&lt;","&gt;","&ndash;");
			$a['json_data'] = str_replace($healthy, $yummy, $a['json_data']);
			$output .= "`DATA` = '" . json_encode($a['json_data']) . "',";
		}
		$output = trim($output, ",");
		if($output != ''){ 
			$k = mysqli_query($conn, "UPDATE `LISTING_LAYOUT` SET {$output} WHERE `LISTING`='". $a['id'] ."'");
			if(!$k){mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $USER_ID ."', '[{$_SERVER['PHP_SELF']}] [GET] Failed to login the user.', '". '\n JSON OUTPUT:' .  str_replace("'","`",mysqli_error($conn)) . "'," . time() . ");"); die('{"response": "error","message": "Oops. It seems that we have discovered a bug, the error report has been automatically to technical support."}');}
		}	
		
		echo '{"response": "success","message": "Successfully updated the listing."}';
		///////////// END ERROR REPORTING //////////

	}
	
}
else if($method == 'DELETE')
{//[DELETE]: You can only delete listing if API key matches user
	if($request['id']        == ''){ print_r($request); die('{"response": "error","message": "[Synclis API] - Listing ID is required."}'); }
	
	$k = mysqli_query($conn, "SELECT USER FROM `LISTING` WHERE HASH62 = '{$request['id']}'");
	$j = mysqli_fetch_row($k);
	if($j[0] == $USER_ID)
	{//Make sure the listing is theirs.

	
			mysqli_query($conn, "DELETE FROM `LISTING` WHERE `HASH62` = '{$request['id']}'");
			mysqli_query($conn, "DELETE FROM `LISTING_IMAGE` WHERE `LISTING` = '{$request['id']}'");
			mysqli_query($conn, "DELETE FROM `LISTING_LAYOUT` WHERE `LISTING` = '{$request['id']}'");
			mysqli_query($conn, "DELETE FROM `LISTING_VIDEO` WHERE `LISTING` = '{$request['id']}'");
			mysqli_query($conn, "DELETE FROM `ENJOY` WHERE `LISTING` = '{$request['id']}'");
			mysqli_query($conn, "DELETE FROM `BOOKMARK` WHERE `LISTING` = '{$request['id']}'");
			
			try{
				$q = explode("listingimg/",$row[1]);
				if($row[1] != ''){
					unlink('../media/listingimg/'. $q[1]);
					unlink('../media/listingimg/thumb/thumb_'. $q[1]);
				}
			}catch(Exception $e){
				mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, 'CRON DAEMON', '[{$_SERVER['PHP_SELF']}] [GET] Failed to Remove Image', '". $e ."'," . time() . ");");
			}	
			echo '{"response": "success","message": "Successfully deleted the listing."}';
			///////////// END ERROR REPORTING ///////////
	}
	else{
		die('{"response": "error","message": "You do not own this listing."}');
	}
}

else if($method == 'GET')
{//[GET]: 
	if($request['q']        == ''){ die('{"response": "error","message": "[Synclis API] - Search Query is required."}'); }
	$query = preg_replace('/[^a-z\d ]+/i', '', $request['q']);
	$u = mysqli_query($conn, "SELECT * FROM `LISTING` WHERE MATCH(`DESCRIPTION`, `NAME`) AGAINST ('". $query ."')");
	$res = '';
	if(mysqli_num_rows($u) === 0){
		die('{"response": "success","message": "No search results found."}');
	}
	
	$res .= '{"results":[';
	while($row = mysqli_fetch_row($u)){
		$res .= '{"name": "'.$row[1].'","description": "'.$row[2].'","type": "'.$row[3].'","category": "'.$row[4].'"},';
	}
	$res = trim($res, ",");
	$res .= ']}';

	
	///////////// ERROR REPORTING ///////////////
	if(!$u){
		mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $request[email] ."', '[{$_SERVER['PHP_SELF']}] [GET] Failed to login the user.', '". str_replace("'","`",mysql_error()) ."'," . time() . ");");
		echo '{"response": "error","message": "Oops. It seems that we have discovered a bug, the error report has been automatically to technical support."}';}
	else{ echo $res; }
	///////////// END ERROR REPORTING ///////////
}

else{
	die('{"response": "error","message": "[Synclis API] - Invalid Request Type."}');
}


/*Utililites */
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