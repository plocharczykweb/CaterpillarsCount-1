<?php
	require_once('orm/resources/Keychain.php');
	require_once('orm/Site.php');
  
	$siteIDs = json_decode($_GET["siteIDs"]);
	$breakdown = $_GET["breakdown"]; //site, year, plant species, none
	$comparisonMetric = $_GET["comparisonMetric"]; //occurrence, absoluteDensity, relativeProportion
  
	$dbconn = (new Keychain)->getDatabaseConnection();
	$readableArthropods = array(
		"ant" => "Ants",
		"aphid" => "Aphids and Psyllids",
		"bee" => "Bees and Wasps",
		"beetle" => "Beetles",
		"caterpillar" => "Caterpillars",
		"daddylonglegs" => "Daddy Longlegs",
		"fly" => "Flies",
		"grasshopper" => "Grasshoppers and Crickets",
		"leafhopper" => "Leaf Hoppers and Cicadas",
		"moths" => "Butterflies and Moths",
		"spider" => "Spiders",
		"truebugs" => "True Bugs",
		"other" => "Other",
		"unidentified" => "Unidentified"
	);
	$siteID = intval($siteIDs[0]);

	function getArthropodOccurrence($dbconn, $readableArthropods, $siteID, $extraSQL){
		//surveys with arthropod at site
		$arthropodSurveys = array();
		$query = mysqli_query($dbconn, "SELECT ArthropodSighting.Group, COUNT(DISTINCT ArthropodSighting.SurveyFK) AS SurveysWithArthropodCount FROM `ArthropodSighting` JOIN Survey ON ArthropodSighting.SurveyFK = Survey.ID JOIN Plant ON Survey.PlantFK = Plant.ID WHERE Plant.SiteFK = '$siteID'" . $extraSQL . " GROUP BY ArthropodSighting.Group");
		while($row = mysqli_fetch_assoc($query)){
			$arthropodSurveys[$row["Group"]] = floatval($row["SurveysWithArthropodCount"]);
		}
		
		//surveys at site
		$query = mysqli_query($dbconn, "SELECT COUNT(*) AS TotalSurveyCount FROM `Survey` JOIN Plant ON Survey.PlantFK=Plant.ID WHERE Plant.SiteFK='$siteID'" . $extraSQL);
		$totalSurveyCount = floatval(mysqli_fetch_assoc($query)["TotalSurveyCount"]);

		$arthropodOccurrence = array();
		$keys = array_keys($arthropodSurveys);
		for($i = 0; $i < count($keys); $i++){
			$arthropodOccurrence[$readableArthropods[$keys[$i]]] = round(($arthropodSurveys[$keys[$i]] / $totalSurveyCount) * 100, 2);
		}
		return $arthropodOccurrence;
	}

	function getArthropodAbsoluteDensity($dbconn, $readableArthropods, $siteID, $extraSQL){
		//sum of each arthropod at site
		$arthropodCounts = array();
		$query = mysqli_query($dbconn, "SELECT ArthropodSighting.Group, SUM(ArthropodSighting.Quantity) AS ArthropodCount FROM ArthropodSighting JOIN Survey ON ArthropodSighting.SurveyFK=Survey.ID JOIN Plant ON Survey.PlantFK=Plant.ID WHERE Plant.SiteFK='$siteID'" . $extraSQL . " GROUP BY ArthropodSighting.Group");
		while($row = mysqli_fetch_assoc($query)){
			$arthropodCounts[$row["Group"]] = floatval($row["ArthropodCount"]);
		}
		
		//total survey count at site
		$query = mysqli_query($dbconn, "SELECT COUNT(*) AS SurveyCount FROM Survey JOIN Plant ON Survey.PlantFK=Plant.ID WHERE Plant.SiteFK='$siteID'" . $extraSQL);
		$surveyCount = floatval(mysqli_fetch_assoc($query)["SurveyCount"]);
		
		$arthropodAbsoluteDensity = array();
		$keys = array_keys($arthropodCounts);
		for($i = 0; $i < count($keys); $i++){
			$arthropodAbsoluteDensity[$readableArthropods[$keys[$i]]] = round(($arthropodCounts[$keys[$i]] / $surveyCount) * 100, 2);
		}
		return $arthropodAbsoluteDensity;
	}

	function getArthropodRelativeProportion($dbconn, $readableArthropods, $siteID, $extraSQL){
		//sum of each arthropod at site
		$arthropodCounts = array();
		$query = mysqli_query($dbconn, "SELECT ArthropodSighting.Group, SUM(ArthropodSighting.Quantity) AS ArthropodCount FROM ArthropodSighting JOIN Survey ON ArthropodSighting.SurveyFK=Survey.ID JOIN Plant ON Survey.PlantFK=Plant.ID WHERE Plant.SiteFK='$siteID'" . $extraSQL . " GROUP BY ArthropodSighting.Group");
		while($row = mysqli_fetch_assoc($query)){
			$arthropodCounts[$row["Group"]] = floatval($row["ArthropodCount"]);
		}
		
		//total survey count at site
		$query = mysqli_query($dbconn, "SELECT SUM(ArthropodSighting.Quantity) AS AllArthropodsCount FROM ArthropodSighting JOIN Survey ON ArthropodSighting.SurveyFK=Survey.ID JOIN Plant ON Survey.PlantFK=Plant.ID WHERE Plant.SiteFK='$siteID'" . $extraSQL);
		$allArthropodsCount = floatval(mysqli_fetch_assoc($query)["AllArthropodsCount"]);
		
		$arthropodRelativeProportion = array();
		$keys = array_keys($arthropodCounts);
		for($i = 0; $i < count($keys); $i++){
			$arthropodRelativeProportion[$readableArthropods[$keys[$i]]] = round(($arthropodCounts[$keys[$i]] / $allArthropodsCount) * 100, 2);
		}
		return $arthropodRelativeProportion;
	}
  
	if($breakdown == "site" || $breakdown == "none"){
		//get percents
		$arthropodPercents = array();
		for($i = 0; $i < count($siteIDs); $i++){
			$siteID = intval($siteIDs[$i]);
			$site = Site::findByID($siteID);
			if(!is_object($site) || get_class($site) != "Site"){continue;}
			$siteName = $site->getName();
			
			if($comparisonMetric == "occurrence"){
				$arthropodPercents[strval($siteName)] = getArthropodOccurrence($dbconn, $readableArthropods, $siteID, "");
			}
			else if($comparisonMetric == "absoluteDensity"){
				$arthropodPercents[strval($siteName)] = getArthropodAbsoluteDensity($dbconn, $readableArthropods, $siteID, "");
			}
			else{//relativeProportion
				$arthropodPercents[strval($siteName)] = getArthropodRelativeProportion($dbconn, $readableArthropods, $siteID, "");
			}
		}
		die("true|" . json_encode($arthropodPercents));
	}
	else if($breakdown == "year"){
		//get years
		$years = array();
		$query = mysqli_query($dbconn, "SELECT DISTINCT YEAR(LocalDate) AS Year FROM Survey JOIN Plant ON Survey.PlantFK=Plant.ID WHERE Plant.SiteFK='$siteID'");
		while($row = mysqli_fetch_assoc($query)){
			$years[] = $row["Year"];
		}
		
		//get percents
		$arthropodPercents = array();
		for($i = 0; $i < count($years); $i++){
			if($comparisonMetric == "occurrence"){
				$arthropodPercents[strval($years[$i])] = getArthropodOccurrence($dbconn, $readableArthropods, $siteID, " AND YEAR(Survey.LocalDate)='" . $years[$i] . "'");
			}
			else if($comparisonMetric == "absoluteDensity"){
				$arthropodPercents[strval($years[$i])] = getArthropodAbsoluteDensity($dbconn, $readableArthropods, $siteID, " AND YEAR(Survey.LocalDate)='" . $years[$i] . "'");
			}
			else{//relative proportion
				$arthropodPercents[strval($years[$i])] = getArthropodRelativeProportion($dbconn, $readableArthropods, $siteID, " AND YEAR(Survey.LocalDate)='" . $years[$i] . "'");
			}
		}
		die("true|" . json_encode($arthropodPercents));
	}
	else{//plant species
		//get species
		$species = array();
		$query = mysqli_query($dbconn, "SELECT DISTINCT Species FROM Plant WHERE SiteFK='$siteID'");
		while($row = mysqli_fetch_assoc($query)){
			$species[] = $row["Species"];
		}
		
		//get percents
		$arthropodPercents = array();
		for($i = 0; $i < count($species); $i++){
			if($comparisonMetric == "occurrence"){
				$arthropodPercents[strval($species[$i])] = getArthropodOccurrence($dbconn, $readableArthropods, $siteID, " AND Plant.Species='" . $species[$i] . "'");
			}
			else if($comparisonMetric == "absoluteDensity"){
				$arthropodPercents[strval($species[$i])] = getArthropodAbsoluteDensity($dbconn, $readableArthropods, $siteID, " AND Plant.Species='" . $species[$i] . "'");
			}
			else{//relative proportion
				$arthropodPercents[strval($species[$i])] = getArthropodRelativeProportion($dbconn, $readableArthropods, $siteID, " AND Plant.Species='" . $species[$i] . "'");
			}
		}
		die("true|" . json_encode($arthropodPercents));
	}
?>
