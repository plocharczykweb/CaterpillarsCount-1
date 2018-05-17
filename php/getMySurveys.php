<?php
	require_once('orm/User.php');
	require_once('orm/Survey.php');
	
	$email = $_GET["email"];
	$salt = $_GET["salt"];
	$page = $_GET["page"];
	$PAGE_LENGTH = 25;
	
	$user = User::findBySignInKey($email, $salt);
	if(is_object($user) && get_class($user) == "User"){
		$surveys = Survey::findSurveysByUser($user, ((intval($page) - 1) * $PAGE_LENGTH), $PAGE_LENGTH);
		$surveysArray = array();
		for($i = 0; $i < count($surveys); $i++){
			$arthropodSightings = $surveys[$i]->getArthropodSightings();
			$arthropodSightingsArray = array();
			for($j = 0; $j < count($arthropodSightings); $j++){
				$arthropodSightingsArray[] = array(
					"id" => $arthropodSightings[$j]->getID(),
					"group" => $arthropodSightings[$j]->getGroup(),
					"length" => $arthropodSightings[$j]->getLength(),
					"quantity" => $arthropodSightings[$j]->getQuantity(),
					"photoURL" => $arthropodSightings[$j]->getPhotoURL(),
					"notes" => $arthropodSightings[$j]->getNotes(),
					"hairy" => $arthropodSightings[$j]->getHairy(),
					"rolled" => $arthropodSightings[$j]->getRolled(),
					"tented" => $arthropodSightings[$j]->getTented(),
				);
			}
			$surveysArray[] = array(
				"id" => $surveys[$i]->getID(),
				"observerID" => $surveys[$i]->getObserver()->getID(),
				"observerFullName" => $surveys[$i]->getObserver()->getFullName(),
				"plantCode" => $surveys[$i]->getPlant()->getCode(),
				"siteID" => $surveys[$i]->getPlant()->getSite()->getID(),
				"siteName" => $surveys[$i]->getPlant()->getSite()->getName(),
				"siteRegion" => $surveys[$i]->getPlant()->getSite()->getRegion(),
				"siteCoordinates" => $surveys[$i]->getPlant()->getSite()->getLatitude() . "," . $surveys[$i]->getPlant()->getSite()->getLongitude(),
				"localDate" => $surveys[$i]->getLocalDate(),
				"localTime" => $surveys[$i]->getLocalTime(),
				"observaionMethod" => $surveys[$i]->getObservationMethod(),
				"notes" => $surveys[$i]->getNotes(),
				"wetLeaves" => $surveys[$i]->getWetLeaves(),
				"plantSpecies" => $surveys[$i]->getPlantSpecies(),
				"numberOfLeaves" => $surveys[$i]->getNumberOfLeaves(),
				"averageLeafLength" => $surveys[$i]->getAverageLeafLength(),
				"herbivoryScore" => $surveys[$i]->getHerbivoryScore(),
				"submittedThroughApp" => $surveys[$i]->getSubmittedThroughApp(),
				"arthropodSightings" => $arthropodSightingsArray,
			);
		}
		die("true|" . json_encode($surveysArray));
	}
	die("false|Your log in dissolved. Maybe you logged in on another device.");
?>
