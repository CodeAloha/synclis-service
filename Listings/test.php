<?php include('../meta.php');?>
<!DOCTYPE html>
<!--[if IE 8]><html class="no-js ie8" lang="en-US"><![endif]-->
<!--[if IE 9]><html class="no-js ie9" lang="en-US"><![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" lang="en-US"><!--<![endif]-->
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Synclis | Listings</title>
  <link rel="shortcut icon" href="../favicon.ico" />
  <?php
	if(!$_GET['catid']){
		echo "<script>window.location='../Sections?msg=NotFound';</script>";
	}else{
		$a = mysql_query("SELECT * FROM `LISTING` WHERE `CATEGORY`=" . $_GET['catid'] . " ORDER BY `TIMESTAMP` DESC LIMIT 30");
	}
  ?>
  
<link rel='stylesheet' href='../wp-content/plugins/revslider/rs-plugin/css/settings.css' type='text/css' media='all' />
<link rel='stylesheet' href='../wp-content/plugins/revslider/rs-plugin/css/dynamic-captions.css' type='text/css' media='all' />
<link rel='stylesheet' href='../wp-content/plugins/revslider/rs-plugin/css/static-captions.css' type='text/css' media='all' />
<link rel='stylesheet' href='../wp-content/plugins/x-custom/x-custom.css' type='text/css' media='screen' />
<link rel='stylesheet' href='../wp-content/plugins/x-shortcodes/css/renew.css' type='text/css' media='all' />
<link rel='stylesheet' href='../wp-content/themes/x/framework/css/site/stacks/renew.css' type='text/css' media='all' />
<link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Open+Sans:300,300italic,700,700italic|Open+Sans:700|Raleway:400|Raleway:700&#038;subset=latin,latin-ext' type='text/css' media='all' />
<script type='text/javascript' src='../wp-includes/js/jquery/jquery.js?ver=1.10.2'></script>
<script type='text/javascript' src='../wp-includes/js/jquery/jquery-migrate.min.js?ver=1.2.1'></script>
<script type='text/javascript' src='../wp-content/plugins/revslider/rs-plugin/js/jquery.themepunch.plugins.min.js?rev=4.1.4&#038;ver=3.8.1'></script>
<script type='text/javascript' src='../wp-content/plugins/revslider/rs-plugin/js/jquery.themepunch.revolution.min.js?rev=4.1.4&#038;ver=3.8.1'></script>
<script type='text/javascript' src='../wp-content/plugins/x-shortcodes/js/vendor/backstretch-2.0.3.min.js'></script>
<script type='text/javascript' src='../wp-content/plugins/x-shortcodes/js/vendor/modernizr-2.7.1.min.js'></script>
<script type='text/javascript' src='../wp-content/plugins/x-shortcodes/js/vendor/fittext-1.1.0.min.js'></script>
<script type='text/javascript' src='../wp-content/themes/x/framework/js/x.min.js'></script>
<script type='text/javascript' src='../wp-content/themes/x/framework/js/vendor/jplayer/jplayer-2.3.0.min.js'></script>
<script type='text/javascript' src='../wp-content/themes/x/framework/js/vendor/bigvideo/jquery-ui-1.8.22.min.js'></script>
<script type='text/javascript' src='../wp-content/themes/x/framework/js/vendor/bigvideo/imagesloaded-3.0.4.min.js'></script>
<script type='text/javascript' src='../wp-content/themes/x/framework/js/vendor/bigvideo/video-4.1.0.min.js'></script>
<script type='text/javascript' src='../wp-content/themes/x/framework/js/vendor/bigvideo/bigvideo-1.0.0.min.js'></script>
<script type='text/javascript' src='../wp-includes/js/comment-reply.min.js?ver=3.8.1'></script>
<style type="text/css">

    

    body {
      background: #ecf0f1 url() center top repeat;
    }

    a,
    h1 a:hover,
    h2 a:hover,
    h3 a:hover,
    h4 a:hover,
    h5 a:hover,
    h6 a:hover,
    .x-comment-time:hover,
    #reply-title small a,
    .comment-reply-link:hover,
    .x-comment-author a:hover,
    .x-close-content-dock:hover i {
      color: #222222;
    }

      
    a:hover,
    #reply-title small a:hover,
    .x-recent-posts a:hover .h-recent-posts {
      color: #666666;
    }

    a.x-img-thumbnail:hover,
    li.bypostauthor > article.comment {
      border-color: #222222;
    }

      
    .flex-direction-nav a,
    .flex-control-nav a:hover,
    .flex-control-nav a.flex-active,
    .x-dropcap,
    .x-skill-bar .bar,
    .x-pricing-column.featured h2,
    .h-comments-title small,
    .pagination a:hover,
    .x-entry-share .x-share:hover,
    .entry-thumb,
    .widget_tag_cloud .tagcloud a:hover,
    .widget_product_tag_cloud .tagcloud a:hover,
    .x-highlight,
    .x-recent-posts .x-recent-posts-img,
    .x-recent-posts .x-recent-posts-img:before,
    .x-portfolio-filters {
      background-color: #222222;
    }

      
    .x-recent-posts a:hover .x-recent-posts-img,
    .x-portfolio-filters:hover {
      background-color: #666666;
    }

    .x-topbar .p-info,
    .x-topbar .p-info a,
    .x-topbar .x-social-global a {
      color: #2a2a2a;
    }

    .x-topbar .p-info a:hover {
      color: #959baf;
    }

    .x-brand,
    .x-brand:hover,
    .x-navbar .x-nav > li > a,
    .x-navbar .x-nav > li:before,
    .x-navbar .sub-menu li > a,
    .x-navbar .x-navbar-inner .x-nav-collapse .x-nav > li > a:hover,
    .x-navbar .x-navbar-inner .x-nav-collapse .sub-menu a:hover,
    .tp-leftarrow:before,
    .tp-rightarrow:before,
    .tp-bullets.simplebullets.navbar .bullet,
    .tp-bullets.simplebullets.navbar .bullet:hover,
    .tp-bullets.simplebullets.navbar .bullet.selected,
    .tp-bullets.simplebullets.navbar-old .bullet,
    .tp-bullets.simplebullets.navbar-old .bullet:hover,
    .tp-bullets.simplebullets.navbar-old .bullet.selected {
      color: #2a2a2a;
    }

    .x-navbar .sub-menu li:before,
    .x-navbar .sub-menu li:after {
      background-color: #2a2a2a;
    }

    .x-navbar .x-navbar-inner .x-nav-collapse .x-nav > li > a:hover,
    .x-navbar .x-navbar-inner .x-nav-collapse .sub-menu a:hover,
    .x-navbar .x-navbar-inner .x-nav-collapse .x-nav .current-menu-item > a {
      color: #828899;
    }

    .x-navbar .x-nav > li > a:hover,
    .x-navbar .x-nav > li.current-menu-item > a {
      -webkit-box-shadow: 0 2px 0 0 #828899;
              box-shadow: 0 2px 0 0 #828899;
    }

    .x-btn-navbar,
    .x-btn-navbar:hover {
      color: #ffffff;
    }

    .x-colophon.bottom,
    .x-colophon.bottom a,
    .x-colophon.bottom .x-social-global a {
      color: #2a2a2a;
    }

    .x-topbar {
      background-color: #ffffff;
    }

    .x-navbar,
    .x-navbar .sub-menu,
    .tp-bullets.simplebullets.navbar,
    .tp-bullets.simplebullets.navbar-old,
    .tp-leftarrow.default,
    .tp-rightarrow.default {
      background-color: #ecf0f1 !important;
    }

    .x-colophon.bottom {
      background-color: #ecf0f1;
    }

    .x-btn-navbar,
    .x-btn-navbar.collapsed:hover {
      background-color: #f4f8f9;
    }

    .x-btn-navbar.collapsed {
      background-color: #e5e9ea;
    }

    .entry-title:before {
      color: #2a2a2a;
    }

      
    .x-main {
      width: 68.79803%;
    }

    .x-sidebar {
      width: 24.79803%;
    }

    .x-navbar-static-active .x-navbar .x-nav > li,
    .x-navbar-fixed-top-active .x-navbar .x-nav > li {
      height: 90px;
      padding-top: 38px;
    }

    .x-navbar-fixed-left-active .x-navbar .x-nav > li > a,
    .x-navbar-fixed-right-active .x-navbar .x-nav > li > a {
      margin-top: 14px;
      margin-bottom: 14px;
    }

    .x-navbar .x-nav > li:before {
      padding-top: 38px;
    }

    .sf-menu li:hover ul,
    .sf-menu li.sfHover ul {
      top: 90px;;
    }

    .sf-menu li li:hover ul,
    .sf-menu li li.sfHover ul {
      top: -1.75em;
    }

    .x-navbar-fixed-left-active .x-widgetbar {
      left: 235px;
    }

    .x-navbar-fixed-right-active .x-widgetbar {
      right: 235px;
    }


    /*
    // Renew container sizing.
    */

    .x-container-fluid.width {
      width: 96%;
    }



      
      .site,
      .x-navbar.x-navbar-fixed-top.x-container-fluid.max.width {
        width: 96%;
      }

      

    /*
    // Renew custom fonts.
    */

      
      .x-comment-author a,
      .comment-form-author label,
      .comment-form-email label,
      .comment-form-url label,
      .comment-form-comment label,
      .widget_calendar #wp-calendar caption,
      .widget_calendar #wp-calendar th,
      .x-accordion-heading .x-accordion-toggle,
      .x-nav-tabs > li > a:hover,
      .x-nav-tabs > .active > a,
      .x-nav-tabs > .active > a:hover {
        color: #2a2a2a;
      }

      .widget_calendar #wp-calendar th {
        border-bottom-color: #2a2a2a;
      }

      .pagination span.current,
      .x-portfolio-filters-menu,
      .widget_tag_cloud .tagcloud a,
      .h-feature-headline span i,
      .widget_price_filter .ui-slider .ui-slider-handle {
        background-color: #2a2a2a;
      }

      
      
      .x-comment-author a {
        color: #7a7a7a;
      }

        
      
      .h-landmark {
        font-weight: 300;
              }


    /*
    // Renew mobile styles.
    */

    @media (max-width: 979px) {
      .x-navbar-static-active .x-navbar .x-nav > li,
      .x-navbar-fixed-top-active .x-navbar .x-nav > li {
        height: auto;
        padding-top: 0;
      }

      .x-navbar-fixed-left .x-container-fluid.width,
      .x-navbar-fixed-right .x-container-fluid.width {
        width: 88%;
      }

      .x-navbar-fixed-left-active .x-navbar .x-nav > li > a,
      .x-navbar-fixed-right-active .x-navbar .x-nav > li > a {
        margin-top: 0;
      }

      .x-navbar-fixed-left-active .x-widgetbar {
        left: 0;
      }

      .x-navbar-fixed-right-active .x-widgetbar {
        right: 0;
      }
    }

    

    /*
    // Body.
    */

    body {
      font-size: 14px;
      font-weight: 300;
                    color: #7a7a7a;
          }


    /*
    // Headings.
    */

    h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
      font-weight: 400;
            letter-spacing: -1px;
          }


    /*
    // Content.
    */

    .entry-header,
    .entry-content {
      font-size: 14px;
    }


    /*
    // Brand.
    */

    .x-brand {
      font-weight: 700;
            letter-spacing: -2px;
              text-transform: uppercase;
          }

    
    
    body,
    input,
    button,
    select,
    textarea {
      font-family: "Open Sans", "Helvetica Neue", Helvetica, sans-serif;
    }

    h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
      font-family: "Raleway", "Helvetica Neue", Helvetica, sans-serif;
    }

    .x-brand {
      font-family: "Raleway", "Helvetica Neue", Helvetica, sans-serif;
    }

    .x-navbar .x-nav > li > a {
      font-family: "Open Sans", "Helvetica Neue", Helvetica, sans-serif;
    }

    
    
    h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a, .h1 a, .h2 a, .h3 a, .h4 a, .h5 a, .h6 a, blockquote {
      color: #2a2a2a;
    }

    
    
    

    /*
    // Content/sidebar sizing.
    */

    .x-main.full {
      float: none;
      display: block;
      width: auto;
    }

    @media (max-width: 979px) {
      .x-main.left,
      .x-main.right,
      .x-sidebar.left,
      .x-sidebar.right {
        float: none;
        display: block;
        width: auto;
      }
    }


    /*
    // Widgetbar.
    */

    .x-btn-widgetbar {
      border-top-color: #d6d6d6;
      border-right-color: #d6d6d6;
    }

    .x-btn-widgetbar:hover {
      border-top-color: #a3a3a3;
      border-right-color: #a3a3a3;
    }


    /*
    // Navbar layout.
    */

    body.x-navbar-fixed-left-active {
      padding-left: 235px;
    }

    body.x-navbar-fixed-right-active {
      padding-right: 235px;
    }

    .x-navbar {
      font-size: 12px;
    }

    .x-navbar .x-nav > li > a {
              font-style: normal;
                    text-transform: uppercase;
          }

    .x-navbar-fixed-left,
    .x-navbar-fixed-right {
      width: 235px;
    }

    .x-navbar-fixed-top-active .x-navbar-wrap {
      height: 90px;
    }

    .x-navbar-inner {
      min-height: 90px;
    }

    .x-btn-navbar {
      margin-top: 23px;;
    }

    .x-btn-navbar,
    .x-btn-navbar.collapsed {
      font-size: 21px;
    }

    .x-brand {
      font-size: 42px;
      font-size: 4.2rem;
      margin-top: 25px;
    }

    body.x-navbar-fixed-left-active .x-brand,
    body.x-navbar-fixed-right-active .x-brand {
      margin-top: 30px;
    }

    @media (max-width: 979px) {
      body.x-navbar-fixed-left-active,
      body.x-navbar-fixed-right-active {
        padding: 0;
      }

      body.x-navbar-fixed-left-active .x-brand,
      body.x-navbar-fixed-right-active .x-brand {
        margin-top: 25px;
      }

      .x-navbar-fixed-top-active .x-navbar-wrap {
        height: auto;
      }

      .x-navbar-fixed-left,
      .x-navbar-fixed-right {
        width: auto;
      }
    }


    /*
    // Buttons.
    */

    .x-btn,
    .button,
    [type="submit"] {
      color: #2a2a2a;
      border-color: #2a2a2a;
      background-color: #ff2a13;
    }

    .x-btn:hover,
    .button:hover,
    [type="submit"]:hover {
      color: #00a4af;
      border-color: #00a4af;
      background-color: #ef2201;
    }

    .x-btn.x-btn-real,
    .x-btn.x-btn-real:hover {
      margin-bottom: 0.25em;
      text-shadow: 0 0.075em 0.075em rgba(0, 0, 0, 0.65);
    }

    .x-btn.x-btn-real {
      -webkit-box-shadow: 0 0.25em 0 0 #a71000, 0 4px 9px rgba(0, 0, 0, 0.75);
              box-shadow: 0 0.25em 0 0 #a71000, 0 4px 9px rgba(0, 0, 0, 0.75);
    }

    .x-btn.x-btn-real:hover {
      -webkit-box-shadow: 0 0.25em 0 0 #a71000, 0 4px 9px rgba(0, 0, 0, 0.75);
              box-shadow: 0 0.25em 0 0 #a71000, 0 4px 9px rgba(0, 0, 0, 0.75);
    }

    .x-btn.x-btn-flat,
    .x-btn.x-btn-flat:hover {
      margin-bottom: 0;
      text-shadow: 0 0.075em 0.075em rgba(0, 0, 0, 0.65);
      -webkit-box-shadow: none;
              box-shadow: none;
    }

    .x-btn.x-btn-transparent,
    .x-btn.x-btn-transparent:hover {
      margin-bottom: 0;
      border-width: 3px;
      text-shadow: none;
      text-transform: uppercase;
      background-color: transparent;
      -webkit-box-shadow: none;
              box-shadow: none;
    }

    .x-btn-circle-wrap:before {
      width: 172px;
      height: 43px;
      background: url(http://theme.co/x/demo/renew/8/../wp-content/themes/x/framework/img/global/btn-circle-top-small.png) center center no-repeat;
      -webkit-background-size: 172px 43px;
              background-size: 172px 43px;
    }

    .x-btn-circle-wrap:after {
      width: 190px;
      height: 43px;
      background: url(http://theme.co/x/demo/renew/8/../wp-content/themes/x/framework/img/global/btn-circle-bottom-small.png) center center no-repeat;
      -webkit-background-size: 190px 43px;
              background-size: 190px 43px;
    }

    
    .x-btn,
    .x-btn:hover,
    .button,
    .button:hover,
    [type="submit"],
    [type="submit"]:hover {
      border-width: 3px;
      text-transform: uppercase;
      background-color: transparent;
    }

    
    .x-btn, .button, [type="submit"] { border-radius: 0.25em; }
    
    button{
		border: 1px solid #ddd;
		background: #f0f0f0;
		-webkit-box-shadow: 2px 2px 2px 1px rgba(220,220,220,1);
		   -moz-box-shadow: 2px 2px 2px 1px rgba(220,220,220,1);
		        box-shadow: 2px 2px 2px 1px rgba(220,220,220,1);
		border-radius: 3px;
		transition: color 0.4s;
		color: #777;
	}
	button:hover{
		-webkit-box-shadow: inset 2px 2px 2px 1px rgba(220,220,220,1);
		   -moz-box-shadow: inset 2px 2px 2px 1px rgba(220,220,220,1);
		        box-shadow: inset 2px 2px 2px 1px rgba(220,220,220,1);
		color: #222;
	}
  </style>

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

				
				

				

				<div id="x-content-band-5" class="x-content-band border-top border-bottom man" style="background-color: #fff;">
					<div class="x-container-fluid max width">
						<span style="font-size: 150%;">Synclis > Clothing > Ante Prima</span><br/><br/>
						<button><i class="x-icon-pencil-square"></i> Create Listing</button>
					</div>
				</div>
				

				<?php
					$count = 0; $timeCountr = 1;

					while($row = mysql_fetch_row($a))
					{//BEGIN MAIN LOOP SEQUENCE----------------------------------------------------------
							echo '~( TIME:) ' . $row[14] . '  >= ' . (time()-(60*60*24*$timeCountr)) . '   ('. ($row[14] - (time()-(60*60*24*$timeCountr))) .')<br/>';
							if( !($row[14] >= (time()-(60*60*24*$timeCountr)) ) ){
								$count=0;
								echo '>>> Throw into Lists from day ' . $timeCountr . '<br/>';
								$timeCountr = (time() - $row[14]) / 24 / 60/ 60;
								echo '>>> Adjust Time Counter to -> ' . $timeCountr . ' days.<br/>';
								echo '>>> Clear Lists'  . '<br/>';
							}
							
							echo '[ID: '. $row[0] .']['. $count .']['. date("F j, Y  g:i a", $row[14]) .'] Print Next Post on day ' . $timeCountr . '<br/>';
							$count++;
						
					}//END MAIN LOOP
				?>




                              
      </div> <!-- end .entry-content -->
  </div> <!-- end .x-main -->



    
  
      
    

    
    <footer class="x-colophon bottom" role="contentinfo">
		<?php printFooter(); ?>
    </footer> <!-- end .x-colophon.bottom -->

    
  </div>

  <!--
  END #top.site
  -->


<script type='text/javascript' src='../wp-content/plugins/contact-form-7/includes/js/jquery.form.min.js?ver=3.48.0-2013.12.28'></script>
<script type='text/javascript'>
/* <![CDATA[ */
var _wpcf7 = {"loaderUrl":"http:\/\/theme.co\/x\/demo\/renew\/8\/wp-content\/plugins\/contact-form-7\/images\/ajax-loader.gif","sending":"Sending ..."};
/* ]]> */
</script>
<script type='text/javascript' src='../wp-content/plugins/contact-form-7/includes/js/scripts.js?ver=3.7'></script>
<script type='text/javascript' src='../wp-content/plugins/x-custom/x-custom.js'></script>
<script type='text/javascript' src='../wp-content/plugins/x-shortcodes/js/x-shortcodes.min.js'></script>
<script type='text/javascript' src='../wp-content/plugins/x-shortcodes/js/vendor/easing-1.3.0.min.js'></script>
<script type='text/javascript' src='../wp-content/plugins/x-shortcodes/js/vendor/flexslider-2.1.0.min.js'></script>
<script type='text/javascript' src='../wp-content/plugins/x-shortcodes/js/vendor/bootstrap/collapse-2.3.0.min.js'></script>
<script type='text/javascript' src='../wp-content/plugins/x-shortcodes/js/vendor/bootstrap/alert-2.3.0.min.js'></script>
<script type='text/javascript' src='../wp-content/plugins/x-shortcodes/js/vendor/bootstrap/tab-2.3.0.min.js'></script>
<script type='text/javascript' src='../wp-content/plugins/x-shortcodes/js/vendor/bootstrap/transition-2.3.0.min.js'></script>
<script type='text/javascript' src='../wp-content/plugins/x-shortcodes/js/vendor/bootstrap/tooltip-2.3.0.min.js'></script>
<script type='text/javascript' src='../wp-content/plugins/x-shortcodes/js/vendor/bootstrap/popover-2.3.0.min.js'></script>
<script type='text/javascript' src='../wp-content/plugins/x-shortcodes/js/vendor/waypoints-2.0.3.min.js'></script>
<script type='text/javascript' src='../wp-content/themes/x/framework/js/vendor/hoverintent-7.0.0.min.js'></script>
<script type='text/javascript' src='../wp-content/themes/x/framework/js/vendor/superfish-1.5.1.min.js'></script>
<!--[if lt IE 9]><script type="text/javascript" src="../wp-content/themes/x/framework/js/vendor/selectivizr-1.0.2.min.js"></script><![endif]-->
  

  
    
  
</body>
</html>
