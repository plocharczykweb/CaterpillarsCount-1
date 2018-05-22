<?php
	require_once('orm/User.php');
	require_once('orm/Survey.php');
	
	$email = $_GET["email"];
	$salt = $_GET["salt"];
	$page = $_GET["page"];
	$PAGE_LENGTH = 3;
	
	$user = User::findBySignInKey($email, $salt);
	if(is_object($user) && get_class($user) == "User"){
		$start = "last";
		if($page !== "last"){
			$start = ((intval($page) - 1) * $PAGE_LENGTH);
		}
		$surveys = Survey::findSurveysByUser($user, $start, $PAGE_LENGTH);
		$totalPages = ceil($surveys[0]/$PAGE_LENGTH);
		$surveys = $surveys[1];
		$surveysArray = array();
		for($i = 0; $i < count($surveys); $i++){
			if(is_object($surveys[$i]) && get_class($surveys[$i]) == "Survey"){
				$arthropodSightings = $surveys[$i]->getArthropodSightings();
				$arthropodSightingsArray = array();
				for($j = 0; $j < count($arthropodSightings); $j++){
					if(is_object($arthropodSightings[$j]) && get_class($arthropodSightings[$j]) == "ArthropodSighting"){
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
				}
				$surveysArray[] = array(
					"id" => $surveys[$i]->getID(),
					"observerID" => $surveys[$i]->getObserver()->getID(),
					"observerFullName" => $surveys[$i]->getObserver()->getFullName(),
					"observerEmail" => $surveys[$i]->getObserver()->getEmail(),
					"plantCode" => $surveys[$i]->getPlant()->getCode(),
					"siteID" => $surveys[$i]->getPlant()->getSite()->getID(),
					"siteName" => $surveys[$i]->getPlant()->getSite()->getName(),
					"siteRegion" => $surveys[$i]->getPlant()->getSite()->getRegion(),
					"siteCoordinates" => $surveys[$i]->getPlant()->getSite()->getLatitude() . "," . $surveys[$i]->getPlant()->getSite()->getLongitude(),
					"circle" => $surveys[$i]->getPlant()->getCircle(),
					"orientation" => $surveys[$i]->getPlant()->getOrientation(),
					"color" => $surveys[$i]->getPlant()->getColor(),
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
		}
		die("true|" . json_encode(array($totalPages, $surveysArray)));
	}
	die("false|Your log in dissolved. Maybe you logged in on another device.");
?>
