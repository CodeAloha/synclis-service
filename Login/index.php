<?php 
	include('connectToDB.php');
	session_start(); 

	// change the following paths if necessary 
	$config = dirname(__FILE__) . '/hybridauth/config.php';
	require_once( "hybridauth/Hybrid/Auth.php" );

	// check for erros and whatnot
	$error = "";
	
	if( isset( $_GET["error"] ) ){
		$error = trim( strip_tags(  $_GET["error"] ) ) . " ";
	}

	// if user select a provider to login with
		// then inlcude hybridauth config and main class
		// then try to authenticate te current user
		// finally redirect him to his profile page
	if( isset( $_GET["provider"] ) && $_GET["provider"] ):
		try{
			// create an instance for Hybridauth with the configuration file path as parameter
			$hybridauth = new Hybrid_Auth( $config );
 
			// set selected provider name 
			$provider = @ trim( strip_tags( $_GET["provider"] ) );

			// try to authenticate the selected $provider
			$adapter = $hybridauth->authenticate( $provider );

			// if okey, we will redirect to user profile page 
			$hybridauth->redirect( "profile.php?provider=$provider" );
		}
		catch( Exception $e ){
			// In case we have errors 6 or 7, then we have to use Hybrid_Provider_Adapter::logout() to 
			// let hybridauth forget all about the user so we can try to authenticate again.

			// Display the recived error, 
			// to know more please refer to Exceptions handling section on the userguide
			switch( $e->getCode() ){ 
				case 0 : $error = "Unspecified error."; break;
				case 1 : $error = "Hybriauth configuration error."; break;
				case 2 : $error = "Provider not properly configured."; break;
				case 3 : $error = "Unknown or disabled provider."; break;
				case 4 : $error = "Missing provider application credentials."; break;
				case 5 : $error = "Authentication failed. The user has canceled the authentication or the provider refused the connection."; break;
				case 6 : $error = "User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again."; 
					     $adapter->logout(); 
					     break;
				case 7 : $error = "User not connected to the provider."; 
					     $adapter->logout(); 
					     break;
			} 

			// well, basically your should not display this to the end user, just give him a hint and move on..
			$error .= $e->getMessage() . " TRACE: " . $e->getTraceAsString();
		}
    endif;
	
	// if we got an error then we display it here
	if( $error ){
		mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)
		VALUES (NULL, '0', '[{$_SERVER['PHP_SELF']}] [GET] Failed to create a bookmark for a listing.', '". 'Login Page Error:' . $error . '->'. print_r( $_SESSION, true ) ."'," . time() . ");");
	}
