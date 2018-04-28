<?php
	header('Access-Control-Allow-Origin: *');
	
	require_once('orm/User.php');
	
	$email = $_GET["email"];
	$salt = $_GET["salt"];
	
	$user = User::findBySignInKey($email, $salt);
	if(is_object($user) && get_class($user) == "User"){
		$managerRequests = $user->getPendingManagerRequests();
		$requestsArray = array();
		for($i = 0; $i < count($managerRequests); $i++){
			$requestsArray[] = array(
				"id" => $managerRequests[$i]->getID(),
				"requester" => $managerRequests[$i]->getSite()->getCreator()->getFullName(),
				"siteName" => $managerRequests[$i]->getSite()->getName(),
				"siteDescription" => $managerRequests[$i]->getSite()->getDescription(),
				"siteCoordinates" => $managerRequests[$i]->getSite()->getLatitude() . ", " . $managerRequests[$i]->getSite()->getLatitude(),
				"siteRegion" => $managerRequests[$i]->getSite()->getRegion(),
				"siteOpenToPublic" => $managerRequests[$i]->getSite()->getOpenToPublic(),
			);
		}
		die("true|" . json_encode($requestsArray));
	}
	die("false|Your log in dissolved. Maybe you logged in on another device.");
?>
