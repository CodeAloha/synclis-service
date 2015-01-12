<?php
	include('../connectToDB.php');
	include('lib/core.php');
	include('lib/tools.php');
/*
[LOGIN API] Synclis Service RESTFUL API

Request permitted only within server.

 
 [GET] email      AUTH-REQ -> Used to retrieve users email.
 [GET] listingID   
 [GET] Header
 [GET] Message
*/

		if($request['email'] == '' || !filter_var($request['email'], FILTER_VALIDATE_EMAIL)){ die('{"response": "error","message": "Your e-mail is required."}'); }
/*/////////////////////////////////
	DATA VALIDATION CHECK
*//////////////////////////////////
	if($method == 'POST'){

		$t = mysqli_query($conn,"SELECT `USER`.`FIRST_NAME`, `USER`.`LAST_NAME`, `USER`.`EMAIL`, `LISTING`.`NAME`,`LISTING`.`USER`,`LISTING`.`HASH62` FROM `LISTING` LEFT JOIN `USER` ON `USER`.`ID`=`LISTING`.`USER` WHERE `LISTING`.`HASH62`='". $request['listing'] ."' LIMIT 1");
		$receiver = mysqli_fetch_row($t);
		if(!$t){die('{"response": "error","message": "User does not exist."}'); }
		else
		{
			
			mysqli_query($conn,"UPDATE `LISTING` SET `INQUIRIES` = `INQUIRIES` + 1 WHERE  `LISTING`.`HASH62`='" . $receiver[5]. "';");
if($receiver[2] == '' || $receiver[2] == null){ $email = $receiver[4]; $receiver[0] ="Anonymous User"; }
else    /*If User is not anonymous */         { $email = $receiver[2]; }


$to  = $email;

// subject
$subject = '[Synclis] ' . $request['header'];

// message
$message = '
<html>
<head>
  <title>'.$request['header'].'</title>
</head>
<body>
  <img src="https://synclis.com/media/logo.png"/>
  <p>Someone sent you a message from your '. $receiver[3] .' post:</p>
  '. $request['message'] .'<br/><br/>
  <a href = "https://synclis.com/ViewPost">Click here to respond anonymously.</a><br/>
  * Or respond to this message to respond to '. $request['email'] .' as normal email conversation.
</body>
</html>';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers 
$headers .= 'To: '. $receiver[0] .' ' . $receiver[1] . ' <'. $email .'>' . "\r\n";
$headers .= 'From: Interested Client <'. $request['email'] .'>' . "\r\n";

// Mail it
mail($to, $subject, $message, $headers);
		echo '{"response":"success","message":"The message has been successfully sent."}';
		}
	}
	else{
		_response('Invalid Method', 405);
		echo '{"response": "error","message": "Method supplied does not exist."}';
	}


?>