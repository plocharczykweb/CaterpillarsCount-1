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
    
    		$weightedLines[] = $dateWeights;
  	}
  	mysqli_close($dbconn);
  	die(json_encode($weightedLines));//in the form of: [[[LOCAL_DATE, PERCENT]]] //example: [[[2018-08-09, 30], [2018-08-12, 25]], [[2018-08-15, 21.3], [2018-09-02, 70]]]
?>
