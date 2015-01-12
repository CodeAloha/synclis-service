
<!-- 1/ show how to user getConnectedProviders --> 
<?php 
	// try to get already authenticated provider list
	try{
		$connected_adapters_list = $hybridauth->getConnectedProviders(); 
		$facebookOn = false;
		$twitterOn = false;
		if( count( $connected_adapters_list ) ){
			
			foreach( $connected_adapters_list as $adapter_id ){
				if($adapter_id == 'Facebook') $facebookOn = true;
				if($adapter_id == 'Twitter') $twitterOn = true;
			}

		}
	}
	catch( Exception $e ){
		echo "Ooophs, we got an error: " . $e->getMessage();

		echo " Error code: " . $e->getCode();

		echo "<br /><br />Please try again.";

		echo "<hr /><h3>Trace</h3> <pre>" . $e->getTraceAsString() . "</pre>"; 
	}

	//Not Logged Into
	$available_providers_list = array( 
		"Google"    ,
		"Facebook"  ,
		"Twitter"   
	);
	?>
	<style>
		.socialhang{ position: fixed; top:135px; left:0; z-index: 9999; }
		.socialhang ul { padding:0; margin:0;}
		.socialhang ul li{ list-style: none; }
		.socialhang ul li a div{
			padding: 12px;
			opacity: 0.7;
			width: 50px; height: 50px; overflow: hidden;
			transition: opacity 0.4s, width 0.4s;
			-webkit-transition: opacity 0.4s, width 0.4s;
			-moz-transition: opacity 0.4s, width 0.4s;
			-o-transition: opacity 0.4s, width 0.4s;
			color: white;
		}
		.socialhang ul li a div:hover{opacity:1; width: 200px;}
		.socialhang img {max-width:200px; height: 30px; float:left;}
		
		.showFacebook {background: #4E6BBB;}
		.showGoogle   {background: #D63F2A;}
		.showTwitter  {background: #44A5F0;}
		
</style>
	
	<div class="socialhang">
		<ul>
	<?php
		foreach( $available_providers_list as $adapter_id ){
			if( ! $hybridauth->isConnectedWith( $adapter_id ) ){
				?>
					<li><a href="https://synclis.com/Login/QuickLogin?provider=<?php echo $adapter_id; ?>&s=<?php echo $_GET['s']; ?>&c=<?php echo $_GET['c']; ?>">  <div class="show<?php echo $adapter_id; ?>"><img src="https://synclis.com/Login/public/icon/<?php echo $adapter_id; ?>.png" /></div></a></li> 
				<?php
			}
		}
?> 
		</ul>
	</div>
