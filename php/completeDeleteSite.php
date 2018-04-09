<?php
  require_once('orm/Site.php');
  require_once('orm/resources/Keychain.php');
  
  $siteID = $_GET["siteID"];
  $site = Site::findByID($siteID);
  $plants = $site->getPlants();
  
  $dbconn = (new Keychain)->getDatabaseConnection();
  
  for($i = 0; $i < count($plants); $i++){
    $plantID = $plants[$i]->getID();
    mysqli_query($dbconn, "DELETE FROM `Survey` WHERE `PlantFK`='$plantID'");
    $plants[$i]->permanentDelete();
  }
  
  $site->permanentDelete();
?>
