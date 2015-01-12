<?php 
	/*Begin Get Group Feed From Facebook.*/
    $config = dirname(__FILE__) . '/../Login/hybridauth/config.php';
    require_once( "../Login/hybridauth/Hybrid/Auth.php" );

	// initialise hybridauth
	$hybridauth = new Hybrid_Auth( $config );

include('../meta.php');
?>
<!DOCTYPE html>
<!--[if IE 8]><html class="no-js ie8" lang="en-US"><![endif]-->
<!--[if IE 9]><html class="no-js ie9" lang="en-US"><![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" lang="en-US"><!--<![endif]-->
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--SEO TAGS-->
	<title>Create your listing | Synclis</title>
	<meta name='description' content='Synclis is a powerful peer to peer listing resource made with you in mind. It also uses Social Media to get the most out of your listings. It is free to get started, why not post your listings today?'>
	<meta name="ROBOTS" content="INDEX, NOFOLLOW" />
	<link rel="publisher" href="https://plus.google.com/u/0/b/111736498704458786396/"/>
	<meta property="og:title" content="Discover Synclis"/>
	<meta property="og:type" content="article" />
	<meta property="og:image" content="https://synclis.com/media/symbolwhitebg.png"/>
	<meta property="og:url" content="https://synclis.com"/>
	<meta property="og:description" content="Synclis is a powerful peer to peer listing resource made with you in mind. It also uses Social Media to get the most out of your listings. It is free to get started, why not post your listings today?" />
	<meta name="twitter:card" content="summary">
	<meta name="twitter:title" content="Discover Synclis" />
	<meta name="twitter:url" content="https://synclis.com"/>
	<meta name="twitter:description" content="Synclis is a powerful peer to peer listing resource made with you in mind. It also uses Social Media to get the most out of your listings. It is free to get started, why not post your listings today?">
	<meta name="twitter:image" content="https://synclis.com/media/symbolwhitebg.png">
	<!--SEO TAGS-->
  
  <link rel="shortcut icon" href="../../favicon.ico" />
  <?php
	if(!$_GET['c'] || !ctype_alpha ($_GET['c']) || !$_GET['s'] || !ctype_alpha ( $_GET['s']) ){
		echo "<script>window.location='https://synclis.com/CreateListing/Select';</script>";
	}
	else{
		$t = mysqli_query($conn,"SELECT `SECTION`.`LISTING_TYPE`, `CATEGORY`.`ID`, `CATEGORY`.`ICON` FROM `SECTION` LEFT JOIN `CATEGORY` ON `CATEGORY`.`SECTION`=`SECTION`.`ID`
		WHERE `SECTION`.`SECTION`='". preg_replace('/\B([A-Z])/', ' $1', $_GET['s']) ."' AND `CATEGORY`.`NAME`='". preg_replace('/\B([A-Z])/', ' $1', $_GET['c']) ."' LIMIT 1");
		$cat = mysqli_fetch_row($t);
		
		if(!$cat){
			echo "<script>window.location='https://synclis.com/CreateListing/Select';</script>";
		}
		if(!$_COOKIE["SYNCLIS_PL"]){
			do{
				$uniqkey = makeKey();
				$y = mysqli_query($conn,"SELECT EXISTS(SELECT 1 FROM `LISTING` WHERE `HASH62`='{$uniqkey}');");
				$chk = mysqli_fetch_row($y);
			}while($chk[0]);
		}else{
			$uniqkey = $_COOKIE["SYNCLIS_PL"];
		}
		
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
  

<link rel='stylesheet' href='../../wp-content/plugins/x-custom/x-custom.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../../wp-content/plugins/x-shortcodes/css/renew.css' type='text/css' media='all' />
<link rel='stylesheet' href='../../wp-content/themes/x/framework/css/site/stacks/renew.css' type='text/css' media='all' />
<link rel='stylesheet' href='../../wp-content/primary.css' type='text/css' media='all' />
<link rel='stylesheet' href='../screenres.css' type='text/css' media='all' />

<script type='text/javascript' src='../../wp-includes/js/jquery/jquery-1.9.1.js'></script>
<script type='text/javascript' src='../../wp-includes/js/jquery/jquery-migrate.min.js?ver=1.2.1'></script>
<script type='text/javascript' src='../../wp-content/themes/x/framework/js/x.min.js'></script>
<script type='text/javascript' src='../../api/cookies.js'></script>

<link rel='stylesheet' href='../../wp-content/plugins/magnificpopup/css/magnific-popup.css' type='text/css' media='all' />
<script type='text/javascript' src='../../wp-content/plugins/x-shortcodes/js/vendor/backstretch-2.0.3.min.js'></script>
<script type='text/javascript' src='../../wp-content/plugins/x-shortcodes/js/vendor/modernizr-2.7.1.min.js'></script>
<script type='text/javascript' src='../../wp-content/plugins/x-shortcodes/js/vendor/fittext-1.1.0.min.js'></script>

<link href="../owl-carousel/owl.carousel.css" rel="stylesheet">
<link href="../owl-carousel/owl.theme.css" rel="stylesheet">
<script src="../owl-carousel/owl.carousel.js"></script>
<script src="../../wp-content/pace.min.js"></script>
<link href="../../wp-content/dataurl.css" rel="stylesheet" />


    <style>
      #map-canvas {
        height: 400px;
        margin: 0px;
        padding: 0px
      }
	  .synclis-stp{
		border: 1px solid #ddd; border-radius: 3px; padding: 12px; margin-bottom: 6px; position: relative; background: white;
	  }
	  #pageEditor{
		width: 100%;
	  }
	  #pageEditor ul{
		margin:0;
		padding:0;
		text-align: center;
	  }
	  #pageEditor ul li{
		list-style:none;
		float: left;
		width: 33.333%;
	  }
	  #pageEditor ul li div{
		width: 100%;
		padding: 12px;
		border-top: 2px solid #ddd;
		border-right: 2px solid #ddd;
	  }
	  #pageEditor ul li div:hover, #pageEditor ul li div.selected{
		-webkit-box-shadow: inset 2px 2px 2px 1px rgba(220,220,220,0.7);
		-moz-box-shadow: inset 2px 2px 2px 1px rgba(220,220,220,0.7);
		box-shadow: inset 2px 2px 2px 1px rgba(220,220,220,0.7);
		background: #fcfcfc;
		color: #1FB5AC;
	  }
	  
		#owl-demo .owl-item{
			margin: 3px;
		}
		#owl-demo .owl-item img{
			display: block;
			max-height: 250px;
			height: auto;
		}

		/*Youtubr Styles*/
		.youtube{
			font-size: 14px;
			height: 300px;
			overflow-y: auto;
		}
		.youtube li{
			padding: 0px;
			margin: 4px;
			border: 1px solid #ccc;
			border-radius: 3px;
			list-style:none;
		}
		.youtube img{
			float:left;
			margin-right: 7px;
		}
		.selectYoutube{
			width: 100%;
			border-top: 1px solid #eee;
			text-align: center;
			padding: 5px;
			background: #eee;
			color: #1FB5AC;
		}
		
		.mediatools{
			width: 100%;
			margin:0;
			padding:0;
			margin-left: 33.33%;
		}
		.mediatools li{
			float:left;
			text-align: center;
			width: 33.33%;
		}
		.mediatools li div{
			width: 100%; padding: 7px;
			border-bottom: 1px solid #ddd;
			border-left: 1px solid #ddd;
			background: #f1f1f1;
			transition: background 0.4s;
			-moz-transition: background 0.4s;
			-o-transition: background 0.4s, color;
			-ms-transition: background 0.4s, color 0.4s;
			
		}
		.mediatools li div:hover{
			background: #eee;
		-webkit-box-shadow: inset 2px 2px 2px 1px rgba(220,220,220,1);
		   -moz-box-shadow: inset 2px 2px 2px 1px rgba(220,220,220,1);
		        box-shadow: inset 2px 2px 2px 1px rgba(220,220,220,1);
		}
		
    </style>
	
	<script type="text/javascript" src="../../api/base64.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=drawing"></script>
    <script>
	var marker, map;
	var minZoomLevel = 5;
	function initialize() {
	  var mapOptions = {
		zoom: 15,
		center: new google.maps.LatLng(37.090240,-95.712891),
		minZoom: 12
	  }
	  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
	  geocoder = new google.maps.Geocoder();
	  
	  var geoloc = Base64.decode(readCookie('SYNCLIS_CURPOS')).split(":");
	  codeAddress(geoloc[0] + ", " + geoloc[1] + ", " + geoloc[2]);
	  
	}
	google.maps.event.addDomListener(window, 'load', initialize);
	
	function codeAddress(address) {
		geocoder.geocode( { 'address': address}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
			  map.setCenter(results[0].geometry.location);
			  if(marker) marker = null;
			  marker = new google.maps.Marker({
				  position: results[0].geometry.location,
				  map: map,
				title: 'Set lat/lon values for this listing',
				draggable: true
			  });
			} else {
			  mapOn = false;
			  document.getElementById('displayMap').style.display = "none";
			}
		});
	}
	
	setInterval(function(){
		if(marker) map.panTo(new google.maps.LatLng(marker.getPosition().lat(), marker.getPosition().lng()));
	},5000);

	function loadcontent(){
		setTimeout(function(){
			synclis_shiftContentMode('simp');
		},200);
	}
	
	</script>
	
	
		<!--DragAndDrop-->
		<link rel='stylesheet' href='../resources/tagmanager.css' type='text/css' media='all' />
		<!--DragAndDrop-->
	
  </head>
