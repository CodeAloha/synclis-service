<?php include('../meta.php');?>
<!DOCTYPE html>
<!--[if IE 8]><html class="no-js ie8" lang="en-US"><![endif]-->
<!--[if IE 9]><html class="no-js ie9" lang="en-US"><![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" lang="en-US"><!--<![endif]-->

<?php
	if( ctype_alnum ($_GET['c']) ){
		$k= mysqli_query($conn,"SELECT `USER`.`FIRST_NAME`, `USER`.`LAST_NAME`,`USER`.`PROFILE_IMG`,`USER`.`REGISTERED`,`USER`.`REP`,`USER_PROFILE`.`PREFERENCES`,`USER_PROFILE`.`SKILLS`,`USER_PROFILE`.`BIO`,`USER_PROFILE`.`TRADE`, `USER_PROFILE`.`LOCSETTING`, `USER_PROFILE`.`SHOW_LOCATION`, `USER_LOGIN`.`MULTI_LOGIN`,`USER`.`COUNTRY`,`USER`.`PROVIDENCE`,`USER`.`CITY`
								FROM `USER`
								LEFT JOIN `USER_PROFILE` ON `USER`.`ID`=`USER_PROFILE`.`ID`
								LEFT JOIN `USER_LOGIN` ON `USER`.`ID`=`USER_LOGIN`.`ID`
								WHERE `USER`.`CLEAN_NAME`='{$_GET['c']}' LIMIT 1");
		if(!$k) die('Opps something went wrong.');
		$userinfo = mysqli_fetch_row($k);
	}
	else{
		die('Sorry, this Profile does not exist.');
	}
?>

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!--SEO TAGS-->
<title><?php echo $userinfo[0] . ' ' . $userinfo[1]; ?> | Synclis</title>
<meta name='description' content='<?php echo $userinfo[0] . ' ' . $userinfo[1]; ?>s Profile on Synclis, sign up for Synclis and begin sharing your listings, events and services within your local community.'>
<meta name="ROBOTS" content="INDEX, NOFOLLOW" />
<link rel="publisher" href="https://plus.google.com/u/0/b/111736498704458786396/"/>
<meta property="og:title" content="<?php echo $userinfo[0] . ' ' . $userinfo[1]; ?> | Synclis"/>
<meta property="og:type" content="article" />
<meta property="og:image" content="https://synclis.com/media/symbolwhitebg.png"/>
<meta property="og:url" content="<?php echo "http://". $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"/>
<meta property="og:description" content="<?php echo $userinfo[0] . ' ' . $userinfo[1]; ?>s Profile on Synclis, sign up for Synclis and begin sharing your listings, events and services within your local community." />
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="<?php echo $userinfo[0] . ' ' . $userinfo[1]; ?>" />
<meta name="twitter:url" content="<?php echo "http://". $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"/>
<meta name="twitter:description" content="<?php echo $userinfo[0] . ' ' . $userinfo[1]; ?>s Profile on Synclis, sign up for Synclis and begin sharing your listings, events and services within your local community.">
<meta name="twitter:image" content="https://synclis.com/media/symbolwhitebg.png">
<!--SEO TAGS-->

<link rel="shortcut icon" href="../favicon.ico" />
<link rel='stylesheet' href='../wp-content/plugins/x-custom/x-custom.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../wp-content/plugins/x-shortcodes/css/renew.css' type='text/css' media='all' />
<link rel='stylesheet' href='../wp-content/themes/x/framework/css/site/stacks/renew.css' type='text/css' media='all' />
<link rel="stylesheet" type="text/css" href="../wp-content/primary.css" media='all'/>
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans:300,300italic,700,700italic|Open+Sans:700|Raleway:400|Raleway:700&#038;subset=latin,latin-ext' type='text/css' media='all' />
<script src="../wp-includes/js/jquery/jquery-1.9.1.js"></script>
<script type='text/javascript' src='../api/cookies.js'></script>
<script type='text/javascript' src='../wp-content/themes/x/framework/js/x.min.js'></script>
<script type='text/javascript' src='../wp-includes/js/jquery/jquery-migrate.min.js?ver=1.2.1'></script>
<script type='text/javascript' src='../wp-content/plugins/x-shortcodes/js/vendor/backstretch-2.0.3.min.js'></script>
<script type='text/javascript' src='../wp-content/plugins/x-shortcodes/js/vendor/modernizr-2.7.1.min.js'></script>
<script type='text/javascript' src='../wp-content/plugins/x-shortcodes/js/vendor/fittext-1.1.0.min.js'></script>
<script src="../wp-content/pace.min.js"></script>
<link href="../wp-content/dataurl.css" rel="stylesheet" />
<link rel='stylesheet' href='lib/tagmanager.css' type='text/css' media='all' />

	<!-- DEV MODE - including each .css file -->
	
				<style>
					.simplex{
						padding:4px;
						float:left;
						text-align: center;
						height: 30px;
						width:40%;
						border-right: 1px solid #ddd;
						border-top: 1px solid #ddd;
						background: #f1f1f1;
					}
					.simplex:hover{
						-webkit-box-shadow: inset 2px 2px 2px 1px rgba(220,220,220,0.7);
						-moz-box-shadow: inset 2px 2px 2px 1px rgba(220,220,220,0.7);
						box-shadow: inset 2px 2px 2px 1px rgba(220,220,220,0.7);
					}
					.simplex.twenty{
						width:20%;
						border-right: none;
					}
					.simplex.twenty:hover{
						-webkit-box-shadow: inset 2px 2px 2px 1px rgba(229,169,66,1);
						-webkit-box-shadow: inset 2px 2px 2px 1px rgba(229,169,66,1);
						-webkit-box-shadow: inset 2px 2px 2px 1px rgba(229,169,66,1);
					}
					
					.card-tabs{
						border: 1px solid #ddd;
						border-radius: 3px;
						
					}
					.card-tabs ul li{
						float: left;
						width: 20%;
						background: #eee;
						text-align: center;
						transition: 0.4s background;
						-webkit-transition: 0.4s background, 0.4s color;
						-moz-transition: 0.4s background, 0.4s color;
						-ms-transition: 0.4s background, 0.4s color;
						-o-transition: 0.4s background, 0.4s color;
						-webkit-box-shadow: inset 2px 2px 3px 1px rgba(188,188,188,0.6);
						-moz-box-shadow: inset 2px 2px 3px 1px rgba(188,188,188,0.6);
						box-shadow: inset 2px 2px 3px 1px rgba(188,188,188,0.6);
					}
					.card-tabs ul li:hover, .card-tabs ul li.selected{
						background: #fff;
						-webkit-box-shadow: none;
						-moz-box-shadow: none;
						box-shadow: none;
						color: #1FB5AC;
						
					}
					.card-tabs ul li div{
						float: left;
						padding: 12px;
						text-align: center;
						width: 100%;
						
					}
					.page{
						background: white;
						border-radius: 0 0 3px 3px;
						transition: 1s opacity;
						-moz-transition: 1s opacity;
						-ms-transition: 1s opacity;
						-o-transition: 1s opacity;
						opacity:1;
					}
					h3{ padding:0; margin:0;color:#1FB5AC; margin-bottom: 8px; font-family: 'Open Sans', Helvetica, Arial; font-weight: lighter; font-weight: 100;}
					h5{ padding:0; margin:0;color:#666; margin-bottom: 8px; font-family: 'Open Sans', Helvetica, Arial; font-weight: lighter; font-weight: 100;}
					strong { color:#1FB5AC; font-family: 'Open Sans', Helvetica, Arial; font-weight: normal; font-weight: 300;}
					
					.tableprops{ float: left; font-size: 13px;}
					
					@media only screen and (min-width:1139px) {
						#img-container{ float:left; }
						  .tableprops {
							  max-width: 60%;
						  }
						  #synclis-img{ max-width: 150px; max-height:150px; float:left; margin: 0 8px 8px 0; border:1px solid #eee; border-radius: 3px; }
					}
					@media only screen and (max-width:1139px) {
						#img-container{ float:center; text-align: center; }
						.tableprops {
							width: 100%;
							max-width: 100%;
						}
						#synclis-img{  max-width: 150px; max-height:150px; border:1px solid #eee; border-radius: 75px; }
					}
					.hideinmobile{ font-style: normal; }
					@media only screen and (min-width:601px) {
						.page{padding:30px;}
					}
					@media only screen and (max-width:600px) {
						.hideinmobile{ display:none; }
						.page{padding:2px;}
					}
					
					.tt-dropdown-menu{
						padding: 10px 0 10px 0;
						text-align: center;
						background: #fff;
						border: 1px solid #777;
						border-bottom-left-radius: 3px;
						border-bottom-right-radius: 3px;
						width: 100%;
						max-height: 150px;
						overflow-y: auto;
					}
					
					.tt-dropdown-menu span p{
						background: #fff;
						transition: background 0.4s;
						-webkit-transition: background 0.4s;
						-moz-transition: background 0.4s;
						
					}
					
					.tt-dropdown-menu span p:hover{
						background: #eee;
					}
					[contenteditable="true"]:active,
					[contenteditable="true"]:focus{
						border:1px dashed #1FB5AC;
						outline:none;
					}
					      #map-canvas {
							height: 450px;
							margin: 0px;
							padding: 0px
						  }
				</style>
				
				
		<?php if(($userinfo[10] =='' || $userinfo[10] == 1 || $userinfo[10] == true) && ($_GET['c'] != $GLOBALS['USER_DATA'][1])){ ?>
			<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=drawing"></script>
			<script>
			var marker, map, geocoder;
			var minZoomLevel = 5;
			function initialize() {
			  var mapOptions = {
				zoom: 15,
				center: new google.maps.LatLng(37.090240,-95.712891),
				minZoom: 12
			  }
			  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
			  geocoder = new google.maps.Geocoder();
			  
			  codeAddress("<?php echo $userinfo[12] . ", " . $userinfo[13] . ", " . $userinfo[14]; ?>");
			}
			google.maps.event.addDomListener(window, 'load', initialize);
			
			function codeAddress(address) {
				geocoder.geocode( { 'address': address}, function(results, status) {
					if (status == google.maps.GeocoderStatus.OK)
					{//Geocoder status OK
					  map.setCenter(results[0].geometry.location);
						marker = new google.maps.Marker({
							position: results[0].geometry.location,
							map: map,
							title: 'Approximate Location of user.'
						});
					} else {
					  alert('Geocode was not successful for the following reason: ' + status);
					}
				});
			}
			
			</script>
		<?php }?>
				
  </head>
<body class="home page-id-3034 page-template page-template-template-blank-4-php x-renew x-navbar-fixed-top-active x-boxed-layout-active x-sidebar-content-active"
onLoad = "synclisSetLocation(<?php if($userinfo[9] =='') echo "0"; else echo $userinfo[9]; ?>);">


<div id="top" class="site">

<header class="masthead" role="banner">
	<?php printNav(); ?>
</header>

	<div class="x-main" role="main">
			<div class="entry-content">

				<div id="x-content-band-12" class="x-content-band bg-pattern man" style="background-image: url(../icons/cream_pixels.png); background-color: transparent;">
					<div id="synclis-content" class="x-container-fluid max width">

						<div class="card-tabs">
							<ul style = "width: 100%; margin:0; padding:0; display:none;"><!--Hidden Until official Release-->
								<a href="Javascript:;" onClick="showPage('profile');"><li class="selected" id="profiletab"><div><i class="x-icon-user"></i><br/><i class="hideinmobile">Profile</i></div></li></a>
								<a href="Javascript:;" onClick="showPage('portfolio');"><li id="portfoliotab"><div><i class="x-icon-folder-open"></i><br/><i class="hideinmobile">Portfolio</i></div></li></a>
								<a href="Javascript:;" onClick="showPage('services');"><li id="servicestab"><div><i class="x-icon-inbox"></i><br/><i class="hideinmobile">Services</i></div></li></a>
								<a href="Javascript:;" onClick="showPage('education');"><li id="educationtab"><div><i class="x-icon-book"></i><br/><i class="hideinmobile">Education</i></div></li></a>
								<a href="Javascript:;" onClick="showPage('experience');"><li id="experiencetab"><div><i class="x-icon-suitcase"></i><br/><i class="hideinmobile">Experience</i></div></li></a>
							</ul>
							<div style = "clear:both;"></div>
							<div style="background: white;">
								<div id="profile" class="page">
									<div class="x-column one-half synclis-stp">
										
										<!--Profile Image-->

											<div id="img-container" style ="width: 150px; height: 150px; position: relative; border-radius: 3px;">
												<img id="synclis-img" src="<?php if($userinfo[2] == '') echo 'noprofilem.png'; else echo $userinfo[2]; ?>" style ="width: 150px; height: 150px; position:absolute; top:0; left:0;" onError="this.onerror=null;this.src='noprofilem.png';" />
												<?php if($_GET['c'] == $GLOBALS['USER_DATA'][1]){ ?>
													<form id="synclisDropzone"style = "width: 150px; height: 150px; position:absolute; top:0; left:0;" method="PUT" class="dropzone">
														<div class="fallback">
															<input name="file"  type="file" multiple />
														</div>
													</form>
												<?php } ?>
											</div>
										<!--End Profile Image-->
										
										<table class="tableprops">
											<tr><td><center><h3><?php echo $userinfo[0] . ' ' . $userinfo[1]; ?></h3></center></td></tr>
											<tr><td><strong><i class="x-icon-suitcase"></i> Profession: </strong><span id="synclis-trade"  <?php if($_GET['c'] == $GLOBALS['USER_DATA'][1]){echo 'contentEditable="true" class="synclis-propKey"';}?>><?php echo $userinfo[8]; ?></span></td></tr>
											<tr><td><strong><i class="x-icon-star"></i> Reputation: </strong><?php echo $userinfo[4]; ?></td></tr>
											<tr><td><strong><i class="x-icon-calendar"></i> Member Since: </strong><?php echo date("F j, Y", $userinfo[3]); ?></td></tr>
											<tr><td>&emsp;<div id="synclis-bio" <?php if($_GET['c'] == $GLOBALS['USER_DATA'][1]){echo 'contentEditable="true" class="synclis-propKey"';}?>><?php echo $userinfo[7]; ?></div></td></tr>
										</table>
										<div style = "clear:both;"></div>
										
											<?php if($_GET['c'] != $GLOBALS['USER_DATA'][1]){ echo "<h5>What I'm skilled in: </h5>"; } ?>
											<input type="text" name="tags" placeholder="Add Skills" class="tm-input <?php if($_GET['c'] != $GLOBALS['USER_DATA'][1]){ echo 'hidden'; } ?>" />
											<div id="tm-container"></div>
											<?php if($_GET['c'] != $GLOBALS['USER_DATA'][1]){ echo "<h5>What I'm interested in: </h5>"; } ?>
											<input type="text" name="tags" placeholder="Add Intrests" class="tm-input2 typeahead <?php if($_GET['c'] != $GLOBALS['USER_DATA'][1]){ echo 'hidden'; } ?>" />
											<div id="tm-container2"></div>
											
											
									<?php if($_GET['c'] == $GLOBALS['USER_DATA'][1]){?>
										<br/><br/><center><a href="Javascript:;" onClick="synclis_updateSettings();"><button>Save your Settings &amp; Preferences.</button></a></center>
									<?php }?>
									</div>
									
									<?php if($_GET['c'] == $GLOBALS['USER_DATA'][1]){?>
									<div class="x-column one-half last synclis-stp">
										<center><h3>Preferences</h3></center>
										
										
										<strong><i class="x-icon-map-marker"></i> Location Settings: </strong>
										<br/>&emsp;<?php echo '<span style="padding: 5px;"> '. $GLOBALS['COUNTRY'] .', '. $GLOBALS['REGION'] .' ('. $GLOBALS['CITY'] .')</span>';?>
										
										<br/>&emsp;&emsp;&emsp;<a href= "Javascript:;" style="color: #333;" onClick="synclisSetLocation(0)"><i id="locationset0" class="x-icon-circle-o"></i> Use GPS to find my location.</a>
										<br/>&emsp;&emsp;&emsp;<a href= "Javascript:;" style="color: #333;" onClick="synclisSetLocation(1)"><i id="locationset1" style="color: #1FB5AC" class="x-icon-dot-circle-o"></i> Keep this location forever.</a>
										<br/>&emsp;&emsp;&emsp;<a href= "Javascript:;" style="color: #333;" onClick="synclisSetLocation(2)"><i id="locationset2" class="x-icon-circle-o"></i> I will set my own location.</a>
										<br/><br/>
										
										<strong><i class="x-icon-lock"></i> Security Settings: </strong>
										<br/>&emsp;&emsp;&emsp;<a href= "Javascript:;" style="color: #333;" onClick="synclisShowLocation()"><?php if($userinfo[10] ==1) echo '<i id="showLocation" style="color: #1FB5AC" class="x-icon-check-square-o"></i>'; else echo '<i id="showLocation" style="color: #333" class="x-icon-square-o"></i>'; ?> Show my location to others.</a>
										<br/>&emsp;&emsp;&emsp;<a href= "Javascript:;" style="color: #333;" onClick="synclisMultiLogin()"><?php if($userinfo[11] ==0) echo '<i id="multiLogin" style="color: #1FB5AC" class="x-icon-check-square-o"></i>'; else echo '<i id="multiLogin" style="color: #333" class="x-icon-square-o"></i>'; ?> Only allow me to only log into one place at a time.</a>
										<br/><br/>

										<strong><i class="x-icon-clock-o"></i> Timezone settings: </strong>
										<select name="DropDownTimezone" id="DropDownTimezone" style="width:100%;">
										  <option value="-12.0">(GMT -12:00) Eniwetok, Kwajalein</option>
										  <option value="-11.0">(GMT -11:00) Midway Island, Samoa</option>
										  <option value="-10.0">(GMT -10:00) Hawaii</option>
										  <option value="-9.0">(GMT -9:00) Alaska</option>
										  <option value="-8.0">(GMT -8:00) Pacific Time (US &amp; Canada)</option>
										  <option value="-7.0">(GMT -7:00) Mountain Time (US &amp; Canada)</option>
										  <option value="-6.0">(GMT -6:00) Central Time (US &amp; Canada), Mexico City</option>
										  <option value="-5.0">(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima</option>
										  <option value="-4.0">(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz</option>
										  <option value="-3.5">(GMT -3:30) Newfoundland</option>
										  <option value="-3.0">(GMT -3:00) Brazil, Buenos Aires, Georgetown</option>
										  <option value="-2.0">(GMT -2:00) Mid-Atlantic</option>
										  <option value="-1.0">(GMT -1:00 hour) Azores, Cape Verde Islands</option>
										  <option value="0.0">(GMT) Western Europe Time, London, Lisbon, Casablanca</option>
										  <option value="1.0">(GMT +1:00 hour) Brussels, Copenhagen, Madrid, Paris</option>
										  <option value="2.0">(GMT +2:00) Kaliningrad, South Africa</option>
										  <option value="3.0">(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg</option>
										  <option value="3.5">(GMT +3:30) Tehran</option>
										  <option value="4.0">(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi</option>
										  <option value="4.5">(GMT +4:30) Kabul</option>
										  <option value="5.0">(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option>
										  <option value="5.5">(GMT +5:30) Bombay, Calcutta, Madras, New Delhi</option>
										  <option value="5.75">(GMT +5:45) Kathmandu</option>
										  <option value="6.0">(GMT +6:00) Almaty, Dhaka, Colombo</option>
										  <option value="7.0">(GMT +7:00) Bangkok, Hanoi, Jakarta</option>
										  <option value="8.0">(GMT +8:00) Beijing, Perth, Singapore, Hong Kong</option>
										  <option value="9.0">(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk</option>
										  <option value="9.5">(GMT +9:30) Adelaide, Darwin</option>
										  <option value="10.0">(GMT +10:00) Eastern Australia, Guam, Vladivostok</option>
										  <option value="11.0">(GMT +11:00) Magadan, Solomon Islands, New Caledonia</option>
										  <option value="12.0">(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka</option>
									</select>
										<br/><br/><strong><i class="x-icon-keyboard-o"></i> Language: </strong>
										    <select id="DropDownLanguage" style="width:100%;">
												<?php
												

		$lang= mysqli_query($conn,"SELECT `NAME`,`LANGUAGE` FROM `U8i_LANGUAGES` LIMIT 50");
		if(!$lang) echo '';
		else{
			while($s = mysqli_fetch_row($lang)){
				?><option value="<?php echo $s[1];?>"><?php echo $s[0]; ?></option><?php
			}
		}
												
												?>
											</select>
											
											
											
										<br/><br/><strong><i class="x-icon-link"></i> Set your URL ID: </strong>
										<br/><i style = "font-size: 10px; font-style: normal;"> * Your URL ID, changes the value in your URL. www.synclis.com/Profile/URL ID</i>
										<br/><input id="synclis-clean-name"type="text" style="padding: 5px;" value="<?php echo $_GET['c']; ?>"></input>
										
										
										<script>
											function displayResult() {
												var x = document.getElementById("DropDownTimezone");
												var tzSelect = '<?php echo $GLOBALS['USER_DATA'][2]; ?>';
												for (var i = 0; i < x.length; i++) {
													if(x.options[i].value  ==  tzSelect){
														x.options[i].selected = true;
													}
												}
											}
											
											function displayLanguage() {
												var x = document.getElementById("DropDownLanguage");
												var lgSelect = '<?php if($GLOBALS['USER_DATA'][3] == '') echo 'en'; else echo $GLOBALS['USER_DATA'][3]; ?>';
												for (var i = 0; i < x.length; i++) {
													if(x.options[i].value  ==  lgSelect){
														x.options[i].selected = true;
													}
												}
											}
											displayLanguage();
											displayResult();
										</script>
										
									</div>
									<?php } /*End check if the user is you.*/
									else{/*else show the map of where the user or business is located*/
											if($userinfo[10] =='' || $userinfo[10] == 1 || $userinfo[10] == true){
									?>
											
											<div id="displayMap" class="x-column one-half last synclis-stp" style = "padding:0; margin:0; position: relative;">
											<div style="position: absolute; top:8px; left:4px; width: 100%; z-index: 500;">
											<h3 class="h-custom-headline mtn center-text h5 accent"><span>Location</span></h3>
											</div>
											<div id="map-canvas"></div>
											</div>
									<?php } else { ?>
											<div class="x-column one-half last synclis-stp">
												<center><h3>Location</h3></center>

												<strong><i class="x-icon-map-marker"></i> This user has chosen to hide their exact location </strong>
											</div>
											
									<?php 		}
										} ?>
									<div style="clear:both;"></div>
								</div>
								<div id="portfolio" class="page" style="opacity:0; display:none">
									Masonry of items
								</div>
								<div id="services" class="page" style="opacity:0; display:none;">
									Video / description / masonry
								</div>
								<div id="education" class="page" style="opacity:0; display:none;">
									list display:none;
								</div>
								<div id="experience" class="page" style="opacity:0; display:none;">
									list
								</div>
							</div>
						</div>
						
					</div>
				</div>
				
				<script>
				
					/*Tab Shift Animations*/
					var lastPage = 'profile', dclick = false;
					function showPage(page){
						if(page != lastPage && !dclick){
							dclick = true;
							document.getElementById(page).style.transition = '500ms opacity';
							document.getElementById(page).style.WebkitTransition = '500ms opacity';
							document.getElementById(page).style.MozTransition = '500ms opacity';
							document.getElementById(page).style.MsTransition = '500ms opacity';
							document.getElementById(lastPage).style.transition = '500ms opacity';
							document.getElementById(lastPage).style.WebkitTransition = '500ms opacity';
							document.getElementById(lastPage).style.MozTransition = '500ms opacity';
							document.getElementById(lastPage).style.MsTransition = '500ms opacity';
							document.getElementById(page).style.display="";
							document.getElementById(page + "tab").className="selected";
							document.getElementById(lastPage).style.display="none";
							document.getElementById(lastPage + "tab").className="";
							document.getElementById(lastPage).style.opacity= '0';
							
							setTimeout(function(){ 
								document.getElementById(page).style.opacity= '1';
								lastPage = page;
								dclick = false;
							},500);
						}
					}
					/*END Tab Shift Animations*/
				</script>

                              
      </div> <!-- end .entry-content -->
  </div> <!-- end .x-main -->

    
    <footer class="x-colophon bottom" role="contentinfo">
		<?php printFooter(); ?>
    </footer> <!-- end .x-colophon.bottom -->

    
  </div>

  <!--
  END #top.site
  -->

<!--[if lt IE 9]><script type="text/javascript" src="../wp-content/themes/x/framework/js/vendor/selectivizr-1.0.2.min.js"></script><![endif]-->
	<script type='text/javascript' src='lib/typeahead.js'></script>
	<script type='text/javascript' src='lib/tagmanager.js'></script>
	<script src="../wp-content/plugins/dragndrop/dropzone.js"></script>
	<script>
	var locationSet = <?php if($userinfo[9] =='') echo "0"; else echo $userinfo[9]; ?>;
	
	var showLoc =  <?php if($userinfo[10] =='') echo "0"; else echo $userinfo[10]; ?>;
	var multilog = <?php if($userinfo[11] =='') echo "0"; else echo $userinfo[11]; ?>;

	function synclis_updateSettings(){
		var checkImg = "";
		if(document.getElementById('synclis-img').src && document.getElementById('synclis-img').src != '')
			if(document.getElementById('synclis-img').src.substring(0,4) != 'http')
				checkImg = '"image":"'+ document.getElementById('synclis-img').src +'",';
		
		var http = new XMLHttpRequest();
		http.open("PUT", "https://synclis.com/api/sys/users/<?php echo $_GET['c']; ?>", true);
		var params = '{"trade":"'+ document.getElementById('synclis-trade').innerHTML + '",' +
				  '"biography":"'+ document.getElementById('synclis-bio').innerHTML   + '",' +
			         '"skills":"'+ document.getElementById('synclis-skills').value   + '",' +
			    '"preferences":"'+ document.getElementById('synclis-preferences').value   + '",' +
			     '"clean_name":"'+ document.getElementById('synclis-clean-name').value + '",' +
				   '"timezone":"'+ document.getElementById('DropDownTimezone').value + '",' +
		   '"location_setting":"'+ locationSet + '",' +
			  '"show_location":"'+ showLoc + '",' +
		        '"multi_login":"'+ multilog + '",' + checkImg +
				   '"language":"'+ document.getElementById('DropDownLanguage').value + '",' +
				    '"session":"'+ readCookie('SYNCLIS_TOKEN') +'"}';

		//Send the proper header information along with the request
		http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		http.setRequestHeader("Content-Type", "Content-Type: application/json");
		http.onreadystatechange = function() {//Call a function when the state changes.
			if(http.readyState == 4 && http.status == 200)
			{
				try{
					var json = JSON.parse(http.responseText);
					if(json.response == 'error')
						alert("ERROR: " + json.message);
					else if(json.response == 'success'){
						if(document.getElementById('synclis-clean-name').value != '<?php echo $_GET['c']; ?>'){
							window.location = "https://synclis.com/Profile/" +document.getElementById('synclis-clean-name').value;
						}
						else{
							pushNote("Your changes have been made.","success");
						}
					}
					else
						alert(http.responseText);
				}catch(e){
					alert("Uhh Oh. Something went wrong." + http.responseText);
				}
			}
		}
		http.send(params);
	}
	
	
	function synclisShowLocation(){
		if(showLoc == 1){
			showLoc = 0;
			document.getElementById('showLocation').style.color = "#333";
			document.getElementById('showLocation').className = "x-icon-square-o";
		}else{
			showLoc = 1;
			document.getElementById('showLocation').style.color = "#1FB5AC";
			document.getElementById('showLocation').className = "x-icon-check-square-o";
		}
	}
	function synclisMultiLogin(){
		if(multilog == 1){
			multilog = 0;
			document.getElementById('multiLogin').style.color = "#333";
			document.getElementById('multiLogin').className = "x-icon-square-o";
		}else{
			multilog = 1;
			document.getElementById('multiLogin').style.color = "#1FB5AC";
			document.getElementById('multiLogin').className = "x-icon-check-square-o";
		}
	}
	
	function synclisSetLocation(l){
		locationSet = l;
		if(l == 0){
			if( document.getElementById('locationset1')){
				document.getElementById('locationset1').className = 'x-icon-circle-o';
				document.getElementById('locationset1').style.color = '#333';
			}
			if( document.getElementById('locationset2')){
				document.getElementById('locationset2').className = 'x-icon-circle-o';
				document.getElementById('locationset2').style.color = '#333';
			}
		}
				   
		if(l == 1){
			if( document.getElementById('locationset0')){
				document.getElementById('locationset0').className = 'x-icon-circle-o'; 
				document.getElementById('locationset0').style.color = '#333';
			}
			if( document.getElementById('locationset2')){
				document.getElementById('locationset2').style.color = '#333';
				document.getElementById('locationset2').className = 'x-icon-circle-o';
			}
		}
		if(l == 2){
			if( document.getElementById('locationset1')){
				document.getElementById('locationset1').className = 'x-icon-circle-o';
				document.getElementById('locationset1').style.color = '#333';
			}
			if( document.getElementById('locationset0')){
				document.getElementById('locationset0').className = 'x-icon-circle-o';
				document.getElementById('locationset0').style.color = '#333';
			}
		}
		
		if( document.getElementById('locationset' + l)){
			document.getElementById('locationset' + l).className = 'x-icon-dot-circle-o';
			document.getElementById('locationset' + l).style.color = '#1FB5AC';
		}
		
	}
	
	
		var preferences = "<?php echo  $userinfo[5]; ?>";
		var skills      = "<?php echo  $userinfo[6]; ?>";
	
		jQuery(".tm-input").tagsManager({
			tagClass: 'tm-tag tm-tag-info',
			tagCloseIcon: '&nbsp;&#215;&nbsp;',
			blinkBGColor_1: '#eef',
			blinkBGColor_2: '#C5EEFA',
			maxTags: 10,
			CapitalizeFirstLetter: true,
			deleteTagsOnBackspace: false,
			<?php if($_GET['c'] != $GLOBALS['USER_DATA'][1]){ echo "tagCloseIcon: '',"; } ?>
			hiddenTagListId: 'synclis-skills',
			tagsContainer: '#tm-container'
		});
		
		var skill = skills.split(",");
		for(var s=0; s<skill.length; s++){
			jQuery('.tm-input').tagsManager('pushTag',skill[s]);
		}

		
		jQuery(".tm-input2").tagsManager({
			tagClass: 'tm-tag tm-tag-success',
			tagCloseIcon: '&nbsp;&#215;&nbsp;',
			blinkBGColor_1: '#eef',
			blinkBGColor_2: '#C5EEFA',
			CapitalizeFirstLetter: true,
			deleteTagsOnBackspace: false,
			<?php if($_GET['c'] != $GLOBALS['USER_DATA'][1]){ echo "tagCloseIcon: '',"; } ?>
			hiddenTagListId: 'synclis-preferences',
			maxTags: 10,
			tagsContainer: '#tm-container2'
			
		});	
		
		

		var  preference = preferences.split(",");
		for(var s=0; s< preference.length; s++){
			jQuery('.tm-input2').tagsManager('pushTag', preference[s]);
		}
		
		
		
		var substringMatcher = function(strs) {
		  return function findMatches(q, cb) {
			var matches, substringRegex;
			matches = [];
			substrRegex = new RegExp(q, 'i');
			$.each(strs, function(i, str) {
			  if (substrRegex.test(str)) {
				matches.push({ value: str });
			  }
			});
		 
			cb(matches);
		  };
		};
		
		
		
		var interests = <?php $v= mysqli_query($conn,"SELECT `NAME` FROM `CATEGORY` GROUP BY `NAME`"); if(!$v) die('Opps something went wrong.'); $count = 0; while($i = mysqli_fetch_row($v)){ $intrests[$count] = $i[0];  $count++;} echo json_encode($intrests); ?>;
		 
		$('.typeahead').typeahead({
		  hint: true,
		  highlight: true,
		  minLength: 1
		},
		{
		  name: 'skills',
		  displayKey: 'value',
		  source: substringMatcher(interests)
		});
		
		//Content Editable Fixes
		$(document).on('keypress', '.synclis-propKey', function(e){
			return e.which != 13; 
		});  
		
		
		
		<!--Drag N Drop-->
		Dropzone.options.synclisDropzone = {
		  maxFilesize: 2, 
		  maxFiles: 1,
		  clickable: true,
		  uploadMultiple: false,
		  thumbnailWidth: "300",
		  thumbnailHeight: "300",
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
			document.getElementById('synclis-img').src = dataUrl;
			return _results;
		  }
		};
		
		<!--Drag N Drop-->
	</script>
  <?php  alertSystem(); ?>
    
  
</body>
</html>
