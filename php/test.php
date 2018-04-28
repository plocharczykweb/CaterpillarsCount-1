<?php
require_once('orm/User.php');
$user = User::findByEmail("aaron@game103.net");
echo $user->getFullName();
echo count($user->getPendingManagerRequests());
  $managerRequests = $user->getPendingManagerRequests();
		$requestsArray = array();
		for($i = 0; $i < count($managerRequests); $i++){
			$requestArray = array(
				"id" => $managerRequests[$i]->getID(),
				"requester" => $managerRequests[$i]->getSite()->getCreator()->getFullName(),
				"siteName" => $managerRequests[$i]->getSite()->getName(),
				"siteDescription" => $managerRequests[$i]->getSite()->getDescription(),
				"siteCoordinates" => $managerRequests[$i]->getSite()->getLatitude() . ", " . $managerRequests[$i]->getSite()->getLongitude(),
				"siteRegion" => $managerRequests[$i]->getSite()->getRegion(),
				"siteOpenToPublic" => $managerRequests[$i]->getSite()->getOpenToPublic(),
			);
			
			array_push($requestsArray, $requestArray);
		}
		die("true|" . json_encode($requestsArray));
  ?>
