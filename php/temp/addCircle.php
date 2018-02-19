<?php
	require_once('../orm/User.php');
	require_once('../orm/Site.php');
	
	$email = $_GET["email"];
	$salt = $_GET["salt"];
	$siteID = $_GET["siteID"];
	
	$user = User::findBySignInKey($email, $salt);
	if(is_object($user) && get_class($user) == "User" && $user->getID() == 25){
		$site = Site::findByID($siteID);
		if(is_object($site) && get_class($site) == "Site"){
			$site->addCircle();
			die("Added circle.");
		}
		die("ID does not correpond to a site.");
	}
	die("You are not logged in as a developer.");
?>
