<?php

		
//define the receiver of the email
$to = "Chris@OneCupOfJava.com";
//define the subject of the email
$subject = "[Synclis] Someone has sent us a suggestion"; 
//define the message to be sent. Each line should be separated with \n
$message = "Message from ({$_POST['email']}),
\n\n

{$_POST["message"]}\n

"; 
//define the headers we want passed. Note that they are separated with \r\n
$headers = "From: {$_POST['email']}\r\nReply-To: {$_POST['email']}";
//send the email
$mail_sent = @mail( $to, $subject, $message, $headers );
				
if($mail_sent)
	echo "1";
else
	echo "0";

	
?>