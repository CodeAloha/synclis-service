<?php 
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
	<title>Synclis Tours | Synclis</title>
	<meta name='description' content='Synclis is a powerful peer to peer listing resource made with you in mind. It also uses Social Media to get the most out of your listings. It is free to get started, why not post your listings today?'>
	<meta name="ROBOTS" content="INDEX" />
	<link rel="publisher" href="https://plus.google.com/u/0/b/111736498704458786396/"/>
	<meta property="og:title" content="Synclis Tours"/>
	<meta property="og:type" content="article" />
	<meta property="og:image" content="https://synclis.com/media/symbolwhitebg.png"/>
	<meta property="og:url" content="https://synclis.com/tour"/>
	<meta property="og:description" content="Synclis is a powerful peer to peer listing resource made with you in mind. It also uses Social Media to get the most out of your listings. It is free to get started, why not post your listings today?" />
	<meta name="twitter:card" content="summary">
	<meta name="twitter:title" content="Synclis Tours" />
	<meta name="twitter:url" content="https://synclis.com"/>
	<meta name="twitter:description" content="Synclis is a powerful peer to peer listing resource made with you in mind. It also uses Social Media to get the most out of your listings. It is free to get started, why not post your listings today?">
	<meta name="twitter:image" content="https://synclis.com/media/symbolwhitebg.png">
	<!--SEO TAGS-->
  
	<link rel="shortcut icon" href="../../favicon.ico" />
	<?php

			$t = mysqli_query($conn,"SELECT
`LISTING`.`ID`,
`LISTING`.`NAME`,
`LISTING`.`DESCRIPTION`,
`LISTING`.`CATEGORY`,
`LISTING`.`IMAGE`,
`LISTING`.`LONG`,
`LISTING`.`LAT`,
`LISTING`.`TOGGLE`,
`LISTING`.`AGE_FILTER`,
`LISTING`.`HASH62`,
`CATEGORY`.`ICON`,
`LISTING_LAYOUT`.`DATA`,
`LISTING_VIDEO`.`VIDEO_TYPE`,
`LISTING_VIDEO`.`VIDEO_URL`
FROM `LISTING`
LEFT JOIN `CATEGORY` ON `LISTING`.`CATEGORY` = `CATEGORY`.`ID`
LEFT JOIN `SECTION` ON `SECTION`.`ID`=`CATEGORY`.`SECTION`
LEFT JOIN `LISTING_LAYOUT` ON `LISTING_LAYOUT`.`LISTING`=`LISTING`.`HASH62`
LEFT JOIN `LISTING_VIDEO` ON `LISTING_VIDEO`.`LISTING`=`LISTING`.`HASH62`
WHERE `LISTING`.`FEATURED` = 1
ORDER BY `LISTING`.`RATING` DESC LIMIT 100");
		
	?>
  

	<link rel='stylesheet' href='../../wp-content/plugins/x-custom/x-custom.css' type='text/css' media='screen' />
	<link rel='stylesheet' href='../../wp-content/plugins/x-shortcodes/css/renew.css' type='text/css' media='all' />
	<link rel='stylesheet' href='../../wp-content/themes/x/framework/css/site/stacks/renew.css' type='text/css' media='all' />
	<link rel='stylesheet' href='../../wp-content/primary.css' type='text/css' media='all' />

	<script type='text/javascript' src='../../wp-includes/js/jquery/jquery-1.9.1.js'></script>
	<script type='text/javascript' src='../../wp-includes/js/jquery/jquery-migrate.min.js?ver=1.2.1'></script>
	<script type='text/javascript' src='../../wp-content/themes/x/framework/js/x.min.js'></script>
	<script type='text/javascript' src='../../api/cookies.js'></script>

	<link rel='stylesheet' href='../../wp-content/plugins/magnificpopup/css/magnific-popup.css' type='text/css' media='all' />
	<script type='text/javascript' src='../../wp-content/plugins/x-shortcodes/js/vendor/backstretch-2.0.3.min.js'></script>
	<script type='text/javascript' src='../../wp-content/plugins/x-shortcodes/js/vendor/modernizr-2.7.1.min.js'></script>
	<script type='text/javascript' src='../../wp-content/plugins/x-shortcodes/js/vendor/fittext-1.1.0.min.js'></script>

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
	  .x-topbar{
		display:none;
	  }
	  
	  #synclis-map-center-location{
		-webkit-box-shadow: 0px 2px 3px 0px rgba(221,221,221,0.5);
		-moz-box-shadow: 0px 2px 3px 0px rgba(221,221,221,0.5);
		box-shadow: 0px 2px 3px 0px rgba(221,221,221,0.5);
		outline: none;
		background: #fff; 
		width: 33%; 
		position: absolute; 
		bottom: 12px; 
		left: 20%; 
		padding: 6px; 
		border-radius: 3px; 
		border: 1px solid #aaa;
		transition: padding 0.4s;
		-webkit-transition: padding 0.4s;
		-moz-transition: padding 0.4s;
		-o-transition: padding 0.4s;
	  }
	  #synclis-map-center-location:focus{
		padding: 6px 6px 6px 12px;
		border-color: rgba(31, 181, 172, 0.8);
		box-shadow: 0 1px 1px rgba(31, 181, 172, 0.075) inset, 0 0 4px rgba(31, 181, 172, 0.6);
	  }
    </style>
	
	<script type="text/javascript" src="../../api/base64.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=geometry"></script>
    <script>
	var marker, map, listings= [];
	var minZoomLevel = 5;
	function initialize() {
	  var mapOptions = {
		zoom: 15,
		center: new google.maps.LatLng(21.306944,-157.858333),
		minZoom: 12
	  }
	  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
	  geocoder = new google.maps.Geocoder();

	  <?php $count= 0; while($row = mysqli_fetch_row($t)){ ?>
		  listings[<?php echo $count; ?>] = new google.maps.Marker({
			  position: new google.maps.LatLng(<?php echo $row[6] ?>, <?php echo $row[5] ?>),
				   map: map,
					id: '<?php echo $row[9] ?>',
				 title: '<?php echo $row[1] ?>',
		   description: '<?php echo str_replace(array("\n","\r"), '', nl2br (   substr ( $row[2] , 0, 200)  )); ?>',
				  data: '<?php echo $row[11] ?>',
				 image: '<?php echo $row[4] ?>',
				 video: '<?php echo $row[13] ?>',
				    vt: '<?php echo $row[12] ?>',
				  icon: 'https://synclis.com/ImageGenerator.php?img=<?php echo $row[10] ?>',
				   gen: 'https://synclis.com/<?php echo $row[10] ?>'
		  });
		  google.maps.event.addListener(listings[<?php echo $count; ?>], 'click', function() {
			generatePreview(listings[<?php echo $count; ?>].id, listings[<?php echo $count; ?>].title, listings[<?php echo $count; ?>].description, listings[<?php echo $count; ?>].data, listings[<?php echo $count; ?>].gen, listings[<?php echo $count; ?>].image,listings[<?php echo $count; ?>].video,listings[<?php echo $count; ?>].vt);
		  });
	  <?php $count++; } ?>

	  
		marker = new google.maps.Marker({
		  position: new google.maps.LatLng(22.306944,-157.858333),
		  map: map,
		 icon: 'light-blue-circle.png'
		});
		
		// Add circle overlay and bind to marker
		var circle = new google.maps.Circle({
		  map: map,
		  radius: 50,    // 10 miles in metres
		  zIndex: 5,
		  strokeWeight: 0,
		  fillColor: '#00DD00'
		});
		circle.bindTo('center', marker, 'position');
		
		google.maps.event.addListener(map, 'center_changed', function() {
			window.setTimeout(function() {
			  map.panTo(marker.getPosition());
			}, 300);
		});
	}
	google.maps.event.addDomListener(window, 'load', initialize);
	function codeAddress(address) {
		geocoder.geocode( { 'address': address}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
			  map.setCenter(results[0].geometry.location);

			  
			  if(marker) marker.setMap(null);
			  marker = new google.maps.Marker({
				  position: results[0].geometry.location,
				  map: map,
				 icon: 'light-blue-circle.png'
			  });
			  
			  
			} else {
				alert("Could not find your desired location.");
			}
		});
	}
	
	
	//FOLLOW ME
	var watchID;
	var geoLoc;
	function showLocation(position) {
	  var latitude = position.coords.latitude;
	  var longitude = position.coords.longitude;
	  map.setCenter(new google.maps.LatLng(latitude,longitude));

	  
	  marker.setPosition( new google.maps.LatLng( latitude,longitude) );
	  /*if(marker) marker.setMap(null);
	  
	  marker = new google.maps.Marker({
		  position: new google.maps.LatLng(latitude,longitude),
		  map: map,
		 icon: 'light-blue-circle.png'
	  });*/
	}


	function errorHandler(err) {
		alert("Error("+ err.mcode +"): " + err.message);
	}

	if(navigator.geolocation){
	  var options = {enableHighAccuracy: true};
	  geoLoc = navigator.geolocation;
	  watchID = geoLoc.watchPosition(showLocation, errorHandler, options);
	}else{
	  alert("Sorry, browser does not support geolocation!");
	}

	
	
	
	
	
	
	function generatePreview(i,t,d,k,m,o,v,vt){
		document.getElementById("synclis-main-contain").style.transition = "opacity 0.4s";
		document.getElementById("synclis-main-contain").style.WebkitTransition = "opacity 0.4s";
		document.getElementById("synclis-main-contain").style.WebkitTransform = "translate3d(0, 0, 0)";
		document.getElementById("synclis-main-contain").style.opacity = '0';
		
		if(document.getElementById("synclis-slidein-container").style.right != 0){
			document.getElementById("synclis-slidein-container").style.transition = "right 0.4s";
			document.getElementById("synclis-slidein-container").style.WebkitTransition = "right 0.4s";
			document.getElementById("synclis-slidein-container").style.WebkitTransform = "translate3d(0, 0, 0)";
			document.getElementById("synclis-slidein-container").style.right = '0';
		}
		
		//Parse Data
		setTimeout(function(){
			document.getElementById("synclis-title").innerHTML = '<img src="'+ m +'" style= "width: 28px; height:28px;" />&nbsp;' + t;
			document.getElementById("synclis-description").innerHTML = d;
			document.getElementById("synclis-img").src = o;
			
			if(vt && v){
				document.getElementById("synclis-img").innerHTML = '';
				if(vt == 'YouTube')
					document.getElementById("synclis-videoiframesource").innerHTML = '<iframe style="border-top-left-radius: 3px; border-top-right-radius: 3px; width: 100%; height: 200px; max-width:276px;" src="https://www.youtube.com/embed/'+ v +'?wmode=transparent&autoplay=1" frameborder="0" allowfullscreen="" wmode="Opaque"></iframe>';
				
			}else{
				document.getElementById("synclis-videoiframesource").innerHTML = '';
				document.getElementById("synclis-img").innerHTML = '<img src="'+ o +'" style="border-top-left-radius: 3px; border-top-right-radius: 3px; max-width: 276px; height: 200px;" />';
			}
			
			var j = JSON.parse(k), res = "";

			if(j.website) res += "<a href='"+ j.website +"' target='_blank'><i class='x-icon-link'></i>: "+ j.website.replace('http://', '') +"</a><br/>";
			if(j.price && j.paymentbasis) res += "<i class='x-icon-tags'></i>: $" + j.price + " " + j.paymentbasis + "<br/>";
			if(j.phoneno) res += "<i class='x-icon-phone'></i>: "+ j.phoneno + "<br/>";
			if(j.bedroom) res += "<img src='https://synclis.com/icons/multipurpose/bed.png' style='width: 16px; height: 16px;'/>: "+ j.bedroom + "<br/>";
			if(j.bathroom) res += "<img src='https://synclis.com/icons/multipurpose/bath.png' style='width: 16px; height: 16px;'/>: "+ j.bathroom + "<br/>";
			
			if(res != '')document.getElementById("synclis-misc-data").innerHTML = '<div style="padding: 12px; border: 1px dashed #aaa; border-radius: 3px; background: #fff;">' + res + "</div>";
			else document.getElementById("synclis-misc-data").innerHTML = "";
			setTimeout(function(){
				document.getElementById("synclis-main-contain").style.opacity = '1';
			},400);
		},400);
	}
	
	
	</script>
	
  </head>
