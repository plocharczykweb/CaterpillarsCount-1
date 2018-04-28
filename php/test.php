<?php
require_once('orm/User.php');
require_once('orm/Site.php');
require_once('orm/ManagerRequest.php');
require_once('orm/resources/Keychain.php');

$user = User::findByEmail("aaron@game103.net");
echo $user->getFullName();
$dbconn = (new Keychain)->getDatabaseConnection();
		$query = mysqli_query($dbconn, "SELECT * FROM `ManagerRequest` WHERE `UserFKOfManager`='" . $user->getID() . "' AND `Status`='Pending'");
		mysqli_close($dbconn);
		
		$managerRequestsArray = array();
		while($managerRequestRow = mysqli_fetch_assoc($query)){
			$id = $managerRequestRow["ID"];
			$manager = User::findByID($managerRequestRow["UserFKOfManager"]);
			$site = Site::findByID($managerRequestRow["SiteFK"]);
			$status = $managerRequestRow["Status"];
			$managerRequest = new ManagerRequest($id, $manager, $site, $status);
			
			array_push($managerRequestsArray, "");
		}
		echo count($managerRequestsArray);
  ?>
