<?php
	header('Content-Type: text/html; charset=UTF-8');
	$GLOBALS['ROOT'] = 'https://synclis.com';
	
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https" : "http";
	if($protocol == 'http'){ header("Location: " . $GLOBALS['ROOT']); }
	
	include('api/connectToDB.php');
	mysqli_query($conn, "SET NAMES 'utf8'");
	
	if(!$_COOKIE["SYNCLIS_TOKEN"])
		 $GLOBALS['LOGGED_IN_FLAG'] = false;
	else{$GLOBALS['LOGGED_IN_FLAG'] = true;
		
		$e = mysqli_query($conn,
			"SELECT `USER`.`EMAIL`, `USER`.`CLEAN_NAME`,`USER_PROFILE`.`TIMEZONE`,`USER`.`LANGUAGE`
				FROM `USER`
				LEFT JOIN `AUTH_TOKEN` ON `AUTH_TOKEN`.`USER_ID`=`USER`.`ID`
				LEFT JOIN `USER_PROFILE` ON  `USER_PROFILE`.`ID`=`AUTH_TOKEN`.`USER_ID`
				WHERE `AUTH_TOKEN`.`HASH_KEY`='{$_COOKIE["SYNCLIS_TOKEN"]}' LIMIT 1");
		$GLOBALS['USER_DATA'] = mysqli_fetch_row($e);
		if(mysqli_num_rows($e) == 0){
			echo '<script>window.location="https://synclis.com/Login/logout"</script>';
		}/*Profile Image*/
		
	}
	$GLOBALS['NO_LOCATION'] = false;
	if(!$_COOKIE["SYNCLIS_CURPOS"]){
		$json = file_get_contents("http://ipinfo.io/{$_SERVER['REMOTE_ADDR']}");
		$details = json_decode($json);
		
		$GLOBALS['COUNTRY'] = $details->country;
		$GLOBALS['CITY']  = $details->city; 
		$GLOBALS['REGION'] = $details->region;
		if($GLOBALS['COUNTRY'] != '' && $GLOBALS['REGION'] != '' && $GLOBALS['CITY'] != '')
		{
			?>
				<script type="text/javascript" src="<?php echo $GLOBALS['ROOT']; ?>/api/cookies.js"></script>
				<script type="text/javascript">createCookieByHour("SYNCLIS_CURPOS","<?php echo base64_encode( $GLOBALS['COUNTRY'] .":". $GLOBALS['CITY'] .":". $GLOBALS['REGION']); ?> .'",72);</script>
			<?php
		}
		else{
			$GLOBALS['NO_LOCATION'] = true;
		}
	}
	else{
		$val = explode(':',base64_decode($_COOKIE["SYNCLIS_CURPOS"]));
		$GLOBALS['COUNTRY'] = $val[0];
		$GLOBALS['CITY']  = $val[1];
		$GLOBALS['REGION'] = $val[2];
		
		if($GLOBALS['COUNTRY'] == '' && $GLOBALS['REGION'] == '' && $GLOBALS['CITY'] == ''){
			$GLOBALS['NO_LOCATION'] = true;
		}
	}
	
	function printNav(){
	
	$c = explode("/",$_SERVER[REQUEST_URI]);
	
	if($GLOBALS['LOGGED_IN_FLAG']){
		if($c[1] == 'Profile'){ $pr = 'current-menu-item current_page_item'; } else{ $pr = ''; }
		if($c[1] == 'MyListings' || $c[1] == 'EditListing'){$mlr = 'current-menu-item current_page_item'; } else{$mlr = ''; }
		$logoutopt = 
				   '<li class="menu-item-object-custom menu-item-home"><a href="'. $GLOBALS['ROOT'] .'/Login/logout"><i class="x-icon-power-off"></i><i class="hideunder980">&nbsp;Log Out '.$GLOBALS['NO_LOCATION'] .'</i></a></li>';
		$account = '<li class="menu-item-object-custom menu-item-home '. $pr .'"><a href="'. $GLOBALS['ROOT'] .'/Profile/'. $GLOBALS['USER_DATA'][1]  .'"><i class="x-icon-user"></i><i class="hideunder980">&nbsp;Profile</i></a></li>
					<li class="menu-item-object-custom menu-item-home '. $mlr .'"><a href="'. $GLOBALS['ROOT'] .'/MyListings"><i class="x-icon-align-left"></i><i class="hideunder980">&nbsp;&nbsp;My&nbsp;Listings</a></i></li>';
	}
	else{
		$logoutopt = '';
		$account = '<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children"><a href="'. $GLOBALS['ROOT'] .'/Login"><i class="x-icon-user"></i><i class="hideunder980">&nbsp;Sign Up</i></a></li>';
	}
	
	?>
	<div class="x-topbar">
		<div class="x-topbar-inner x-container-fluid max width">
			<span style="float:right; padding: 5px; font-size:11px;"><i class="x-icon-map-marker"></i> <?php echo $GLOBALS['COUNTRY'] .', '. $GLOBALS['REGION'] .' ('. $GLOBALS['CITY'] .')'; ?></span>
		</div>
	</div> 

	<div class="x-navbar-wrap">
	  <div class="x-navbar">
		<div class="x-navbar-inner x-container-fluid max width">
		  <h3 class="visually-hidden">Synclis</h3>
		  <a href="https://synclis.com/"><img id="synclis-logo" src="<?php echo $GLOBALS['ROOT']; ?>/media/logo.png" style="width: 150px;" href="https://synclis.com" class="x-brand text" title="Synclis"/></a>
		  
		  <nav class="x-nav-collapse collapse" role="navigation">

			<ul id="menu-primary" class="x-nav sf-menu">
				
				<li class="menu-item-object-page <?php if(!$c[1]){ echo 'current-menu-item current_page_item'; } ?>"><a href="<?php echo $GLOBALS['ROOT']; ?>"><i class="x-icon-home"></i><i class="hideunder980">&nbsp;Home</i></a></li>
				<li class="menu-item-object-custom menu-item-home <?php if($c[1] == 'Sections' || $c[1] == 'tour' || $c[1] == 'Listings' || $c[1] == 'ViewListing' || $c[1] == 'Search'){ echo 'current-menu-item current_page_item'; } ?>"><a href="<?php echo $GLOBALS['ROOT']; ?>/Sections"><i class="x-icon-globe"></i><i class="hideunder980">&nbsp;Explore</i></a> </li>
				<?php echo $account; ?>
				<li class="menu-item-object-custom menu-item-home <?php if($c[1] == 'CreateListing'){ echo 'current-menu-item current_page_item'; } ?>"><a href="<?php echo $GLOBALS['ROOT']; ?>/CreateListing/Select"><i class="x-icon-plus" title="Create your own listing"></i><i class="hideunder980">&nbsp;Create</i></li></a>
				<?php echo $logoutopt ?>
				<li class="hideunder980">
					<input type="text" id="search-box" style="float:right;" placeholder="search"></input>
					<div style="border: 2px solid #ddd; width:34px; border-right: none;height:34px; float:right; padding: 8px; cursor:pointer;" onClick="execSearch();">
					<i class="x-icon-search"></i></div>
					<div style="clear:both;"></div>
				</li>
				
			</ul>
		  </nav>
		</div>
	  </div>
	</div>
	<?php
	}
	
	function printFooter()
	{
		?>
		<div class="x-container-fluid max width" style="position:absolute;">
			<div class="soc-icon" style="font-size: 16px;">
				<a title="Facebook" href="https://www.facebook.com/Synclis" target="_tab"><i class="x-social-facebook"></i></a>
				<a style = "margin-left:16px;" title="Twitter"  href="https://twitter.com/Synclis" target="_tab"><i class="x-social-twitter"></i></a>
				<a style = "margin-left:16px;" title="Google+" href="https://plus.google.com/+SynclisOfficial/" target="_blank"><i class="x-social-google-plus"></i></a>
				<a style = "margin-left:16px;" title="Pinterest" href="http://www.pinterest.com/synclis/" target="_blank"><i class="x-social-pinterest"></i></a>
				<a style = "margin-left:16px;" title="YouTube" href="https://www.youtube.com/channel/UCu7GZ5mceclvioNsO7LHg6g" target="_blank"><i class="x-icon-youtube-square"></i></a>
			</div>          
			<div class="x-colophon-content">
				&copy; Synclis <?php echo date("Y"); ?>. All rights reserved. <br/>
				<a href="https://synclis.com/About">About</a> | <a href="http://blog.synclis.com/">Blog</a> | <a href="http://api.synclis.com/">API</a> | <!--a href="#">Advertise</a> | <a href="#">Jobs</a--> | <a href="https://synclis.com/tos">Terms</a> | <a href="https://synclis.com/privacy">Privacy</a>
			</div>
        </div>
			<script type="text/javascript">
				function execSearch(){
					if(document.getElementById("search-box").value != ""){
						window.location="<?php echo $GLOBALS['ROOT']; ?>/Search/?q=" + document.getElementById("search-box").value;
					}
					else{
						alert("You must enter a query.");
					}
				}
				
			  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			  ga('create', 'UA-44624992-2', 'synclis.com');
			  ga('send', 'pageview');
			  
			jQuery(document).ready(function(){
				var retina = window.devicePixelRatio > 1 ? true : false;

				if(retina) {
					jQuery('#synclis-logo').attr('src', 'https://synclis.com/media/mlogo.png');
					jQuery('#synclis-logo').attr('width', '122');
					jQuery('#synclis-logo').attr('height', '37');
				}
			});
			
			document.getElementById('search-box').onkeyup = function(e){
			  e = e || event;
			  if (e.keyCode === 13) {
				execSearch();
			  }
			  return true;
			 }
			
			
</script>
	<?php

	}
	
	function printChat()
	{

	}
	
	function alertSystem()
	{
		?>
		<link rel="stylesheet" href="<?php echo $GLOBALS['ROOT']; ?>/wp-content/plugins/alertify/css/alertify.core.css" />
		<link id="#toggleCSS" rel="stylesheet" href="<?php echo $GLOBALS['ROOT']; ?>/wp-content/plugins/alertify/css/alertify.default.css" />
		<script src="<?php echo $GLOBALS['ROOT']; ?>/wp-content/plugins/alertify/js/lib/alertify.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				if(document.getElementById("synclis-content")){
					setTimeout(function(){
						document.getElementById("synclis-content").style.WebkitTransform = "translate3d(0,0,0)";
						document.getElementById("synclis-content").style.transform = "translate3d(0,0,0)";
						document.getElementById("synclis-content").style.WebkitTransition = "opacity 0.5s";
						document.getElementById("synclis-content").style.MozTransition = "opacity 0.5s";
						document.getElementById("synclis-content").style.transition = "opacity 0.5s";
						document.getElementById("synclis-content").style.opacity=1;
					},1000);
				}
			});

		function reset () {
			$("#toggleCSS").attr("href", "<?php echo $GLOBALS['ROOT']; ?>/wp-content/plugins/alertify/css/alertify.default.css");
			alertify.set({
				labels : {
					ok     : "OK",
					cancel : "Cancel"
				},
				delay : 5000,
				buttonReverse : false
			});
		}

		$("#forever").on( 'click', function () {
			reset();
			alertify.log("Will stay until clicked", "", 0);
			return false;
		});

		function pushNote(vals,type){
			reset();
			if(type="success"){
				alertify.success(vals);
			}else{
			alertify.custom = alertify.extend("custom");
			alertify.custom(vals);
			}
			return false;
		}
		</script>
		<?php
		if($GLOBALS['NO_LOCATION']){
		?>
			<script type='text/javascript' src='<?php echo $GLOBALS['ROOT']; ?>/wp-content/plugins/bootstrap/js/bootstrap.min.js'></script>
			<script type='text/javascript' src='<?php echo $GLOBALS['ROOT']; ?>/api/base64.js'></script>
			<script type="text/javascript" src="<?php echo $GLOBALS['ROOT']; ?>/api/cookies.js"></script>
			<link rel='stylesheet' href='<?php echo $GLOBALS['ROOT']; ?>/wp-content/plugins/bootstrap/css/bootstrap.min.css' type='text/css' media='all' />
			<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
			
				<div class="modal fade" id="geocodeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="max-width: 300px; margin-left: -150px; display:none;">
				  <div class="modal-dialog">
					<div class="modal-content">
					  <div class="modal-header">
						<h5 style="padding:0; margin:0 0 6px 0; text-align: center;" >Set your Location:</h5>
					  </div>
					  <div class="modal-body" style="color: black;">
						<center>
							<div id="demo" style="border: 1px solid #aaa; border-radius: 3px; background: #f8f8f8; padding: 6px; text-align: center; color: black;">
								Set Location
							</div><br/><br/>
						</center>
					  </div>
					  <div class="modal-footer">
						<button onClick="synclis_useGPS()" style="margin-bottom:5px;">Set your location with GPS.</button>
					  </div>
					</div>
				  </div>
				</div>
			<script>
				$('#geocodeModal').modal('show');
				var x = document.getElementById("demo");
				function synclis_useGPS()
				{
					if (navigator.geolocation)
					{
						navigator.geolocation.getCurrentPosition(showPosition);
					}
					else{x.innerHTML = "Geolocation is not supported by this browser.";}
				}
				function showPosition(position)
				{
					codeLatLng(position.coords.latitude,position.coords.longitude);
					if(window.successGeocode){
						$('#geocodeModal').modal('hide');
					}
				}
				var geocoder= new google.maps.Geocoder();
				function codeLatLng(lat,lng) {
				  var latlng = new google.maps.LatLng(lat, lng);
				  geocoder.geocode({'latLng': latlng}, function(results, status) {
					if (status == google.maps.GeocoderStatus.OK) {
					  if (results[1]) {
						window.successGeocode = true;
						createCookieByHour("SYNCLIS_CURPOS", Base64.encode(results[1].address_components[4].short_name + ":"+ results[1].address_components[1].long_name  +":" + results[1].address_components[3].long_name ),72);
					  } else {
						alert('No results found');
						x.innerHTML = "Unknown Location.";
						createCookieByHour("SYNCLIS_CURPOS", Base64.encode("UU" + ":"+ "Unknown"  +":" + "Unknown" ),72);
						window.successGeocode = false;
					  }
					} else {
					  alert('Geocoder failed due to: ' + status);
					  x.innerHTML = "Unknown Location.";
					  createCookieByHour("SYNCLIS_CURPOS", Base64.encode("UU" + ":"+ "Unknown"  +":" + "Unknown" ),72);
					  window.successGeocode = false;
					}
				  });
				}
			</script>
		<?php
		}
	}
	
	function additionalScript()
	{

	}
	
	unset($a);
?>
