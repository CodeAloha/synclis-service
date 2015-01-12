<?php
	session_start(); 

	// change the following paths if necessary 
	$config = dirname(__FILE__) . '/hybridauth/config.php';
	require_once( "hybridauth/Hybrid/Auth.php" );

	if( $_GET["provider"] ):
		try{
			// create an instance for Hybridauth with the configuration file path as parameter
			$hybridauth = new Hybrid_Auth( $config );
 
			// set selected provider name 
			$provider = @ trim( strip_tags( $_GET["provider"] ) );

			// try to authenticate the selected $provider
			$adapter = $hybridauth->authenticate( $provider );

			// if okey, we will redirect to user profile page 
			$hybridauth->redirect( "https://synclis.com/CreateListing/{$_GET['s']}/{$_GET['c']}" );
			?>
			<script>window.location="https://synclis.com/CreateListing/<?php echo $_GET['s']; ?>/<?php echo $_GET['c']; ?>";</script>
			<?php
		}
		catch( Exception $e ){
			// In case we have errors 6 or 7, then we have to use Hybrid_Provider_Adapter::logout() to 
			// let hybridauth forget all about the user so we can try to authenticate again.

			// Display the recived error, 
			// to know more please refer to Exceptions handling section on the userguide
			switch( $e->getCode() ){ 
				case 0 : $error = "Unspecified error."; break;
				case 1 : $error = "Hybriauth configuration error."; break;
				case 2 : $error = "Provider not properly configured."; break;
				case 3 : $error = "Unknown or disabled provider."; break;
				case 4 : $error = "Missing provider application credentials."; break;
				case 5 : $error = "Authentication failed. The user has canceled the authentication or the provider refused the connection."; break;
				case 6 : $error = "User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again."; 
					     $adapter->logout(); 
					     break;
				case 7 : $error = "User not connected to the provider."; 
					     $adapter->logout(); 
					     break;
			} 

			// well, basically your should not display this to the end user, just give him a hint and move on..
			$error .= $e->getMessage() . " TRACE: " . $e->getTraceAsString();
		}
    endif;
	
?>

