<?php
	header('Access-Control-Allow-Origin: *');
	
	require_once('orm/User.php');
	require_once('orm/Site.php');
	
	$email = $_GET["email"];
	$salt = $_GET["salt"];
	
	$user = User::findBySignInKey($email, $salt);
	if(is_object($user) && get_class($user) == "User"){
		$sites = $user->getSites();
		$siteIDs = array();
		for($i = 0; $i < count($sites); $i++){
			$siteIDs[] = $sites[$i]->getID();
		}
		$query = mysqli_query($dbconn, "SELECT Site.ID FROM `Survey` JOIN `Plant` ON Survey.PlantFK = Plant.ID JOIN `Site` ON Plant.SiteFK=Site.ID WHERE Survey.UserFKOfObserver='" . $user->getID() . "'");
		while($siteRow = mysqli_fetch_assoc($query)){
			$id = $siteRow["ID"];
			if(!in_array($id, $siteIDs)){
				$siteIDs[] = $id;
				$sites[] = Site::findByID($id);
			}
		}
		$sitesArray = array();
		for($i = 0; $i < count($sites); $i++){
			$sitesArray[$i] = array(
				"id" => $sites[$i]->getID(),
				"name" => $sites[$i]->getName(),
				"region" => $sites[$i]->getRegion(),
			);
		}
		die("true|" . json_encode($sitesArray));
	}
	die("false|Your log in dissolved. Maybe you logged in on another device.");
?>