<body class="home page page-template page-template-template-blank-4-php x-renew x-navbar-fixed-top-active x-boxed-layout-active x-sidebar-content-active" >
	<header id="desktop-header" class="masthead" role="banner">
		<?php printNav(); ?>
	</header>
	<div id="map-canvas"></div>
	<input id="synclis-map-center-location" placeholder="Enter a Location" ></input>
	<div id="synclis-slidein-container" style="position: fixed; top: 90px; right:-305px; width: 300px; background: #fff; background: rgba(255,255,255,0.95); z-index: 20; height: 100%; border-left: 1px solid #ddd;">
		<img src="symbollite.png" style="position: absolute; bottom: 0; left:0; z-index: 0; max-width: 489px;" />
		<div id="synclis-main-contain">
			<div style="padding: 12px;position: relative; z-index: 1;">
				<div id="synclis-img" style="background: #eee; text-align: center;"></div>
				<div id="synclis-videoiframesource"></div>
				<div style="width: 276px; background: rgba(240,240,240,0.5); font-size: 12px; padding: 6px; ">
					<div id="synclis-title" style="color: #222; text-align: center; margin: 6px 0 6px 0; font-size: 16px;"></div>
					<div id="synclis-misc-data"></div>
					<div id="synclis-description" style="padding: 12px; "></div>
				</div>
			</div>
		</div>
	</div>
	
	<script>
		var MUX = 0;
		window.onresize = function(event) {
		
			if(window.innerHeight <=1200 && window.innerWidth <= 1200){
				document.getElementById("desktop-header").style.display = "none";
				MUX = 0;
			}else{
				document.getElementById("desktop-header").style.display = "";
				MUX = 90;
			}
			document.getElementById('map-canvas').style.height = (window.innerHeight-MUX) +"px";
		};
		if(window.innerHeight <=1200 && window.innerWidth <= 1200){
			document.getElementById("desktop-header").style.display = "none";
			MUX = 0;
		}else{
			document.getElementById("desktop-header").style.display = "";
			MUX = 90;
		}
		document.getElementById('map-canvas').style.height = (window.innerHeight-MUX) +"px";
	
		document.getElementById('synclis-map-center-location').onkeyup = function(e){
			e = e || event;
			if (e.keyCode === 13) {
				codeAddress(document.getElementById('synclis-map-center-location').value);
				document.getElementById('synclis-map-center-location').value = "";
			}
			return true;
		}
	</script>
</body>
</html>
