<?php
	require_once("orm/User.php");
	require_once("orm/Site.php");

	$email = $_GET["email"];
	$salt = $_GET["salt"];
	$siteID = $_GET["siteID"];
	
	$user = User::findBySignInKey($email, $salt);
	if(is_object($user) && get_class($user) == "User"){
    		$site = Site::findByID($siteID);
		if(is_object($site) && get_class($site) == "Site" && $site->sendPrintTagsEmailTo($user)){
      			die("true|");
    		}
    		die("false|You do not have permission to request tags for this site.");
  	}
	die("false|Your log in dissolved. Maybe you logged in on another device.");
?>
