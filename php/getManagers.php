<?php
  	header('Access-Control-Allow-Origin: *');
	
	require_once('orm/User.php');
	require_once('orm/Site.php');
	
  	$siteID = $_GET["siteID"];
	$email = $_GET["email"];
	$salt = $_GET["salt"];
	
	$user = User::findBySignInKey($email, $salt);
	if(is_object($user) && get_class($user) == "User"){
    		$site = Site::findByID($siteID);
    		if(is_object($site) && get_class($site) == "Site" && $user->getID() == $site->getCreator()->getID()){
      			die("true|" . json_encode($site->getManagersArray()));
    		}
    		die("false|You did not create this site, so you cannot oversee its management.");
  	}
  	die("false|Your log in dissolved. Maybe you logged in on another device.");
?>
