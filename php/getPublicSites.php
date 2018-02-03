<?php
	require_once("orm/Site.php");
	
	$publicSites = Site::findAllPublicSites();
	$publicSitesArray = array();
	for($i = 0; $i < count($publicSites); $i++){
		$publicSitesArray[$i] = array(
			"creatorEmail" => $publicSites[$i]->getCreator()->getEmail(),
			"siteName" => $publicSites[$i]->getName(),
			"description" => $publicSites[$i]->getDescription(),
			"location" => $publicSites[$i]->getLocation(),
			"plantCount" => count($publicSites[$i]->getPlants()),
		);
	}
	die(json_encode($publicSitesArray));
?>
