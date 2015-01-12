<?php
	// config and whatnot
    $config = dirname(__FILE__) . '/hybridauth/config.php';
    require_once( "hybridauth/Hybrid/Auth.php" );

	try{
		$hybridauth = new Hybrid_Auth( $config );

		// logout the user from $provider
		$hybridauth->logoutAllProviders(); 

		setcookie("SYNCLIS_TOKEN", '', 1, "/");
		setcookie("SYNCLIS_TOKEN", '', 1, "/Sections");
		setcookie("SYNCLIS_TOKEN", '', 1, "/Login");
		setcookie("SYNCLIS_TOKEN", '', 1, "/Profile");
		setcookie("SYNCLIS_TOKEN", '', 1, "/Listings");
		setcookie("SYNCLIS_TOKEN", '', 1, "/ViewListing");
		setcookie("SYNCLIS_TOKEN", '', 1, "/CreateListing");
		setcookie("SYNCLIS_TOKEN", '', 1, "/MyListings");
		$hybridauth->redirect( "https://synclis.com/Login" );
    }
	catch( Exception $e ){
		mysqli_query($conn,"INSERT INTO `ERROR_REPORTING` (`ID`,`USER`, `DESCRIPTION`, `RESPONSE`,`TIMESTAMP`)VALUES (NULL, '". $request[email] ."', '[{$_SERVER['PHP_SELF']}] [GET] Unable to create a user profile.', '". $e->getTraceAsString() ."'," . time() . ");");
		echo 'There was a problem in logging you out of your accounts securely. This was automatically reported by friendly robots.';
	}
?>