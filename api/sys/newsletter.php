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


/*/////////////////////////////////
	DATA VALIDATION CHECK
*//////////////////////////////////
	
	if(!filter_var($request['email'], FILTER_VALIDATE_EMAIL)){ die('{"response": "error","message": "Invalid Email Address."}'); }

/*/////////////////////////////////
	SEND MESSAGE
*//////////////////////////////////

	if($method == 'POST'){
		
		mysqli_query($conn,"INSERT INTO `NEWSLETTER` (`ID`, `EMAIL`, `TIMESTAMP`) VALUES (NULL, '{$_POST['email']}', '".time()."');");
		
		$t = mysqli_query($conn,"SELECT `USER`.`FIRST_NAME`, `USER`.`LAST_NAME`, `USER`.`EMAIL`, `LISTING`.`NAME` FROM `USER` LEFT JOIN `LISTING` ON `LISTING`.`USER`=`USER`.`ID` WHERE `LISTING`.`HASH62`='". $request['listing'] ."' LIMIT 1");
		$receiver = mysqli_fetch_row($t);

		if(!$t){die('{"response": "error","message": "User does not exist."}'); }
		else
		{
// multiple recipients
$to = $request['email']; // note the comma

// subject
$subject = '[Synclis] Thanks for your support.';

// message
$message = '
<html>
<head>
  <title>Thanks for your support.</title>
</head>
<body>
<table border="0" cellpadding="0" cellspacing="0" width="600" style="margin-bottom:20px;border:1px solid #eee">
            	<tbody><tr>
                	<td align="center" valign="top">
                    	<table border="0" cellpadding="0" cellspacing="0" width="600" style="background-color:#fff;">
                        	<tbody><tr>
                            	<td align="center" valign="top">
                                	<table border="0" cellpadding="0" cellspacing="0" width="600">
                                        <tbody>
                                        <tr>
                                        	<td>
												&emsp;
                                        	</td>
                                        </tr>
										<tr>
                                            <td>&emsp;&emsp;<img src="https://synclis.com/media/logo.png" alt="Synclis"></td>
                                        </tr>
                                        <tr>
                                        	<td>
												&emsp;
                                        	</td>
                                        </tr>
                                    </tbody></table>
                                </td>
                            </tr>
                        	<tr>
                            	<td align="center" valign="top">
                           	    	<table border="0" cellpadding="0" cellspacing="0" width="600" style=" background-color:#fafafa;">
                                    	<tbody><tr>
                                    		<td>
					                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="color:#555555;font-family:Tahoma,Arial;font-size:14px;line-height:150%;text-align:left">
													<tbody><tr>
														<td style="padding-top:15px;padding-right:25px;padding-bottom:15px;padding-left:20px" valign="top">
															
															<p style="font-family: \'Helevtica Nueue\', Helvetica;  padding: 12px; border-radius: 3px; color: #777; background: #fff;">
																<b style="color:#1FB5AC;">Thank you for your interest in our beta testing.</b>
																<br><br>
																We are excited to see the progression of the project as it\'s direction is in dependence of you.
																<br><br/>
																<i style="color:#1FB5AC; font-style:normal;">Your input is valuable.</i> We will make real time live updates on Synclis, in accordance to your suggestions during the beta test.
																<br><br/><br/>
																We will send you a message to inform you when testing begins.
															</p>														
															<br/>
															<p style="color:#999999;margin-top:0;margin-bottom:.8em;font-family:Arial,Helvetica,sans-serif;line-height:14px">Thank you again for your support, and see you on Thursday.</p>

															<p style="color:#999999;margin-top:0;margin-bottom:.5em;font-family:Arial,Helvetica,sans-serif;line-height:14px"><i style="color:#1FB5AC; font-style:normal;">Synclis Team.</i></p>

															
														</td>
													</tr>
													</tbody>
												</table>
											</td>
                                        </tr>
                                    </tbody></table>
                            	</td>	
                            </tr>
                        </tbody></table>
                    </td>
                </tr>
                <tr>
                	<td align="center" valign="top">
            		    <table border="0" cellpadding="10" cellspacing="0" width="600" style="padding-top:5px;padding-left:10px;background-color:#f1f1f1;color:#777777">
            		        <tbody><tr>  
                			    <td>
                                    <p style="color:#a3a3a3;font-family:Tahoma,Geneva,sans-serif;font-size:10px">Please do not reply to this message; it was sent from an unmonitored email address. This message is a service email based on your newsletter subscription. For information or requested support please consult our <a href="mailto:support@synclis.com" style="color:#1FB5AC; text-decoration:none" target="_blank">Synclis Support Center</a></p>
                			    </td>    
                    		</tr>
                    	</tbody></table>


                    </td>
                </tr>
            </tbody></table>
</body>
</html>';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers 
$headers .= 'To: You <'. $request['email'] .'>' . "\r\n";
$headers .= 'From: Synclis <no-reply@synclis.com>' . "\r\n";
$headers .= 'Reply-To: no-reply@synclis.com' . "\r\n";
$headers .= 'X-Mailer: PHP/' . phpversion();

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