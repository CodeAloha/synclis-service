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
	<title>Edit your listing | Synclis</title>
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
	if(!$_GET['s'] || !ctype_alnum ( $_GET['s']) ){
		echo "<script>window.location='https://synclis.com/Sections?msg=NotFound';</script>";
	}
	else{
		$t = mysqli_query($conn,"SELECT
								`LISTING`.`NAME`,
								`LISTING`.`DESCRIPTION`,
								`LISTING`.`TYPE`,
								`LISTING`.`CATEGORY`,
								`LISTING`.`IMAGE`,
								`LISTING`.`COUNTRY`,
								`LISTING`.`PROVIDENCE`,
								`LISTING`.`CITY`,
								`LISTING`.`LONG`,
								`LISTING`.`LAT`,
								`LISTING`.`HASH62`,
								`LISTING_LAYOUT`.`DATA`,
								`LISTING_LAYOUT`.`SHOW_MAP`,
								`LISTING_VIDEO`.`VIDEO_TYPE`,
								`LISTING_VIDEO`.`VIDEO_URL`,
								`LISTING_VIDEO`.`VIDEO_COVER`,
								`SECTION`.`LISTING_TYPE`,
								`LISTING`.`CATEGORY`
        FROM `LISTING`
		LEFT JOIN `LISTING_LAYOUT` ON `LISTING_LAYOUT`.`LISTING`=`LISTING`.`HASH62`
		LEFT JOIN `LISTING_VIDEO` ON `LISTING_VIDEO`.`LISTING`=`LISTING`.`HASH62`
		LEFT JOIN `CATEGORY` ON `CATEGORY`.`ID`=`LISTING`.`CATEGORY`
		LEFT JOIN `SECTION` ON `SECTION`.`ID`=`CATEGORY`.`SECTION`
		WHERE `LISTING`.`HASH62`='{$_GET['s']}'
		LIMIT 1");
		$LISTING_META = mysqli_fetch_row($t);
		
		if(!$LISTING_META){
			echo "<script>window.location='https://synclis.com/Sections?msg=NotFound';</script>";
		}
	}

  ?>
  

<link rel='stylesheet' href='../wp-content/plugins/x-custom/x-custom.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../wp-content/plugins/x-shortcodes/css/renew.css' type='text/css' media='all' />
<link rel='stylesheet' href='../wp-content/themes/x/framework/css/site/stacks/renew.css' type='text/css' media='all' />
<link rel='stylesheet' href='../wp-content/primary.css' type='text/css' media='all' />
<link rel='stylesheet' href='screenres.css' type='text/css' media='all' />

<script type='text/javascript' src='../wp-includes/js/jquery/jquery-1.9.1.js'></script>
<script type='text/javascript' src='../wp-includes/js/jquery/jquery-migrate.min.js?ver=1.2.1'></script>
<script type='text/javascript' src='../wp-content/themes/x/framework/js/x.min.js'></script>

<link rel='stylesheet' href='../wp-content/plugins/magnificpopup/css/magnific-popup.css' type='text/css' media='all' />
<script type='text/javascript' src='../wp-content/plugins/x-shortcodes/js/vendor/backstretch-2.0.3.min.js'></script>
<script type='text/javascript' src='../wp-content/plugins/x-shortcodes/js/vendor/modernizr-2.7.1.min.js'></script>
<script type='text/javascript' src='../wp-content/plugins/x-shortcodes/js/vendor/fittext-1.1.0.min.js'></script>
<link href="owl-carousel/owl.carousel.css" rel="stylesheet">
<link href="owl-carousel/owl.theme.css" rel="stylesheet">
<script src="../wp-content/pace.min.js"></script>
<link href="../wp-content/dataurl.css" rel="stylesheet" />


  
		
		
	
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
			width: 100%;
			height: auto;
		}

		/*Youtubr Styles*/
		.youtube{
			font-size: 14px;
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
		}
		.mediatools li{
			float:left;
			text-align: center;
			width: 25%;
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
	
	<script type="text/javascript" src="../api/base64.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=drawing"></script>
    <script>
	var marker, map, lat=<?php echo $LISTING_META[9]; ?>,lng=<?php echo $LISTING_META[8]; ?>;
	var minZoomLevel = 5;
	
	
	if(!lat || lat == '' || lng || lng == ''){
		lat = 37.090240;
		lng = -95.712891;
	}
	
	function initialize() {
	  var mapOptions = {
		zoom: 15,
		center: new google.maps.LatLng(lat,lng),
		minZoom: 12
	  }
	  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
	  geocoder = new google.maps.Geocoder();
	  
	  var geoloc = Base64.decode(readCookie('SYNCLIS_CURPOS')).split(":");
	  setPin();
	  
	}
	google.maps.event.addDomListener(window, 'load', initialize);
	
	function setPin(address) {
		  map.setCenter(new google.maps.LatLng(lat,lng));
		  marker = new google.maps.Marker({
			  position: new google.maps.LatLng(lat,lng),
			  map: map,
			title: 'Set lat/lon values for this property',
			draggable: true
		  });

	}
	
	setInterval(function(){
		if(marker)
		map.panTo(new google.maps.LatLng(marker.getPosition().lat(), marker.getPosition().lng()));
	},5000);

	function loadcontent(){
		setTimeout(function(){
			synclis_shiftContentMode('simp');
		},200);
	}
	</script>
	
	
		<!--DragAndDrop-->
		<link rel='stylesheet' href='resources/tagmanager.css' type='text/css' media='all' />
		<!--DragAndDrop-->
	
  </head>
<body class="home page page-template page-template-template-blank-4-php x-renew x-navbar-fixed-top-active x-boxed-layout-active x-sidebar-content-active"
onLoad="loadcontent();">

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
						<span style="font-size: 150%;">Synclis > Edit Listing</span><br/><br/>
					</div>
				</div>
				

				<div id="x-content-band-6" class="x-content-band bg-pattern man" style="background-image: url(../../icons/cream_pixels.png); background-color: transparent;">
					<div class="x-container-fluid max width">
						<div class="x-column two-thirds synclis-stp" style = "padding:0;">
							<ul id="inline-popups" class="mediatools">
								<a href="#youtube-popup" data-effect="mfp-zoom-in"><li><div style="border-left: none;" id="change-content-vid">Add Video</div></a>
								<a href="Javascript:alert('Not available.');"><li>     <div>Main Image</div></a>
								<a href="#imageup-popup" data-effect="mfp-zoom-in"><li><div>Add Image</div></a>
								<a href="Javascript:alert('Not available.');"><li>     <div>Remove Image</div></a>
							</ul>
							<div style = "padding: 12px;">
								<!--DEV ZONE-->
									<div style="clear:both; margin-bottom: 8px;"></div>
									
									<center><div id="video-content"></div></center>
									
									<div style="clear:both; margin-bottom: 5px;"></div>
								
									  <div id="demo">
										<div class="container">
										  <div class="row">
											<div class="span12">
												<div id="owl-demo" class="owl-carousel"></div>
											</div>
										  </div>
										</div>
									</div>
								<!--END DEV ZONE-->
								
					
								<input id="synlis-title" type="text" placeholder="Listing Title" style="width:100%;" value="<?php echo $LISTING_META[0]; ?>"></input><br/>
								<script>if(!readCookie('SYNCLIS_TOKEN')){ document.write('<input id="synlisemail" type="text" placeholder="Anonymous Email" style="width:100%;"></input><br/>');}</script>

								<div id="pageEditor">
									<ul class="hidemob">
										<a href="Javascript:synclis_shiftContentMode('simp');"><li style="border-left: 2px solid #ddd;"><div id="zsimp" class="selected">Simple</div></li></a>
										<a href="Javascript:synclis_shiftContentMode('hori');"><li><div id="zhori">Two Horizontal Sections</div></li></a>
										<a href="Javascript:synclis_shiftContentMode('vert');"><li><div id="zvert">Two Vertical Sections</div></li></a>
									</ul>
									<div style="clear:both;"></div>
									<textarea id="simp" style = "width: 100%; min-height: 300px;  margin-bottom: 6px; outline: none; resize: none; overflow: auto;" placeholder="Simple Text Input"><?php echo $LISTING_META[1]; ?></textarea>
					
									<div id="hori1" contenteditable="true" style="border: 2px solid #ddd; min-height: 144px; width: 100%; margin-bottom: 6px;">In-Line Editor</div>
									<div id="hori2" contenteditable="true" style="border: 2px solid #ddd; min-height: 150px; width: 100%;"></div>
									
									<div id="vert1" contenteditable="true" class="x-column one-half" style="border: 2px solid #ddd; min-height: 300px;">In-Line Editor</div>
									<div id="vert2" contenteditable="true" class="x-column one-half last" style="border: 2px solid #ddd; min-height: 300px;"></div>
									
								</div>
								<div style="clear:both;"></div>
								
								
								<a href="Javascript:;" id="order" style="display:none;">B</a>
								<a href="Javascript:;" id="inform" style="display:none;">I</a>
								<input id="uid" type= "hidden"></input>
								<a href = "Javascript:;" onClick="document.getElementById('inform').click();"><button style="margin-top: 14px;padding:7px; width:100%; color: #5CA8A3;"> <i class="x-icon-pencil-square-o"></i>Finish Editing Listing</button></a>
							</div>
						</div>

						
						<div class="x-column one-third last">
							<div class="synclis-stp" style = "padding:0;">
								<div style = "padding: 12px;">
								<h3  class="h-custom-headline mtn center-text h5 accent"><span>Profile Information</span></h3>
								<i class="x-icon-users"></i> Your Information will be shown.<br/>
								<i class="x-icon-calendar-o"></i> <?php echo date("F j, Y  g:i a", time()); ?> <br/><br/>
								<b style="font-size: 9px;">* Your profile will be public, messages will be sent and others will be able to view your profile.</b>
								</div>
								
								<a href = "Javascript:;"><div style="float:left;border-top: 1px solid #ddd;width: 50%; text-align: center;"><i class="x-icon-user"></i>&emsp;Show my profile</div></a>
								<a href = "Javascript:toggleMap();"><div id="togMapContents" style="float:left;border-top: 1px solid #ddd;border-left: 1px solid #ddd;width: 50%; text-align: center;"><i class="x-icon-user"></i>&emsp;Hide Map</div></a>
								<div style="clear:both;"></div>
							</div>
							<div class="synclis-stp">
								<h3  class="h-custom-headline mtn center-text h5 accent"><span>Additional Information</span></h3>
								<br/>
									<input id="synclis_json_website" type="text" placeholder="Website" style="width:100%;"></input><br/>
									<input id="synclis_json_contact" type="text" placeholder="Contact Number" style="width:100%;"></input><br/>
									<?php if( $LISTING_META[16] == 'house'  || $LISTING_META[16] == 'freelance' || $LISTING_META[16] == 'job') { ?>
										<div class="x-column one-half">
											<input id="synclis_json_price" type="text" placeholder="Price" style="width:100%;"></input>
										</div>
										<div class="x-column one-half last">
											<select id="synclis_json_payment" style="width:100%;"> <option value="">Payment Basis</option><option>One time</option><option>Per Year</option><option>Per Month</option><option>Per Week</option><option>Per Day</option><option>Per Hour</option></select>
										</div>
									<?php } if( $LISTING_META[16] == 'house') { ?>
										<div class="x-column one-half">
											<select id="synclis_json_bedroom" style="width:100%;"> <option value="">Bedrooms</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option value="9">9+</option></select>
										</div>
										<div class="x-column one-half last">
											<select id="synclis_json_bathroom" style="width:100%;"> <option value="">Bathrooms</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option value="9">9+</option></select>
											
										</div>
									
									<?php } if( $LISTING_META[16] == 'market') { ?>
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
							<div id="displayMap" class="synclis-stp" style = "padding:0; margin:0; position: relative;">
								<div style="position: absolute; top:8px; left:4px; width: 100%; z-index: 500;">
									<h3 class="h-custom-headline mtn center-text h5 accent"><span>Location</span></h3>
								</div>
								<div id="map-canvas"></div>
							</div>
						</div>
					<hr class="x-clear">
					</div>
				</div>
				

                              
      </div> <!-- end .entry-content -->
  </div> <!-- end .x-main -->


	<div id="imageup-popup" class="white-popup mfp-with-anim mfp-hide" style = "padding:0;">
		<div style = "background: #5AC8C2; padding: 8px; text-align: center; color: #222;">
			Upload Image
		</div>
		<center>
			<div style ="width: 250px; height: 250px; position: relative; border-radius: 3px;">
				<img id="synclis-img" src="draganddrop.png" style ="width: 250px; height: 250px; position:absolute; top:0; left:0; border-radius: 3px;" />
					<form id="synclisDropzone"style = "width: 100%; height: 100%; max-width: 250px; max-height: 250px; position:absolute; top:0; left:0;" method="PUT" class="dropzone">
						<div class="fallback">
							<input name="file"  type="file" multiple />
						</div>
					</form>
			</div>
			<input type="text" placeholder="caption" style="width: 80%;"></input>
		</center>
	</div>
	
	
	<div id="youtube-popup" class="white-popup mfp-with-anim mfp-hide" style = "padding:0; min-height: 210px;">
		<div style = "background: #5AC8C2; padding: 8px; text-align: center; color: #222;">
			Youtube Video
		</div>
		<div style="width: 100%;">
			<a href="Javascript:;" onClick="synclis_search()"><div style="width: 10%; float:left;"><div style="border: 2px solid #ccc; border-right:none; padding: 5px; text-align:center; min-height: 34px;"><i class="x-icon-search"></i></div></div></a>
			<div style="width: 90%; float:left;"><input id="searchbox" type="text" style="width:100%;" placeholder="Search"></input></div>
		</div>
		<div style="clear:both;"></div>
		<br/>
		<ul class="youtube" id="output">
	</div>
	
	
	
	
  
    
    <footer class="x-colophon bottom" role="contentinfo">
		<?php printFooter(); ?>
    </footer> <!-- end .x-colophon.bottom -->

    
  </div>

  <!--
  END #top.site
  -->

	<script src="owl-carousel/owl.carousel.js"></script>
	<script type="text/javascript">
	var currentVideoId = '',	mainImage = "", twitterAutoPost = false, facebookAutoPost = false, facebook_gid='', jsonValue = '{}';
	
	function twitterPublisher(){
		if( twitterAutoPost){
			twitterAutoPost = false;
			document.getElementById('twitterButton').className = "";
		}
		else{
			twitterAutoPost = true;
			document.getElementById('twitterButton').className = "pressed";
		}
	}
	
	function facebookPublisher(){
		if( facebookAutoPost){
			facebookAutoPost = false;
			document.getElementById('facebookButton').className = "";
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
		if(contentType == 'vert')     desc = '[v1]' + document.getElementById('vert1').innerHTML + '[/v1][v2]' + document.getElementById('vert2').innerHTML + '[/v2]';
		else if(contentType =='hori') desc = '[h1]' + document.getElementById('hori1').innerHTML + '[/h1][h2]' + document.getElementById('hori2').innerHTML + '[/h2]';
		else desc = document.getElementById('simp').value;
		
		var http = new XMLHttpRequest();
		
		http.open("PUT", "https://synclis.com/api/sys/listings", true);
		
		
		if(facebook_gid && document.getElementById('synclis-facebookgroupid')) facebook_gid = document.getElementById('synclis-facebookgroupid').value;
		var params = '{"title":"' + document.getElementById("synlis-title").value + '",' +
			    '"description":"' + desc.replace(/"/g, "&quot;") + '",' +
						 '"id":"' + '<?php echo $LISTING_META[10]; ?>' + '",' +
				      '"image":"' + mainImage + '",' +
				        '"lat":"' + marker.getPosition().lat() + '",' +
					    '"lng":"' + marker.getPosition().lng() + '",' +
					    '"vid":"' + currentVideoId +             '",' +
			      '"json_data":' + parseJSONValue() +           ',' +
				    '"session":"' + readCookie('SYNCLIS_TOKEN')+ '",' +
		           '"show_map":'  + mapOn            +           '}';
		document.getElementById('simp').innerHTML = params;
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
						document.getElementById('uid').value = json.uid;
						document.getElementById("order").click();
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
		var jsonbuilder = '{"id":"<?php echo $LISTING_META[10]; ?>",';
		
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
		var params = "id=<?php echo $LISTING_META[10]; ?>&description="+ alt + "&image=" + imginc;

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
		document.getElementById("output").innerHTML = "<img src=''></img>";
		var http = new XMLHttpRequest();
		http.open("GET", "https://www.googleapis.com/youtube/v3/search?part=snippet&maxResults=10&q="+ document.getElementById('searchbox').value +"&key=AIzaSyB091nAI-FbITXOoM5ViEuilCZhrO302H8", true);

		//Send the proper header information along with the request
		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		http.onreadystatechange = function() {//Call a function when the state changes.
			if(http.readyState == 4 && http.status == 200)
			{
				//document.getElementById("output").innerHTML= http.responseText;
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
		
		try{
			var magnificPopup = $.magnificPopup.instance; 
			magnificPopup.close(); 
		}catch(e){ }
		document.getElementById("change-content-vid").innerHTML = "Change Video";
	}
	var loadedVid = '<?php echo $LISTING_META[14]; ?>'; if(loadedVid && loadedVid != '') setVideo(loadedVid);
	
	/*<!--Parse JSON Values-->*/
		function loopThrough(el,k){
			for (var i = 0; i < el.length; i++)
				if(el.options[i].text == k){
					el.options[i].selected=true;
					break;
				}
			
		}
	
		var json = <?php echo $LISTING_META[11]; ?>;
		try{
			if(json.website       != undefined && json.website       != '' && document.getElementById('synclis_json_website')  ) document.getElementById('synclis_json_website').value = json.website;
			if(json.phoneno       != undefined && json.phoneno       != '' && document.getElementById('synclis_json_contact')  ) document.getElementById('synclis_json_contact').value = json.phoneno.replace(/&ndash;/g,"-");
			if(json.price         != undefined && json.price         != '' && document.getElementById('synclis_json_price')    ) document.getElementById('synclis_json_price').value = json.price;
			if(json.paymentbasis  != undefined && json.paymentbasis  != '' && document.getElementById('synclis_json_payment')  ) document.getElementById('synclis_json_payment').value = json.paymentbasis;
			if(json.bedroom       != undefined && json.bedroom       != '' && document.getElementById('synclis_json_bedroom')  ) document.getElementById('synclis_json_bedroom').value = json.bedroom;
			if(json.bathroom      != undefined && json.bathroom      != '' && document.getElementById('synclis_json_bathroom') ) document.getElementById('synclis_json_bathroom').value = json.bathroom;
			if(json.condition     != undefined && json.condition     != '' && document.getElementById('synclis_json_state')    ) document.getElementById('synclis_json_state').value = json.condition;
			if(json.paymentmethod != undefined && json.paymentmethod != '' && document.getElementById('synclis_json_paymethod')) document.getElementById('synclis_json_paymethod').value = json.paymentmethod;
		}catch(k){
			alert('A problem occured when parsing your listing.');
		}

	/*<!--EndParse JSON Values-->*/
	
	</script> 
    
  
<!--[if lt IE 9]><script type="text/javascript" src="../../wp-content/themes/x/framework/js/vendor/selectivizr-1.0.2.min.js"></script><![endif]-->
<script type='text/javascript' src='resources/tagmanager.js'></script>
<script type='text/javascript' src="../wp-content/plugins/dragndrop/dropzone.js"></script>
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
	
	/*
	jQuery(".tm-input").tagsManager({
			tagClass: 'tm-tag tm-tag-info',
			tagCloseIcon: '&nbsp;×&nbsp;',
			blinkBGColor_1: '#eef',
			blinkBGColor_2: '#C5EEFA',
			tagsContainer: '#tm-container'
		});
	*/
		
		
		
		
		$("#order").on( 'click', function () {
			alertify.set({ buttonReverse: true });
			alertify.confirm("Your listing has been udpated.<br/>Do you want to continue to make changes?", function (e) {
				if (e) {
					
				} else {
					if(document.getElementById('uid').value != '')
					window.location = '../../MyListings';
					else{
						alert('Fatal Error, your listing has been disassociated from the server.');
						window.location='../../Sections';
					}
				}
			});
			return false;
		});
		$("#inform").on( 'click', function () {
			alertify.set({ buttonReverse: true });
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
		});
		
var owl;
$(document).ready(function() {
 
  owl = $("#owl-demo").owlCarousel({
    jsonPath : 'https://synclis.com/api/sys/imgupload/<?php echo $LISTING_META[10]; ?>',
    jsonSuccess : customDataSuccess,
	items : 3,
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
       content += "<div id='owlimgs"+ i +"' class='owl-item'><img src=\"" +img+ "\" alt=\"" +alt+ "\"></div>";
    }
    $("#owl-demo").html(content);
  }
});

	function reload(){
		var http = new XMLHttpRequest();
		http.open("GET", "https://synclis.com/api/sys/imgupload/<?php echo $LISTING_META[10]; ?>", true);
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
					document.getElementById("synclis-img").src = 'http://synclis.com/CreateListing/draganddrop.png';
				}catch(e){
					//alert(http.responseText);
					
				}
			}
		}
		http.send();
	}


var mapOn = true;
<?php if($LISTING_META[12]) echo 'toggleMap();'; ?>
function toggleMap(){	
	if(mapOn) {document.getElementById('displayMap').style.display = "none"; document.getElementById('togMapContents').innerHTML = '<i class="x-icon-user"></i>&emsp;Show Map'; mapOn = false;}
	else      {document.getElementById('displayMap').style.display = ""; document.getElementById('togMapContents').innerHTML = '<i class="x-icon-user"></i>&emsp;Hide Map'; mapOn = true; initialize();}
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
			
			try{
				var magnificPopup = $.magnificPopup.instance; 
				magnificPopup.close();
			}catch(e){}
			return _results;
		  }
		};
		
		<!--Drag N Drop-->

</script>
<script type='text/javascript' src='../wp-content/plugins/magnificpopup/js/jquery.magnific-popup.min.js'></script>
<script type='text/javascript' src='../wp-content/plugins/magnificpopup/js/prefixfree.min.js'></script>
<script type='text/javascript' src='../wp-content/plugins/magnificpopup/js/index.js'></script>
<?php  alertSystem(); ?>

</body>
</html>
