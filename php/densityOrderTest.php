<?php
  require_once('orm/resources/Keychain.php');
  
  $dbconn = (new Keychain)->getDatabaseConnection();
  
  $siteID = 95;
  $totalDensity = array();
		$query = mysqli_query($dbconn, "SELECT Plant.Species, COUNT(*) AS SurveyCount, COUNT(DISTINCT Plant.ID) AS Branches FROM Survey JOIN Plant ON Survey.PlantFK=Plant.ID WHERE Plant.SiteFK='$siteID' GROUP BY Plant.Species");
		while($row = mysqli_fetch_assoc($query)){
			$totalDensity[$row["Species"]] = floatval($row["SurveyCount"]);
		}
		$query = mysqli_query($dbconn, "SELECT Plant.Species, SUM(ArthropodSighting.Quantity) AS ArthropodCount FROM ArthropodSighting JOIN Survey ON ArthropodSighting.SurveyFK=Survey.ID JOIN Plant ON Survey.PlantFK=Plant.ID WHERE Plant.SiteFK='$siteID' GROUP BY Plant.Species");
		while($row = mysqli_fetch_assoc($query)){
			if($totalDensity[$row["Species"]] > 0){
				$totalDensity[$row["Species"]] = floatval($row["ArthropodCount"]) / $totalDensity[$row["Species"]];
			}
		}
		asort($totalDensity, SORT_NUMERIC);
		$order = array_keys($totalDensity);
    
    die(json_encode($totalDensity) . "<br/><br/>" . json_encode($order))
?>
