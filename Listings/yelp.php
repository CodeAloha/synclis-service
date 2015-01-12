<?php

// Enter the path that the oauth library is in relation to the php file
require_once ('../Login/hybridauth/Hybrid/thirdparty/OAuth/OAuth.php');

// For example, request business with id 'the-waterboy-sacramento'
$unsigned_url = "http://api.yelp.com/v2/search?term=". preg_replace('/(?<! )(?<!^)[A-Z]/',' $0', $_GET['c']) ."&location=Honolulu";


// Set your keys here
$consumer_key = "5GPR_xw1Wg8STp8mag4Ftw";
$consumer_secret = "8JxIshEt-4kkCVfYDKMWCWrS5-g";
$token = "QYZizIovlxYRb4l0cdWIYhrpp_eDaK-a";
$token_secret = "wJIUilRfGaMQ_8KlTU1TVprF3GA";

// Token object built using the OAuth library
$token = new OAuthToken($token, $token_secret);

// Consumer object built using the OAuth library
$consumer = new OAuthConsumer($consumer_key, $consumer_secret);

// Yelp uses HMAC SHA1 encoding
$signature_method = new OAuthSignatureMethod_HMAC_SHA1();

// Build OAuth Request using the OAuth PHP library. Uses the consumer and token object created above.
$oauthrequest = OAuthRequest::from_consumer_and_token($consumer, $token, 'GET', $unsigned_url);

// Sign the request
$oauthrequest->sign_request($signature_method, $consumer, $token);

// Get the signed URL
$signed_url = $oauthrequest->to_url();

// Send Yelp API Call
$ch = curl_init($signed_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, 0);
$data = curl_exec($ch); // Yelp response
curl_close($ch);

// Handle Yelp response data
$response = json_decode($data,true);

for( $a = 0; $a < sizeof($response['businesses']); $a++ ){
	if($response['businesses'][$a]['is_claimed'] && !$response['businesses'][$a]['is_closed'])
	?>
	<div class="item">
		<div style="position:absolute; top:0;right:6px; color: #eee;"><i class="x-icon-comments-o"></i>&nbsp;<?php echo $response['businesses'][$a]['review_count']; ?></span></div>
		<a href="<?php echo $response['businesses'][$a]['url']; ?>"><div class="synclis_bgimg"><img src="<?php echo $response['businesses'][$a]['snippet_image_url']; ?>" onerror="this.src='../no-photo.png';" /></div></a>
		<div style = "padding: 0 8px 8px 8px; font-size: 90%;">
			<h4 style="font-weight:normal; font-size: 110%; padding:0;"><img src="http://s3-media1.ak.yelpcdn.com/assets/2/www/img/55e2efe681ed/developers/yelp_logo_50x25.png" style="width: 50px; height:25px; margin-right: 6px;"/><?php echo $response['businesses'][$a]['name']; ?></h4>
			<div style = "background: #f7f7f7; padding: 5px;  margin-bottom: 8px;">
			<img src="<?php echo $response['businesses'][$a]['rating_img_url_large']; ?>" style="width: 111px; height: 20px;" /><br/><br/>
			<i class="x-icon-users"></i> <?php echo $response['businesses'][$a]['name']; ?><br/>
			<i class="x-icon-map-marker"></i> <?php echo $response['businesses'][$a]['location']['city']; ?> <?php echo $response['businesses'][$a]['location']['state_code']; ?><br/>
			</div>
			<p style="font-size: 90%;"><?php echo strip_tags ( $response['businesses'][$a]['snippet_text'] ) ?></p>
		</div>
		
		<div style = "width: 100%;">
			<a href="<?php echo $response['businesses'][$a]['url']; ?>"><div class="simplex not-loggedin-listing" style="border-bottom-left-radius: 4px;"><i class="x-icon-search"></i> Preview</div></a>
		</div>
	</div>

	<?
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

?>