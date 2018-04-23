<?php
	require_once('orm/Survey.php');
	require_once('orm/resources/Keychain.php');
	
	$dbconn = (new Keychain)->getDatabaseConnection();
	
	$query = mysqli_query($dbconn, "SELECT * FROM `Survey` WHERE `ID`<742");
	
  	$arr = array();
	while($row = mysqli_fetch_assoc($query)){
    		$survey = Survey::findByID($row["ID"]);
    		$arthropodSightings = $survey->getArthropodSightings();
    		$plant = $survey->getPlant();
    
    		$arthropodData = array();
    		for($i = 0; $i < count($arthropodSightings); $i++){
      			$arthropodData[] = array(
        			$arthropodSightings[$i]->getGroup(),
        			$arthropodSightings[$i]->getLength(),
        			$arthropodSightings[$i]->getQuantity(),
        			$arthropodSightings[$i]->getNotes(),
        			$arthropodSightings[$i]->getHairy(),
        			$arthropodSightings[$i]->getRolled(),
        			$arthropodSightings[$i]->getTented(),
      			);
    		}
    
    $arr[] = array(
      $plant->getCode(),
      $survey->getNotes(),
      $survey->getPlantSpecies(),
      $survey->getHerbivoryScore(),
      $survey->getObservationMethod(),
      $survey->getNumberOfLeaves(),
      $survey->getLocalDate(),
      $survey->getLocalTime(),
      $arthropodData,
    );
	}
  die(json_encode($arr));
?>
