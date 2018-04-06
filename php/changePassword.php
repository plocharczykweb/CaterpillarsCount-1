<?php
	header('Access-Control-Allow-Origin: *');
	
	require_once('orm/User.php');
	
	$currentPassword = rawurldecode($_GET["currentPassword"]);
	$newPassword = rawurldecode($_GET["newPassword"]);
	$email = rawurldecode($_GET["email"]);
	
	$user = User::findByEmail($email);
	if(is_object($user) && get_class($user) == "User"){
		if($user->passwordIsCorrect($currentPassword)){
			if($user->setPassword($newPassword)){
				$newSalt = $user->signIn($newPassword);
				die($newSalt);
			}
			die("false|New password must be at least 8 characters with no spaces.");
		}
		die("false|Current password is incorrect.");
	}
	die("false|Your log in dissolved. Maybe you logged in on another device.");
?>
