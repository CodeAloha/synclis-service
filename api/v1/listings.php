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
		if(ctype_alpha(str_replace(' ', '', $request['title'])) === false) { die('{"response": "error","message": "[Synclis API] - The title of your listing may only contain Letters, and spaces."}'); }
	}
	if($request['description'] != '')
	{
		//Thorough check of description
	}
	
	if($request['type'] != '')
	{
		//Convert the string to a tiemstamp
		if( $request['type'] != 'Standard' &&
			$request['type'] != 'Housing' &&
			$request['type'] != 'Sales')
		{
			die('{"response": "error","message": "[Synclis API] Listings Type is invalid."}');
		}
	}
	

/*/////////////////////////////////
	API SERVICE
*//////////////////////////////////

if($method == 'POST')
{//[POST]: 
	if($request['title']           == ''){ die('{"response": "error","message": "[Synclis API] - Title is required."}'); }
	if($request['description']     == ''){ die('{"response": "error","message": "[Synclis API] - Description is required."}'); }
	if($request['type']            == ''){ die('{"response": "error","message": "[Synclis API] - Listing Type is required."}'); }
	if(($request['country'] == '' && $request['city'] == '' && $request['providence'] == ''))
	{ die('{"response": "error","message": "[Synclis API] - Location parameters must be supplied, either a Geolocation coordinate, or country,providence,city are acceptable."}'); }
	
	if($request['image'] != '')
		$imagess = "../media/listingimg/". uploadImage() . ".png";
	else
		$imagess = "";
	
	$w = mysqli_query($conn, "SELECT MAX( id ) FROM LISTING");
	$num = mysqli_fetch_row($w);
	$w = toBase( ($num[0]+2422350) );
	$s = mysqli_query($conn, "INSERT INTO `LISTING` (`ID`, `NAME`, `DESCRIPTION`, `TYPE`, `CATEGORY`, `IMAGE`, `COUNTRY`, `PROVIDENCE`, `CITY`, `LONG`, `LAT`, `INQUIRIES`, `USER`, `TIMESTAMP`, `TOGGLE`, `AGE_FILTER`,`HASH62`)
	VALUES (NULL, '{$request['title']}', '{$request['description']}', '{$request['type']}', '{$request['cat-id']}', '{$imagess}', '{$request['country']}', '{$request['providence']}', '{$request['city']}', '{$request['lng']}', '{$request['lat']}', '0', '{$usr}', '". time() ."', '1', '0', '". $w ."');");	
	
	///////////// ERROR REPORTING ///////////////
	if(!$s){mysqli_query($conn, "INSERT INTO `ERROR_REPORTING` (`ID`, `COMPANY`, `USER`, `SOURCE`, `DESCRIPTION`, `RESPONSE`,`TIME`)VALUES (NULL, '{$request['company-id']}', '{$request['user-id']}', '{$_SERVER['PHP_SELF']}', '[POST][Q_CAMPAIGN] Failed to create a CAMPAIGN.', '".  str_replace("'","`",mysqli_error())  ."'," . time() . ");"); echo '{"response": "error","message": "Atlas System Error discovered, error was reported to administrators: '. mysqli_error() .'"}';}
	else{ echo '{"response":"success","message":"Successfully created the listing, ' . $request['title'] .'","uid":"'. $w .'"}'; }
	///////////// END ERROR REPORTING ///////////						  
}

else if($method == 'PUT')
{//[PUT]: 
	if($request['id']        == ''){ die('{"response": "error","message": "[Synclis API] - Listing ID is required."}'); }
	
	$a = json_decode($file, true);
	
	if(!$a){ die('{"response": "error","message": "[Synclis API] - Invalid JSON Object received."}'); }
	else{//JSON String is VALID =========================================================================================
		if($a['title']        != '')
			$output = "`NAME` =  '{$a['title']}',";
		if($a['description'] != '')
			$output = "`DESCRIPTION` =  '{$a['description']}',";
		if($a['country'] != '')
			$output = "`COUNTRY` =  '{$a['label']}',";
		if($a['providence'] != '')
			$output = "`PROVIDENCE` =  '{$a['manager']}',";
		if($a['city'] != '')
			$output = "`CITY` =  '{$a['start-date']}',";
		if($a['lng']        != '')
			$output = "`LONG` =  '{$a['end-date']}',";
		if($a['lat']        != '')
			$output = "`LAT` =  '{$a['end-date']}',";

		if(!$output){ die('{"response": "error","message": "[Synclis API] - No Changes made."}'); }	
		
		$output = trim($output, ",");

		
		$v = mysqli_query($conn, "UPDATE  `LISTING` SET {$output} WHERE  `HASH62` =  '{$request['id']}'");	
						  
		///////////// ERROR REPORTING ///////////////
		if(!$v){mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $request[email] ."', '[{$_SERVER['PHP_SELF']}] [GET] Failed to login the user.', '". str_replace("'","`",mysql_error()) ."'," . time() . ");"); echo '{"response": "error","message": "Oops. It seems that we have discovered a bug, the error report has been automatically to technical support."}';}
		else{ echo '{"response": "success","message": "Successfully updated the listing."}'; }
		///////////// END ERROR REPORTING //////////

	}
	
}
else if($method == 'DELETE')
{//[DELETE]: You can only delete listing if API key matches user
	if($request['id']        == ''){ print_r($request); die('{"response": "error","message": "[Synclis API] - Listing ID is required."}'); }
	
	$u = mysqli_query($conn, "DELETE FROM `LISTING` WHERE `HASH62` = '{$request['id']}'");	

	///////////// ERROR REPORTING ///////////////
	if(!$u){
		mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $request[email] ."', '[{$_SERVER['PHP_SELF']}] [GET] Failed to login the user.', '". str_replace("'","`",mysql_error()) ."'," . time() . ");"); echo '{"response": "error","message": "Synclis could not delete your post, system error reported."}';		
		echo '{"response": "error","message": "Oops. It seems that we have discovered a bug, the error report has been automatically to technical support."}';
	}
	else{ echo '{"response": "success","message": "Successfully deleted the listing.'; }
	///////////// END ERROR REPORTING ///////////
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


function toBase($num) {
  $base='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $r = $num  % 62;
  $res = $base[$r];
  $q = floor($num/62);
  while ($q) {
	$r = $q % 62;
	$q =floor($q/62);
	$res = $base[$r].$res;
  }
  return $res;
}	
function to10( $num, $b=62) {
  $base='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $limit = strlen($num);
  $res=strpos($base,$num[0]);
  for($i=1;$i<$limit;$i++) {
	$res = $b * $res + strpos($base,$num[$i]);
  }
  return $res;
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


?>