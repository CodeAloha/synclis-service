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

	if($request['listing'] != '')
	{//CHECK FOR FIRST NAME---------------------------------------
		if( (ctype_alnum($request['listing'])) === false) || ( strlen ( $request['first_name'] ) >= 16) )
		{ die('{"response": "error","message": "This is not a valid listing title."}'); }
	}
	
/*/////////////////////////////////
	API SERVICE
*//////////////////////////////////

if($method == 'POST')
{//[POST]: 
		
	$s = mysqli_query($conn, "INSERT INTO `USER` (`ID`, `USER`, `LISTING`, `RATING`, `EMAIL_NOTIFICATION`)
	VALUES (NULL, '{$USER_ID}', '{$request['listing']}', '{$request['rating']}',0);");	
	
	///////////// ERROR REPORTING ///////////////
	mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $USER_ID ."', '[{$_SERVER['PHP_SELF']}] [GET] Failed to post a bookmark.', '". str_replace("'","`",mysql_error()) ."'," . time() . ");");
	else{ echo '{"response":"success","message":"Successfully created the bookmark."}'; }
	///////////// END ERROR REPORTING ///////////				  
}
else if($method == 'DELETE')
{//[DELETE]: You can only delete listing if API key matches user
	//if($request['id']        == ''){ print_r($request); die('{"response": "error","message": "[Synclis API] - Listing ID is required."}'); }
	
	//If session_id does not match with user, then deny service.
	$u = mysqli_query($conn, "DELETE FROM `BOOKMARK` WHERE `USER` = '{$USER_ID}'");
	
	
	///////////// ERROR REPORTING ///////////////
	if(!$u){
		mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $request[email] ."', '[{$_SERVER['PHP_SELF']}] [GET] Failed to login the user.', '". str_replace("'","`",mysql_error()) ."'," . time() . ");"); echo '{"response": "error","message": "Synclis could not delete your post, system error reported."}';		
		echo '{"response": "error","message": "Oops. It seems that we have discovered a bug, the error report has been automatically to technical support."}';
	}
	else{ echo '{"response": "success","message": "Successfully deleted the bookmark.'; }
	///////////// END ERROR REPORTING ///////////
}
else if($method == 'GET')
{//[GET]: Retrieve all bookmarks associated with user
	if($request['q']        == ''){ die('{"response": "error","message": "[Synclis API] - Search Query is required."}'); }
	
	$u = mysqli_query($conn, "SELECT * FROM `USER`");	
	
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

function string_to_ascii($string)
{
    $ascii = NULL;
 
    for ($i = 0; $i < strlen($string); $i++) 
    { 
    	$ascii += ord($string[$i]); 
    }
 
    return($ascii);
}

?>