<?php
	require_once('orm/resources/Keychain.php');
	
	$dbconn = (new Keychain)->getDatabaseConnection();
  
  	$lines = json_decode($_GET["lines"], true);
  
  	$weightedLines = array();
  	for($i = 0; $i < count($lines); $i++){
    		$densityOrOccurrence = $lines[$i]["densityOrOccurrence"];
		$siteID = $lines[$i]["siteID"];
		$arthropod = $lines[$i]["arthropod"];
		$year = $lines[$i]["year"];
    
    		$dateWeights = array();
    
		//get survey counts each day
		$query = mysqli_query($dbconn, "SELECT Survey.LocalDate, COUNT(*) AS DailySurveyCount FROM `Survey` JOIN Plant ON Survey.PlantFK=Plant.ID WHERE Plant.SiteFK='$siteID' AND YEAR(Survey.LocalDate)='$year' GROUP BY Survey.LocalDate ORDER BY Survey.LocalDate");
		while($row = mysqli_fetch_assoc($query)){
			$dateParts = explode("-", $row["LocalDate"]);
			$month = $dateParts[1];
			$day = $dateParts[2];
			$julianDay = gregoriantojd($month, $day, $year);
			$dateWeights[strval($julianDay)] = array($julianDay, 0, intval($row["DailySurveyCount"]));
		}
    
		if($densityOrOccurraece == "occurrence"){//occurrence
			echo "occurrence";
			//get [survey with specified arthropod] counts each day
			$query = mysqli_query($dbconn, "SELECT Survey.LocalDate, COUNT(DISTINCT ArthropodSighting.SurveyFK) AS SurveysWithArthropodsCount FROM ArthropodSighting JOIN Survey ON ArthropodSighting.SurveyFK=Survey.ID JOIN Plant ON Survey.PlantFK=Plant.ID WHERE Plant.SiteFK='$siteID' AND ArthropodSighting.Group LIKE '$arthropod' AND YEAR(Survey.LocalDate)='$year' GROUP BY Survey.LocalDate ORDER BY Survey.LocalDate");
			while($row = mysqli_fetch_assoc($query)){
				$dateParts = explode("-", $row["LocalDate"]);
				$month = $dateParts[1];
				$day = $dateParts[2];
				$julianDay = gregoriantojd($month, $day, $year);
				$dateWeights[strval($julianDay)][1] = intval($row["SurveysWithArthropodsCount"]);
			}
		}
		else{//density
			echo "density";
			//get arthropod counts each day
			$query = mysqli_query($dbconn, "SELECT Survey.LocalDate, SUM(ArthropodSighting.Quantity) AS DailyArthropodSightings FROM `ArthropodSighting` JOIN Survey ON ArthropodSighting.SurveyFK=Survey.ID JOIN Plant ON Survey.PlantFK=Plant.ID WHERE Plant.SiteFK='$siteID' AND ArthropodSighting.Group LIKE '$arthropod' AND YEAR(Survey.LocalDate)='$year' GROUP BY Survey.LocalDate ORDER BY Survey.LocalDate");
			while($row = mysqli_fetch_assoc($query)){
				$dateParts = explode("-", $row["LocalDate"]);
				$month = $dateParts[1];
				$day = $dateParts[2];
				$julianDay = gregoriantojd($month, $day, $year);
				$dateWeights[strval($julianDay)][1] = intval($row["DailyArthropodSightings"]);
			}
		}
    
		//divide
		$dateWeights = array_values($dateWeights);
		for($j = 0; $j < count($dateWeights); $j++){
			$dateWeights[$j] = array($dateWeights[$j][0], (($dateWeights[$j][1] / $dateWeights[$j][2]) * 100));
		}
    
    		$weightedLines[] = $dateWeights;
  	}
  	mysqli_close($dbconn);
  	die(json_encode($weightedLines));//in the form of: [[[JULIAN DAY, PERCENT]]] //example: [[[2458336.5, 30], [2458337.5, 25]], [[2458336.5, 21.3], [2458337.5, 70]]]
?>
