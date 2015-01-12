<?php include('../meta.php');?>
<!DOCTYPE html>
<!--[if IE 8]><html class="no-js ie8" lang="en-US"><![endif]-->
<!--[if IE 9]><html class="no-js ie9" lang="en-US"><![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" lang="en-US"><!--<![endif]-->
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../favicon.ico" />
  
  <?php

	if(!$_GET['l'] || $_GET['l'] == '' || !base64_decode($_GET['l'], true)){
		echo "<script>window.location='../Sections?msg=NotFound';</script>";
	}
	else{
		$result = mysqli_query($conn,"SELECT
`LISTING`.`NAME` ,  
`LISTING`.`DESCRIPTION` ,  
`LISTING`.`TYPE` ,  
`CATEGORY`.`NAME` ,  
`LISTING`.`IMAGE` ,  
`LISTING`.`COUNTRY` ,  
`LISTING`.`PROVIDENCE` ,  
`LISTING`.`CITY` , 
`LISTING`.`LONG` ,  
`LISTING`.`LAT` ,  
`LISTING`.`INQUIRIES`,  
`LISTING`.`TIMESTAMP` ,  
`LISTING`.`FEATURED` ,  
`LISTING`.`TOGGLE` ,  
`LISTING`.`AGE_FILTER` ,  
`USER`.`FIRST_NAME` , 
`USER`.`LAST_NAME` ,  
`USER`.`COUNTRY` ,  
`USER`.`PROVIDENCE` ,  
`USER`.`EMAIL` ,  
`USER`.`CLEAN_NAME` , 
`USER`.`REGISTERED` ,  
`USER`.`REP`,  
`USER`.`ACTIVATED`,
`SECTION`.`SECTION`,
`LISTING_VIDEO`.`VIDEO_URL`,
`CATEGORY`.`ICON`,
`LISTING_LAYOUT`.`SHOW_MAP`,
`LISTING_LAYOUT`.`DATA`

FROM  `LISTING` 
LEFT JOIN `USER` ON  `USER`.`ID` =  `LISTING`.`USER` 
LEFT JOIN `CATEGORY` ON `CATEGORY`.`ID`=`LISTING`.`CATEGORY`
LEFT JOIN `LISTING_LAYOUT` ON `LISTING`.`HASH62`=`LISTING_LAYOUT`.`LISTING`
LEFT JOIN `SECTION` ON `SECTION`.`ID`=`CATEGORY`.`SECTION`
LEFT JOIN `LISTING_VIDEO` ON `LISTING_VIDEO`.`LISTING`=`LISTING`.`HASH62`
WHERE  `LISTING`.`HASH62` =  '{$_GET['l']}'
LIMIT 1");

		$empty = mysqli_num_rows($result);
		if($empty <= 0){
			 die('Uh Oh, This listing Does Not Exist.<script>window.location = "https://synclis.com/this-listing-does-not-exist";</script>');
		}
		
		if (!$result) {
			 die('Uh Oh, This listing Does Not Exist.<script>window.location = "https://synclis.com/this-listing-does-not-exist";</script>');
		}
		mysqli_query($conn,"UPDATE `LISTING` SET `PAGE_VIEWS` = `PAGE_VIEWS` + 1 WHERE  `LISTING`.`HASH62`='{$_GET['l']}';");
		$row = mysqli_fetch_row($result);
		
	}
  ?>
  
<!--SEO TAGS-->
<title><?php echo substr($row[0], 0, 60); ?> | Synclis</title>
<meta name='description' content='<?php echo ereg_replace("[^A-Za-z0-9 ]", "", substr($row[1], 0, 200) ); ?>'>
<meta name="ROBOTS" content="INDEX, NOFOLLOW" />
<link rel="publisher" href="https://plus.google.com/u/0/b/111736498704458786396/"/>
<!--SEO TAGS-->
  
<link rel='stylesheet' href='../wp-content/plugins/x-custom/x-custom.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../wp-content/plugins/x-shortcodes/css/renew.css' type='text/css' media='all' />
<link rel='stylesheet' href='../wp-content/themes/x/framework/css/site/stacks/renew.css' type='text/css' media='all' />
<link href="owl-carousel/owl.carousel.css" rel="stylesheet">
<link href="owl-carousel/owl.theme.css" rel="stylesheet">

<script src="../wp-includes/js/jquery/jquery-1.9.1.js"></script>
<script type='text/javascript' src='../wp-includes/js/jquery/jquery-migrate.min.js?ver=1.2.1'></script>
<script type='text/javascript' src='../wp-content/themes/x/framework/js/x.min.js'></script>
<script type='text/javascript' src='../wp-content/plugins/x-shortcodes/js/vendor/modernizr-2.7.1.min.js'></script>
<script type='text/javascript' src='../wp-content/plugins/x-shortcodes/js/vendor/fittext-1.1.0.min.js'></script>
<script type='text/javascript' src='../api/cookies.js'></script>

<script type='text/javascript' src='../wp-content/plugins/bootstrap/js/bootstrap.min.js'></script>
<link href="../wp-content/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<script src="../wp-content/pace.min.js"></script>
<link href="../wp-content/dataurl.css" rel="stylesheet" />

<link href="../wp-content/primary.css" rel="stylesheet">

<style type="text/css" media="screen">					
.useroptions{
	width: 100%;
	margin:0;
	padding:0;
}
.useroptions li{
	width: 33.3333%;
	color: black;
	float:left;
	transition: background 0.4s;
	-webkit-transition: background 0.4s;
	-moz-transition: background 0.4s;
	-o-transition: background 0.4s;
	-ms-transition: background 0.4s;
}
.useroptions li:hover{
	background: #eee;
	color: #1FB5AC;
	-webkit-box-shadow: inset 2px 2px 2px 1px rgba(220,220,220,1);
	-moz-box-shadow: inset 2px 2px 2px 1px rgba(220,220,220,1);
	box-shadow: inset 2px 2px 2px 1px rgba(220,220,220,1);
}
.useroptions li div{
	border-top: 1px solid #ddd;
	border-left: 1px solid #ddd;
	text-align: center;
	padding: 5px;
}

#owl-demo .owlitem{
	margin: 3px;
}
#owl-demo .owlitem img{
	display: block;
	width: 100%;
	height: auto;
}
      #map-canvas {
        height: 400px;
        margin: 0px;
        padding: 0px
      }