?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
<!--SEO TAGS-->
<title>Login | Synclis</title>
<meta name='description' content='Sign up for Synclis and begin sharing your listings, events and services within your local community.'>
<meta name="ROBOTS" content="INDEX, NOFOLLOW" />
<link rel="publisher" href="https://plus.google.com/u/0/b/111736498704458786396/">
<meta property="og:title" content="Login | Synclis"/>
<meta property="og:type" content="article" />
<meta property="og:image" content="https://synclis.com/media/symbolwhitebg.png">
<meta property="og:url" content='https://synclis.com/Login'>
<meta property="og:description" content='Sign up for Synclis and begin sharing your listings, events and services within your local community.'>
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="Login | Synclis" />
<meta name="twitter:url" content='https://synclis.com/Login'>
<meta name="twitter:description" content='Sign up for Synclis and begin sharing your listings, events and services within your local community.'>
<meta name="twitter:image" content="https://synclis.com/media/symbolwhitebg.png">
<!--SEO TAGS-->
		
		<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans:300,300italic,700,700italic|Open+Sans:700|Raleway:400|Raleway:700&#038;subset=latin,latin-ext' type='text/css' media='all' />
		<script src="../wp-content/pace.min.js"></script>
		<link href="../wp-content/dataurl.css" rel="stylesheet" />
		<style>
			*{
				 font-family: "Open Sans", "Helvetica Neue", Helvetica, sans-serif;
			}
			
			body{ background-image: url('public/light_grey.png');
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
		position:absolute; top:0; left: 0; right:0;
		width:30%;
		min-width: 300px;
		opacity: 0; border: 1px solid #aaa; border-radius: 4px; background: #ddd; background: rgba(215,215,215,0.7);
		margin: 0 auto;
	}
	
		</style>
	</head>
    <body onLoad = "peerIn();">
	<style>
		.socialhang{ position: fixed; top:6%; left:0; z-index: 9999; }
		.socialhang ul { padding:0; margin:0;}
		.socialhang ul li{ list-style: none; }
		.socialhang ul li a div{
			padding: 12px;
			opacity: 0.7;
			width: 25px; height: 25px; overflow: hidden;
			transition: opacity 0.4s, width 0.4s;
			-webkit-transition: opacity 0.4s, width 0.4s;
			-moz-transition: opacity 0.4s, width 0.4s;
			-o-transition: opacity 0.4s, width 0.4s;
			color: white;
		}
		.socialhang ul li a div:hover{opacity:1; width: 200px;}
		.socialhang img {min-width:200px;width: 100%; height: 30px; float:left;}
		
	@media screen and (max-width: 480px) {
		.socialhang{ position: fixed; top:0; left:0; z-index: 9999; }
		.socialhang ul li{ float:left; }
		.socialhang ul li a div{ padding: 5px; opacity:1; width: 200px;}
		#loginp{
			width: 300px;
		}
		.hidemobile{
			display:none;
		}
	}
	.synclis-input{
		background: white; padding: 12px 0px 12px 10px; margin-bottom: 8px;
	}
		
	</style>
		<div id="loginp">
			<div style = "background: #fff; text-align:center; padding-top:24px; border-radius: 4px 4px 0 0;">
				<img src="https://synclis.com/media/logo.png"><br/>
				<b style = "font-weight: normal; font-size: 120%;">LOG IN</b><br/><br/>
			</div>
			<div id="expand" style= "padding: 18px; height: 110px;">
				<center>
				<input class="synclis-input" type="email"    placeholder="Email"    id="username" onChange="changeCheck('user');" value=""><br/>
				<input class="synclis-input" type="password" placeholder="Password" id="password" onChange="changeCheck('pass');" value=""><br/>
				
				<div id="signup" style = "display: none; opacity:0;">
					<input class="synclis-input" type="password" placeholder="Password Again" id="password2" onChange="" value=""><br/><br/>
				
						<div style="width:50%; float:left;"><input class="synclis-input" type="text"         placeholder="First Name" id="fname" onChange="" style="padding: 12px 0px 12px 10px;"></div>
						<div style="width:50%; float:left;"><input class="synclis-input" type="text"          placeholder="Last Name" id="lname" onChange="" style="padding: 12px 0px 12px 10px;"></div>
					
					<div style="clear:both;"></div>
					<input type="text" class="synclis-input" placeholder="Address" id="address" onChange="" value=""><br/>
					<input type="text" class="synclis-input" placeholder="Zip Code" id="zip" onChange="" value="">
				</div>
				
				</center>
			</div>
			<div style = " background: #fff; padding: 18px; font-size: 12px; border-radius: 0 0 3px 3px;">
				<a href="Javascript:;" onClick="login();"><button id="lginbtn" style = "width: 101%; padding: 8px;">Log In</button></a><br/><br/>
				<a href="Javascript:;" id="fpt" onClick="emailNote();" style="float:left;">Forgot password</a>
				<a href="Javascript:;" id="btt" onClick="collapse();" style="float:right;">Sign up</a>
				<div style="clear:both;"></div>
			</div>

		</div>
		
		
				<!--Social Login Functions -->
			<div id="socialhang" class="socialhang">
				
				<ul>
					<li><a href="?provider=Facebook">  <div style="background: #4E6BBB;"><img src="public/icon/Facebook.png" /></div></a></li>
					<li class="hidemobile"><a href="?provider=Twitter">   <div style="background: #44A5F0;"><img src="public/icon/Twitter.png" /></div></a></li>
					<li class="hidemobile"><a href="?provider=Google">    <div style="background: #D63F2A;"><img src="public/icon/Google.png" /></div></a></li>
					<li class="hidemobile"><a href="?provider=LinkedIn">  <div style="background: #4476AB;"><img src="public/icon/LinkedIn.png" /></div></a> </li>
					<li class="hidemobile"><a href="?provider=Foursquare"><div style="background: #2B89D3;"><img src="public/icon/Foursquare.png" /></div></a></li>
					<li class="hidemobile"><a href="?provider=AOL">       <div style="background: #404040;"><img src="public/icon/AOL.png" /></div></a></li>
				</ul>
			</div>
	<!--Social Login Functions -->
		
    </body>
	
	
		<!--Alertify-->
	
		<script src="../wp-includes/js/jquery/jquery-1.9.1.js"></script>
		<script type='text/javascript' src='../wp-includes/js/jquery/jquery-migrate.min.js?ver=1.2.1'></script>
		<link rel="stylesheet" href="../wp-content/plugins/alertify/css/alertify.core.css" />
		<link id="#toggleCSS" rel="stylesheet" href="../wp-content/plugins/alertify/css/alertify.default.css" />
		<script src="../wp-content/plugins/alertify/js/lib/alertify.min.js"></script>
		<script>
		var pushMsg = '';var p = "LogIn"; var clicked = false;
		function reset () {
			$("#toggleCSS").attr("href", "../wp-content/plugins/alertify/css/alertify.default.css");
			alertify.set({
				labels : {
					ok     : "OK",
					cancel : "Cancel"
				},
				delay : 5000,
				buttonReverse : false
			});
		}

		$("#delay").on( 'click', function () {
			reset();
			alertify.set({ delay: 10000 });
			alertify.log("Hiding in 10 seconds");
			return false;
		});

		
		function pushNote(vals){
			reset();
			alertify.custom = alertify.extend("custom");
			alertify.custom(vals);
		}
		//END ALERTIFY
		
		function emailNote(){
			if(!clicked)
			{//If clicked before animation finished prevent.
				clicked = true;
				
				document.getElementById('password').style.display = "none";
				pushNote("Enter your email to renew your password.");
				document.getElementById("lginbtn").innerHTML  = "Send Password Reset";
				p="email";
				document.getElementById("btt").innerHTML  = "Log In";
				document.getElementById("fpt").style.display="";
				setTimeout(function(){
					clicked = false;
				},100);
			}
		}
		
		function collapse(){
			if(!clicked){
				clicked = true;
				document.getElementById("signup").style.transition = "opacity 0.4s linear";
				document.getElementById("signup").style.WebkitTransition = "opacity 0.4s linear";
				document.getElementById("expand").style.transition  = "min-height 1s linear";
				document.getElementById("expand").style.WebkitTransition = "min-height 1s linear";
				
				if(p=="LogIn"){
						document.getElementById("expand").style.minHeight = "338px";
						document.getElementById("lginbtn").innerHTML = "Sign Up";
						document.getElementById("btt").innerHTML  = "Log In";
						document.getElementById('password').style.display = "";
						document.getElementById("fpt").style.display="none";
						setTimeout(function(){
							document.getElementById("signup").style.display = "";
							setTimeout(function(){
								document.getElementById("signup").style.opacity = "1";
							},400);
						},1000);
						p = "SignUp";
				}
				else{
						document.getElementById("lginbtn").innerHTML  = "Log In";
						document.getElementById("btt").innerHTML  = "Sign Up";
						document.getElementById("signup").style.opacity = "0";
						document.getElementById('password').style.display = "";
						document.getElementById("fpt").style.display="";
						setTimeout(function(){
							document.getElementById("signup").style.display = "none";
						},400);
						
						setTimeout(function(){
							document.getElementById("expand").style.minHeight = "110px";
						},1000);
						p = "LogIn";
				}
				setTimeout(function(){
					clicked = false;
				},2000);
			}else{
				pushNote("Try again in a second.");
			}
		}
		
		
	
		function peerIn(){
			document.getElementById("loginp").style.transform = 'translate3d(0, 0, 0)';
			document.getElementById("loginp").style.webkitTransform = 'translate3d(0, 0, 0)';
			document.getElementById("loginp").style.transition = "opacity 2s, top 1s";
			document.getElementById("loginp").style.WebkitTransition = "opacity 2s, top 1s";
			document.getElementById("loginp").style.opacity = 1;
			document.getElementById("loginp").style.top = "8%";
		}
	
		if(window.innerWidth <= 720){
			document.getElementById("synclis-filter-panel").style.display = "none";
		}
		
	</script>
	<script type="text/javascript" src="public/sha.js"></script>
	<script type="text/javascript" src="public/login.js"></script>
	
</html>
