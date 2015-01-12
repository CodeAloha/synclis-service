<?php include('../meta.php');?>
<!DOCTYPE html>
<!--[if IE 8]><html class="no-js ie8" lang="en-US"><![endif]-->
<!--[if IE 9]><html class="no-js ie9" lang="en-US"><![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" lang="en-US"><!--<![endif]-->
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
<!--SEO TAGS-->
<title>Search Results | Synclis</title>
<meta name='description' content='Synclis is a powerful peer to peer listing resource made with you in mind. It also utilizes Social Media to get the most out of your listings. It is free to get started, why not post your listings today?'>
<meta name="ROBOTS" content="NOINDEX, NOFOLLOW" />
<link rel="publisher" href="https://plus.google.com/u/0/b/111736498704458786396/"/>
<meta property="og:title" content="Search Results | Synclis"/>
<meta property="og:type" content="article" />
<meta property="og:image" content="https://synclis.com/media/symbolwhitebg.png"/>
<meta property="og:url" content="https://synclis.com/"/>
<meta property="og:description" content="Synclis is a powerful peer to peer listing resource made with you in mind. It also utilizes Social Media to get the most out of your listings. It is free to get started, why not post your listings today?" />
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="Search Results | Synclis" />
<meta name="twitter:url" content="https://synclis.com"/>
<meta name="twitter:description" content="Synclis is a powerful peer to peer listing resource made with you in mind. It also utilizes Social Media to get the most out of your listings. It is free to get started, why not post your listings today?">
<meta name="twitter:image" content="https://synclis.com/media/symbolwhitebg.png">
<!--SEO TAGS-->

  
  <link rel="shortcut icon" href="../favicon.ico" />

<link rel='stylesheet' href='../wp-content/plugins/x-custom/x-custom.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../wp-content/plugins/x-shortcodes/css/renew.css' type='text/css' media='all' />
<link rel='stylesheet' href='../wp-content/themes/x/framework/css/site/stacks/renew.css' type='text/css' media='all' />
<link rel='stylesheet' href='../wp-content/primary.css' type='text/css' media='all' />
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans:300,300italic,700,700italic|Open+Sans:700|Raleway:400|Raleway:700&#038;subset=latin,latin-ext' type='text/css' media='all' />
<script src="../wp-includes/js/jquery/jquery-1.9.1.js"></script>
<script type='text/javascript' src='../wp-includes/js/jquery/jquery-migrate.min.js?ver=1.2.1'></script>
<script type='text/javascript' src='../wp-content/themes/x/framework/js/x.min.js'></script>
<script type='text/javascript' src='../wp-content/plugins/x-shortcodes/js/vendor/backstretch-2.0.3.min.js'></script>
<script type='text/javascript' src='../wp-content/plugins/x-shortcodes/js/vendor/modernizr-2.7.1.min.js'></script>
<script type='text/javascript' src='../wp-content/plugins/x-shortcodes/js/vendor/fittext-1.1.0.min.js'></script>

	<!-- DEV MODE - including each .css file -->

  </head>
<body class="home page page-id-3034 page-template page-template-template-blank-4-php x-renew x-navbar-fixed-top-active x-boxed-layout-active x-sidebar-content-active">


<div id="top" class="site">

<header class="masthead" role="banner">
	<?php printNav(); ?>
</header>

    
    

	<div class="x-main" role="main">
		<article id="post-3034" class="post-3034 page type-page status-publish hentry no-post-thumbnail">
			<div class="entry-content">

				
				
				

				<div id="x-content-band-12" class="x-content-band bg-pattern man" style="background-image: url(../icons/cream_pixels.png); background-color: transparent;">
					<div class="x-container-fluid max width">
						<div id="container">
							<?php
								if($GLOBALS['LOGGED_IN_FLAG']){
									$notlogged = " AND `AUTH_TOKEN`.`HASH_KEY`='{$_COOKIE['SYNCLIS_TOKEN']}'";
									$notlogged1= ", MAX(CASE `BOOKMARK`.`LISTING` WHEN `LISTING`.`HASH62` THEN 1 ELSE 0 END) AS IS_BOOK, MAX(CASE `ENJOY`.`LISTING` WHEN `LISTING`.`HASH62` THEN 1 ELSE 0 END) AS IS_ENJOY";
									$notlogged2= "LEFT JOIN `AUTH_TOKEN` ON `AUTH_TOKEN`.`USER_ID` LEFT JOIN `BOOKMARK` ON `AUTH_TOKEN`.`USER_ID`=`BOOKMARK`.`USER` LEFT JOIN `ENJOY` ON `AUTH_TOKEN`.`USER_ID`=`ENJOY`.`USER`";
								}
								else{
									$notlogged = "";
									$notlogged1= "";
									$notlogged2= "";
								}
								if(!preg_match('/^[-\w\s+%]+$/', $_GET['q'])){
									echo '<script>window.location ="https://synclis.com/Sections";</script>';
								}else{
									$query = str_replace("%20", " ", $_GET['q']);
								}
								
								if($_GET['s'] && ctype_alpha ( $_GET['s']) ) $sectionFilter = "AND `SECTION`.`SECTION`='" . str_replace("%20", " ", $_GET['s']) . "' ";
								else           $sectionFilter = "";
								
								
								$u = mysqli_query($conn, "SELECT
`LISTING`.`ID`,
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
`LISTING`.`PAGE_VIEWS`,
`LISTING`.`INQUIRIES`,
`LISTING`.`USER`,
`LISTING`.`TIMESTAMP`,
`LISTING`.`FEATURED`,
`LISTING`.`TOGGLE`,
`LISTING`.`AGE_FILTER`,
`LISTING`.`HASH62`,
`CATEGORY`.`ID` ". $notlogged1 ."
FROM `LISTING`
".$notlogged2."
LEFT JOIN `CATEGORY` ON `LISTING`.`CATEGORY` = `CATEGORY`.`ID`
LEFT JOIN `SECTION` ON `SECTION`.`ID`
WHERE MATCH(`LISTING`.`DESCRIPTION`,`LISTING`.`NAME`) AGAINST ('". $query ."')" . $notlogged ."
". $sectionFilter ."
GROUP BY `LISTING`.`HASH62`
ORDER BY `LISTING`.`TIMESTAMP` DESC LIMIT 30");

								if(mysqli_num_rows($u) === 0){
									print('No search results were found for : ' . $query .' <br/><br/><br/><br/>');
								}else{
									mysqli_query($conn, "INSERT INTO `SEARCH_CLOUD` (`ID` ,`SEARCH_TERM` ,`COUNTRY` ,`PROVIDENCE` ,`TIME`) VALUES (NULL ,  '". $_GET['q'] ."',  '". $GLOBALS['COUNTRY'] ."',  '". $GLOBALS['REGION'] ."',  '". time() ."');");
								
								
									while($row = mysqli_fetch_row($u)){
										//Shorten down to 250chars
										if(strlen($row[2]) > 250)$res = substr($row[2], 0, 250) . '...';else $res = $row[2];
										//If image is null, put placeholder.
										if($row[5] =='')$imgp = 'no-photo.png';else $imgp = $row[5];
										if($row[12] > 5) $status = '<div style="position:absolute; top:-1px;right:-1px; width: 0;height: 0;border-top: 75px solid #f55;border-left: 75px solid transparent; opacity: 0.96;"></div>'; else $status = '';
										if($row[20] ==1) { $bookmarked='bookmarked'; $text='Saved';} else { $bookmarked ='unbookmarked'; $text='Bookmark';}
										if($row[21] ==1) { $enjoy = 'enjoy'; } else { $enjoy = 'nojoy'; }
										$tags = array("[h1]", "[/h1]", "[h2]", "[/h2]", "[v1]", "[/v1]", "[v2]", "[/v2]");
										
											echo 
										'<div class="item">
								<div style="position:absolute; top:0;right:6px; color: #eee;"><i class="x-icon-comments-o"></i> ' . $row[12] . '</span></div>
								<div class="synclis_bgimg"><img src="'. $imgp .'" onerror="this.src=\'no-photo.png\';" /></div>
								<div style = "padding: 0 8px 8px 8px; font-size: 90%;">
									<h4 style="font-weight:normal; font-size: 110%; padding:0;"><img src="../icons/categories/restraunt.png" style="width: 32px; height:32px; margin-right: 6px;"/>'. $row[1] .'</h4>
									<div style = "background: #f7f7f7; padding: 5px;  margin-bottom: 8px;">
									<i class="x-icon-users"></i> Anonymous <a href="#"><i class="x-icon-flag" style="color:#F07E68; float:right;" title="Report User"></i></a><br/>
									<i class="x-icon-map-marker"></i> '. $row[7] .', '. $row[8] .'<br/>
									<i class="x-icon-calendar-o"></i> '. date("F j, Y  g:i a", ($row[14] + (($GLOBALS['USER_DATA'][2]+5)*60*60)) ) .'<br/>
									</div>
									<p style="font-size: 90%;">'. strip_tags ( str_replace($tags, " ", $res) ) . '</p>
								</div>
								
								<div style = "width: 100%;">
									<a href="../ViewListing/'. $row[18] .'"><div class="simplex" style="border-bottom-left-radius: 4px;"><i class="x-icon-search"></i> Preview</div></a>
									<a href="Javascript:;" onClick="bookmarkit(\''. $row[18] .'\');"><div class="simplex '. $bookmarked .'" id="bkm'. $row[18] .'"><i class="x-icon-bookmark-o"></i> '. $text .'</div></a>
									<a href="Javascript:;" onClick="enjoyit(\''. $row[18] .'\');" style=" color: white;"><div id="tog'. $row[18] .'" class="simplex twenty '. $enjoy .'" title="Enjoyed It."><i class="x-icon-star-o"></i>&nbsp;</div></a>
								</div>
							</div>';
									}
								
								}
							
							?>
						
						<script src="masonry.pkgd.min.js"></script>
						
						<script>
							var container = document.querySelector('#container');
							var msnry = new Masonry( container, {
							  itemSelector: '.item'
							});
						</script>
						
					</div>
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


<!--[if lt IE 9]><script type="text/javascript" src="../wp-content/themes/x/framework/js/vendor/selectivizr-1.0.2.min.js"></script><![endif]-->
  

  <?php  alertSystem(); ?>
    
  
</body>
</html>