</style>

<!--Google Maps API-->
	<?php
		if($row[27] == 1){
	?>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=drawing"></script>
    <script>
	var marker, map;
	var minZoomLevel = 5;
	function initialize() {
	  var myLatlng = new google.maps.LatLng(<?php echo $row[9]; ?>,<?php echo $row[8]; ?>);
	  var mapOptions = {
		zoom: 15,
		center: myLatlng,
		minZoom: 12
	  }
	  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
	  marker = new google.maps.Marker({
		  position: myLatlng,
		  map: map,
		title: 'Location of this Event'
	  });
	}
	google.maps.event.addDomListener(window, 'load', initialize);
	
	</script>
	<?php
		}
	?>
<!--Google Maps API-->


  </head>
<body class="home page page-id-3034 page-template page-template-template-blank-4-php x-renew x-navbar-fixed-top-active x-boxed-layout-active x-sidebar-content-active">
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=219802621553344";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div id="top" class="site">

<header class="masthead" role="banner">
	<?php printNav(); ?>
</header>
    

	<div class="x-main" role="main">
		<article id="post-3034" class="post-3034 page type-page status-publish hentry no-post-thumbnail">
			<div class="entry-content">

				<div id="x-content-band-5" class="x-content-band border-top border-bottom man" style="background-color: #fff; padding-bottom:20px ">
					<div class="x-container-fluid max width">
						<span style="font-size: 150%;"><a href="https://synclis.com">Synclis</a> > <a href="https://synclis.com/Sections/"><?php echo $row[24]; ?></a> > <a href="https://synclis.com/Listings/<?php echo $row[24]?>/<?php echo $row[3]; ?>"> <img style="width:64px; height:64px;" src="../<?php echo $row[26]; ?>"/> </a> > <?php echo $row[0]; ?></span><br/><br/>
					</div>
				</div>
				


				<div id="x-content-band-6" class="x-content-band bg-pattern man" style="background-image: url(../icons/cream_pixels.png); background-color: transparent;">
					<div class="x-container-fluid max width">
						<h3  class="h-custom-headline mtn center-text h5 accent"><span><?php echo $row[0]; ?></span></h3>

						
						<div class="x-column two-thirds" >
							<div style="border: 1px solid #ddd; border-radius: 3px; margin-bottom: 6px; position: relative; background: white;">
							
							<?php
							if($row[25] != '' || $row[25] != null)
								echo '<center><iframe style="width: 100%; height: 300px; max-width:480px;" src="https://www.youtube.com/embed/'. $row[25] .'" frameborder="0" allowfullscreen></iframe></center>';

								$e = mysqli_query($conn,"SELECT `LOCATION`,`DESCRIPTION`,`THUMB` FROM `LISTING_IMAGE` WHERE `LISTING`='{$_GET['l']}'");
								if(!e){die("<script>window.location='http://synclis.com/Sections?msg=NotFound';</script>");}
								if(mysqli_num_rows($e) > 0){
							?>
								  <div id="demo">
									<div class="container" style="border: 1px solid #aaa; border-radius: 3px; padding: 6px; margin: 6px;">
									  <div class="row">
										<div class="span12">
										  <span id="image-popups">
										  <div id="owl-demo" class="owl-carousel">
											<?php
												
												while($ro = mysqli_fetch_row($e))
													echo '<div class="owlitem"><a href="'. $ro[0] .'" target="_blank"><img class="lazyOwl" data-src="'. $ro[2]  .'" alt="'. $ro[1] .'"></a></div>';
											?>
										  </div>
										  </span>
										</div>
									  </div>
									</div>
								</div>
								<?php }?>

								<!--END DEV ZONE-->
								
								<style>
									.hori{
										width: 100%;
										border: 1px solid #ddd;
										border-radius: 3px;
										margin-bottom: 7px;
										padding: 3px;
									}
									.des{
										border: 1px solid #ddd;
										border-radius: 3px;
										margin-bottom: 7px;
										padding: 3px;
									}
								</style>
								
								<div style = "padding: 12px;">
									<h3  class="h-custom-headline mtn center-text h5 accent"><span>Description</span></h3>
									<div class="x-container-fluid max width">
									<?  
										$bcode   = array("[h1]", "[h2]", "[v1]","[v2]","[/h1]","[/h2]","[/v1]","[/v2]");
										$htmlout = array("<div class='hori'>", "<div class='hori'>", "<div class='x-column one-half des'>","<div class='x-column one-half last des'>","</div>","</div>","</div>","</div>");
										echo str_replace($bcode, $htmlout, nl2br ($row[1]) );
									?>
									</div>
											
								</div>
								<div style="clear:both;"></div>
							</div>
						</div>
						
						<div  class="x-column one-third last " >
							<div style="border: 1px solid #ddd; border-radius: 3px; margin-bottom: 6px; position: relative; background: white;">
								<?php if($row[23] == 1){ ?>
								<div style="padding: 12px;">
									<h3  class="h-custom-headline mtn center-text h5 accent"><span>User Profile</span></h3>
									
									<img src="noprofilem.png" style = "border: 1px solid #eee; border-radius: 3px; float: left; margin-right: 8px;" />
									<i class="x-icon-users"></i> <a href="https://synclis.com/Profile/<?php echo $row[20]; ?>"><?php echo $row[15] . ' ' . $row[16]; ?></a><br/>
									( Reputation: <?php echo $row[22]; ?> )<br/>
									<i class="x-icon-map-marker"></i> <?php echo $row[17] . ", " . $row[18]; ?><br/>
									<i class="x-icon-calendar-o"></i> User since: <?php echo date("M, Y", ($row[21] + (($GLOBALS['USER_DATA'][2]+5)*60*60)) ); ?><br/><br/>
								</div>
								
								<ul class="useroptions">
									<a href="Javascript:void(0);" data-toggle="modal" data-target="#myModal"><li><div style="border-left: none;"><i class="x-icon-pencil-square-o"></i> Message </div></li></a>
									<a href="Javascript:void(0);" onClick="bookmarkit('<?php echo $_GET['l']; ?>');"><li><div id="bkm<?php echo $_GET['l']; ?>"><i class="x-icon-bookmark"></i> Bookmark </div></li></a>
									<a href="Javascript:void(0);" data-toggle="modal" data-target="#reportModal"><li><div><i class="x-icon-flag"></i> Report </div></li></a>
									<div style="clear:both;"></div>
								</ul>
								<?php }else if($row[23] === 0){
								?>
									<div style="padding: 12px;">
										<h3  class="h-custom-headline mtn center-text h5 accent" style="color: #f88;"><span>User Profile <?php echo $row[23]; ?></span></h3>
										<img src="noprofilem.png" style = "border: 1px solid #eee; border-radius: 3px; float: left; margin-right: 8px;" />
										<i class="x-icon-users"></i> *This user has been banned or terminated from Synclis.<br/>
									</div>
								<?php
								}
								else{
								?>
									<div style="padding: 12px;">
										<h3  class="h-custom-headline mtn center-text h5 accent"><span>User Profile</span></h3>
										
										<img src="noprofilem.png" style = "border: 1px solid #eee; border-radius: 3px; float: left; margin-right: 8px;" />
										<i class="x-icon-users"></i> Anonymous User<br/>
										<i class="x-icon-map-marker"></i> <?php echo $row[6] . ", " . $row[7]; ?><br/>
										<i class="x-icon-calendar-o"></i> Created: <?php echo date("M d, Y", $row[11] ); ?><br/><br/>
									</div>
									
									<ul class="useroptions" id="inline-popups">
										<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal"><li><div style="border-left: none;"><i class="x-icon-pencil-square-o"></i> Message </div></li></a>
										<a href="javascript:void(0);" ><li><div><i class="x-icon-bookmark"></i> Bookmark </div></li></a>
										<a href="javascript:void(0);" data-toggle="modal" data-target="#reportModal"><li><div><i class="x-icon-flag"></i> Report </div></li></a>
										<div style="clear:both;"></div>
									</ul>
								<?php
								}
								?>
								
							</div>


							<div id="aiwidget" style="border: 1px solid #ddd; border-radius: 3px; padding: 12px; margin-bottom: 6px; position: relative; background: white;">
								<h3  class="h-custom-headline mtn center-text h5 accent"><span>Additional Information</span></h3>
								<p id = "aioutput"></p>
								<div style="clear:both;"></div>
							</div>
							
							<div style="border: 1px solid #ddd; border-radius: 3px; padding: 12px; margin-bottom: 6px; position: relative; background: white;">
								<h3  class="h-custom-headline mtn center-text h5 accent"><span>Share</span></h3>
									
								<center>
								<div style="width: 31%;margin: 1%;height: 75px;float:left;background: white;border-radius: 3px;">
									<div style="width: 100%; padding: 6px; text-align: center;">
										<!--  Facebook Share Button-->
										<div class="fb-share-button" data-href="https://synclis.com/ViewListing/<?php echo $_GET['l']; ?>" data-type="box_count"></div>
									</div>
								</div>
								</center>
								<div style="width: 31%;margin: 1%;height: 75px;float:left;background: white;border-radius: 3px;">
									<div style="width: 100%; padding: 6px 6px 6px 26px;">
										<!-- Twitter Share Button --> 
										<a href="https://twitter.com/share" class="twitter-share-button" data-url="https://synclis.com/ViewListing/<?php echo $_GET['l']; ?>" data-lang="en" data-count="vertical">Tweet</a>
										<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
									</div>
								</div>
								</center>
								<div style="width: 31%;margin: 1%;height: 75px;float:right;background: white;border-radius: 3px;">
									<div style="padding: 6px; float: right;">
										<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script><div class="g-plusone" data-size="tall" ></div>
									</div>
								</div>
								
								<div style="clear:both;"></div>
							</div>
							
							
							<?php
								if($row[27] == 1){
							?>
								<div id="displayMap" style = "padding:0; margin:0; position: relative;border: 1px solid #ddd; border-radius: 3px;">
									<div style="position: absolute; top:8px; left:4px; width: 100%; z-index: 500;">
										<h3 class="h-custom-headline mtn center-text h5 accent"><span>Location</span></h3>
									</div>
									<div id="map-canvas"></div>
								</div>
							<?php
								}
							?>
						</div>
						
						<hr class="x-clear">
					</div>
				</div>
        
      </div> <!-- end .entry-content -->
  </div> <!-- end .x-main -->

  


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="max-width: 300px; margin-left: -150px; display:none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style = "background: #5AC8C2; padding: 8px; text-align: center; color: #222;">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			Write Message
      </div>
      <div class="modal-body">
		<div style="padding: 8px;">
			<script>if(!readCookie('SYNCLIS_TOKEN'))document.write('<input type="text" id="synlis-email" placeholder="Your Email" style="width: 100%;"></input>');</script>
			<input type="text" id="synlis-header" placeholder="Title" style="width: 100%;"></input>
			<textarea id="synlis-message" placeholder="Message" style ="width:100%; height: 200px; resize: none;"></textarea>
			<div style="clear:both;"></div><br/>
		</div>
      </div>
      <div class="modal-footer">
		<a href="javascript:void(0);"  onClick="synclis_sendMessage();"><button style="width:80%; float:left;">Send</button></a>
        <button type="button"  style="width:20%; float:left;" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- Report Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="max-width: 300px; margin-left: -150px;  display:none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style = "background: #f55; padding: 8px; text-align: center; color: #222;">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			Report This User
      </div>
      <div class="modal-body">
		<div style="padding: 8px; border: #f33; background: #f99; color: black; font-size: 10px; border-radius: 3px;">
			Reporting a user in Synclis is community driven.<br/>
			The more compelling the reports generated through a series of unique users will cause this user to be temporarily banned.
		</div>
		<br/>
		<div style="padding: 8px;">
			<select style="width:100%;">
				<option>Select Reason for Reporting</option>
				<option>Inappropriate Content</option>
				<option>Scamming or Phishing</option>
				<option>Invalid claim</option>
				<option>Other</option>
			</select>
			<textarea id="synlis-message" placeholder="Additional information" style ="width:100%; height: 200px; resize: none;"></textarea>
			<div style="clear:both;"></div><br/>
		</div>
      </div>
      <div class="modal-footer">
		<a href="javascript:void(0);"  onClick="synclis_sendMessage();"><button style="width:80%; float:left;">Report This User</button></a>
        <button type="button"  style="width:20%; float:left;" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

    
    <footer class="x-colophon bottom" role="contentinfo">
		<?php printFooter(); ?>
    </footer> <!-- end .x-colophon.bottom -->

    
  </div>

  <!--
  END #top.site
  -->
  
