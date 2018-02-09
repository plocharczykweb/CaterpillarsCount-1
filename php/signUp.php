<?php
	header('Access-Control-Allow-Origin: *');
	
	require_once("orm/User.php");
	$firstName = $_GET["firstName"];
	$lastName = $_GET["lastName"];
	$email = $_GET["email"];
	$password = $_GET["password"];
	
	$newUser = User::create($firstName, $lastName, $email, $password);
	if(is_object($newUser) && get_class($newUser) == "User"){
		$userid = intval($newUser->getID());
		User::sendEmailVerificationCodeToUser($userid);
		die("success");
	}
	die((string)$newUser);
?>
