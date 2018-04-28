<?php
  	header('Access-Control-Allow-Origin: *');
	
	require_once('orm/User.php');
	require_once('orm/Site.php');
	require_once('orm/ManagerRequest.php');
	
  	$siteID = $_GET["siteID"];
  	$managerID = $_GET["managerID"];
	$email = $_GET["email"];
	$salt = $_GET["salt"];
	
	$user = User::findBySignInKey($email, $salt);
	if(is_object($user) && get_class($user) == "User"){
    		$site = Site::findByID($siteID);
    		if(is_object($site) && get_class($site) == "Site" && $user->getID() == $site->getCreator()->getID()){
      			$manager = User::findByID($managerID);
      			if(is_object($manager) && get_class($manager) == "User"){
				if($manager == $user){
					$managerRequest = ManagerRequest::findByManagerAndSite($manager, $site);
					if(get_class($managerRequest) == "ManagerRequest"){
						$managerRequest->permanentDelete();
						die("true|");
					}
					die("false|There is no need for termination here. " . $manager->getFullName() . " is not a manager of this site anyway.");
				}
				die("false|You are the site creator, not a manager. You cannot terminate yourself.");
			}
      			die("false|We could not locate that manager's account. Please reload the page and try again.");
    		}
    		die("false|You did not create this site, so you cannot oversee its management.");
  	}
  	die("false|Your log in dissolved. Maybe you logged in on another device.");
?>