<script src="owl-carousel/owl.carousel.js"></script>	
<script type='text/javascript' src='../wp-content/plugins/listinghelper.js'></script>

<!--JSON INTERPRETER-->
<script>
	try{
		var json = <?php if(!$row[28] || $row[28] == '' || $row[28] == null) echo 'empty'; else echo $row[28] ?>;
		
		if(json.website)  document.getElementById('aioutput').innerHTML += "<strong>Website:</strong> <a style='color: #1FB5AC;' href='"+ json.website +"'>" + json.website + "</a><br/>";
		if(json.phoneno)  document.getElementById('aioutput').innerHTML += "<strong>Phone: </strong>" + json.phoneno + "<br/>";
		if(json.price)    document.getElementById('aioutput').innerHTML += "<strong>Price:</strong> $" + json.price + " ";
	if(json.paymentbasis) document.getElementById('aioutput').innerHTML += json.paymentbasis + "<br/>"; else document.getElementById('aioutput').innerHTML += "<br/>";
		if(json.bedroom) document.getElementById('aioutput').innerHTML += "<strong>Bedrooms:</strong> " + json.bedroom + "<br/>";
		if(json.bathroom)document.getElementById('aioutput').innerHTML += "<strong>Bathrooms:</strong> " + json.bathroom + "<br/>";
		if(json.condition)    document.getElementById('aioutput').innerHTML += "<strong>Condition:</strong> " + json.condition + "<br/>";
		if(json.paymentmethod) document.getElementById('aioutput').innerHTML += "<strong>Payment Method:</strong> " + json.paymentmethod + "<br/>";
		if(json.required_skills) document.getElementById('aioutput').innerHTML += "<strong>Required Skills:</strong> " + json.required_skills + "<br/>";
		
		if(json.length == 'empty' && document.getElementById('aiwidget')) document.getElementById('aiwidget').style.display = "none";
		if(document.getElementById('aioutput') && document.getElementById('aiwidget')) if(document.getElementById('aioutput').innerHTML == '') document.getElementById('aiwidget').style.display = "none";
	}catch(aiwidgeterror){
		if(document.getElementById('aiwidget')) document.getElementById('aiwidget').style.display = "none";
	}
	
</script>
<!--JSON INTERPRETER-->


<script>
	function synclis_sendMessage(){

		var http = new XMLHttpRequest();
		http.open("POST", "https://synclis.com/api/sys/mailuser", true);
		
		if(readCookie('SYNCLIS_TOKEN'))
			syncemail = "<?php echo $GLOBALS['USER_DATA'][0]; ?>";
		else
			syncemail = document.getElementById("synlis-email").value;
		
		var params = "header="+ document.getElementById("synlis-header").value + "&message="+ document.getElementById("synlis-message").value + "&listing=<?php echo $_GET['l'] ?>&email=" + syncemail;

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

	$(document).ready(function() {

		$("#owl-demo").owlCarousel({
			items : 3,
			lazyLoad : true,
			navigation : true,
			itemsMobile : [479,1]
		});

	});
</script>
	
<?php  alertSystem(); ?>
  
    
  
</body>
</html>
