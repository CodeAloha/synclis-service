<?php include('../meta.php');?>
<!DOCTYPE html>
<!--[if IE 8]><html class="no-js ie8" lang="en-US"><![endif]-->
<!--[if IE 9]><html class="no-js ie9" lang="en-US"><![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" lang="en-US"><!--<![endif]-->
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

<!--SEO TAGS-->
<title>My Listings | Synclis</title>
<meta name='description' content='View your listings on Synclis, sign up for Synclis and begin sharing your listings, events and services within your local community.'>
<meta name="ROBOTS" content="INDEX, NOFOLLOW" />
<link rel="publisher" href="https://plus.google.com/u/0/b/111736498704458786396/"/>
<meta property="og:title" content="View My Listings | Synclis"/>
<meta property="og:type" content="article" />
<meta property="og:image" content="https://synclis.com/media/symbolwhitebg.png"/>
<meta property="og:url" content="<?php echo "http://". $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"/>
<meta property="og:description" content='View your listings on Synclis, sign up for Synclis and begin sharing your listings, events and services within your local community.'>
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="View My Listings | Synclis" />
<meta name="twitter:url" content="<?php echo "http://". $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"/>
<meta name="twitter:description" content='View your listings on Synclis, sign up for Synclis and begin sharing your listings, events and services within your local community.'>
<meta name="twitter:image" content="https://synclis.com/media/symbolwhitebg.png">
<!--SEO TAGS-->
  
  <link rel="shortcut icon" href="../favicon.ico" />
  <?php
	
	if(!$_COOKIE['SYNCLIS_TOKEN']){
		echo "<script>window.location='../Sections?msg=NotLoggedIn';</script>";
	}
	else{
		
		$a = mysqli_query($conn,"SELECT 
`LISTING`.`NAME`,
`LISTING`.`DESCRIPTION`,
`CATEGORY`.`ICON`,
`LISTING`.`IMAGE`,
`LISTING`.`COUNTRY`,
`LISTING`.`PROVIDENCE`,
`LISTING`.`CITY`,
`LISTING`.`LONG`,
`LISTING`.`LAT`,
`LISTING`.`PAGE_VIEWS`,
`LISTING`.`INQUIRIES`,
`LISTING`.`TIMESTAMP`,
`LISTING`.`FEATURED`,
`LISTING`.`TOGGLE`,
`LISTING`.`AGE_FILTER`,
`LISTING`.`HASH62`

FROM `LISTING`
LEFT JOIN `AUTH_TOKEN` ON `AUTH_TOKEN`.`USER_ID`=`LISTING`.`USER`
LEFT JOIN `CATEGORY` ON `CATEGORY`.`ID`=`LISTING`.`CATEGORY`
WHERE `AUTH_TOKEN`.`HASH_KEY`='{$_COOKIE['SYNCLIS_TOKEN']}' 
ORDER BY `TIMESTAMP` DESC
LIMIT 200");
		
	}
	
	$b = mysqli_query($conn,"SELECT
`LISTING`.`NAME`,
`LISTING`.`DESCRIPTION`,
`CATEGORY`.`ICON`,
`LISTING`.`IMAGE`,
`LISTING`.`COUNTRY`,
`LISTING`.`PROVIDENCE`,
`LISTING`.`CITY`,
`LISTING`.`LONG`,
`LISTING`.`LAT`,
`LISTING`.`PAGE_VIEWS`,
`LISTING`.`INQUIRIES`,
`LISTING`.`TIMESTAMP`,
`LISTING`.`FEATURED`,
`LISTING`.`TOGGLE`,
`LISTING`.`AGE_FILTER`,
`LISTING`.`HASH62`
FROM `BOOKMARK`
LEFT JOIN `AUTH_TOKEN` ON `AUTH_TOKEN`.`USER_ID`=`BOOKMARK`.`USER`
LEFT JOIN `LISTING` ON `LISTING`.`USER`
LEFT JOIN `CATEGORY` ON `CATEGORY`.`ID`=`LISTING`.`CATEGORY`
WHERE `AUTH_TOKEN`.`HASH_KEY`='{$_COOKIE['SYNCLIS_TOKEN']}' AND `BOOKMARK`.`LISTING`=`LISTING`.`HASH62`
ORDER BY `TIMESTAMP` DESC
LIMIT 300");
	
  ?>

<link rel='stylesheet' href='../wp-content/plugins/x-custom/x-custom.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../wp-content/plugins/x-shortcodes/css/renew.css' type='text/css' media='all' />
<link rel='stylesheet' href='../wp-content/themes/x/framework/css/site/stacks/renew.css' type='text/css' media='all' />
<link rel='stylesheet' href='../wp-content/primary.css' type='text/css' media='all' />
<script src="../wp-includes/js/jquery/jquery-1.9.1.js"></script>
<script type='text/javascript' src='../wp-includes/js/jquery/jquery-migrate.min.js?ver=1.2.1'></script>
<script type='text/javascript' src='../wp-content/themes/x/framework/js/x.min.js'></script>
<script type='text/javascript' src='../wp-content/plugins/x-shortcodes/js/vendor/backstretch-2.0.3.min.js'></script>
<script type='text/javascript' src='../wp-content/plugins/x-shortcodes/js/vendor/modernizr-2.7.1.min.js'></script>

<script type='text/javascript' src='../wp-content/plugins/bootstrap/js/bootstrap.min.js'></script>
<link href="../wp-content/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<script src="../wp-content/pace.min.js"></script>
<link href="../wp-content/dataurl.css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="jquery.dataTables.min.js"></script>
		<script type="text/javascript" charset="utf-8">
			/* Formating function for row details */

			var oTable;
			$(document).ready(function() {

				 
				oTable = $('#example2').dataTable( {
					"aoColumnDefs": [
						{ "bSortable": false, "aTargets": [ 0 ] }
					],
					"aaSorting": [[1, 'asc']],
					"iDisplayLength" : 5,
					"aLengthMenu": [[5, 10, 20, 50, -1],
									[5, 10, 20, 50, "All"]]
				});
				 
				oTable = $('#example').dataTable( {
					"aoColumnDefs": [
						{ "bSortable": false, "aTargets": [ 0 ] }
					],
					"aaSorting": [[1, 'asc']],
					"iDisplayLength" : 5,
					"aLengthMenu": [[5, 10, 20, 50, -1],
									[5, 10, 20, 50, "All"]]
				});
				function ptg(){
					if( navigator.userAgent.match(/Android/i)){return true;}
					else if( navigator.userAgent.match(/webOS/i)) {return true;}
					else if( navigator.userAgent.match(/iPhone/i)){return true;}
					else if( navigator.userAgent.match(/iPad/i)){return true;}
					else if( navigator.userAgent.match(/iPod/i)){return true;}
					else if( navigator.userAgent.match(/BlackBerry/i) ){return true;}
					else if( navigator.userAgent.match(/Windows Phone/i) || navigator.userAgent.match(/IEMobile/i) ){ return true; }
					else if( navigator.userAgent.match(/Opera Mini/i) ){ return true; }
					else{return false;}
				}
				if(ptg()){
					fnShowHide( 2 );
					fnShowHide( 3 );
					fnShowHide( 4 );
					fnBookmark( 2 );
					fnBookmark( 3 );
					fnBookmark( 4 );
				}
				
			} );
			
			function fnShowHide( iCol )
			{
				/* Get the DataTables object again - this is not a recreation, just a get of the object */
				var oTable = $('#example').dataTable();
				
				var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
				oTable.fnSetColumnVis( iCol, bVis ? false : true );
			}
			function fnBookmark( iCol )
			{
				/* Get the DataTables object again - this is not a recreation, just a get of the object */
				var oTable = $('#example2').dataTable();
				
				var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
				oTable.fnSetColumnVis( iCol, bVis ? false : true );
			}
			
			function reconformation(){
				document.getElementById("synclis-delete-list").style.transition = "width 0.4s";
				document.getElementById("synclis-delete-list").style.WebkitTransition = "width 0.4s";
				document.getElementById("synclis-delete-list").style.width = "122px";
				document.getElementById("synclis-are-you-sure").style.transition = "width 0.4s";
				document.getElementById("synclis-are-you-sure").style.WebkitTransition = "width 0.4s";
				document.getElementById("synclis-are-you-sure").style.width = "122px";
				
				setTimeout(function(){
					document.getElementById("synclis-are-you-sure").innerHTML = "Are you sure?";
					document.getElementById("synclis-are-you-sure").style.border = "1px solid #FC2B36";
				},400);
				
			}
			
			function updateModal(idval){
				document.getElementById('modalContents').innerHTML =
				'<a href = "https://synclis.com/ViewListing/'+ idval +'" style="margin-bottom: 12px;"><button style="width: 250px;">View Listing</button></a>' +
				'<div style="clear:both; margin-bottom: 12px;"></div>' +
				'<a href = "https://synclis.com/EditListing/'+ idval +'" style="margin-bottom: 12px;"><button style="width: 250px;">Edit Listing</button></a><br/><br/>' +

				'<div id="synclis-delete-list" onClick="reconformation();" style="color: white; width: 250px; background: #FC2B36; border: 1px solid #FC2B36; float:left; border-top-left-radius: 3px; border-bottom-left-radius: 3px;">Delete Listing</div>' +
				'<div id="synclis-are-you-sure" onClick="synclis_remote_d(\''+ idval +'\');" style="color: white; width: 0px; background: #FD6068; float:left;  border-left: none; border-top-right-radius: 3px; border-bottom-right-radius: 3px; cursor:pointer;"></div>' +
				'<div style="clear:both;"></div><br/>';
			}
			function synclis_remote_d(idval){
				var http = new XMLHttpRequest();
				http.open("DELETE", "https://synclis.com/api/sys/listings/" + idval + "&session=" + readCookie('SYNCLIS_TOKEN'), true);
				var params = "session=" + readCookie('SYNCLIS_TOKEN');
				
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
								oTable.fnDeleteRow( document.getElementById( 'synclis-row' + idval ) );
								var magnificPopup = $.magnificPopup.instance; 
								magnificPopup.close(); 
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
		</script>

	<!-- DEV MODE - including each .css files -->
	
  
  </head>
<body class="home page page-id-3034 page-template page-template-template-blank-4-php x-renew x-navbar-fixed-top-active x-boxed-layout-active x-sidebar-content-active">


<div id="top" class="site">

<header class="masthead" role="banner">
	<?php printNav(); ?>
</header>

    
    

	<div class="x-main" role="main">
		<div id="synclis-content" class="entry-content">

			
			
			<style>
				table img{
					max-width: 150px;
					max-height:100px;
				}
				table .ftd{
					overflow: hidden; width: 160px; height: 105px;
				}
				@media screen and (max-width: 720px) {
					table img{ max-width: 75px; max-height:50px; }
					table .ftd{
					overflow: hidden; width: 80px; height: 55px;
				}
				}
				table thead tr{
					background: #eee;
				}
				table tbody tr{
					background: white;
					transition: background 0.4s;
					-moz-transition: background 0.4s;
					-webkit-transition: background 0.4s;
					-ms-transition: background 0.4s;
					font-size: 14px;
				}
				table tbody tr:hover{
					background: #f6f6f6;
				}
				
				#example_filter{
					position: absolute; top: 20px; right:16px;
				}
				#example2_filter{
					position: absolute; top: 20px; right:16px;
				}
				#example_length{
					margin:7px 0 0 4px;
				}
				#example2_length{
					margin:7px 0 0 4px;
				}
				#example_length select{
					border: 1px solid #eee;
				}
				#example2_length select{
					border: 1px solid #eee;
				}
				
				#example_wrapper{
					background: white;
					border: 1px solid #ddd;
					border-collapse: collapse;
					border-radius: 3px;
						-webkit-box-shadow: 2px 2px 2px 1px rgba(220,220,220,0.5);
						-moz-box-shadow: 2px 2px 2px 1px rgba(220,220,220,0.5);
						box-shadow: 2px 2px 2px 1px rgba(220,220,220,0.5);
				}
				#example2_wrapper{
					background: white;
					border: 1px solid #ddd;
					border-collapse: collapse;
					border-radius: 3px;
						-webkit-box-shadow: 2px 2px 2px 1px rgba(220,220,220,0.5);
						-moz-box-shadow: 2px 2px 2px 1px rgba(220,220,220,0.5);
						box-shadow: 2px 2px 2px 1px rgba(220,220,220,0.5);
				}
				
				#example_paginate{
					position: absolute; bottom: 16px; right:16px;
				}
				#example_paginate img{
					width: 12px;
					height: 12px;
				}
				#example_paginate div{
					float:left;
					padding: 4px 8px 4px 8px;
					margin: 3px;
					background: #f1f1f1;
					border-radius: 3px;
				}
				
				#example2_paginate{
					position: absolute; bottom: 16px; right:16px;
				}
				#example2_paginate img{
					width: 12px;
					height: 12px;
				}
				#example2_paginate div{
					float:left;
					padding: 4px 8px 4px 8px;
					margin: 3px;
					background: #f1f1f1;
					border-radius: 3px;
				}
				
			</style>

			


			<div id="x-content-band-12" class="x-content-band bg-pattern man" style="background-image: url(../icons/cream_pixels.png); background-color: transparent;">
				<div class="x-column one-half">
					<center><img src="icon/yourlistings.png" style = "width: 30%; min-width: 220px; max-width: 320px;"></center>
					
					<div id="container" style = "padding: 12px; position: relative;">

						<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
							<thead>
								<tr>
									<th style="font-weight: normal; font-weight: 300;">Listing</th>
									<th></th>
									<th><i class="x-icon-th-list"></i></th>
									<th><i class="x-icon-search"></i></th>
									<th><i class="x-icon-comments-o"></i></th>
								</tr>
							</thead>
							<tbody id="inline-popups">
							<?php
								$count = 0; $timeCountr = 1;
								while($row = mysqli_fetch_row($a))
								{//BEGIN MAIN LOOP SEQUENCE----------------------------------------------------------
									//If image is null, put placeholder.
									if($row[3] =='')$imgp = 'no-photo.png';else $imgp = $row[3];
									?><tr id="synclis-row<?php echo $row[15]; ?>" class="gradeX">
										<td class="ftd">
											<a href="Javascript:void(0);" onClick="updateModal('<?php echo $row[15]; ?>')" data-toggle="modal" data-target="#myModal" >
											<img id="highlight-synclis-img<?php echo $count; ?>" src="<?php echo $imgp; ?>" onerror="this.src='no-photo.png';" />
											</a>
										</td>
										<td><i class="x-icon-tag"></i>&emsp;<?php echo $row[0]; ?><br/><i class="x-icon-map-marker"></i>&emsp; <?php echo $row[5] .', '. $row[6]; ?><br/><i class="x-icon-calendar"></i>&emsp;<?php echo date("F j, Y  g:i a", ($row[11] + (($GLOBALS['USER_DATA'][2]+5)*60*60))   ); ?></td>
										<td><img src="../<?php echo $row[2]; ?>" style="width: 40px; height: 40px;" /></td>
										<td class="center"><?php echo $row[9] ?></td>
										<td class="center"><?php echo  $row[10] ?></td>
									</tr><?php
									$count++;
								}
							?>
							</tbody>

						</table>
					</div>
					
					
				</div>
				
				<!--BOOKMARKs-->
				
				<div class="x-column one-half last">
					<center><img src="icon/bookmark.png" style = "width: 30%; min-width: 220px;  max-width: 320px;"></center>
					<div id="container" style = "padding: 12px; position: relative;">


						<table cellpadding="0" cellspacing="0" border="0" class="display" id="example2">
							<thead>
								<tr>
									<th style="font-weight: normal; font-weight: 300;">Listing</th>
									<th></th>
									<th><i class="x-icon-th-list"></i></th>
									<th><i class="x-icon-search"></i></th>
									<th><i class="x-icon-comments-o"></i></th>
								</tr>
							</thead>
							<tbody>
						<?php
								$count = 0; $timeCountr = 1;
								while($row = mysqli_fetch_row($b))
								{//BEGIN MAIN LOOP SEQUENCE----------------------------------------------------------
									//Shorten down to 250chars
									if(strlen($row[2]) > 250)$res = substr($row[2], 0, 250) . '...';else $res = $row[2];
									//If image is null, put placeholder.
									if($row[3] =='')$imgp = 'no-photo.png';else $imgp = $row[3];
									if($row[12] > 5) $status = '';
									else $status = '';
									?><tr class="gradeX">
										<td><a href="https://synclis.com/ViewListing/<?php echo $row[15]; ?>" target="_blank"><img src="<?php echo $imgp; ?>" onerror="this.src='no-photo.png';" /></a></td>
										<td><i class="x-icon-tag"></i>&emsp;<?php echo $row[0]; ?><br/><i class="x-icon-map-marker"></i>&emsp; <?php echo $row[5] .', '. $row[6]; ?><br/><i class="x-icon-calendar"></i>&emsp;<?php echo date("F j, Y  g:i a", $row[11]); ?></td>
										<td><img src="../<?php echo $row[2]; ?>" style="width: 40px; height: 40px;" /></td>
										<td class="center"><?php echo $row[9] ?></td>
										<td class="center"><?php echo  $row[10] ?></td>
									</tr><?php
								}

						?>
							</tbody>

						</table>
					</div>
				</div>
				
				
			</div>
		</div> <!-- end .entry-content -->
  </div> <!-- end .x-main -->

	
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="max-width: 300px; margin-left: -150px;">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			Select Option
		  </div>
		  <div class="modal-body">
			<div style="padding: 4px; text-align: center;">
				<center>
				<div style="padding: 8px;" id="modalContents">
					An Error has occured.
				</div>
				</center>
			</div>
		  </div>
		  <div class="modal-footer">
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

	<!--[if lt IE 9]><script type="text/javascript" src="../wp-content/themes/x/framework/js/vendor/selectivizr-1.0.2.min.js"></script><![endif]-->

  <?php  alertSystem(); ?>
    
  
</body>
</html>
