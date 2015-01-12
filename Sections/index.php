<?php include('../meta.php');?>
<!DOCTYPE html>
<!--[if IE 8]><html class="no-js ie8" lang="en-US"><![endif]-->
<!--[if IE 9]><html class="no-js ie9" lang="en-US"><![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" lang="en-US"><!--<![endif]-->
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
<!--SEO TAGS-->
<title>Sections | Synclis</title>
<meta name='description' content='Synclis is a powerful peer to peer listing resource made with you in mind. It also utilizes Social Media to get the most out of your listings. It is free to get started, why not post your listings today?'>
<meta name="ROBOTS" content="INDEX, NOFOLLOW" />
<link rel="publisher" href="https://plus.google.com/u/0/b/111736498704458786396/"/>
<meta property="og:title" content="View All Sections | Synclis"/>
<meta property="og:type" content="article" />
<meta property="og:image" content="https://synclis.com/media/symbolwhitebg.png"/>
<meta property="og:url" content="https://synclis.com/Sections"/>
<meta property="og:description" content="Synclis is a powerful peer to peer listing resource made with you in mind. It also utilizes Social Media to get the most out of your listings. It is free to get started, why not post your listings today?" />
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="View All Sections | Synclis"/>
<meta name="twitter:url" content="https://synclis.com/Sections"/>
<meta name="twitter:description" content="Synclis is a powerful peer to peer listing resource made with you in mind. It also utilizes Social Media to get the most out of your listings. It is free to get started, why not post your listings today?">
<meta name="twitter:image" content="https://synclis.com/media/symbolwhitebg.png">
<!--SEO TAGS-->
  
  <link rel="shortcut icon" href="../favicon.ico" />
  
<link rel='stylesheet' href='../wp-content/plugins/x-custom/x-custom.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../wp-content/plugins/x-shortcodes/css/renew.css' type='text/css' media='all' />
<link rel='stylesheet' href='../wp-content/themes/x/framework/css/site/stacks/renew.css' type='text/css' media='all' />
<link rel='stylesheet' href='../wp-content/primary.css' type='text/css' media='all' />

<script src="src/jquery.min.js"></script>
<script type='text/javascript' src='../wp-includes/js/jquery/jquery-migrate.min.js?ver=1.2.1'></script>
<script type='text/javascript' src='../wp-content/themes/x/framework/js/x.min.js'></script>
<script type='text/javascript' src='../wp-content/plugins/x-shortcodes/js/vendor/modernizr-2.7.1.min.js'></script>
<script type='text/javascript' src='../wp-content/plugins/x-shortcodes/js/vendor/fittext-1.1.0.min.js'></script>
	<script src="../wp-content/pace.min.js"></script>
	<link href="../wp-content/dataurl.css" rel="stylesheet" />
<style>
    
	.categories-prev{
		list-style: none;
		margin:0;
		padding:0;
	}
	.categories-prev li{
		transition: background 0.4s;
		-webkit-transition: background 0.4s;
		-moz-transition: background 0.4s;
	}
	.categories-prev li:hover{
		background: #ddd;
	}
    
	
	.content-prov{
		overflow:hidden;
		max-height:0px;
		overflow-y:scroll;
		-webkit-overflow-scrolling: touch;
		transition: height 1s;
		-webkit-transition: height 1s;
		-webkit-transform: translate3d(0, 0, 0);
	}


  #canvas-container {
    overflow-x: auto;
    overflow-y: visible;
    position: relative;
    margin-top: 20px;
    margin-bottom: 20px;
	font-family: OpenSans;
  }
  .canvas {
    display: block;
    position: relative;
    overflow: hidden;
  }

  .canvas.hide {
    display: none;
  }

  #html-canvas > span {
    transition: text-shadow 1s ease, opacity 1s ease;
    -webkit-transition: text-shadow 1s ease, opacity 1s ease;
    -ms-transition: text-shadow 1s ease, opacity 1s ease;
  }

  #html-canvas > span:hover {
    text-shadow: 0 0 10px, 0 0 10px #fff, 0 0 10px #fff, 0 0 10px #fff;
    opacity: 0.5;
  }

  #loading {
    animation: blink 2s infinite;
    -webkit-animation: blink 2s infinite;
  }
  @-webkit-keyframes blink {
    0% { opacity: 1; }
    100% { opacity: 0; }
  }
  @keyframes blink {
    0% { opacity: 1; }
    100% { opacity: 0; }
  }

	.synclis-mobile-container{
		border: 1px solid #f1f1f1; border-radius: 5px; padding:12px; background:white; margin-bottom: 7px;
		-moz-box-shadow:    -1px -1px 3px 1px #f1f1f1;
		-webkit-box-shadow: -1px -1px 3px 1px #f1f1f1;
		box-shadow:         -1px -1px 3px 1px #f1f1f1;
		-moz-box-shadow:    -1px -1px 3px 1px rgba(220,220,220,0.2);
		-webkit-box-shadow: -1px -1px 3px 1px rgba(220,220,220,0.2);
		box-shadow:         -1px -1px 3px 1px rgba(220,220,220,0.2);
		background-image: url(../plugin/assets/bwsymbol.png);
		background-repeat: no-repeat;
		background-position: right bottom;
	}
	.synclis-category-icons{
		width:24px;
	}
	@media (max-width: 980px) {
		.synclis-mobile-collapsible{
			overflow:hidden; max-height:0px;transition: height 1s; -webkit-transition: height 1s;
		}
		.categories-prev li{
			padding: 6px;
		}
		.synclis-category-icons{
			width:36px;
		}
		.synclis-mobile-inner-container{
			overflow-y:scroll; max-height: 190px;
		}
	}
  </style>
  <script>
	var lastid = -1;
	function show(id){
		if(window.innerWidth <= 980){
			if(lastid != -1 && lastid != id){
				document.getElementById('show' + lastid).style.transition='max-height 1s';
				document.getElementById('show' + lastid).style.WebkitTransition='max-height 1s';
				document.getElementById('show' + lastid).style.maxHeight='0px';
			}
			document.getElementById('show' + id).style.transition='max-height 1s';
			document.getElementById('show' + id).style.WebkitTransition='max-height 1s';
			document.getElementById('show' + id).style.maxHeight='290px';
			lastid=id;
		}
	}
  </script>

  </head>
