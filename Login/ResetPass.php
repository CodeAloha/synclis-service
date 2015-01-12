<?php
	include('../api/connectToDB.php');

	if(!$_GET['c'] || $_GET['c'] == '' || !base64_decode($_GET['c'], true)){
		echo "Unable to process password reset, please try again.<br/>Redirecting in 3 seconds..";
		echo "<script>setTimeout(function(){ window.location='https://synclis.com/Login'; },3500);</script>";
	}
	else{
		$result = mysqli_query($conn,"SELECT `USER`.`CLEAN_NAME` FROM `USER`
															LEFT JOIN `USER_LOGIN` ON `USER_LOGIN`.`ID`=`USER`.`ID`
																WHERE `USER_LOGIN`.`P_RESET` ='". $_GET['c'] ."';");
		
		if (!$result) {
			echo "Unexpected error has occured, This is a system error and has been automatically reported.<br/>
				  Unable to complete your registration, please try again<br/>Redirecting in 3 seconds..";
			echo "<script>setTimeout(function(){ window.location='https://synclis.com/Login'; },3500);</script>";
			mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $_GET['c']."', '[{$_SERVER['PHP_SELF']}] [PUT] Unable to complete password reset.', '". str_replace("'","`",mysqli_error($conn)) ."'," . time() . ");");
		}
		$t = mysqli_fetch_row($result);
	}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Password Reset | Synclis</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans:300,300italic,700,700italic|Open+Sans:700|Raleway:400|Raleway:700&#038;subset=latin,latin-ext' type='text/css' media='all' />
		
		<style>
			*{
				 font-family: "Open Sans", "Helvetica Neue", Helvetica, sans-serif;
			}
			


			input{
				-webkit-transform: translate3d(0, 0, 0);
				width:94%; padding: 3%;
				font-size: 15px;
				border-radius: 3px;
				border: 1px solid #fff;
				transition: all 0.4s;
				-webkit-transition: all 0.4s;
			}
			input:focus{
				width:92%; padding: 3% 4% 3% 4%;
				border: 1px solid #1FB5AC;
			}

    button{
		border: 1px solid #ddd;
		background: #f0f0f0;
		-webkit-box-shadow: 2px 2px 2px 1px rgba(220,220,220,1);
		   -moz-box-shadow: 2px 2px 2px 1px rgba(220,220,220,1);
		        box-shadow: 2px 2px 2px 1px rgba(220,220,220,1);
		border-radius: 3px;
		transition: color 0.4s;
		-webkit-transition: color 0.4s;
		color: #777;
	}
	button:hover{
		-webkit-box-shadow: inset 2px 2px 2px 1px rgba(220,220,220,1);
		   -moz-box-shadow: inset 2px 2px 2px 1px rgba(220,220,220,1);
		        box-shadow: inset 2px 2px 2px 1px rgba(220,220,220,1);
		color: #222;
	}
	a{	
		-webkit-transform: translate3d(0, 0, 0);
		text-decoration: none;
		transition: color 0.4s;
		color: #888;
		-webkit-transition: color 0.4s;
	}
	a:visited{
		color: #888;
	}
	a:hover{
		color: #1FB5AC;
	}
	#loginp{
		-webkit-transform: translate3d(0, 0, 0);
	}
	
		</style>
	</head>
    <body>
		<div id="loginp" style="opacity: 1; border: 1px solid #aaa; border-radius: 4px; background: rgba(215,215,215,0.7); min-width: 270px; max-width: 480px; margin: 8% auto;">
			<div style = "background: #fff; text-align:center; padding-top:24px; border-radius: 4px 4px 0 0;">
				<img src="https://synclis.com/media/logo.png"><br/>
				<b style = "font-weight: normal; font-size: 120%;">NEW PASSWORD</b><br/><br/>
			</div>
			<div id="expand" style= "padding: 18px; height: 110px;">
				<center>
					<input type="password" placeholder="Password" id="password"  value=""><br/>
					<input type="password" placeholder="Password Again" id="password2" value=""><br/><br/>
				</center>
			</div>
			<div style = " background: #fff; padding: 18px; font-size: 12px; border-radius: 0 0 3px 3px;">
				<a href="Javascript:;" onClick="setPass();"><button id="lginbtn" style = "width: 101%; padding: 8px;">Reset Password</button></a><br/><br/>
				<a href="https://synclis.com/Login" style="float:left;">< Back To Login</a>
				<div style="clear:both;"></div>
			</div>
		</div>
		<a href="Javascript:;" id="custom" style="display:none;">x</a>
    </body>
	
	<script type="text/javascript" src="https://synclis.com/Login/public/sha.js"></script>
	<script>
	function calcHash(value) {
		try {
			var hashObj = new jsSHA(value, "TEXT");
			return hashObj.getHash("SHA-512","HEX",1);
		} catch(e) {
			alert('Unable to process password');
		}
	}
	if(document.URL.substr( 0, 5) != 'https'){
		window.location="https://synclis.com/Login/ResetPass/<?php echo $_GET['c']; ?>";
	}
	
	function setPass(){
		if(document.getElementById('password').value == ''){
			document.getElementById('password').style.border = '1px solid #faa';
			document.getElementById('password2').style.border = '1px solid #faa';
			alert("Passwords field left empty");
		}
		else if(document.getElementById('password').value != document.getElementById('password2').value){
			document.getElementById('password').style.border = '1px solid #faa';
			document.getElementById('password2').style.border = '1px solid #faa';
			alert("Passwords do not match.");
		}
		else{
			synclis_pwdrst();
		}
	}
	
	function synclis_pwdrst(){
		var http = new XMLHttpRequest();
		//Must be encrypted with SHA 128, 256, 512
		http.open("PUT", "https://synclis.com/api/sys/passreset/<?php echo $t[0]; ?>", true);
		var params = '{"password":"'+ calcHash(document.getElementById('password').value) +'"}';
		
		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		http.setRequestHeader('Content-type', 'application/json');
		http.onreadystatechange = function() {
			if(http.readyState == 4 && http.status == 200)
			{
				try{
					var json = JSON.parse(http.responseText);
					if(json.response == 'error'){
						alert(json.message);
					}
					else if (json.response == 'success'){
						window.location = "https://synclis.com/Login";
					}
					else{
						alert("Unexpected error has occured.");
					}
				}catch(e){
					alert(http.responseText);
					setTimeout(function(){
						window.location = "https://synclis.com/";
					},1000);
				}
			}
		}
		http.send(params);
	}
	</script>
	
</html>