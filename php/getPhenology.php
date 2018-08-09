<?php
	require_once('orm/resources/Keychain.php');
	require_once('orm/Site.php');
	
	$dbconn = (new Keychain)->getDatabaseConnection();
	
  	$lines = json_decode($_GET["lines"], true);
	$readableArthropods = array(
		"%" => "all arthropods",
		"ant" => "ants",
		"aphid" => "aphids and psyllids",
		"bee" => "bees and wasps",
		"beetle" => "beetles",
		"caterpillar" => "caterpillars",
		"daddylonglegs" => "daddy longlegs",
		"fly" => "flies",
		"grasshopper" => "grasshoppers and crickets",
		"leafhopper" => "leaf hoppers and cicadas",
		"moths" => "butterflies and moths",
		"spider" => "spiders",
		"truebugs" => "true bugs",
		"other" => "\"other\" arthropods",
		"unidentified" => "unidentified arthropods"
	);
  
  	$weightedLines = array();
  	for($i = 0; $i < count($lines); $i++){
		$siteID = intval($lines[$i]["siteID"]);
		$site = Site::findByID(siteID);
		if(!is_object($site) || get_class($site) != "Site"){continue;}
    		$densityOrOccurrence = $lines[$i]["densityOrOccurrence"];
		$arthropod = mysqli_real_escape_string($dbconn, $lines[$i]["arthropod"]);
		$year = intval($lines[$i]["year"]);
    
    		$dateWeights = array();
    
		//get survey counts each day
		$query = mysqli_query($dbconn, "SELECT Survey.LocalDate, COUNT(*) AS DailySurveyCount FROM `Survey` JOIN Plant ON Survey.PlantFK=Plant.ID WHERE Plant.SiteFK='$siteID' AND YEAR(Survey.LocalDate)='$year' GROUP BY Survey.LocalDate ORDER BY Survey.LocalDate");
		while($row = mysqli_fetch_assoc($query)){
			$dateWeights[$row["LocalDate"]] = array($row["LocalDate"], 0, intval($row["DailySurveyCount"]));
		}
    
		if($densityOrOccurrence == "occurrence"){//occurrence
			//get [survey with specified arthropod] counts each day
			$query = mysqli_query($dbconn, "SELECT Survey.LocalDate, COUNT(DISTINCT ArthropodSighting.SurveyFK) AS SurveysWithArthropodsCount FROM ArthropodSighting JOIN Survey ON ArthropodSighting.SurveyFK=Survey.ID JOIN Plant ON Survey.PlantFK=Plant.ID WHERE Plant.SiteFK='$siteID' AND ArthropodSighting.Group LIKE '$arthropod' AND YEAR(Survey.LocalDate)='$year' GROUP BY Survey.LocalDate ORDER BY Survey.LocalDate");
			while($row = mysqli_fetch_assoc($query)){
				$dateWeights[$row["LocalDate"]][1] = intval($row["SurveysWithArthropodsCount"]);
			}
		}
		else{//density
			//get arthropod counts each day
			$query = mysqli_query($dbconn, "SELECT Survey.LocalDate, SUM(ArthropodSighting.Quantity) AS DailyArthropodSightings FROM `ArthropodSighting` JOIN Survey ON ArthropodSighting.SurveyFK=Survey.ID JOIN Plant ON Survey.PlantFK=Plant.ID WHERE Plant.SiteFK='$siteID' AND ArthropodSighting.Group LIKE '$arthropod' AND YEAR(Survey.LocalDate)='$year' GROUP BY Survey.LocalDate ORDER BY Survey.LocalDate");
			while($row = mysqli_fetch_assoc($query)){
				$dateWeights[$row["LocalDate"]][1] = intval($row["DailyArthropodSightings"]);
			}
		}
    
		//divide
		$dateWeights = array_values($dateWeights);
		for($j = 0; $j < count($dateWeights); $j++){
			$dateWeights[$j] = array($dateWeights[$j][0], (($dateWeights[$j][1] / $dateWeights[$j][2]) * 100));
		}
    
    		$weightedLines[ucfirst($densityOrOccurrence) . " of " . $readableArthropods[$arthropod] . " at " . $site->getName() . " in " . $year] = $dateWeights;
  	}
  	mysqli_close($dbconn);
  	die(json_encode($weightedLines));//in the form of: [LABEL: [[LOCAL_DATE, PERCENT]]] //example: ["Density of all arthropods at Example Site in 2018": [[2018-08-09, 30], [2018-08-12, 25]], [[2018-08-15, 21.3], [2018-09-02, 70]]]
?>
