<?php
  header('Access-Control-Allow-Origin: *');
  require_once('orm/resources/Keychain.php');
  //require_once('orm/resources/mailing.php');

  $colHeaders = array("SiteName", 
    "SiteDescription", 
    "Latitude", 
    "Longitude", 
    "Region", 
    "LocalDate", 
    "LocalTime", 
    "SurveyLocationCode", 
    "Circle", 
    "Orientation", 
    "PlantSpeciesMarkedByObserver", 
    "OfficialPlantSpecies", 
    "ObservationMethod", 
    "SurveyNotes", 
    "WetLeaves", 
    "NumberOfLeaves", 
    "AverageLeafLength", 
    "HerbivoryScore", 
    "ArthropodGroup", 
    "ArthropodLength", 
    "ArthropodQuantity", 
    "ArthropodPhotoURL", 
    "ArthropodNotes", 
    "IsCaterpillarAndIsHairy", 
    "IsCaterpillarAndIsInLeafRoll", 
    "IsCaterpillarAndIsInSilkTent");

  function getArrayFromTable(){
    $tableArray = array();
    
    $dbconn = (new Keychain)->getDatabaseConnection();
    $query = mysqli_query($dbconn, "SELECT Survey.ID, Survey.LocalDate, SUBSTR(Survey.LocalTime, 1, 5) AS `LocalTime`, Plant.Code AS SurveyLocationCode, Plant.Circle, Plant.Orientation, Survey.PlantSpecies AS PlantSpeciesMarkedByObserver, Plant.Species AS OfficialPlantSpecies, Site.Name AS SiteName, Site.Description AS SiteDescription, Site.Latitude, Site.Longitude, Site.Region, ArthropodSighting.Group AS ArthropodGroup, ArthropodSighting.Length AS ArthropodLength, ArthropodSighting.Quantity AS ArthropodQuantity, IF(ArthropodSighting.PhotoURL='','',CONCAT('https://caterpillarscount.unc.edu/images/arthropods/', ArthropodSighting.PhotoURL)) AS ArthropodPhotoURL, ArthropodSighting.Notes AS ArthropodNotes, ArthropodSighting.Hairy AS IsCaterpillarAndIsHairy, ArthropodSighting.Rolled AS IsCaterpillarAndIsInLeafRoll, ArthropodSighting.Tented AS IsCaterpillarAndIsInSilkTent, Survey.ObservationMethod, Survey.Notes AS SurveyNotes, Survey.WetLeaves, Survey.NumberOfLeaves, Survey.AverageLeafLength, Survey.HerbivoryScore FROM ArthropodSighting JOIN Survey ON ArthropodSighting.SurveyFK=Survey.ID JOIN Plant ON Survey.PlantFK=Plant.ID JOIN Site ON Plant.SiteFK=Site.ID ORDER BY Survey.LocalDate DESC, Survey.LocalTime DESC");
    
    //ROWS
    $surveyIDsWithSightings = array();
    while ($row = mysqli_fetch_assoc($query)){
      $rowArray = array();
      for($i = 0; $i < count($colHeaders); $i++){
        $rowArray[] = $row[$colHeaders[$i]];
      }
      $tableArray[] = $rowArray;
      $surveyIDsWithSightings[] = $row["ID"];
    }
    
    $query = mysqli_query($dbconn, "SELECT Survey.LocalDate, SUBSTR(Survey.LocalTime, 1, 5) AS `LocalTime`, Plant.Code AS SurveyLocationCode, Plant.Circle, Plant.Orientation, Survey.PlantSpecies AS PlantSpeciesMarkedByObserver, Plant.Species AS OfficialPlantSpecies, Site.Name AS SiteName, Site.Description AS SiteDescription, Site.Latitude, Site.Longitude, Site.Region, Survey.ObservationMethod, Survey.Notes AS SurveyNotes, Survey.WetLeaves, Survey.NumberOfLeaves, Survey.AverageLeafLength, Survey.HerbivoryScore FROM Survey JOIN Plant ON Survey.PlantFK=Plant.ID JOIN Site ON Plant.SiteFK=Site.ID WHERE Survey.ID NOT IN (" . join(", ", $surveyIDsWithSightings) . ")");
    mysqli_close($dbconn);
    while ($row = mysqli_fetch_assoc($query)){
      $rowArray = array();
      for($i = 0; $i < count($colHeaders); $i++){
        if(array_key_exists($colHeaders[$i], $row)){
          $rowArray[] = $row[$colHeaders[$i]];
        }
        else if($colHeaders[$i] == "ArthropodGroup"){
          $rowArray[] = "None";
        }
        else{
          $rowArray[] = "";
        }
      }
      $tableArray[] = $rowArray;
    }
    return $tableArray;
  }

  function customSort($a, $b){
    $alphabeticalResult = strcmp($a[0], $b[0]);
    if($alphabeticalResult != 0){
      return $alphabeticalResult;
    }
    $aTime = date_create_from_format("Y-m-d H:i", $a[5] . " " . $a[6]);
    $aTime = $aTime->getTimestamp();
    $bTime = date_create_from_format("Y-m-d H:i", $b[5] . " " . $b[6]);
    $bTime = $bTime->getTimestamp();
    return $bTime - $aTime;
  }

  $tableArray = getArrayFromTable();
  usort($tableArray, "customSort");
  //array_unshift($tableArray, $colHeaders);
  $filename = "CaterpillarsCountDataAtTimestamp_" . time() . ".csv";
  $fp = fopen($filename, 'w');
  foreach ($tableArray as $line) fputcsv($fp, $line);
  
  header('Content-Type: application/octet-stream');
  header("Content-Transfer-Encoding: Binary"); 
  header("Content-disposition: attachment; filename=\"" . basename($filename) . "\"");
  
  readfile($filename);
  //note that each line in this data pertains to a specific arthropod sighting, so surveys which contained no arthropod sightings are excluded from this data.
  unlink($filename);
?>