<body class="home page page-template page-template-template-blank-4-php x-renew x-navbar-fixed-top-active x-boxed-layout-active x-sidebar-content-active" onLoad="loadcontent();">

<div id="top" class="site">

<header class="masthead" role="banner">
	<?php printNav(); ?>
</header>

    
    
<div id="dropbox" style = "display:none;"><span id="droplabel"></span></div>
	<div class="x-main" role="main">
		<article id="post-3034" class="post-3034 page type-page status-publish hentry no-post-thumbnail">
			<div class="entry-content">


				<div id="x-content-band-5" class="x-content-band border-top border-bottom man" style="background-color: #fff;">
					<div class="x-container-fluid max width">
						<span style="font-size: 150%;"><img src="<?php echo "https://synclis.com/" . $cat[2]; ?>" />&emsp;Synclis > Create Listing > <?php echo $_GET['c']; ?></span><br/><br/>
					</div>
				</div>
				

				<div id="x-content-band-6" class="x-content-band bg-pattern man" style="background-image: url(../../icons/cream_pixels.png); background-color: transparent;">
					<div class="x-container-fluid max width">
						<div class="x-column two-thirds synclis-stp" style = "padding:0;">
							<div style = "padding: 12px;">
								<!--DEV ZONE-->
									<div style="clear:both; margin-bottom: 8px;"></div>
									
									<center>
										<a id="closeYoutube" href="Javascript:youtubeOutput();">
											<img src="../66.png" style="border:2px dashed #ccc; width: 270px;"></img>
										</a>
										
										<div style="position:relative;">
											<div id="video-content"></div>
											<a id="video-toggle" href="Javascript:youtubeOutput();" style="display:none;">
												<div style="position:absolute; top:0px; left: 0px; background: #1FB5AC; opacity: 0.96; padding: 12px; color: black;">
													Change Video
												</div>
											</a>
										</div>
									</center>
									
									<div style="clear:both; margin-bottom: 5px;"></div>
									
									<div style = "border: 1px solid #ccc; height: 260px; padding-top: 8px;">
										<div style ="width: 33%; height: 250px; position: relative; border-radius: 3px; float: left;">
											<img id="synclis-img" src="../draganddrop.png" style ="width: 100%; position:absolute; top:0; left:0; border-radius: 3px;" />
											<form id="synclisDropzone"style = "width: 100%; height: 100%; max-width: 350px; max-height: 250px; position:absolute; top:0; left:0;" method="PUT" class="dropzone">
												<div class="fallback">
													<input name="file"  type="file" multiple />
												</div>
											</form>
										</div>
										
										  <div id="demo" style = "float: left; width: 66%; height: 250px;">
											<div class="container">
											  <div class="row">
												<div class="span12">
													<div id="owl-demo" class="owl-carousel"></div>
												</div>
											  </div>
											</div>
										</div>
									</div>
								<!--END DEV ZONE-->
								
								
								
								<div style="clear:both; margin-bottom: 12px;"></div>
					
								<input id="synlis-title" type="text" placeholder="Listing Title" style="width:100%;"></input><br/>
								<script>if(!readCookie('SYNCLIS_TOKEN')){ document.write('<input id="synlisemail" type="text" placeholder="Anonymous Email" style="width:100%;"></input><br/>');}</script>
								
									<!--Facebook Group Feed.-->

	<?php	
	// selected provider name 
	$provider = @ "Facebook";


	try{
		$adapter = $hybridauth->getAdapter( $provider );

		// ask facebook api for the users accounts
		$accounts = $adapter->api()->api('/me/groups');

		if( ! count( $accounts["data"] ) ){
		?>
			<p>
				You do not have any group pages to post to, Synclis will not post to Facebook.
			</p>
			<p>
				<b>Note</b>: To be able to post to facebook pages you should:
			</p>
			<ol>
				<li>Sign in on Facebook.</li>
				<li>Either create a group page, or join a group page to post to.</li>
				<li>Try creating a post on Synclis again.</li>
			</ol> 
		<?php
		}
		else{
		?>	
			<select id="synclis-facebookgroupid" style="width:100%; display:none;">
				<?php foreach( $accounts["data"] as $account ){ ?>
					<option value="<?php echo $account['id']; ?>"><?php echo $account['name']; ?></option>
				<?php } ?> 
			</select>

		<?php  
		}
	}
	catch( Exception $e ){
		
	}
	include('../social_quicklogin.php');
	/*End Get Group Feed From Facebook.*/
