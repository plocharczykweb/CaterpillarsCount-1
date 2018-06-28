<?php
	require_once('orm/resources/Keychain.php');
	require_once('orm/Site.php');
	
	$dbconn = (new Keychain)->getDatabaseConnection();
	$query = mysqli_query($dbconn, "SELECT Site.ID, Site.Name, Site.Region, Site.Latitude, Site.Longitude, Site.OpenToPublic, SUM(CASE WHEN Survey.SubmissionTimestamp >= (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 7) THEN 1 ELSE 0 END) AS Week, SUM(CASE WHEN Survey.SubmissionTimestamp >= (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 14) AND Survey.SubmissionTimestamp < (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 7) THEN 1 ELSE 0 END) AS LastWeek, ROUND(IFNULL((SUM(CASE WHEN Survey.SubmissionTimestamp >= (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 7) THEN 1 ELSE 0 END) / SUM(CASE WHEN Survey.SubmissionTimestamp < (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 7) AND Survey.SubmissionTimestamp >= (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 14) THEN 1 ELSE 0 END) - 1) * 100, SUM(CASE WHEN Survey.SubmissionTimestamp >= (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 7) THEN 1 ELSE 0 END) * 100), 2) AS WeekIncrease, SUM(CASE WHEN Survey.SubmissionTimestamp >= (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 30) THEN 1 ELSE 0 END) AS Month, SUM(CASE WHEN Survey.SubmissionTimestamp >= (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 60) AND Survey.SubmissionTimestamp < (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 30) THEN 1 ELSE 0 END) AS LastMonth, ROUND(IFNULL((SUM(CASE WHEN Survey.SubmissionTimestamp >= (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 30) THEN 1 ELSE 0 END) / SUM(CASE WHEN Survey.SubmissionTimestamp < (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 30) AND Survey.SubmissionTimestamp >= (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 60) THEN 1 ELSE 0 END) - 1) * 100, SUM(CASE WHEN Survey.SubmissionTimestamp >= (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 30) THEN 1 ELSE 0 END) * 100), 2) AS MonthIncrease, SUM(CASE WHEN Survey.SubmissionTimestamp >= (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 365) THEN 1 ELSE 0 END) AS Year, SUM(CASE WHEN Survey.SubmissionTimestamp >= (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 730) AND Survey.SubmissionTimestamp < (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 365) THEN 1 ELSE 0 END) AS LastYear, ROUND(IFNULL((SUM(CASE WHEN Survey.SubmissionTimestamp >= (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 365) THEN 1 ELSE 0 END) / SUM(CASE WHEN Survey.SubmissionTimestamp < (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 365) AND Survey.SubmissionTimestamp >= (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 730) THEN 1 ELSE 0 END) - 1) * 100, SUM(CASE WHEN Survey.SubmissionTimestamp >= (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 365) THEN 1 ELSE 0 END) * 100), 2) AS YearIncrease, Count(*) AS Total, ((SUM(CASE WHEN Survey.SubmissionTimestamp >= (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 30) THEN 1 ELSE 0 END) + 1) / 30 * Count(*)) AS Points FROM Survey JOIN Plant ON Survey.PlantFK=Plant.ID JOIN Site ON Plant.SiteFK=Site.ID WHERE Site.ID<>2 GROUP BY Site.ID ORDER BY Points DESC");
	mysqli_close($dbconn);
		
	$rankingsArray = array();
  	$i = 1;
	$siteIDs = array();
	while($row = mysqli_fetch_assoc($query)){
    		$openToPublic = $row["OpenToPublic"];
    		$coordinates = "NONE";
    		if($openToPublic){
      			$coordinates = $row["Latitude"] . "," . $row["Longitude"];
    		}
		$rankingsArray[] = array(
      			"Rank" => $i++,
      			"Points" => $row["Points"],
      			"Name" => $row["Name"] . " (" . $row["Region"] . ")",
      			"Coordinates" => $coordinates,
      			"Week" => $row["Week"],
      			"LastWeek" => $row["LastWeek"],
      			"WeekIncrease" => $row["WeekIncrease"],
      			"Month" => $row["Month"],
      			"LastMonth" => $row["LastMonth"],
      			"MonthIncrease" => $row["MonthIncrease"],
      			"LastYear" => $row["LastYear"],
      			"Year" => $row["Year"],
      			"YearIncrease" => $row["YearIncrease"],
      			"Total" => $row["Total"],
    		);
		$siteIDs[] = $row["ID"];
	}

	$allSites = Site::findAll();
	for($j = 0; $j < count($allSites); $j++){
		if(is_object($allSites[$j]) && get_class($allSites[$j]) == "Site" && !in_array($allSites[$j]->getID(), $siteIDs)){
			$coordinates = "NONE";
			if($allSites[$j]->getOpenToPublic()){
				$coordinates = $allSites[$j]->getLatitude() . "," . $allSites[$j]->getLongitude();
			}
			$rankingsArray[] = array(
				"Rank" => $i++,
				"Points" => 0,
				"Name" => $allSites[$j]->getName() . " (" . $allSites[$j]->getRegion() . ")",
				"Coordinates" => $coordinates,
				"Week" => 0,
				"LastWeek" => 0,
				"WeekIncrease" => 0,
				"Month" => 0,
				"LastMonth" => 0,
				"MonthIncrease" => 0,
				"LastYear" => 0,
				"Year" => 0,
				"YearIncrease" => 0,
				"Total" => 0,
			);
			$siteIDs[] = $allSites[$j]->getID();
		}
	}

	die(json_encode($rankingsArray));
	
?>
