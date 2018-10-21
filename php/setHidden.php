<?php
	require_once('orm/resources/Keychain.php');
	require_once('orm/User.php');
  
	$email = $_GET["email"];
	$salt = $_GET["salt"];
	$newValue = filter_var($_GET["newValue"], FILTER_VALIDATE_BOOLEAN);
  
  	$user = User::findBySignInKey($email, $salt);
	if(is_object($user) && get_class($user) == "User"){
    		$user->setHidden($newValue);
    		die("true|" . ($user->getHidden() ? 'true' : 'false'));
  	}
	die("false|Your log in dissolved. Maybe you logged in on another device.");
?>
