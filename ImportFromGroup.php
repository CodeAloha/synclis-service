<?php
	/*Begin Get Group Feed From Facebook.*/
    $config = dirname(__FILE__) . '/Login/hybridauth/config.php';
    require_once( "Login/hybridauth/Hybrid/Auth.php" );

	// initialise hybridauth
	$hybridauth = new Hybrid_Auth( $config );

	$provider = @ "Facebook";
?>


<?php

	try{
		$adapter = $hybridauth->getAdapter( $provider );

		// ask facebook api for the users accounts
		
		$accounts = $adapter->api()->api('/290960160920739/feed');
		
		for($a = 0; $a < sizeof($accounts['data']); $a++ ){
				
				$values = explode(".", $accounts['data'][$a]['message']);
				$values = substr( preg_replace('/[^A-Za-z0-9! .?]/', '',$values[0]), 0, 60  );
				// Get cURL resource
				$curl = curl_init();
				// Set some options - we are passing in a useragent too here
				curl_setopt_array($curl, array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL => 'https://synclis.com/api/sys/listings',
					CURLOPT_POST => 1,
					CURLOPT_POSTFIELDS => array(
						'title' => $values,
						'description' => $accounts['data'][$a]['message'],
						'cat-id' => '1',
						'image' => $accounts['data'][$a]['picture'],
						'country' => 'United States',
						'providence' => 'Ewa',
						'city' => 'Honolulu',
						'lat' => 21.341267,
						'lng' => -157.961371,
						'show_map' => 1,
						'vid' => 'o8iqxzaQ_D0',
						'type' => 'market',
						'email' => 'ChrisAnonymously@gmail.com'
					)
				));
		
				// Send the request & save response to $resp
				$resp = curl_exec($curl);
				echo $resp . '<br/>';
				// Close request to clear up some resources
				curl_close($curl);
		}
		
/*
		var params = "title="+ encodeURIComponent(document.getElementById("synlis-title").value) +
			  "&description="+ encodeURIComponent(desc) +
			         "&type=<?php echo $cat[0]; ?>" +
				  "&cat-id="+ "<?php echo $cat[1]; ?>" +
				 "&country="+ geoloc[0] +
			  "&providence="+ geoloc[2] +
			        "&city="+ geoloc[1] +
				  "&image=" + mainImage +
				    "&lat=" + marker.getPosition().lat() +
					"&lng=" + marker.getPosition().lng() +
					sessionValue +
					 "&id=<?php echo $uniqkey; ?>" +
					"&vid=" + currentVideoId +
			  "&ap_twitter=" + twitterAutoPost +
			 "&ap_facebook=" + facebookAutoPost +
		  "&facebook_group=" + facebook_gid +
			   "&json_data=" + parseJSONValue() +
		        "&show_map=" + mapOn;
*/
	
	}catch( Exception $e ){
		echo $e;
	}
	include('social_quicklogin.php');
	
?>