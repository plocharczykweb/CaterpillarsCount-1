<?php
	require_once('orm/resources/Keychain.php');
	require_once('orm/User.php');
  
	$email = $_GET["email"];
	$salt = $_GET["salt"];
  
  	$user = User::findBySignInKey($email, $salt);
	if(is_object($user) && get_class($user) == "User"){
		$privacySettings = array(
			"HiddenFromLeaderboards" => $user->getHiddenFromLeaderboards()
		);
    		die("true|" . json_encode($privacySettings));
  	}
	die("false|Your log in dissolved. Maybe you logged in on another device.");
?>
