<?php
	require_once('orm/resources/Keychain.php');
	
	$dbconn = (new Keychain)->getDatabaseConnection();
	$query = mysqli_query($dbconn, "SELECT Site.ID, Site.Name, SUM(CASE WHEN Survey.SubmissionTimestamp >= (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 7) THEN 1 ELSE 0 END) AS Week, ROUND(IFNULL((SUM(CASE WHEN Survey.SubmissionTimestamp >= (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 7) THEN 1 ELSE 0 END) / SUM(CASE WHEN Survey.SubmissionTimestamp < (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 7) AND Survey.SubmissionTimestamp >= (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 14) THEN 1 ELSE 0 END) - 1) * 100, SUM(CASE WHEN Survey.SubmissionTimestamp >= (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 7) THEN 1 ELSE 0 END) * 100), 2) AS WeekIncrease, SUM(CASE WHEN Survey.SubmissionTimestamp >= (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 30) THEN 1 ELSE 0 END) AS Month, ROUND(IFNULL((SUM(CASE WHEN Survey.SubmissionTimestamp >= (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 30) THEN 1 ELSE 0 END) / SUM(CASE WHEN Survey.SubmissionTimestamp < (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 30) AND Survey.SubmissionTimestamp >= (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 60) THEN 1 ELSE 0 END) - 1) * 100, SUM(CASE WHEN Survey.SubmissionTimestamp >= (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 30) THEN 1 ELSE 0 END) * 100), 2) AS MonthIncrease, SUM(CASE WHEN Survey.SubmissionTimestamp >= (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 365) THEN 1 ELSE 0 END) AS Year, ROUND(IFNULL((SUM(CASE WHEN Survey.SubmissionTimestamp >= (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 365) THEN 1 ELSE 0 END) / SUM(CASE WHEN Survey.SubmissionTimestamp < (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 365) AND Survey.SubmissionTimestamp >= (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 730) THEN 1 ELSE 0 END) - 1) * 100, SUM(CASE WHEN Survey.SubmissionTimestamp >= (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 365) THEN 1 ELSE 0 END) * 100), 2) AS YearIncrease, Count(*) AS Total, ((SUM(CASE WHEN Survey.SubmissionTimestamp >= (UNIX_TIMESTAMP(NOW()) - 60 * 60 * 24 * 30) THEN 1 ELSE 0 END) + 1) / 30 * Count(*)) AS Points FROM Survey JOIN Plant ON Survey.PlantFK=Plant.ID JOIN Site ON Plant.SiteFK=Site.ID WHERE Site.ID<>2 GROUP BY Site.ID ORDER BY Points DESC");
	mysqli_close($dbconn);
		
	$rankingsArray = array();
  $i = 1;
	while($row = mysqli_fetch_assoc($query)){
    $openToPublic = $row["OpenToPublic"]
    $coordinates = "NONE";
    if($openToPublic){
      $coordinates = $row["Latitude"] . "," . $row["Longitude"];
    }
		$rankingsArray[] = array(
      "Rank" => $i++,
      "Points" => $row["Points"],
      "Name" => $row["Name"] . "(" . $row["Region"] . ")",
      "Coordinates" => $coordinates,
      "Week" => $row["Week"],
      "WeekIncrease" => $row["WeekIncrease"],
      "Month" => $row["Month"],
      "MonthIncrease" => $row["MonthIncrease"],
      "Year" => $row["Year"],
      "YearIncrease" => $row["YearIncrease"],
      "Total" => $row["Total"],
    );
	}
	die(json_encode($rankingsArray));
	
?>