?>  
	<!--Facebook Group Feed.-->
								<?php if($facebookOn){ ?>
								<div class="x-column one-third">
									<a href = "Javascript:;" onClick="facebookPublisher();"><button id="facebookButton" style="padding:7px; width:100%; color: #3B5998;"> <i class="x-icon-facebook"></i>&emsp;<i class="centertext">Post to Facebook group.</i></button></a>
								</div>
								<?php }if($twitterOn){ ?>
								<div class="x-column one-third">
									<a href = "Javascript:;" onClick="twitterPublisher();"><button id="twitterButton" style="padding:7px; width:100%; color: #2DAAE1;"> <i class="x-icon-twitter"></i>&emsp; <i class="centertext">Post to Twitter.</i></button></a>
								</div>
								<?php } ?>
								<div class="x-column one-third last">
									<a href = "Javascript:;" onClick="mailPublisher();"><button id="mailButton" style="padding:7px; width:100%; color: #0073B2;"> <i class="x-icon-envelope"></i>&emsp; <i class="centertext">Email updates.</i></button></a>
								</div>
								<div style="clear:both;"></div>
								<br/><br/>
								<div id="pageEditor">
									<ul class="hidemob">
										<a href="Javascript:synclis_shiftContentMode('simp');"><li style="border-left: 2px solid #ddd;"><div id="zsimp" class="selected">Simple</div></li></a>
										<a href="Javascript:synclis_shiftContentMode('hori');"><li><div id="zhori">Two Horizontal Sections</div></li></a>
										<a href="Javascript:synclis_shiftContentMode('vert');"><li><div id="zvert">Two Vertical Sections</div></li></a>
									</ul>
									<div style="clear:both;"></div>
									<textarea id="simp" style = "width: 100%; min-height: 300px;  margin-bottom: 6px; outline: none; resize: none; overflow: auto;" placeholder="Simple Text Input"></textarea>
					
									<div id="hori1" contenteditable="true" style="border: 2px solid #ddd; min-height: 144px; width: 100%; margin-bottom: 6px;"></div>
									<div id="hori2" contenteditable="true" style="border: 2px solid #ddd; min-height: 150px; width: 100%;"></div>
									
									<div id="vert1" contenteditable="true" class="x-column one-half" style="border: 2px solid #ddd; min-height: 300px;"></div>
									<div id="vert2" contenteditable="true" class="x-column one-half last" style="border: 2px solid #ddd; min-height: 300px;"></div>
									
								</div>
								<div style="clear:both;"></div>
								
								
								<a href = "Javascript:;" onClick="inform()" class="hide-on-mobile"><button style="margin-top: 14px;padding:7px; width:100%; color: #5CA8A3;"> <i class="x-icon-pencil-square-o"></i>Create Listing</button></a>
							</div>
						</div>

						
						<div class="x-column one-third last">
							<div class="synclis-stp" style = "padding:0;">
								<div style = "padding: 12px;">
								<h3  class="h-custom-headline mtn center-text h5 accent"><span>Profile Information</span></h3>
								<i class="x-icon-users"></i> Your Information will be shown.<br/>
								<i class="x-icon-calendar-o"></i> <?php echo date("F j, Y  g:i a", (time() + (($GLOBALS['USER_DATA'][2]+5)*60*60) )); ?> <br/><br/>
								<b style="font-size: 9px;">* Your profile will be public, messages will be sent and others will be able to view your profile.</b>
								</div>
								
								<a href = "Javascript:;"><div style="float:left;border-top: 1px solid #ddd;width: 50%; text-align: center;"><i class="x-icon-user"></i>&emsp;Show Profile</div></a>
								<a href = "Javascript:toggleMap();"><div id="togMapContents" style="float:left;border-top: 1px solid #ddd;border-left: 1px solid #ddd;width: 50%; text-align: center;"><i class="x-icon-minus-circle"></i>&emsp;Hide Map</div></a>
								<div style="clear:both;"></div>
							</div>
							<div class="synclis-stp">
								<h3  class="h-custom-headline mtn center-text h5 accent"><span>Additional Information</span></h3>
								<br/>
									<input id="synclis_json_website" type="text" placeholder="Website" style="width:100%;"></input><br/>
									<input id="synclis_json_contact" type="text" placeholder="Contact Number" style="width:100%;"></input><br/>
									<?php if( $cat[0] == 'house'  || $cat[0] == 'freelance' || $cat[0] == 'job') { ?>
										<div class="x-column one-half">
											<input id="synclis_json_price" type="text" placeholder="Price" style="width:100%;"></input>
										</div>
										<div class="x-column one-half last">
											<select id="synclis_json_payment" style="width:100%;"> <option value="">Payment Basis</option><option>One time</option><option>Per Year</option><option>Per Month</option><option>Per Week</option><option>Per Day</option><option>Per Hour</option></select>
										</div>
									<?php } if( $cat[0] == 'house') { ?>
										<div class="x-column one-half">
											<select id="synclis_json_bedroom" style="width:100%;"> <option value="">Bedrooms</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option value="9">9+</option></select>
										</div>
										<div class="x-column one-half last">
											<select id="synclis_json_bathroom" style="width:100%;"> <option value="">Bathrooms</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option value="9">9+</option></select>
											
										</div>
									
									<?php } if( $cat[0] == 'market') { ?>
										<div  class="x-column one-half">
											<input id="synclis_json_price" type="text" placeholder="Price" style="width:100%;"></input>
										</div>
										<div  class="x-column one-half last">
											<select id="synclis_json_state" style="width:100%;"> <option value="">Condition</option><option>New</option><option>Great</option><option>Good</option><option>Moderate</option><option>Poor</option><option>Broken</option></select>
										</div>
										<select id="synclis_json_paymethod" style="width:100%;"> <option value="">Preferred Payment Method</option><option>Cash</option><option>Check</option><option>Card</option></select>
									<?php } ?>

								<div style="clear:both;"></div>
							</div>
							<div id="displayMap" class="synclis-stp hide-on-mobile" style = "padding:0; margin:0; position: relative;">
									<h4 style="padding:0; margin:0; text-align: center;">Location</h4><br/>
									<input id="synclis-findlocation" type="text" placeholder="Find Location" style="position: absolute; bottom: 0; left:12px; width: 90%; z-index: 9;"></input>
								<div id="map-canvas"></div>
							</div>
						</div>
					<hr class="x-clear">
					</div>
					
					<a href = "Javascript:;" onClick="inform()" class="hide-on-desktop"><button style="margin-top: 14px; margin-left: 6%; padding:7px; width:88%; color: #5CA8A3;"> <i class="x-icon-pencil-square-o"></i>Create Listing</button></a>
				</div>
				

                              
      </div> <!-- end .entry-content -->
  </div> <!-- end .x-main -->

	
    
    <footer class="x-colophon bottom" role="contentinfo">
		<?php printFooter(); ?>
    </footer> <!-- end .x-colophon.bottom -->

    
  </div>

  <!--
  END #top.site
  -->

	<script type="text/javascript">
	var currentVideoId = '',	mainImage = "", twitterAutoPost = false, facebookAutoPost = false, facebook_gid='', jsonValue = '{}', userloc='', latlng='', completedPost = false;
	
	function twitterPublisher(){
		if( twitterAutoPost){
			twitterAutoPost = false;
			document.getElementById('twitterButton').className = "unpressed";
		}
		else{
			twitterAutoPost = true;
			document.getElementById('twitterButton').className = "pressed";
		}
	}
	
	function facebookPublisher(){
		if( facebookAutoPost){
			facebookAutoPost = false;
			document.getElementById('facebookButton').className = "unpressed";
			document.getElementById('synclis-facebookgroupid').style.display = "none";
		}
		else{
			facebookAutoPost = true;
			document.getElementById('facebookButton').className = "pressed";
			document.getElementById('synclis-facebookgroupid').style.display = "";
		}
	}
	function mailPublisher(){
			document.getElementById('mailButton').className = "pressed";
	}
	
	function submit(){
		var desc="";
		
		//Check if horizontal or vertical outputs.
		if(contentType == 'vert')     desc = '[v1]' + document.getElementById('vert1').innerHTML + '[/v1][v2]' + document.getElementById('vert2').innerHTML + '[/v2]';
		else if(contentType =='hori') desc = '[h1]' + document.getElementById('hori1').innerHTML + '[/h1][h2]' + document.getElementById('hori2').innerHTML + '[/h2]';
		else desc = document.getElementById('simp').value;
		
		var http = new XMLHttpRequest(), geoloc;
		if(document.cookie.indexOf("SYNCLIS_CURPOS")){
			geoloc = Base64.decode(readCookie('SYNCLIS_CURPOS')).split(":");
			userloc = "&country="+ geoloc[0] +"&providence="+ geoloc[2] +"&city="+ geoloc[1];
		}else{
			userloc = "&country=UU&providence=Unknown&city=Unknown";
		}
		
		if(marker){
			latlng = "&lat=" + marker.getPosition().lat() +"&lng=" + marker.getPosition().lng();
		}
		
		http.open("POST", "https://synclis.com/api/sys/listings", true);
		
		var sessionValue="";
		if(readCookie('SYNCLIS_TOKEN')){ sessionValue = "&session=" + readCookie('SYNCLIS_TOKEN');}
		else                           { 
			if(document.getElementById('synlisemail'))
				sessionValue = "&email=" + document.getElementById('synlisemail').value;
			else{
				alert('You must enter your email as an anonymous user.');
				return;
			}
		}
		
		if(document.getElementById('synclis-facebookgroupid')) facebook_gid = document.getElementById('synclis-facebookgroupid').value;
		var params = "title="+ document.getElementById("synlis-title").value +
			  "&description="+ desc +
			         "&type=<?php echo $cat[0]; ?>" +
				  "&cat-id="+ "<?php echo $cat[1]; ?>" +
				    userloc+
				  "&image=" + mainImage +
				    latlng +
					sessionValue +
					 "&id=<?php echo $uniqkey; ?>" +
					"&vid=" + currentVideoId +
			  "&ap_twitter=" + twitterAutoPost +
			 "&ap_facebook=" + facebookAutoPost +
		  "&facebook_group=" + facebook_gid +
			   "&json_data=" + parseJSONValue() +
		        "&show_map=" + mapOn;
		//Send the proper header information along with the request
		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		http.onreadystatechange = function() {//Call a function when the state changes.
			if(http.readyState == 4 && http.status == 200)
			{
				try{
					var json = JSON.parse(http.responseText);
					if(json.response == 'error')
						alert("ERROR: " + json.message);
					else if(json.response == 'success'){
						testt();
					}
					else
						alert(http.responseText);
				}catch(e){
					alert(http.responseText);
				}
			}
		}
		http.send(params);
	}
	
	function parseJSONValue(){
		var jsonbuilder = '{"id":"<?php echo $uniqkey; ?>",';
		
		if(document.getElementById('synclis_json_website')){
			if(document.getElementById('synclis_json_website').value != '')
				jsonbuilder += '"website":"' + document.getElementById('synclis_json_website').value + '",';
		}
		if(document.getElementById('synclis_json_contact')){
			if(document.getElementById('synclis_json_contact').value != '')
				jsonbuilder += '"phoneno":"' + document.getElementById('synclis_json_contact').value + '",';
		}
		if(document.getElementById('synclis_json_price')){
			if(document.getElementById('synclis_json_price').value != '')
				jsonbuilder += '"price":"' + document.getElementById('synclis_json_price').value + '",';
		}
		if(document.getElementById('synclis_json_payment')){
			if(document.getElementById('synclis_json_payment').value != '')
				jsonbuilder += '"paymentbasis":"' + document.getElementById('synclis_json_payment').value + '",';
		}
		if(document.getElementById('synclis_json_bedroom')){
			if(document.getElementById('synclis_json_bedroom').value != '')
				jsonbuilder += '"bedroom":"' + document.getElementById('synclis_json_bedroom').value + '",';
		}
		if(document.getElementById('synclis_json_bathroom')){
			if(document.getElementById('synclis_json_bathroom').value != '')
				jsonbuilder += '"bathroom":"' + document.getElementById('synclis_json_bathroom').value + '",';
		}
		if(document.getElementById('synclis_json_state')){
			if(document.getElementById('synclis_json_state').value != '')
				jsonbuilder += '"condition":"' + document.getElementById('synclis_json_state').value + '",';
		}
		if(document.getElementById('synclis_json_paymethod')){
			if(document.getElementById('synclis_json_paymethod').value != '')
				jsonbuilder += '"paymentmethod":"' + document.getElementById('synclis_json_paymethod').value + '",';
		}
		if(document.getElementById('tm-container')){
			if(document.getElementById('tm-container').value != '' && document.getElementById('tm-container').value != undefined)
				jsonbuilder += '"skills_required":"' + document.getElementById('tm-container').value + '",';
		}
		return jsonbuilder.slice(0, -1) + '}';
	}
	
	function postImage(){
		var imginc = '';
		if(document.getElementById("synclis-img").src != 'http://synclis.com/CreateListing/draganddrop.png') imginc = document.getElementById("synclis-img").src;
		else imginc = '';
		var alt = "";
		var http = new XMLHttpRequest();
		
		http.open("POST", "https://synclis.com/api/sys/imgupload", true);
		var params = "id=<?php echo $uniqkey; ?>&description="+ alt + "&image=" + imginc;

		//Send the proper header information along with the request
		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		http.onreadystatechange = function() {//Call a function when the state changes.
			if(http.readyState == 4 && http.status == 200)
			{
				try{
					var json = JSON.parse(http.responseText);
					if(json.response == 'error')
						alert("ERROR: " + json.message);
					else{
						reload();
						document.getElementById("synclis-img").src = '../draganddrop.png';
					}
				}catch(e){
					reload();
				}
			}
		}
		http.send(params);
	}
	

	
	/*
		=================================================
		=========== Synclis Youtube Search ==============
		=================================================
	*/
	function synclis_search(){
		document.getElementById("output").innerHTML = "";
		var http = new XMLHttpRequest();
		http.open("GET", "https://www.googleapis.com/youtube/v3/search?part=snippet&maxResults=10&q="+ document.getElementById('searchbox').value +"&key=AIzaSyB091nAI-FbITXOoM5ViEuilCZhrO302H8", true);

		//Send the proper header information along with the request
		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		http.onreadystatechange = function() {//Call a function when the state changes.
			if(http.readyState == 4 && http.status == 200)
			{
				var json = JSON.parse(http.responseText);
				var videoname, resultstring = "";
				for(var q=0; q<json.items.length; q++){
					videoname =json.items[q].snippet.title;
					if(videoname.length > 50)
						videoname = videoname.substring(0, 50);
						
				
					resultstring += 
						"<li><img src='" + json.items[q].snippet.thumbnails.default.url + "' />" +
						"<p style='padding:none; margin:0;'>"+
							"<b>" + videoname + "</b><br/>" +
							json.items[q].snippet.channelTitle + "<br/>" +
						"</p>"+
						"<a href='Javascript:;' onClick='setVideo(\""+ json.items[q].id.videoId +"\");'><div class='selectYoutube'>Select Video</div></a>" +
						"<div style='clear:both;'></div>" +
						"</li>";
						
					document.getElementById("output").innerHTML = resultstring;
				}
			}
		}
		http.send();
	}
	function setVideo(vidurl){
		currentVideoId = vidurl;
		document.getElementById('video-content').innerHTML=
		'<iframe style="width: 100%; height: 300px; max-width:480px;" src="https://www.youtube.com/embed/'+ vidurl +'" frameborder="0" allowfullscreen></iframe>';
		document.getElementById("closeYoutube").style.display = "none";
		document.getElementById("video-toggle").style.display = "";
	}
	
	</script> 
    
  
