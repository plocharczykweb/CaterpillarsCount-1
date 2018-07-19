<?php
  header('Access-Control-Allow-Origin: *');

  require_once('orm/resources/Keychain.php');
  //require_once('orm/resources/mailing.php');

  function getArrayFromTable(){
    $tableArray = array();
    
    $dbconn = (new Keychain)->getDatabaseConnection();
    $query = mysqli_query($dbconn, "SELECT Survey.LocalDate, Survey.LocalTime, Plant.Code AS SurveyLocationCode, Plant.Circle, Plant.Orientation, Survey.PlantSpecies AS PlantSpeciesMarkedByObserver, Plant.Species AS OfficialPlantSpecies, Site.Name AS SiteName, Site.Description AS SiteDescription, Site.Latitude, Site.Longitude, Site.Region, Site.OpenToPublic AS SiteIsOpenToPublic, ArthropodSighting.Group AS ArthropodGroup, ArthropodSighting.Length AS ArthropodLength, ArthropodSighting.Quantity AS ArthropodQuantity, ArthropodSighting.PhotoURL AS ArthopodPhotoURL, ArthropodSighting.Notes AS ArthropodNotes, ArthropodSighting.Hairy AS IsCaterpillarAndIsHairy, ArthropodSighting.Rolled AS IsCaterpillarAndIsInLeafRoll, ArthropodSighting.Tented AS IsCaterpillarAndIsInSilkTent, Survey.ObservationMethod, Survey.Notes AS SurveyNotes, Survey.WetLeaves, Survey.NumberOfLeaves, Survey.AverageLeafLength, Survey.HerbivoryScore, Survey.SubmittedThroughApp AS SubmittedThroughAppInsteadOfWebsite FROM ArthropodSighting JOIN Survey ON ArthropodSighting.SurveyFK=Survey.ID JOIN Plant ON Survey.PlantFK=Plant.ID JOIN Site ON Plant.SiteFK=Site.ID ORDER BY Survey.LocalDate DESC, Survey.LocalTime DESC");
    
    //HEADERS
    $colHeaders = array("LocalDate", "LocalTime", "SurveyLocationCode", "Circle", "Orientation", "PlantSpeciesMarkedByObserver", "OfficialPlantSpecies", "SiteName", "SiteDescription", "Latitude", "Longitude", "Region", "SiteIsOpenToPublic", "ArthropodGroup", "ArthropodLength", "ArthropodQuantity", "ArthropodPhotoURL", "ArthropodNotes", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "");
    $tableArray[] = $colHeaders;
    
    //ROWS
    $query = mysqli_query($dbconn, "SELECT * FROM `" . $tableName . "`");
    mysqli_close($dbconn);
    
    while ($row = mysqli_fetch_assoc($query)){
      $rowArray = array();
      for($i = 0; $i < count($colHeaders); $i++){
        $rowArray[] = $row[$colHeaders[$i]];
      }
      $tableArray[] = $rowArray;
    }
    return $tableArray;
  }

  function createCSV($tableName, $tableArray) {
    if(!$fp = fopen("../iuFYr1xREQOp2ioB5MHvnCTY39UHv2/" . date("Y-m-d") . "_" . $tableName . ".csv", 'w')) return false;
    foreach ($tableArray as $line) fputcsv($fp, $line);
  }

  function backup($tableName, $excludedHeaders=array()){
    $tableArray = getArrayFromTable($tableName, $excludedHeaders);
    createCSV($tableName, $tableArray);
  }

  $site = getArrayFromTable("Site", array("UserFKOfCreator", "SaltedPasswordHash", "Salt"));
  backup("Plant");
  backup("Survey");
  backup("ArthropodSighting");
  
  SELECT * FROM ArthropodSighting JOIN Survey ON ArthropodSighting.SurveyFK=Survey.ID JOIN Plant ON Survey.PlantFK=Plant.ID JOIN Site ON Plant.SiteFK=Site.ID
  




?>
