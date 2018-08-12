<?php
  require_once('orm/resources/Keychain.php');
  
  $siteIDs = json_decode($_GET["siteIDs"]);
  $breakdown = $_GET["breakdown"]; //site, year, species, none
  $comparisonMetric = $_GET["comparisonMetric"]; //occurrence, absoluteDensity, relativeProportion
  
  $dbconn = (new Keychain)->getDatabaseConnection();
  $siteID = intval($siteIDs[0]);
  
  if($breakdown == "site"){
    for($i = 0; $i < count($siteIDs); $i++){
      $siteID = intval($siteIDs[$i]);
    }
  }
  else if($breakdown == "year"){
    
  }
  else if($breakdown == "species"){
    
  }
  else{
    if($comparisonMetric == "occurrence"){
      //surveys with arthropod at site
      $arthropodSurveys = array();
      $query = mysqli_query($dbconn, "SELECT ArthropodSighting.Group, COUNT(DISTINCT ArthropodSighting.SurveyFK) AS SurveysWithArthropodCount FROM `ArthropodSighting` JOIN Survey ON ArthropodSighting.SurveyFK = Survey.ID JOIN Plant ON Survey.PlantFK = Plant.ID WHERE Plant.SiteFK = '$siteID' GROUP BY ArthropodSighting.Group");
      while($row = mysqli_fetch_assoc($query)){
        $arthropodSurveys[$row["Group"]] = floatval($row["SurveysWithArthropodCount"]);
      }

      //surveys at site
      $query = mysqli_query($dbconn, "SELECT COUNT(*) AS TotalSurveyCount FROM `Survey` JOIN Plant ON Survey.PlantFK=Plant.ID WHERE Plant.SiteFK='$siteID'");
      $totalSurveyCount = floatval(mysqli_fetch_assoc($query)["TotalSurveyCount"]);

      $arthropodOccurrence = array();
      $keys = array_keys($arthropodSurveys);
      for($i = 0; $i < count($keys); $i++){
        $arthropodOccurrence[$keys[$i]] = round(($arthropodSurveys[$keys[$i]] / $totalSurveyCount) * 100, 2);
      }
      die(json_encode($arthropodOccurrence));
    }
  }
?>
