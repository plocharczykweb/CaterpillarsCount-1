<?php
  require_once("orm/ArthropodSighting.php");
  require_once("submitToINaturalist.php");
  
  $arthropodSightingID = $_GET["id"];
  
  $arthropodSighting = ArthropodSighting::findByID($arthropodSightingID);
  $survey = $arthropodSighting->getSurvey();
  $user = $survey->getObserver();
  $plant = $survey->getPlant();
  $site = $plant->getSite();
  
  submitINaturalistObservation($user->getINaturalistObserverID(), $plant->getCode(), $survey->getLocalDate(), $survey->getObservationMethod(), $survey->getNotes(), $survey->getWetLeaves(), $arthropodSighting->getGroup(), $arthropodSighting->getHairy(), $arthropodSighting->getRolled(), $arthropodSighting->getTented(), $arthropodSighting->getQuantity(), $arthropodSighting->getLength(), $arthropodSighting->getPhotoURL(), $arthropodSighting->getNotes(), $survey->getNumberOfLeaves(), $survey->getAverageLeafLength(), $survey->getHerbivoryScore());
?>