<!--[if lt IE 9]><script type="text/javascript" src="../../wp-content/themes/x/framework/js/vendor/selectivizr-1.0.2.min.js"></script><![endif]-->
	<script type='text/javascript' src='../resources/tagmanager.js'></script>
	<script type='text/javascript' src="../../wp-content/plugins/dragndrop/dropzone.js"></script>
	<script type="text/javascript">
	var contentType="simp";
	
	function synclis_shiftContentMode(type){
		contentType = type;
		if(type=='hori'){
			//SHOW
			document.getElementById("hori1").style.display="";
			document.getElementById("hori2").style.display="";
			
			//HIDE
			document.getElementById("simp").style.display="none";
			document.getElementById("vert1").style.display="none";
			document.getElementById("vert2").style.display="none";
			document.getElementById("zsimp").className="";
			document.getElementById("zvert").className="";
			document.getElementById("zhori").className="selected";
			
		}else if(type=="vert"){
			//SHOW
			document.getElementById("vert1").style.display="";
			document.getElementById("vert2").style.display="";
			
			//HIDE
			document.getElementById("simp").style.display="none";
			document.getElementById("hori1").style.display="none";
			document.getElementById("hori2").style.display="none";
			document.getElementById("zsimp").className="";
			document.getElementById("zvert").className="selected";
			document.getElementById("zhori").className="";
		}else{
			//SHOW
			document.getElementById("simp").style.display="";
			//HIDE
			document.getElementById("hori1").style.display="none";
			document.getElementById("hori2").style.display="none";
			document.getElementById("vert1").style.display="none";
			document.getElementById("vert2").style.display="none";
			document.getElementById("zsimp").className="selected";
			document.getElementById("zvert").className="";
			document.getElementById("zhori").className="";
		}
	}
	
	
	jQuery(".tm-input").tagsManager({
			tagClass: 'tm-tag tm-tag-info',
			tagCloseIcon: '&nbsp;×&nbsp;',
			blinkBGColor_1: '#eef',
			blinkBGColor_2: '#C5EEFA',
			tagsContainer: '#tm-container'
	});

		
	function youtubeOutput() {
		alertify.set({ labels: { ok     : "Cancel"}  });
		alertify.alert(
		'<div style="width: 100%;">' +
			'<a href="Javascript:;" onClick="synclis_search()"><div style="width: 10%; float:left;"><div style="border: 2px solid #ccc; border-right:none; padding: 5px; text-align:center; min-height: 34px;"><i class="x-icon-search"></i></div></div></a>' +
			'<div style="width: 90%; float:left;"><input id="searchbox" type="text" style="width:100%;" placeholder="Search"></input></div></div>' +
		'<div style="clear:both;"></div><br/>' +
		'<div class="youtube" id="output"></div>',
		function (e) {

		});
		return false;
	}
		
		
	function testt() {
		alertify.set({ buttonReverse: true  });
		alertify.confirm("Your listing was created.<br/>Do you want to make another listing for the category, <?php $_GET['c'] ?>?", function (e) {
			if (e) {
				completedPost = true;
				window.location = '';
			} else {
				completedPost = true;
				window.location = 'https://synclis.com/ViewListing/<?php echo $uniqkey; ?>';
			}
		});
		return false;
	}
	
	
	function inform() {
		alertify.set({ buttonReverse: true, labels: {
    ok     : "Confirm",
    cancel : "Cancel"
} });
		alertify.confirm("<div class='tm-tag tm-tag-error' style='text-align:left;'>"+
							"By publishing a listing you agree that your post abides by the following guidlines before posting to Synclis, and that you agree to the terms and conditions.<br/>" +
							"<p style='font-size: 9px;'>For more information click <a href='https://synclis.com/tos' target='_blank'>here.</a></p>" +
						"</div>"+
						"Synclis' algorithms will screen all listings, to ensure the stability in maintaining a healthy and professional community."
		, function (et){
			if (et) {
				submit();
			} 
		});
		return false;
	}
		
	var owl;
	$(document).ready(function() {
	 
	  owl = $("#owl-demo").owlCarousel({
		jsonPath : 'https://synclis.com/api/sys/imgupload/<?php echo $uniqkey; ?>',
		jsonSuccess : customDataSuccess,
		items : 2,
		lazyLoad : true,
		navigation : true,
		itemsMobile : [479,1]
	  });
	 
	  function customDataSuccess(data){
		var content = "";
		for(var i in data["items"]){
		   
		   var img = data["items"][i].img;
		   var alt = data["items"][i].alt;
		   mainImage = data["items"][i].img;
		   content += "<div onClick='synclis_promptdel("+ i +")' class='owl-item'><img id='owlimgs"+ i +"' src=\"" +img+ "\" alt=\"" +alt+ "\"></div>";
		}
		$("#owl-demo").html(content);
	  }
	 
	});
	
	function synclis_promptdel(id){
		alertify.set({ buttonReverse: true, labels: {ok     : "Confirm",cancel : "Cancel"} });
		alertify.confirm("Are you sure you would like to delete this image?", function (et){
			if (et) {
				var http = new XMLHttpRequest();
				var alnr = document.getElementById("owlimgs"+ id).src.split("thumb_");
				http.open("DELETE", "https://synclis.com/api/sys/imgupload?imgloc=" + alnr[1] + "", true);
				//Send the proper header information along with the request
				http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				http.onreadystatechange = function() {//Call a function when the state changes.
					if(http.readyState == 4 && http.status == 200){
						reload();
					}else{
						alert("An error occured when removing your image.");
					}
				}
				http.send();
			} 
		});
		return false;
	}
	
	function reload(){
		var http = new XMLHttpRequest();
		http.open("GET", "https://synclis.com/api/sys/imgupload/<?php echo $uniqkey; ?>", true);
		//Send the proper header information along with the request
		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		http.onreadystatechange = function() {//Call a function when the state changes.
			if(http.readyState == 4 && http.status == 200)
			{
				try{
					var json = JSON.parse(http.responseText);
					  owl.data('owlCarousel').reinit({
						singleItem : false
					  });
					customDataSuccess(json);
				}catch(e){
					
				}
			}
		}
		http.send();
	}