<body class="home page page-id-3034 page-template page-template-template-blank-4-php x-renew x-navbar-fixed-top-active x-boxed-layout-active x-sidebar-content-active">

  <!--
  BEGIN #top.site
  -->

<div id="top" class="site">

<header class="masthead" role="banner">
	<?php printNav(); ?>
</header>

    
    

	<div class="x-main" role="main">
		<article id="post-3034" class="post-3034 page type-page status-publish hentry no-post-thumbnail">
			<div class="entry-content">
				
				<div class="x-content-band bg-pattern man" style="background-image: url(../icons/cream_pixels.png); background-color: transparent;">
					<div id="synclis-content" class="x-container-fluid max width">
							
							<!--ONE SECTION, MULTIPLE CATEGORIES-->
							<?php 	
								if($GLOBALS['USER_DATA'][3] == '' || $GLOBALS['USER_DATA'][3] == 'en' || !$GLOBALS['USER_DATA'][3]){
									$utf8i = "";
									$utf8u = ", `SECTION`.`SECTION`,`SECTION`.`DESCRIPTION`";
									$utf8s = ",`CATEGORY`.`NAME`";
									$langsec= "";
									$langs = "";
								}else{
									$utf8i = "LEFT JOIN `SECTION_U8i` ON `SECTION`.`ID` = `SECTION_U8i`.`SECTION` WHERE `SECTION_U8i`.`LANGUAGE_CODE`='{$GLOBALS['USER_DATA'][3]}'";
									$utf8u = ", `SECTION_U8i`.`TRANSLATION`,`SECTION_U8i`.`DESCRIPTION`";
									$utf8s = ",`CATEGORY_U8i`.`TRANSLATION`";
									$langsec= "AND `CATEGORY_U8i`.`LANGUAGE_CODE`='{$GLOBALS['USER_DATA'][3]}'";
									$langs = "LEFT JOIN `CATEGORY_U8i` ON `CATEGORY_U8i`.`CATEGORY`=`CATEGORY`.`ID`";
								}
								
								$a = mysqli_query($conn,"SELECT `SECTION`.`ID`,`SECTION`.`SECTION`,`SECTION`.`DESCRIPTION`,`SECTION`.`ICON`{$utf8u} FROM `SECTION` {$utf8i} ORDER BY `SECTION`.`ID`");
								$count=0;
								while($row = mysqli_fetch_row($a)){
									$pc = $count % 3;
									$b = mysqli_query($conn,"SELECT `CATEGORY`.`ID`,`CATEGORY`.`NAME`,`CATEGORY`.`ICON`{$utf8s} FROM `CATEGORY` {$langs} WHERE `CATEGORY`.`SECTION`='{$row[0]}' {$langsec} ORDER BY `CATEGORY`.`NAME`");
									while($row2 = mysqli_fetch_row($b)){
										$cats .= '<a href="../Listings/'. str_replace(' ', '', $row[1]) .'/'. str_replace(' ', '', $row2[1]) .'"><li><img src="../' . $row2[2] . '" class="synclis-category-icons" />&emsp; '. $row2[3] .'</li></a>';
									}
									
									$print[$pc] .= 
									'<div class="synclis-mobile-container">
										<a href="Javascript:;" onClick="show('. $count .');">
											<h4  class="h-feature-headline h6" style="padding-left: 48px; text-align:left;"><p><img src="../' . $row[3] . '" />&emsp; ' . $row[4] . '</p></h4>
											<p style = "font-size: 85%;">' . $row[5] . '</p>
										</a>
										<div id="show'. $count .'" class="synclis-mobile-collapsible">
											<hr/>
											<input id="search'. $count .'" type="text" style="width:100%;" placeholder="Search '.  $row[4] .'"></input>
											<div class="synclis-mobile-inner-container">
												<ul class="categories-prev">'. $cats .'</ul>
											</div>
										</div>
									</div>';
									$count++;$cats = '';
								}
								echo'<div  class="x-column one-third">'. $print[0] .'</div>';
								echo'<div  class="x-column one-third">'. $print[1] .'</div>';
								echo'<div  class="x-column one-third last">'. $print[2] .'</div>';
							?>
							
						<hr class="x-clear">
					</div>
				</div>

				
				
				<div  class="x-visibility x-hidden-phone" >
					<div id="x-content-band-18" class="x-content-band pbn center-text man" style="background-color: #fff;">
					

						<div id="not-supported" class="alert" hidden>
							<strong>Your browser is not supported.</strong>
							</div>

						<div class="span12" id="canvas-container">
							<canvas id="canvas" class="canvas"></canvas>
							<div id="html-canvas" class="canvas hide"></div>
							<div style="position: absolute; top:12px; left:12px; background: #777; background: rgba(55,55,55,0.6); padding:8px; color: white;">See whats trending</div>
						</div>
						


						<div style="display:none;">
							<textarea id="input-list"></textarea>
							<textarea id="config-option" ></textarea>
							<input type="number" id="config-dppx" value="1" >
						</div>
					
						  <?php
							$r = mysqli_query($conn,"SELECT COUNT(SEARCH_TERM), SEARCH_TERM FROM `SEARCH_CLOUD` GROUP BY SEARCH_TERM");
							if(!$r) { mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, 'System', '[{$_SERVER['PHP_SELF']}] [GET] Failed to process Wordcloud from server.', '". str_replace("'","`",mysql_error()) ."'," . time() . ");"); }
							
							while($t = mysqli_fetch_row($r))
								$cloud .= $t[0] . ' ' . $t[1] . '\n';
						  
							if(!preg_match('/MSIE/i',$_SERVER['HTTP_USER_AGENT'])){
								echo '<script src="src/wordcloud2.js"></script>';
							}
							else{
								echo 'Cloud Canvas is not supported in Internet Explorer.';
							}
							
							
							if (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0; rv:11.0') !== false) {
								echo 'Cloud Canvas is not supported in Internet Explorer.';
							}
							else if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)){
								echo 'Cloud Canvas is not supported in Internet Explorer.';
							}
							else{
								echo '<script src="src/wordcloud2.js"></script>';
							}
							
						  ?>
						  <script>
							window.location = "#cloud-gen";
						  var examples = {
							'cloud-gen': {
							  list: '<?php  echo $cloud; ?>',
							  option: '{\n' +
									  '  gridSize: 8,\n' +
									  '  weightFactor: 16,\n' +
									  '  fontFamily: \'Open Sans\',\n' +
									  '  color: \'random-dark\',\n' +
									  '  backgroundColor: \'#fff\',\n' +
									  '  rotateRatio: 0\n' +
									  '}'
							}
						  };
							$("#search0").keyup(function (e) {if (e.keyCode == 13) {  window.location='https://synclis.com/Search/?q=' + document.getElementById('search0').value +'&s=Housing'  }});
							$("#search1").keyup(function (e) {if (e.keyCode == 13) {  window.location='https://synclis.com/Search/?q=' + document.getElementById('search1').value +'&s=Freelancing'  }});
							$("#search2").keyup(function (e) {if (e.keyCode == 13) {  window.location='https://synclis.com/Search/?q=' + document.getElementById('search2').value +'&s=Restaurants'  }});
							$("#search3").keyup(function (e) {if (e.keyCode == 13) {  window.location='https://synclis.com/Search/?q=' + document.getElementById('search3').value +'&s=Technology'  }});
							$("#search4").keyup(function (e) {if (e.keyCode == 13) {  window.location='https://synclis.com/Search/?q=' + document.getElementById('search4').value +'&s=Job%20Postings'  }});
							$("#search5").keyup(function (e) {if (e.keyCode == 13) {  window.location='https://synclis.com/Search/?q=' + document.getElementById('search5').value +'&s=Activities'  }});
							$("#search6").keyup(function (e) {if (e.keyCode == 13) {  window.location='https://synclis.com/Search/?q=' + document.getElementById('search6').value +'&s=Services'  }});
							$("#search7").keyup(function (e) {if (e.keyCode == 13) {  window.location='https://synclis.com/Search/?q=' + document.getElementById('search7').value +'&s=Open%20Market'  }});
							$("#search8").keyup(function (e) {if (e.keyCode == 13) {  window.location='https://synclis.com/Search/?q=' + document.getElementById('search8').value +'&s=Vehicles'  }});
						  </script>
					
						<div class="x-container-fluid max width">
							<div  class="x-column one-fourth" style="" >&nbsp;</div>
							<div  class="x-column mvl pvl one-half" style="" >
								<p class="resp-p">Help us build our community and suggest improvements.</p>
							
								<a class="x-btn x-btn-large" href="https://synclis.com/suggest" data-effect="mfp-zoom-in" title="Help suggest a category!"><i class="x-icon x-icon-share-square-o" ></i>Suggest an idea!</a>
								
							</div>
							<div  class="x-column one-fourth last" style="" >&nbsp;</div>
							<hr class="x-clear">
						</div>
					</div>
				</div>
				

				
<script>jQuery('.resp-h-1').fitText(1.0, { minFontSize: '48px', maxFontSize: '128px' });</script>
<script>jQuery('.resp-h-2').fitText(0.75, { minFontSize: '36px', maxFontSize: '78px' });</script>
<script>jQuery('.resp-p').fitText(2.75, { minFontSize: '16px', maxFontSize: '28px' });</script>

      </div> <!-- end .entry-content -->
  </div> <!-- end .x-main -->

    
    <footer class="x-colophon bottom" role="contentinfo">
		<?php printFooter(); ?>
    </footer> <!-- end .x-colophon.bottom -->
	
  </div>

  <?php 
	alertSystem();
	if($_GET['msg'] == 'NotFound'){
		echo '<script>pushNote("Your unable to find your listing.");</script>';
	}
  ?>

</body>
</html>

