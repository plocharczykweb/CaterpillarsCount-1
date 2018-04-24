<?php
	header('Access-Control-Allow-Origin: *');
	
	require_once('orm/User.php');
	
	$email = $_GET["email"];
	$salt = $_GET["salt"];
	
	$user = User::findBySignInKey($email, $salt);
	if(is_object($user) && get_class($user) == "User"){
		die("true|" . json_encode($user->getManagerRequests()));
	}
	die("false|Your log in dissolved. Maybe you logged in on another device.");
?>