var mapOn = true;
function toggleMap(){	
	if(mapOn) {document.getElementById('displayMap').style.display = "none"; document.getElementById('togMapContents').innerHTML = '<i class="x-icon-map-marker"></i>&emsp;Show Map'; mapOn = false;}
	else      {document.getElementById('displayMap').style.display = ""; document.getElementById('togMapContents').innerHTML = '<i class="x-icon-minus-circle"></i>&emsp;Hide Map'; mapOn = true; initialize();}
}


		<!--Drag N Drop-->
		Dropzone.options.synclisDropzone = {
		  maxFilesize: 2, 
		  maxFiles: 1,
		  clickable: true,
		  uploadMultiple: false,
		  acceptedFiles: "image/*",
		  autoProcessQueue: false, 
		  previewTemplate: '<div class="dz-preview dz-file-preview"><div class="dz-details"></div></div>',
		  thumbnail: function(file, dataUrl){
			var thumbnailElement, _i, _len, _ref, _results;

			_ref = file.previewElement.querySelectorAll("[data-dz-thumbnail]");
			_results = [];
			for (_i = 0, _len = _ref.length; _i < _len; _i++){
				thumbnailElement = _ref[_i];
				thumbnailElement.alt = file.name;
				
			}
			//document.getElementById('synclis-img').src = dataUrl;
			postImage();
			 
			return _results;
		  }
		};
		
		<!--Drag N Drop-->

		
		window.onbeforeunload = function(){
			if(completedPost) eraseCookie("SYNCLIS_PL");
			else createCookieByHour("SYNCLIS_PL","<?php echo $uniqkey; ?>",168);
		};
		
		
		document.getElementById('synclis-findlocation').onkeyup = function(e){
		  e = e || event;
		  if (e.keyCode === 13) {
			codeAddress(document.getElementById('synclis-findlocation').value);
			document.getElementById('synclis-findlocation').value = "";
		  }
		  return true;
		 }
		
</script>

<?php  alertSystem(); ?>

</body>
</html>
