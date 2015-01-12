<?php
	include('../connectToDB.php');
	include('lib/core.php');
/*
[LISTINGS API] SYNCLIS Servlet Service RESTFUL API

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

	/*/////////////////////////////////
		DATA VALIDATION CHECK
	*//////////////////////////////////
	if($request['image'] != '')
	{
		
	}
	if($request['content'] != '')
	{
		$healthy = array("'", '"', "<",">","-");
		$yummy   = array("&lsquo;", "&quot;", "&lt;","&gt;","&ndash;");
		$request['content'] = strip_tags ( str_replace($healthy, $yummy, $request['content']) );
	}
	

/*/////////////////////////////////
	API SERVICE
*//////////////////////////////////

if($method == 'POST')
{//[POST]: 
	if(!$_COOKIE['SYNCLIS_TOKEN']){die('{"response": "error","message": "Please Login first."}');}
	if($request['content']     == ''){ die('{"response": "error","message": "[Synclis API] - Content is required."}'); }
	do{$tkp = makeKey();$y = mysqli_query($conn,"SELECT EXISTS(SELECT 1 FROM `PLUGIN_TMP` WHERE `HASH`='{$tkp}');");$chk = mysqli_fetch_row($y);}while($chk[0]);
	$s = mysqli_query($conn, "INSERT INTO `PLUGIN_TMP` (`ID`, `HASH`, `IMAGE`, `CONTENT`) 
	VALUES (NULL, '{$tkp}', '{$request['image']}', '{$request['content']}');");

	///////////// ERROR REPORTING ///////////////
	if(!$s){mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $USER_ID ."', '[{$_SERVER['PHP_SELF']}] [GET] Failed to create plugin holder.', '". str_replace("'","`",mysqli_error($conn)) ."'," . time() . ");"); echo '{"response": "error","message": "Oops. It seems that we have discovered a bug, the error report has been automatically to technical support.'. $request['content'] .'"}';}
	else{ echo '{"response":"success","iframeid":"'.$tkp.'"}'; }
	///////////// END ERROR REPORTING ///////////						  
}

else if($method == 'PUT')
{//[PUT]: 

}
else if($method == 'DELETE')
{//[DELETE]: You can only delete listing if API key matches user

}

else if($method == 'GET')
{//[GET]: 

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