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
    );
  }

  $dbconn = (new Keychain)->getDatabaseConnection();
	$query = mysqli_query($dbconn, "SELECT Plant.SiteFK, COUNT(*) AS SurveyCount FROM Survey JOIN Plant ON Plant.ID=Survey.PlantFK GROUP BY Plant.SiteFK");
  while($row = mysqli_fetch_assoc($query)){
    $sitesArray[strval($row["SiteFK"])]["SurveyCount"] = intval($row["SurveyCount"]);
  }
  die(json_encode(array_values($sitesArray)));
?>
