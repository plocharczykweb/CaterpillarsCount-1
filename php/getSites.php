<?php
	require_once("orm/Site.php");
	require_once('orm/resources/Keychain.php');
	
	$dbconn = (new Keychain)->getDatabaseConnection();

	$includeWetLeaves = filter_var($_GET["includeWetLeaves"], FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
	$occurrenceInsteadOfDensity = filter_var($_GET["occurrenceInsteadOfDensity"], FILTER_VALIDATE_BOOLEAN);
	$monthStart = sprintf('%02d', intval($_GET["monthStart"]));
	$monthEnd = sprintf('%02d', intval($_GET["monthEnd"]));
	$yearStart = intval($_GET["yearStart"]);
	$yearEnd = intval($_GET["yearEnd"]);
	$arthropod = mysqli_real_escape_string($dbconn, rawurldecode($_GET["arthropod"]));//% if all
	$minSize = intval($_GET["minSize"]);
	$plantSpecies = mysqli_real_escape_string($dbconn, rawurldecode($_GET["plantSpecies"]));//% if all

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

	$query = mysqli_query($dbconn, "SELECT Plant.SiteFK, COUNT(*) AS SurveyCount FROM Survey JOIN Plant ON Plant.ID=Survey.PlantFK GROUP BY Plant.SiteFK");
	while($row = mysqli_fetch_assoc($query)){
		$sitesArray[strval($row["SiteFK"])]["SurveyCount"] = intval($row["SurveyCount"]);
	}
	
	$query = mysqli_query($dbconn, "SELECT Plant.SiteFK, COUNT(*) AS FilteredSurveyCount FROM Survey JOIN Plant ON Plant.ID=Survey.PlantFK WHERE MONTH(Survey.LocalDate)>=$monthStart AND MONTH(Survey.LocalDate)<=$monthEnd AND YEAR(Survey.LocalDate)>=$yearStart AND YEAR(Survey.LocalDate)<=$yearEnd AND (Plant.Species LIKE '$plantSpecies' OR (Plant.Species='N/A' AND Survey.PlantSpecies LIKE '$plantSpecies')) AND Survey.WetLeaves IN (0, $includeWetLeaves) GROUP BY Plant.SiteFK");
	while($row = mysqli_fetch_assoc($query)){
		$sitesArray[strval($row["SiteFK"])]["FilteredSurveyCount"] = intval($row["FilteredSurveyCount"]);
	}

	$query = mysqli_query($dbconn, "SELECT Plant.SiteFK, COUNT(DISTINCT Survey.UserFKOfObserver) AS UserCount FROM `Survey` JOIN Plant ON Survey.PlantFK=Plant.ID GROUP BY Plant.SiteFK");
	while($row = mysqli_fetch_assoc($query)){
		$sitesArray[strval($row["SiteFK"])]["UserCount"] = intval($row["UserCount"]);
	}

	$query = mysqli_query($dbconn, "SELECT Plant.SiteFK, COUNT(DISTINCT ArthropodSighting.Group) AS ArthropodGroupCount FROM `Survey` JOIN Plant ON Survey.PlantFK=Plant.ID JOIN ArthropodSighting ON Survey.ID=ArthropodSighting.SurveyFK GROUP BY Plant.SiteFK");
	while($row = mysqli_fetch_assoc($query)){
		$sitesArray[strval($row["SiteFK"])]["ArthropodGroupCount"] = intval($row["ArthropodGroupCount"]);
	}

	$query = mysqli_query($dbconn, "SELECT Plant.SiteFK, SUM(ArthropodSighting.Quantity) AS ArthropodCount FROM `Survey` JOIN Plant ON Survey.PlantFK=Plant.ID JOIN ArthropodSighting ON Survey.ID=ArthropodSighting.SurveyFK GROUP BY Plant.SiteFK");
	while($row = mysqli_fetch_assoc($query)){
		$sitesArray[strval($row["SiteFK"])]["ArthropodCount"] = intval($row["ArthropodCount"]);
	}

	$query = mysqli_query($dbconn, "SELECT Plant.SiteFK, SUM(ArthropodSighting.Quantity) AS CaterpillarCount FROM `Survey` JOIN Plant ON Survey.PlantFK=Plant.ID JOIN ArthropodSighting ON Survey.ID=ArthropodSighting.SurveyFK WHERE ArthropodSighting.Group='caterpillar' GROUP BY Plant.SiteFK");
	while($row = mysqli_fetch_assoc($query)){
		$sitesArray[strval($row["SiteFK"])]["CaterpillarCount"] = intval($row["CaterpillarCount"]);
	}

	$query = mysqli_query($dbconn, "SELECT Plant.SiteFK, COUNT(DISTINCT ArthropodSighting.SurveyFK) AS Caterpillars FROM ArthropodSighting JOIN Survey ON ArthropodSighting.SurveyFK=Survey.ID JOIN Plant ON Survey.PlantFK=Plant.ID WHERE ArthropodSighting.Group='caterpillar' GROUP BY Plant.SiteFK");
	while($row = mysqli_fetch_assoc($query)){
		$sitesArray[strval($row["SiteFK"])]["Caterpillars"] = round(((floatval($row["Caterpillars"]) / floatval($sitesArray[strval($row["SiteFK"])]["SurveyCount"])) * 100), 2) . "%";
	}

	$query = mysqli_query($dbconn, "SELECT Plant.SiteFK, MAX(STR_TO_DATE(CONCAT(Survey.LocalDate, ' ', Survey.LocalTime), '%Y-%m-%d %T')) AS MostRecentDateTime FROM `Survey` JOIN Plant ON Survey.PlantFK=Plant.ID GROUP BY Plant.SiteFK");
	while($row = mysqli_fetch_assoc($query)){
		$sitesArray[strval($row["SiteFK"])]["MostRecentDateTime"] = $row["MostRecentDateTime"];
	}

	if($occurrenceInsteadOfDensity){
		$query = mysqli_query($dbconn, "SELECT Plant.SiteFK, COUNT(DISTINCT ArthropodSighting.SurveyFK) AS Arthropods FROM ArthropodSighting JOIN Survey ON ArthropodSighting.SurveyFK=Survey.ID JOIN Plant ON Survey.PlantFK=Plant.ID WHERE MONTH(Survey.LocalDate)>=$monthStart AND MONTH(Survey.LocalDate)<=$monthEnd AND YEAR(Survey.LocalDate)>=$yearStart AND YEAR(Survey.LocalDate)<=$yearEnd AND ArthropodSighting.Group LIKE '$arthropod' AND (Plant.Species LIKE '$plantSpecies' OR (Plant.Species='N/A' AND Survey.PlantSpecies LIKE '$plantSpecies')) AND Survey.WetLeaves IN (0, $includeWetLeaves) AND ArthropodSighting.Length>=$minSize GROUP BY Plant.SiteFK");
		while($row = mysqli_fetch_assoc($query)){
			$sitesArray[strval($row["SiteFK"])]["Weight"] = round(((floatval($row["Arthropods"]) / floatval($sitesArray[strval($row["SiteFK"])]["SurveyCount"])) * 100), 2);// . "%";
		}
	}
	else{
		$query = mysqli_query($dbconn, "SELECT Plant.SiteFK, SUM(ArthropodSighting.Quantity) AS Arthropods FROM `Survey` JOIN Plant ON Survey.PlantFK=Plant.ID JOIN ArthropodSighting ON Survey.ID=ArthropodSighting.SurveyFK WHERE MONTH(Survey.LocalDate)>=$monthStart AND MONTH(Survey.LocalDate)<=$monthEnd AND YEAR(Survey.LocalDate)>=$yearStart AND YEAR(Survey.LocalDate)<=$yearEnd AND ArthropodSighting.Group LIKE '$arthropod' AND (Plant.Species LIKE '$plantSpecies' OR (Plant.Species='N/A' AND Survey.PlantSpecies LIKE '$plantSpecies')) AND Survey.WetLeaves IN (0, $includeWetLeaves) AND ArthropodSighting.Length>=$minSize GROUP BY Plant.SiteFK");
		while($row = mysqli_fetch_assoc($query)){
			$sitesArray[strval($row["SiteFK"])]["Weight"] = round(((floatval($row["Arthropods"]) / floatval($sitesArray[strval($row["SiteFK"])]["SurveyCount"])) * 100), 2);// . "%";
		}
	}

	for($i = 0; $i < count($sites); $i++){
		if(!array_key_exists("SurveyCount", $sitesArray[strval($sites[$i]->getID())])){
			$sitesArray[strval($sites[$i]->getID())]["SurveyCount"] = 0;
		}
		if(!array_key_exists("FilteredSurveyCount", $sitesArray[strval($sites[$i]->getID())])){
			$sitesArray[strval($sites[$i]->getID())]["FilteredSurveyCount"] = 0;
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
		if(!array_key_exists("Caterpillars", $sitesArray[strval($sites[$i]->getID())])){
			$sitesArray[strval($sites[$i]->getID())]["Caterpillars"] = "0%";
		}
		if(!array_key_exists("MostRecentDateTime", $sitesArray[strval($sites[$i]->getID())])){
			$sitesArray[strval($sites[$i]->getID())]["MostRecentDateTime"] = "Never";
		}
		if(!array_key_exists("Weight", $sitesArray[strval($sites[$i]->getID())])){
			$sitesArray[strval($sites[$i]->getID())]["Weight"] = 0;
		}
	}
	die(json_encode(array_values($sitesArray)));
?>
