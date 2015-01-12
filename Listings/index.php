<?php include('../meta.php');?>
<!DOCTYPE html>
<!--[if IE 8]><html class="no-js ie8" lang="en-US"><![endif]-->
<!--[if IE 9]><html class="no-js ie9" lang="en-US"><![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" lang="en-US"><!--<![endif]-->

  <?php
	if(!$_GET['c'] || !ctype_alpha ($_GET['c']) || !$_GET['s'] || !ctype_alpha ( $_GET['s']) ){
		echo "<script>window.location='https://synclis.com/Sections?msg=NotFound';</script>";
	}
	else{/**/
		if($GLOBALS['LOGGED_IN_FLAG']){
			$notlogged = "' AND `AUTH_TOKEN`.`HASH_KEY`='{$_COOKIE['SYNCLIS_TOKEN']}";
			$notlogged1= ", MAX(CASE `BOOKMARK`.`LISTING` WHEN `LISTING`.`HASH62` THEN 1 ELSE 0 END) AS IS_BOOK, MAX(CASE `ENJOY`.`LISTING` WHEN `LISTING`.`HASH62` THEN 1 ELSE 0 END) AS IS_ENJOY";
			$notlogged2= "LEFT JOIN `AUTH_TOKEN` ON `AUTH_TOKEN`.`USER_ID` LEFT JOIN `BOOKMARK` ON `AUTH_TOKEN`.`USER_ID`=`BOOKMARK`.`USER` LEFT JOIN `ENJOY` ON `AUTH_TOKEN`.`USER_ID`=`ENJOY`.`USER`";
		}else{
			$notlogged = "";
			$notlogged1= "";
			$notlogged2= "";
		}
		
		$a = mysqli_query($conn,"SELECT
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
`CATEGORY`.`ID`,
`CATEGORY`.`ICON`,
`USER`.`FIRST_NAME`,
`USER`.`LAST_NAME`,
`LISTING_LAYOUT`.`DATA`
". $notlogged1 ."
FROM `LISTING`
".$notlogged2."
LEFT JOIN `CATEGORY` ON `LISTING`.`CATEGORY` = `CATEGORY`.`ID`
LEFT JOIN `SECTION` ON `SECTION`.`ID`=`CATEGORY`.`SECTION`
LEFT JOIN `USER` ON `USER`.`ID`=`LISTING`.`USER`
LEFT JOIN `LISTING_LAYOUT` ON `LISTING_LAYOUT`.`LISTING`=`LISTING`.`HASH62`
WHERE `SECTION`.`SECTION`='". preg_replace('/\B([A-Z])/', ' $1', $_GET['s']) ."' AND `CATEGORY`.`NAME`='" . preg_replace('/\B([A-Z])/', ' $1', $_GET['c']) . $notlogged ."'
GROUP BY `LISTING`.`HASH62`
ORDER BY `LISTING`.`TIMESTAMP` DESC LIMIT 100");
		$c = mysqli_query($conn,"SELECT  `CATEGORY`.`ADVERTISE`, `CATEGORY`.`ICON` FROM  `CATEGORY` LEFT JOIN `SECTION` ON `SECTION`.`ID`=`CATEGORY`.`SECTION` WHERE 
		`CATEGORY`.`NAME` =  '". preg_replace('/\B([A-Z])/', ' $1', $_GET['c'])  ."' AND `SECTION`.`SECTION` = '". preg_replace('/\B([A-Z])/', ' $1', $_GET['s'])  ."'");
		$b = mysqli_query($conn,"SELECT `LISTING_TYPE` FROM `SECTION` WHERE `SECTION` = '". preg_replace('/\B([A-Z])/', ' $1', $_GET['s'])  ."'");
		if(!$a || !$b || !$c){
			mysqli_error($conn);
		}
		$empty = mysqli_num_rows($a);
		$listt = mysqli_fetch_row($b);
		$advertisement = mysqli_fetch_row($c);
		$listt = $listt[0];
		$category = '';
		
	}
  ?>


<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--SEO TAGS-->
	<title><?php echo preg_replace('/\B([A-Z])/', ' $1', $_GET['c']); ?> Listings | Synclis</title>
	<meta name='description' content='Preview all of the <?php echo $_GET['c']; ?> Listings on Synclis. Synclis is a powerful peer to peer listing resource made with you in mind.'>
	<meta name="ROBOTS" content="INDEX, NOFOLLOW" />
	<link rel="publisher" href="https://plus.google.com/u/0/b/111736498704458786396/"/>
	<meta property="og:title" content="<?php echo preg_replace('/\B([A-Z])/', ' $1', $_GET['c']); ?> Listings | Synclis"/>
	<meta property="og:type" content="article" />
	<meta property="og:image" content="https://synclis.com/media/symbolwhitebg.png"/>
	<meta property="og:url" content="<?php echo "http://". $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" />
	<meta property="og:description" content='Preview all of the <?php echo $_GET['c']; ?> Listings on Synclis. Synclis is a powerful peer to peer listing resource made with you in mind.' />
	<meta name="twitter:card" content="summary">
	<meta name="twitter:title" content="<?php echo preg_replace('/\B([A-Z])/', ' $1', $_GET['c']); ?> Listings | Synclis" />
	<meta name="twitter:url" content="<?php echo "http://". $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" />
	<meta name="twitter:description" content='Preview all of the <?php echo $_GET['c']; ?> Listings on Synclis. Synclis is a powerful peer to peer listing resource made with you in mind.' />
	<meta name="twitter:image" content="https://synclis.com/media/symbolwhitebg.png">
	<!--SEO TAGS-->
  <link rel="shortcut icon" href="../../favicon.ico" />
  
<link rel='stylesheet' href='../../wp-content/plugins/x-shortcodes/css/renew.css' type='text/css' media='all' />
<link rel='stylesheet' href='../../wp-content/themes/x/framework/css/site/stacks/renew.css' type='text/css' media='all' />
<link rel='stylesheet' href='../../wp-content/primary.css' type='text/css' media='all' />
<script src="../../wp-includes/js/jquery/jquery-1.9.1.js"></script>
<script type="text/javascript" src="../../api/cookies.js"></script>
<script type='text/javascript' src='../../wp-includes/js/jquery/jquery-migrate.min.js?ver=1.2.1'></script>
<script type='text/javascript' src='../../wp-content/themes/x/framework/js/x.min.js'></script>
<script type='text/javascript' src='../../wp-content/plugins/x-shortcodes/js/vendor/modernizr-2.7.1.min.js'></script>
<script type='text/javascript' src='../../wp-content/plugins/x-shortcodes/js/vendor/fittext-1.1.0.min.js'></script>
	<script src="../../wp-content/pace.min.js"></script>
	<link href="../../wp-content/dataurl.css" rel="stylesheet" />
	<style>
		.not-loggedin-listing{ width: 100%; border-bottom-right-radius: 3px; }
		
	</style>

  </head>
<body class="home page page-id-3034 page-template page-template-template-blank-4-php x-renew x-navbar-fixed-top-active x-boxed-layout-active x-sidebar-content-active"
onLoad="hideOnLoad();">


<div id="top" class="site">

<header class="masthead" role="banner">
	<?php printNav(); ?>
</header>

    
    

	<div class="x-main" role="main">
		<article id="post-3034" class="post-3034 page type-page status-publish hentry no-post-thumbnail">
			<div class="entry-content">

				

				<div id="x-content-band-5" class="x-content-band border-top border-bottom man" style="background-color: #fff;">
					<div class="x-container-fluid max width">
						<span style="font-size: 150%;"><img src="<?php echo "https://synclis.com/" . $advertisement[1]; ?>" />&emsp;Synclis > <a href="https://synclis.com/Sections/"><?php echo preg_replace('/\B([A-Z])/', ' $1', $_GET['s']); ?></a> > <?php echo preg_replace('/\B([A-Z])/', ' $1', $_GET['c']); ?></span><br/><br/>
						<a href="https://synclis.com/CreateListing/<?php echo $_GET['s']; ?>/<?php echo $_GET['c']; ?>" ><button style="color:#1FB5AC; font-size: 15px;"><i class="x-icon-pencil-square"></i>&emsp;Create Listing</button></a>
						<a href="Javascript:;" id="synclis-filter-button" class="hide-on-mobile" onClick="filterView();"><button><i class="x-icon-filter"></i>&emsp;Filter Results</button></a>
						<!--a href="Javascript:alert('coming soon');"><button><i class="x-icon-envelope"></i>&emsp;Send me Updates</button></a-->
					</div>
				</div>
				


				<div id="x-content-band-12" class="x-content-band bg-pattern man" style="background-image: url(../../icons/cream_pixels.png); background-color: transparent;">
					<div id="synclis-content" class="x-container-fluid max width">
						<div id="container" class="masonry-container">
							<?php 
							
								$JSON_BUILDER = '[';
								if($empty != 0){
									$count = 0; $timeCountr = 1;
									?>
										<div id="MessageHelper" class="item" style="height: 180px; overflow:hidden;">	
											<div style="background: #eee; text-align:center; padding: 8px 8px 8px 0;"><b style="font-size:100%;">Listing Helper</b> <a href="Javascript:;" onClick="hideListingHelper();" title="close" style="float:left; background:#ddd; border-radius: 24px; padding: 3px; margin-left: 5px; margin-top: -4px;">&nbsp;&nbsp;&#120;&nbsp;&nbsp;<a></div>
											<div style="padding: 12px; font-size: 90%;">
												* Todays post are marked in <i style="color:#f77;">red.</i><br/>
												* Featured posts are marked in <i style="color:orange;">orange.</i><br/>
												* Be sure to click the <i style="color:orange;">star icon</i> when you enjoy a listing.<br/>
											</div>
										</div>
									<?php
									while($row = mysqli_fetch_row($a))
									{//BEGIN MAIN LOOP SEQUENCE----------------------------------------------------------

												
												//Shorten down to 250chars
												if(strlen($row[2]) > 250)$res = substr($row[2], 0, 250) . '...';else $res = $row[2];
												//If image is null, put placeholder.
												if($row[5] =='')$imgp = '../no-photo.png';else $imgp = $row[5];
												if($row[24] > 0) { $bookmarked='bookmarked'; $text='Saved';} else { $bookmarked ='unbookmarked'; $text='Bookmark';}
												if($row[25] > 0) { $enjoy = 'enjoy'; } else { $enjoy = 'nojoy'; }
												$tags = array("[h1]", "[/h1]", "[h2]", "[/h2]", "[v1]", "[/v1]", "[v2]", "[/v2]");
												
												?>
													<!--Generate HTML-->
													<div id="synclisSort<?php echo $row[18]; ?>" class="item">
														<?php if($row[15] == 1 || $row[11] >= 5){ ?><div style="position:absolute; top:-1px;right:-1px; width: 0;height: 0;border-top: 75px solid orange;border-left: 75px solid transparent; opacity: 0.86;"></div><?php } ?>
														<?php if($row[14] >= time()-86400){ ?><div style="position:absolute; top:-1px;right:-1px; width: 0;height: 0;border-top: 75px solid #f55;border-left: 75px solid transparent; opacity: 0.86;"></div><?php } ?>
														<div style="position:absolute; top:0;right:6px; color: #eee;"><i class="x-icon-comments-o"></i>&nbsp;<?php echo  $row[12] ?></span></div>
														<a href="https://synclis.com/ViewListing/<?php echo $row[18]; ?>"><div class="synclis_bgimg"><img src="<?php echo $imgp; ?>" onerror="this.src='../no-photo.png';" /></div></a>
														<div style = "padding: 0 8px 8px 8px; font-size: 90%;">
															<h4 style="font-weight:normal; font-size: 110%; padding:0;"><img src="../../<?php echo $row[20]; ?>" style="width: 32px; height:32px; margin-right: 6px;"/><?php echo $row[1]; ?></h4>
															<div style = "background: #f7f7f7; padding: 5px;  margin-bottom: 8px;">
															<i class="x-icon-users"></i> <?php if($row[21] && $row[22]) echo $row[21] . ' ' . $row[22]; else echo 'Anonymous'; ?><br/>
															<i class="x-icon-map-marker"></i> <?php echo $row[7] .', '. $row[8]; ?><br/>
															<i class="x-icon-calendar-o"></i> <?php echo date("F j, Y  g:i a", ($row[14] + (($GLOBALS['USER_DATA'][2]+5)*60*60)) ); ?><br/>
															<?php $js = json_decode ( $row[23], true);
																if($js['price']) echo '<i class="x-icon-tags"></i> $' . $js['price'] . " " . $js['paymentbasis'] . "<br/>";
																if($js['bedroom'])  echo '<img src="https://synclis.com/icons/multipurpose/bed.png" style="width: 16px; height: 16px;" /> Bedrooms: ' . $js['bedroom'] . "<br/>"; 
																if($js['bathroom']) echo '<img src="https://synclis.com/icons/multipurpose/bath.png" style="width: 16px; height: 16px;" /> Bathrooms: ' . $js['bathroom'] . "<br/>";
																if($js['condition']) echo '<i class="x-icon-tags"></i> Condition:' . $js['condition'] . "<br/>";
									
															?>
															</div>
															<p style="font-size: 90%;"><?php echo strip_tags ( str_replace($tags, " ", $res) ) ?></p>
														</div>
														
														<div style = "width: 100%;">
															<a href="https://synclis.com/ViewListing/<?php echo $row[18]; ?>"><div class="simplex <?php if (!$_COOKIE['SYNCLIS_TOKEN']){ echo "not-loggedin-listing"; }?>" style="border-bottom-left-radius: 4px;"><i class="x-icon-search"></i> Preview</div></a>
															
															<?php if ($_COOKIE['SYNCLIS_TOKEN']){?>
															<a href="Javascript:;" onClick="bookmarkit('<?php echo $row[18]; ?>');"><div class="simplex '. $bookmarked .'" id="bkm<?php echo $row[18]; ?>"><i class="x-icon-bookmark-o"></i>&nbsp;<?php echo $text; ?></div></a>
															<a href="Javascript:;" onClick="enjoyit('<?php echo $row[18]; ?>');" style=" color: white;"><div id="tog<?php echo $row[18] ?>" class="simplex twenty <?php echo $enjoy ?>" title="+ Rep."><i class="x-icon-star-o"></i>&nbsp;</div></a>
															<?php } ?>
														</div>
													</div>
													<?php $JSON_BUILDER .= $row[23] . ','; ?>
													<!--Generate HTML-->
												<?php
												if($count % 24 == 2){
													?>
													<div class="item">
														<center>
														<div class="synclis_bgimg text-align: center;">									
		<iframe src="https://rcm-na.amazon-adsystem.com/e/cm?t=wwwsyncliscom-20&o=1&p=12&l=ur1&category=<?php echo $advertisement[0]; ?>&f=ifr" width="300" height="250" scrolling="no" border="0" marginwidth="0" style="border:none;" frameborder="0"></iframe>
														</div>
														</center>
													</div>
											
													<?php 
												}
												$count++;
									}
									$JSON_BUILDER = substr($JSON_BUILDER, 0, -1) . ']';
									
								}
								else{
									?>

									<div class="item" style="height: 180px; overflow:hidden;">	
										<div style="background: #eee; text-align:center; padding: 8px 8px 8px 0;"><b style="font-size:100%;">No Synclis Listings were found.</b> 
										</div>
										<div style="padding: 12px; font-size: 90%;">
											Sorry, there are no listings from Synclis.<br/>
											Tell your friends and family about Synclis by clicking 
											<a href="http://synclis.com/Social/" target="_blank">HERE.</a>
										</div>
									</div>
									<?php
								}
								if($_GET['s'] == 'Restaurants') include('yelp.php');
								
								
							?>
						</div>
						
						<script src="../masonry.pkgd.min.js"></script>
						
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

  
	<div id="synclis-filter-panel" class="hide-on-mobile" style = "position: fixed; bottom: -200px; left:0; border-top-right-radius: 6px; border: 1px solid #ccc; background: white; width: 320px; z-index: 10; height: 240px;">
		<a href="Javacript:;" onClick="filterView();"><div style="background: #f5f5f5; padding: 5px; text-align: center; font-size: 16px;  border-top-right-radius: 6px;"><i class="x-icon-filter"></i>&emsp;Filter Options</div></a>
		<div style="padding: 12px;">
		<?php if( $listt == 'house' || $listt == 'freelance'  || $listt == 'job' || $listt == 'market'){ ?>
		<div style = "width:320px;">
			Price Range: <input id="synclissort_minprice" placeholder = "Min Price" style = "width:100px; padding: 3px; margin: 0 3px 6px 0;"/>
			<input id="synclissort_maxprice" placeholder = "Max Price" style = "width:100px; padding: 3px; margin-bottom: 6px;"/>
		</div>
		<?php }  if( $listt == 'house' || $listt == 'freelance'  || $listt == 'job'){ ?>
		&emsp;Basis: &emsp;&emsp;&nbsp;<select id="synclissort_paymentbasis" style="width: 206px;"><option value="One time">Full Value</option><option value="Per Year">Per Year</option><option value="Per Month">Monthly Rent</option><option value="Per Week">Weekly Rent</option><option value="Per Day">Daily Rent</option><option value="Per Hour">Hourly Rent</option></select>
		<?php }  if( $listt == 'house' ){ ?>
			Other Items: 
			<select id="synclissort_bedrooms" style="width: 101px;"><option>Bedrooms</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option value="9">9+</option></select>
			<select id="synclissort_bathrooms" style="width: 101px;"><option>Bathrooms</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option value="9">9+</option></select>
		<?php }  if( $listt == 'market' ){ ?>
			Other Items: 
			<select id="synclissort_condition" style="width: 103px;"><option>Condition</option><option>New</option><option>Great</option><option>Good</option><option>Moderate</option><option>Poor</option><option>Broken</option></select>
			<select id="synclissort_paymentmethod" style="width: 103px;"><option>Payment Method</option><option>Cash</option><option>Check</option><option>Card</option></select>
		<?php } ?>
		<button onClick="synclis_sort();" style="width: 290px;">Filter Items</button>
		</div>
	</div>    
    <footer class="x-colophon bottom" role="contentinfo">
		<?php printFooter(); ?>
    </footer> <!-- end .x-colophon.bottom -->
    
</div>

	<!--Scripts-->
	<script>
		var sortingJSON = <?php if($JSON_BUILDER && $JSON_BUILDER != '[') echo $JSON_BUILDER; else echo '[]'; ?>;
		hideOnLoad();
		function hideOnLoad(){
			if(window.innerWidth <= 720){
				document.getElementById("synclis-filter-panel").style.display = "none";
				document.getElementById("synclis-filter-button").style.display = "none";
			}
		}
		
	</script>
	<script type='text/javascript' src='../../wp-content/plugins/listinghelper.js'></script>

  <?php  alertSystem(); ?>
    
  
</body>
</html>
