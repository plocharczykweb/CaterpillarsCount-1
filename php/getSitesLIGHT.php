<?php
	require_once("orm/Site.php");
  
	$sites = Site::findAll();
	$sitesArray = array();
	for($i = 0; $i < count($sites); $i++){
		$sitesArray[] = array(
			"ID" => $sites[$i]->getID(),
			"Name" => $sites[$i]->getName(),
		);
	}
	die("true|" . json_encode($sitesArray));
?>
