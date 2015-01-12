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
		if( !ctype_alnum($request['listing']) || ( strlen ( $request['listing'] ) >= 16) )
		{ die('{"response": "error","message": "This is not a valid listing"}'); }
	}
	
/*/////////////////////////////////
	API SERVICE
*//////////////////////////////////

if($method == 'POST')
{//[POST]: 
	$s = mysqli_query($conn, "INSERT INTO `ENJOY` (`USER`, `LISTING`)
	SELECT * FROM (SELECT '{$USER_ID}', '{$request['listing']}') AS tmp
	WHERE NOT EXISTS(SELECT `USER` FROM `ENJOY` WHERE `USER`='{$USER_ID}' AND `LISTING`='{$request['listing']}')LIMIT 1");

	
	///////////// ERROR REPORTING ///////////////
	if(!$s){mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $USER_ID ."', '[{$_SERVER['PHP_SELF']}] [GET] Failed to login the user.', '". str_replace("'","`",mysql_error()) ."'," . time() . ");"); echo '{"response": "error","message": "Synclis could not process your enjoy request, system error reported."}';}
	else{ echo '{"response":"success","message":"Successfully created the bookmark."}'; }
	///////////// END ERROR REPORTING ///////////				  
}
else if($method == 'DELETE')
{//[DELETE]: You can only delete listing if API key matches user
	//if($request['id']        == ''){ print_r($request); die('{"response": "error","message": "[Synclis API] - Listing ID is required."}'); }
	
	//If session_id does not match with user, then deny service.
	$u = mysqli_query($conn, "DELETE FROM `ENJOY` WHERE `USER` = '{$USER_ID}' AND `LISTING`='{$request['listing']}'");
	
	
	///////////// ERROR REPORTING ///////////////
	if(!$u){mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $request[email] ."', '[{$_SERVER['PHP_SELF']}] [GET] Failed to login the user.', '". str_replace("'","`",mysql_error()) ."'," . time() . ");"); echo '{"response": "error","message": "Synclis could not delete your enjoy request, system error reported."}';}
	else{ echo '{"response": "success","message": "Toggled Enjoy to off.'; }
	///////////// END ERROR REPORTING ///////////
}
else if($method == 'GET')
{//[GET]: Retrieve all bookmarks associated with user
	if($request['q']        == ''){ die('{"response": "error","message": "[Synclis API] - Search Query is required."}'); }
	
	$u = mysqli_query($conn, "SELECT `USER`,`LISTING` FROM `ENJOY`");	
	
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

?>