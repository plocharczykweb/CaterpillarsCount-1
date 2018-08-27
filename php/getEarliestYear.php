<?php
	require_once('orm/resources/Keychain.php');

	$siteID = $_GET["siteID"];
	$extraSQL = "";
	if(isset($siteID)){
		$extraSQL = " JOIN Plant ON Survey.PlantFK=Plant.ID WHERE Plant.SiteFK='" . intval($siteID) . "'";
	}
	
	$dbconn = (new Keychain)->getDatabaseConnection();
  
	$query = mysqli_query($dbconn, "SELECT YEAR(LocalDate) AS EarliestYear FROM Survey" . $extraSQL . " ORDER BY LocalDate ASC LIMIT 1");
	die(mysqli_fetch_assoc($query)["EarliestYear"]);
?>
