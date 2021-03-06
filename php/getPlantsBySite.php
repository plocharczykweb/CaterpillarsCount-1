<?php
	header('Access-Control-Allow-Origin: *');
	
	require_once('orm/User.php');
	require_once('orm/Site.php');
	
	$email = $_GET["email"];
	$salt = $_GET["salt"];
	$siteID = $_GET["siteID"];
	
	$user = User::findBySignInKey($email, $salt);
	if(is_object($user) && get_class($user) == "User"){
	    $site = Site::findByID($siteID);
	    if(is_object($site) && in_array($site, $user->getSites())){
	      $plants = $site->getPlants();
	      $circles = array();
	      for($i = 0; $i < ceil(count($plants)/5); $i++){
		$circles[$i] = array(($i + 1), array());
	      }
	      for($i = 0; $i < count($plants); $i++){
		$circles[($plants[$i]->getCircle() - 1)][1][] = array($plants[$i]->getOrientation(), $plants[$i]->getCode(), $plants[$i]->getSpecies());
	      }
	      die("true|" . json_encode(array($site->getName() . " (" . $site->getRegion() . ")", $circles)));
	    }
	    die("false|You do not have access to this site.");
	}
	die("false|Your log in dissolved. Maybe you logged in on another device.");
?>
