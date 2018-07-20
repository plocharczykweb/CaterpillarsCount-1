<?php
  header('Access-Control-Allow-Origin: *');
  require_once('orm/resources/Keychain.php');
  //require_once('orm/resources/mailing.php');

  function getArrayFromTable(){
    $tableArray = array();
    
    $dbconn = (new Keychain)->getDatabaseConnection();
    $query = mysqli_query($dbconn, "SELECT Survey.LocalDate, Survey.LocalTime, Plant.Code AS SurveyLocationCode, Plant.Circle, Plant.Orientation, Survey.PlantSpecies AS PlantSpeciesMarkedByObserver, Plant.Species AS OfficialPlantSpecies, Site.Name AS SiteName, Site.Description AS SiteDescription, Site.Latitude, Site.Longitude, Site.Region, Site.OpenToPublic AS SiteIsOpenToPublic, ArthropodSighting.Group AS ArthropodGroup, ArthropodSighting.Length AS ArthropodLength, ArthropodSighting.Quantity AS ArthropodQuantity, ArthropodSighting.PhotoURL AS ArthopodPhotoURL, ArthropodSighting.Notes AS ArthropodNotes, ArthropodSighting.Hairy AS IsCaterpillarAndIsHairy, ArthropodSighting.Rolled AS IsCaterpillarAndIsInLeafRoll, ArthropodSighting.Tented AS IsCaterpillarAndIsInSilkTent, Survey.ObservationMethod, Survey.Notes AS SurveyNotes, Survey.WetLeaves, Survey.NumberOfLeaves, Survey.AverageLeafLength, Survey.HerbivoryScore, Survey.SubmittedThroughApp AS SubmittedThroughAppInsteadOfWebsite FROM ArthropodSighting JOIN Survey ON ArthropodSighting.SurveyFK=Survey.ID JOIN Plant ON Survey.PlantFK=Plant.ID JOIN Site ON Plant.SiteFK=Site.ID ORDER BY Survey.LocalDate DESC, Survey.LocalTime DESC");
    mysqli_close($dbconn);
    
    //HEADERS
    $colHeaders = array("LocalDate", "LocalTime", "SurveyLocationCode", "Circle", "Orientation", "PlantSpeciesMarkedByObserver", "OfficialPlantSpecies", "SiteName", "SiteDescription", "Latitude", "Longitude", "Region", "SiteIsOpenToPublic", "ArthropodGroup", "ArthropodLength", "ArthropodQuantity", "ArthropodPhotoURL", "ArthropodNotes", "IsCaterpillarAndIsHairy", "IsCaterpillarAndIsInLeafRoll", "IsCaterpillarAndIsInSilkTent", "ObservationMethod", "SurveyNotes", "WetLeaves", "NumberOfLeaves", "AverageLeafLength", "HerbivoryScore", "SubmittedThroughAppInsteadOfWebsite");
    $tableArray[] = $colHeaders;
    
    //ROWS
    while ($row = mysqli_fetch_assoc($query)){
      $rowArray = array();
      for($i = 0; $i < count($colHeaders); $i++){
        $rowArray[] = $row[$colHeaders[$i]];
      }
      $tableArray[] = $rowArray;
    }
    return $tableArray;
  }

  $tableArray = getArrayFromTable();
  $filename = "CaterpillarsCountDataAtTimestamp_" . time() . ".csv";
  $fp = fopen($filename, 'w');
  foreach ($tableArray as $line) fputcsv($fp, $line);
  
  header('Content-Type: application/octet-stream');
  header("Content-Transfer-Encoding: Binary"); 
  header("Content-disposition: attachment; filename=\"" . basename($filename) . "\"");
  
  readfile($filename);
  unlink($filename);
?>
