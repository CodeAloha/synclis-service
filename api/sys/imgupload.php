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


	$res = mysqli_query($conn, "SELECT COUNT(`ID`) FROM `LISTING_IMAGE` WHERE `LISTING`='{$request['id']}'");
	$rst= mysqli_fetch_row($res);
	if($rst[0] >= 10) die('{"response": "error","message": "Sorry, you can only have ten images per listing."}');
	


	/*/////////////////////////////////
		DATA VALIDATION CHECK
	*//////////////////////////////////
	if($request['description'] != '')
	{
		if( strlen ( $request['description'] ) >= 64){ die('{"response": "error","message": "[Synclis API] - Caption is too long, maximum 64 characters allowed."}'); }
		if(ctype_alpha(str_replace(' ', '', $request['description'])) === false) { die('{"response": "error","message": "[Synclis API] - The Caption of your image may only contain Letters, and spaces."}'); }
	}
	

/*/////////////////////////////////
	API SERVICE
*//////////////////////////////////

if($method == 'POST')
{//[POST]: 
	if($request['id']           == ''){ die('{"response": "error","message": "[Synclis API] - Unable to upload image, unable to find this listing."}'); }
	if($request['image'] != ''){
				$str = substr($request['image'], 0, 4);
				$success= true;
				$leCODE = uniqid();
				$subdir = substr(dirname(__FILE__), 0, -7);
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
				{//Create a thumbnail
					try{
						$imagess = "https://synclis.com/media/listingimg/". $leCODE . ".png";
						$thumb = new Imagick();
						$thumb->readImage('https://synclis.com/media/listingimg/' . $leCODE . '.png');
						$thumb->resizeImage(300,150,Imagick::FILTER_CATROM,1,true);
						$thumb->writeImage('../../media/listingimg/thumb/thumb_' . $leCODE . '.png');
						$thumb->clear();
						$thumb->destroy(); 
					}catch(Exception $e)
					{//Error with ImageMagik
						mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $request[email] ."', '[{$_SERVER['PHP_SELF']}] [GET] Failed to upload a thumbnail photo. ImageMagik', '". $e->getMessage() ."'," . time() . ");");
						echo '{"response": "error","message": "Oops. It seems that we have discovered a bug, the error report has been automatically to technical support."}';
					}
				}
	}
	else{
		die('{"response": "error","message": "[Synclis API] - Image required."}');
	}
	

	$s = mysqli_query($conn, "INSERT INTO `LISTING_IMAGE` (`ID`, `LISTING`, `LOCATION`,`THUMB`,`DESCRIPTION`, `TIMESTAMP`)
	VALUES (NULL, '{$request['id']}','https://synclis.com/media/listingimg/". $leCODE . ".png','https://synclis.com/media/listingimg/thumb/thumb_" . $leCODE . ".png', '{$request['description']}','". time() ."');");	
	
	///////////// ERROR REPORTING ///////////////
	if(!$s){mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $request[email] ."', '[{$_SERVER['PHP_SELF']}] [GET] Failed to upload a photo.', '". str_replace("'","`",mysqli_error($conn)) ."'," . time() . ");"); echo '{"response": "error","message": "Oops. It seems that we have discovered a bug, the error report has been automatically to technical support."}';}
	else{ echo '{"response":"success","message":"Successfully uploaded the image."}'; }
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
	if($request['imgloc']        == ''){ print_r($request); die('{"response": "error","message": "[Synclis API] - Image location is required."}'); }
	$u = mysqli_query($conn, "DELETE FROM `LISTING_IMAGE` WHERE `LOCATION` = 'https://synclis.com/media/listingimg/{$request['imgloc']}'");
	///////////// ERROR REPORTING ///////////////
	if(!$u){
		mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '', '[{$_SERVER['PHP_SELF']}] [GET] Failed to login the user.', '". str_replace("'","`",mysql_error()) ."'," . time() . ");"); echo '{"response": "error","message": "Synclis could not delete your post, system error reported."}';		
		echo '{"response": "error","message": "Oops. It seems that we have discovered a bug, the error report has been automatically to technical support."}';
	}
	else{ 
			try{
				if($row[1] != ''){
					unlink('../../media/listingimg/'. $request['imgloc']);
					unlink('../../media/listingimg/thumb/thumb_'. $request['imgloc']);
					echo '{"response": "success","message": "Successfully deleted the image."}';
				}
			}catch(Exception $e){
				mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, 'SYSTEM API', '[{$_SERVER['PHP_SELF']}] [GET] Failed to Remove Image', '". $e ."'," . time() . ");");
			}	
	}
	///////////// END ERROR REPORTING ///////////
}
else if($method == 'CLEAR')
{//[DELETE]: You can only delete listing if API key matches user
	if($request['id']        == ''){ print_r($request); die('{"response": "error","message": "[Synclis API] - Listing ID is required."}'); }
	
	$u = mysqli_query($conn, "SELECT `LOCATION` FROM `LISTING_IMAGE` WHERE `LISTING`='{$request['id']}'");
	mysqli_query($conn, "DELETE FROM `LISTING` WHERE `HASH62` = '{$request['id']}'");
	mysqli_query($conn, "DELETE FROM `LISTING_IMAGE` WHERE `LISTING` = '{$request['id']}'");
	mysqli_query($conn, "DELETE FROM `LISTING_LAYOUT` WHERE `LISTING` = '{$request['id']}'");
	mysqli_query($conn, "DELETE FROM `LISTING_VIDEO` WHERE `LISTING` = '{$request['id']}'");
	
	while($row = mysqli_fetch_row($u))
	{
		try{
			$q = explode("listingimg/",$row[0]);
			if($row[1] != ''){
				unlink('../media/listingimg/'. $q[1]);
				unlink('../media/listingimg/thumb/thumb_'. $q[1]);
			}
		}catch(Exception $e){
			mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, 'SYSTEM API [IMAGE CLEAR]', '[{$_SERVER['PHP_SELF']}] [GET] Failed to Remove Image', '". $e ."'," . time() . ");");
		}
	}
	///////////// ERROR REPORTING ///////////////
	if(!$u){
		mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '', '[{$_SERVER['PHP_SELF']}] [GET] Failed to login the user.', '". str_replace("'","`",mysql_error()) ."'," . time() . ");"); echo '{"response": "error","message": "Synclis could not delete your post, system error reported."}';		
		echo '{"response": "error","message": "Oops. It seems that we have discovered a bug, the error report has been automatically to technical support."}';
	}
	else{ echo '{"response": "success","message": "Successfully cleared the listing.'; }
	///////////// END ERROR REPORTING ///////////
}
else if($method == 'GET')
{//[GET]: 
	if($request['id']        == ''){ die('{"response": "error","message": "[Synclis API] - Search ID is required."}'); }
	$u = mysqli_query($conn, "SELECT `THUMB`,`DESCRIPTION` FROM `LISTING_IMAGE` WHERE `LISTING`='{$request['id']}'");
	$res = '';
	if(mysqli_num_rows($u) === 0){
		die('{"response": "success","message": "No search results found."}');
	}
	
	$res .= '{"items":[';
	while($row = mysqli_fetch_row($u)){
		$res .= '{"img": "'.$row[0].'","alt": "'.$row[1].'"},';
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





?>