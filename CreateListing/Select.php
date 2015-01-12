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
	<title>Select Listing Type | Synclis</title>
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
  
  <link rel="shortcut icon" href="../favicon.ico" />

<script type='text/javascript' src='../wp-includes/js/jquery/jquery-1.9.1.js'></script>
<script type='text/javascript' src='../wp-includes/js/jquery/jquery-migrate.min.js?ver=1.2.1'></script>
<script type='text/javascript' src='../wp-content/themes/x/framework/js/x.min.js'></script>

<script type='text/javascript' src='../wp-content/plugins/x-shortcodes/js/vendor/backstretch-2.0.3.min.js'></script>
<script type='text/javascript' src='../wp-content/plugins/x-shortcodes/js/vendor/modernizr-2.7.1.min.js'></script>
<script type='text/javascript' src='../wp-content/plugins/x-shortcodes/js/vendor/fittext-1.1.0.min.js'></script>

<script type='text/javascript' src='../wp-content/plugins/bootstrap/js/bootstrap.min.js'></script>
<link rel='stylesheet' href='../wp-content/plugins/bootstrap/css/bootstrap.min.css' type='text/css' media='all' />

<link rel='stylesheet' href='../wp-content/plugins/x-custom/x-custom.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../wp-content/plugins/x-shortcodes/css/renew.css' type='text/css' media='all' />
<link rel='stylesheet' href='../wp-content/themes/x/framework/css/site/stacks/renew.css' type='text/css' media='all' />
<link rel='stylesheet' href='../wp-content/primary.css' type='text/css' media='all' />

<script src="../wp-content/pace.min.js"></script>
<link href="../wp-content/dataurl.css" rel="stylesheet" />
	<style>
		.shadow{
			-webkit-box-shadow: 2px 2px 2px 1px rgba(0,0,0,0.15);
			-moz-box-shadow: 2px 2px 2px 1px rgba(0,0,0,0.15);
			box-shadow: 2px 2px 2px 1px rgba(0,0,0,0.15);

		}
		.shadow:hover{
			-webkit-box-shadow: inset 2px 2px 2px 1px rgba(0,0,0,0.21);
			-moz-box-shadow: inset 2px 2px 2px 1px rgba(0,0,0,0.21);
			box-shadow: inset 2px 2px 2px 1px rgba(0,0,0,0.21);
		}
		.synclis-stp{
			border-radius: 6px; color: #fff; border:none;
			padding: 12px;
			transition: color 0.4s;
			-moz-transition: color 0.4s;
			-webkit-transition: color 0.4s;
			-o-transition: color 0.4s;
		}
		.synclis-stp:hover{
			color: #fafafa;
		}
		.synclis-stp img{
			width: 64px;
			height: 64px;
			
		}
		.primarylist li{
			padding:8px;
			color: black;
			transition: background 0.4s;
			-moz-transition: background 0.4s;
			-webkit-transition: background 0.4s;
			-o-transition: background 0.4s;
		}
		.primarylist li:hover{
			background: #EEE;
		}
	</style>
  </head>
<body class="home page page-template page-template-template-blank-4-php x-renew x-navbar-fixed-top-active x-boxed-layout-active x-sidebar-content-active">

<div id="top" class="site">

<header class="masthead" role="banner">
	<?php printNav(); ?>
</header>
	<div class="x-main" role="main">
			<div class="entry-content">
			
				<!-- Button trigger modal -->

