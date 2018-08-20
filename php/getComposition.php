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
 			$arthropodAbsoluteDensity[$readableArthropods[$keys[$i]]] = round(($arthropodCounts[$keys[$i]] / $surveyCount) * 1, 2);
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

	function getSet($category, $barTitleQuery, $numeratorQuery, $denominatorQuery, $readableArthropods, $FACTOR){
		$set = array();
		$numerators = array();
		$query = mysqli_query($dbconn, $barTitleQuery);
		while($row = mysqli_fetch_assoc($query)){
			$numerators[$row[$category]] = array();
			$set[$row[$category]] = array();
		}
		$query = mysqli_query($dbconn, $numeratorQuery);
		while($row = mysqli_fetch_assoc($query)){
			$numerators[$row[$category]][$row["Group"]] = $row["Numerator"];
		}

		$surveyCounts = array();
		$query = mysqli_query($dbconn, $denominatorQuery);
		while($row = mysqli_fetch_assoc($query)){
			$surveyCounts[$row[$category]] = $row["Denominator"];
		}

		$barTitleKeys = array_keys($numerators);
		foreach($barTitleKeys as $barTitle) {
			$arthropodWeights = array();
			$arthropodKeys = array_keys($numerators[$barTitle]);
			foreach($arthropodKeys as $arthropod){
				$arthropodWeights[$readableArthropods[$arthropod]] = round(($numerators[$barTitle][$arthropod] / $surveyCounts[$barTitle]) * $FACTOR, 2);
			}
			$set[$barTitle] = $arthropodWeights;
		}
		
		return $set;
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
 		/*
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
 		*/
		
 		if($comparisonMetric == "occurrence"){
 			$arthropodOccurrencesSet = array();
 			$arthropodSurveyCounts = array();
 			$query = mysqli_query($dbconn, "SELECT DISTINCT Species FROM Plant WHERE SiteFK='$siteID'");
 			while($row = mysqli_fetch_assoc($query)){
				$arthropodSurveyCounts[$row["Species"]] = array();
				$arthropodOccurrencesSet[$row["Species"]] = array();
 			}
 			$query = mysqli_query($dbconn, "SELECT Plant.Species, ArthropodSighting.Group, COUNT(DISTINCT ArthropodSighting.SurveyFK) AS ArthropodSurveyCounts FROM `ArthropodSighting` JOIN Survey ON ArthropodSighting.SurveyFK = Survey.ID JOIN Plant ON Survey.PlantFK = Plant.ID WHERE Plant.SiteFK = '$siteID' GROUP BY CONCAT(Plant.Species, '-', ArthropodSighting.Group)");
 			while($row = mysqli_fetch_assoc($query)){
 				$arthropodSurveyCounts[$row["Species"]][$row["Group"]] = $row["ArthropodSurveyCounts"];
 			}
 
 			$surveyCounts = array();
 			$query = mysqli_query($dbconn, "SELECT Plant.Species, COUNT(Survey.ID) AS SurveyCount FROM Survey JOIN Plant ON Survey.PlantFK=Plant.ID WHERE Plant.SiteFK='$siteID' GROUP BY Plant.Species");
 			while($row = mysqli_fetch_assoc($query)){
 				$surveyCounts[$row["Species"]] = $row["SurveyCount"];
 			}
 
 			$speciesKeys = array_keys($arthropodSurveyCounts);
 			foreach($speciesKeys as $species) {
				$arthropodOccurrences = array();
				$arthropodKeys = array_keys($arthropodSurveyCounts[$species]);
				foreach($arthropodKeys as $arthropod){
					$arthropodOccurrences[$readableArthropods[$arthropod]] = round(($arthropodSurveyCounts[$species][$arthropod] / $surveyCounts[$species]) * 100, 2);
				}
				$arthropodOccurrencesSet[$species] = $arthropodOccurrences;
			}
 
 			die("true|" . json_encode($arthropodOccurrencesSet));
 		}
 		else if($comparisonMetric == "absoluteDensity"){
 			$arthropodDensitiesSet = array();
 			$arthropodCounts = array();
 			$query = mysqli_query($dbconn, "SELECT DISTINCT Species FROM Plant WHERE SiteFK='$siteID'");
 			while($row = mysqli_fetch_assoc($query)){
				$arthropodCounts[$row["Species"]] = array();
				$arthropodDensitiesSet[$row["Species"]] = array();
 			}
 			$query = mysqli_query($dbconn, "SELECT Plant.Species, ArthropodSighting.Group, SUM(ArthropodSighting.Quantity) AS ArthropodCount FROM ArthropodSighting JOIN Survey ON ArthropodSighting.SurveyFK=Survey.ID JOIN Plant ON Survey.PlantFK=Plant.ID WHERE Plant.SiteFK='$siteID' GROUP BY CONCAT(Plant.Species, '-', ArthropodSighting.Group)");
 			while($row = mysqli_fetch_assoc($query)){
 				$arthropodCounts[$row["Species"]][$row["Group"]] = $row["ArthropodCount"];
 			}
 
 			$surveyCounts = array();
 			$query = mysqli_query($dbconn, "SELECT Plant.Species, COUNT(Survey.ID) AS SurveyCount FROM Survey JOIN Plant ON Survey.PlantFK=Plant.ID WHERE Plant.SiteFK='$siteID' GROUP BY Plant.Species");
 			while($row = mysqli_fetch_assoc($query)){
 				$surveyCounts[$row["Species"]] = $row["SurveyCount"];
 			}
 
 			$speciesKeys = array_keys($arthropodCounts);
 			foreach($speciesKeys as $species) {
				$arthropodDensities = array();
				$arthropodKeys = array_keys($arthropodCounts[$species]);
				foreach($arthropodKeys as $arthropod){
					$arthropodDensities[$readableArthropods[$arthropod]] = round($arthropodCounts[$species][$arthropod] / $surveyCounts[$species], 2);
				}
				$arthropodDensitiesSet[$species] = $arthropodDensities;
			}
 
 			die("true|" . json_encode($arthropodDensitiesSet));
 		}
 		else{//relative proportion
			$barTitleQuery = "SELECT DISTINCT Species FROM Plant WHERE SiteFK='$siteID'";
			$numeratorQuery = "SELECT Plant.Species, ArthropodSighting.Group, SUM(ArthropodSighting.Quantity) AS ArthropodCount FROM ArthropodSighting JOIN Survey ON ArthropodSighting.SurveyFK=Survey.ID JOIN Plant ON Survey.PlantFK=Plant.ID WHERE Plant.SiteFK='$siteID' GROUP BY CONCAT(Plant.Species, '-', ArthropodSighting.Group)";
			$denominatorQuery = "SELECT Plant.Species, SUM(ArthropodSighting.Quantity) AS AllArthropodsCount FROM ArthropodSighting JOIN Survey ON ArthropodSighting.SurveyFK=Survey.ID JOIN Plant ON Survey.PlantFK=Plant.ID WHERE Plant.SiteFK='$siteID' GROUP BY Plant.Species";
			$set = getSet("Species", $barTitleQuery, $numeratorQuery, $denominatorQuery, $readableArthropods, 100);
 			die("true|" . json_encode($set));
			/*
			$arthropodRelativeProportionsSet = array();
 			$arthropodCounts = array();
 			$query = mysqli_query($dbconn, "SELECT DISTINCT Species FROM Plant WHERE SiteFK='$siteID'");
 			while($row = mysqli_fetch_assoc($query)){
				$arthropodCounts[$row["Species"]] = array();
				$arthropodRelativeProportionsSet[$row["Species"]] = array();
 			}
 			$query = mysqli_query($dbconn, "SELECT Plant.Species, ArthropodSighting.Group, SUM(ArthropodSighting.Quantity) AS ArthropodCount FROM ArthropodSighting JOIN Survey ON ArthropodSighting.SurveyFK=Survey.ID JOIN Plant ON Survey.PlantFK=Plant.ID WHERE Plant.SiteFK='$siteID' GROUP BY CONCAT(Plant.Species, '-', ArthropodSighting.Group)");
 			while($row = mysqli_fetch_assoc($query)){
 				$arthropodCounts[$row["Species"]][$row["Group"]] = $row["ArthropodCount"];
 			}
 
 			$allArthropodCounts = array();
 			$query = mysqli_query($dbconn, "SELECT Plant.Species, SUM(ArthropodSighting.Quantity) AS AllArthropodsCount FROM ArthropodSighting JOIN Survey ON ArthropodSighting.SurveyFK=Survey.ID JOIN Plant ON Survey.PlantFK=Plant.ID WHERE Plant.SiteFK='$siteID' GROUP BY Plant.Species");
 			while($row = mysqli_fetch_assoc($query)){
 				$allArthropodCounts[$row["Species"]] = $row["AllArthropodsCount"];
 			}
 
 			$speciesKeys = array_keys($arthropodCounts);
 			foreach($speciesKeys as $species) {
				$arthropodRelativeProportions = array();
				$arthropodKeys = array_keys($arthropodCounts[$species]);
				foreach($arthropodKeys as $arthropod){
					$arthropodRelativeProportions[$readableArthropods[$arthropod]] = round(($arthropodCounts[$species][$arthropod] / $allArthropodCounts[$species]) * 100, 2);
				}
				$arthropodRelativeProportionsSet[$species] = $arthropodRelativeProportions;
			}
 
 			die("true|" . json_encode($arthropodRelativeProportionsSet));
			*/
 		}
 	}
 ?>
