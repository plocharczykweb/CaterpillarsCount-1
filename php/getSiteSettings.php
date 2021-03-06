<?php
	header('Access-Control-Allow-Origin: *');

	require_once('orm/User.php');
	require_once('orm/Site.php');

	$siteID = $_GET["siteID"];
	$email = $_GET["email"];
	$salt = $_GET["salt"];

	$user = User::findBySignInKey($email, $salt);
	if(is_object($user) && get_class($user) == "User"){
		$sites = $user->getSites();
		$site = Site::findByID($siteID);
		if(is_object($site) && get_class($site) == "Site" && in_array($site, $sites)){
			$siteArray = array(
				"name" => $site->getName(),
				"description" => $site->getDescription(),
				"openToPublic" => $site->getOpenToPublic(),
				"active" => $site->getActive(),
			);
			die("true|" . json_encode($siteArray));
		}
		die("false|You do not have permission to edit this site.");
	}
	die("false|Your log in dissolved. Maybe you logged in on another device.");
?>