<!-- Button trigger modal -->
<!-- Modal -->
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="max-width: 300px; margin-left: -150px;">
				  <div class="modal-dialog">
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h5 style="padding:0; margin:0 0 6px 0; text-align: center;" >Select a category:</h5>
					  </div>
					  <div class="modal-body" style="color: black;">
						<ul id="synclis_catdump" class="primarylist" style="padding: 0; margin:0;">
							<br/>&emsp; Select a section to generate a list of categories.<br/><br/><br/>
						</ul>
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					  </div>
					</div>
				  </div>
				</div>
				

				<div id="x-content-band-6" class="x-content-band bg-pattern man" style="background-image: url(../icons/cream_pixels.png); background-color: transparent;">
					<div id="synclis-content" class="x-container-fluid max width">
						<div class="x-column synclis-stp">
							<div class="x-column one-third">
								<a href="Javascript:;" data-toggle="modal" data-target="#myModal" onClick="synclis_execCG(1);"><div class="synclis-stp shadow"      style="background: #E46F61;"><center><img src="SelectIcons/7.png" /></center>I am looking to post a house listing, a roomate, or real estate.</div></a>
								<a href="Javascript:;" data-toggle="modal" data-target="#myModal" onClick="synclis_execCG(4);"><div class="synclis-stp shadow"      style="background: #F9B256;"><center><img src="SelectIcons/8.png" /></center>I am looking to sell electronics. For example cell phones, or computers.</div></a>
								<a href="Javascript:;" data-toggle="modal" data-target="#myModal" onClick="synclis_execCG(7);"><div class="synclis-stp shadow" style="background: #FBCB43;"><center><img src="SelectIcons/2.png" /></center>I am professional looking to advertise my talents for my business.</div></a>
							</div>
							<div class="x-column one-third">
								<a href="Javascript:;" data-toggle="modal" data-target="#myModal" onClick="synclis_execCG(2);"><div class="synclis-stp shadow" style="background: #B2D974;">   <center><img src="SelectIcons/1.png" /></center>I am a freelancer looking for new opportunities.</div></a>
								<a href="Javascript:;" data-toggle="modal" data-target="#myModal" onClick="synclis_execCG(5);"><div class="synclis-stp shadow"      style="background: #8CC474;"><center><img src="SelectIcons/0.png" /></center>I am a business owner looking to hire new talent.</div></a>
								<a href="Javascript:;" data-toggle="modal" data-target="#myModal" onClick="synclis_execCG(8);"><div class="synclis-stp shadow"      style="background: #4DBFD9;"><center><img src="SelectIcons/3.png" /></center>I am looking to sell something small. For example some clothes, or toys.</div></a>
								
								
							</div>
							<div class="x-column one-third last">
								<a href="Javascript:;" data-toggle="modal" data-target="#myModal" onClick="synclis_execCG(3);"><div class="synclis-stp shadow" style="background: #76A7FA;"><center><img src="SelectIcons/5.png" /></center>I am a store owner, and I am looking to advertise.</div></a>
								<a href="Javascript:;" data-toggle="modal" data-target="#myModal" onClick="synclis_execCG(6);"><div class="synclis-stp shadow"      style="background: #6F85BF;"><center><img src="SelectIcons/6.png" /></center>I want to coordinate an event, and let others in my community find my event.</div></a>
								<a href="Javascript:;" data-toggle="modal" data-target="#myModal" onClick="synclis_execCG(9);"><div class="synclis-stp shadow"      style="background: #BC5679;"><center><img src="SelectIcons/4.png" /></center>I am looking to sell a motored vehicle. For example a car, motorcycle, or ATV.</div></a>
							</div>
						</div>

						

					</div>
				</div>
				

                              
      </div> <!-- end .entry-content -->
  </div> <!-- end .x-main -->
	<script src="../api/base64.js"></script>
	<script>
		function synclis_execCG(value){
		var http = new XMLHttpRequest();
		http.open("GET", "https://synclis.com/api/sys/categories?q="+ value +"?lang=<?php echo $GLOBALS['USER_DATA'][3]; ?>", true);
		
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
						document.getElementById('synclis_catdump').innerHTML = '';
						for(var t=0; t < json.length; t++)
							document.getElementById('synclis_catdump').innerHTML += '<a href="'+ json[t].url +'"><li><img style="width: 32px; height: 32px;"src="https://synclis.com/'+ json[t].icon +'"/> ' + Base64.decode(json[t].name) + '</li></a>';
					}
				}catch(e){
					alert("Opps, something went wrong.");
				}
			}
		}
		http.send();
	}

	</script>

    <footer class="x-colophon bottom" role="contentinfo">
		<?php printFooter(); ?>
    </footer> <!-- end .x-colophon.bottom -->

  </div>

  <!--
  END #top.site
  -->

<?php  alertSystem(); ?>

</body>
</html>
