<?php
  	header('Access-Control-Allow-Origin: *');
	
	require_once('orm/User.php');
	require_once('orm/Site.php');
	require_once('orm/ManagerRequest.php');
	
  	$siteID = $_GET["siteID"];
	$email = $_GET["email"];
	$salt = $_GET["salt"];
	
	$user = User::findBySignInKey($email, $salt);
	if(is_object($user) && get_class($user) == "User"){
    		$site = Site::findByID($siteID);
    		if(is_object($site) && get_class($site) == "Site" && $site->hasCreatorPermissions($user)){
			$managerRequests = ManagerRequest::findManagerRequestsBySite($site);
			$mangers = array();
			for($i = 0; $i < count($managerRequests); $i++){
				$managers[] = array(
					"managerID" => $managerRequests[$i]->getManager()->getID(),
					"fullName" => $managerRequests[$i]->getManager()->getFullName(),
					"email" => $managerRequests[$i]->getManager()->getEmail(),
					"hasCompleteAuthority" => $managerRequests[$i]->getHasCompleteAuthority(),
					"status" => $managerRequests[$i]->getStatus(),
				);
			}
      			die("true|" . json_encode($managers));
    		}
    		die("false|You do not have permission to oversee this site's management.");
  	}
  	die("false|Your log in dissolved. Maybe you logged in on another device.");
?>
