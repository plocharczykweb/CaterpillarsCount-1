<?php
	require_once("orm/Site.php");
	require_once('orm/resources/Keychain.php');

	$sites = Site::findAll();
	$sitesArray = array();
	for($i = 0; $i < count($sites); $i++){
		$sitesArray[strval($sites[$i]->getID())] = array(
			"ID" => $sites[$i]->getID(),
			"Name" => $sites[$i]->getName(),
			"Coordinates" => $sites[$i]->getLatitude() . "," . $sites[$i]->getLongitude(),
			"Description" => $sites[$i]->getDescription(),
		);
	}

	$dbconn = (new Keychain)->getDatabaseConnection();
	$query = mysqli_query($dbconn, "SELECT Plant.SiteFK, COUNT(*) AS SurveyCount FROM Survey JOIN Plant ON Plant.ID=Survey.PlantFK GROUP BY Plant.SiteFK");
	while($row = mysqli_fetch_assoc($query)){
		$sitesArray[strval($row["SiteFK"])]["SurveyCount"] = intval($row["SurveyCount"]);
	}

	$query = mysqli_query($dbconn, "SELECT Plant.SiteFK, COUNT(DISTINCT Survey.UserFKOfObserver) AS UserCount FROM `Survey` JOIN Plant ON Survey.PlantFK=Plant.ID GROUP BY Plant.SiteFK");
	while($row = mysqli_fetch_assoc($query)){
		$sitesArray[strval($row["SiteFK"])]["UserCount"] = intval($row["UserCount"]);
	}

	$query = mysqli_query($dbconn, "SELECT Plant.SiteFK, COUNT(DISTINCT ArthropodSighting.Group) AS ArthropodGroupCount FROM `Survey` JOIN Plant ON Survey.PlantFK=Plant.ID JOIN ArthropodSighting ON Survey.ID=ArthropodSighting.SurveyFK GROUP BY Plant.SiteFK");
	while($row = mysqli_fetch_assoc($query)){
		$sitesArray[strval($row["SiteFK"])]["ArthropodGroupCount"] = intval($row["ArthropodGroupCount"]);
	}

	$query = mysqli_query($dbconn, "SELECT Plant.SiteFK, COUNT(*) AS ArthropodCount FROM `Survey` JOIN Plant ON Survey.PlantFK=Plant.ID JOIN ArthropodSighting ON Survey.ID=ArthropodSighting.SurveyFK GROUP BY Plant.SiteFK");
	while($row = mysqli_fetch_assoc($query)){
		$sitesArray[strval($row["SiteFK"])]["ArthropodCount"] = intval($row["ArthropodCount"]);
	}

	$query = mysqli_query($dbconn, "SELECT Plant.SiteFK, COUNT(*) AS CaterpillarCount FROM `Survey` JOIN Plant ON Survey.PlantFK=Plant.ID JOIN ArthropodSighting ON Survey.ID=ArthropodSighting.SurveyFK WHERE ArthropodSighting.Group='caterpillar' GROUP BY Plant.SiteFK");
	while($row = mysqli_fetch_assoc($query)){
		$sitesArray[strval($row["SiteFK"])]["CaterpillarCount"] = intval($row["CaterpillarCount"]);
	}

	$query = mysqli_query($dbconn, "SELECT Plant.SiteFK, MAX(STR_TO_DATE(CONCAT(Survey.LocalDate, ' ', Survey.LocalTime), '%Y-%m-%d %T')) AS MostRecentDateTime FROM `Survey` JOIN Plant ON Survey.PlantFK=Plant.ID GROUP BY Plant.SiteFK");
	while($row = mysqli_fetch_assoc($query)){
		$sitesArray[strval($row["SiteFK"])]["MostRecentDateTime"] = $row["MostRecentDateTime"];
	}

	for($i = 0; $i < count($sites); $i++){
		if(!array_key_exists("SurveyCount", $sitesArray[strval($sites[$i]->getID())])){
			$sitesArray[strval($sites[$i]->getID())]["SurveyCount"] = 0;
		}
		if(!array_key_exists("UserCount", $sitesArray[strval($sites[$i]->getID())])){
			$sitesArray[strval($sites[$i]->getID())]["UserCount"] = 0;
		}
		if(!array_key_exists("ArthropodGroupCount", $sitesArray[strval($sites[$i]->getID())])){
			$sitesArray[strval($sites[$i]->getID())]["ArthropodGroupCount"] = 0;
		}
		if(!array_key_exists("ArthropodCount", $sitesArray[strval($sites[$i]->getID())])){
			$sitesArray[strval($sites[$i]->getID())]["ArthropodCount"] = 0;
		}
		if(!array_key_exists("CaterpillarCount", $sitesArray[strval($sites[$i]->getID())])){
			$sitesArray[strval($sites[$i]->getID())]["CaterpillarCount"] = 0;
		}
		if(!array_key_exists("MostRecentDateTime", $sitesArray[strval($sites[$i]->getID())])){
			$sitesArray[strval($sites[$i]->getID())]["MostRecentDateTime"] = "Never";
		}
	}
	die(json_encode(array_values($sitesArray)));
?>
