<?php
	require_once('orm/User.php');
	require_once('orm/Survey.php');
	
	$email = $_GET["email"];
	$salt = $_GET["salt"];
	$surveyIDs = json_decode($_GET["surveyIDs"]);
	
	$user = User::findBySignInKey($email, $salt);
	if(is_object($user) && get_class($user) == "User"){
    		$couldntIdentify = array();
    		$noAuthority = array();
		$successes = 0;
    		for($i = 0; $i < count($surveyIDs); $i++){
      			$survey = Survey::findByID($surveyIDs[$i]);
      			if(is_object($survey) && get_class($survey) == "Survey"){
        			if($survey->getObserver() === $user || in_array($survey->getPlant()->getSite(), $user->getSites(), true)){
          				$survey->permanentDelete();
					$successes++;
        			}
        			else{
					$noAuthority[] = $surveyIDs[$i];
				}
      			}
			else{
				$couldntIdentify[] = $surveyIDs[$i];
			}
    		}
		$errors = "";
    		if(count($couldntIdentify) > 0){
			if(count($surveyIDs) < 2){
				$errors .= "This survey does not exist and therefore cannot be deleted. ";
			}
			else if(count($couldntIdentify) == 1){
				$errors .= "The survey with the ID " . $couldntIdentify[0] . " does not exist and therefore cannot be deleted. ";
			}
      			else{
				$errors .= "The surveys with the following IDs do not exist and therefore cannot be deleted: " . join(", ", $couldntIdentify) . ". ";
			}
    		}
		if(count($noAuthority) > 0){
			if(count($surveyIDs) < 2){
				$errors .= "You do not have the authority to delete this survey. ";
			}
			else if(count($noAuthority) == 1){
				$errors .= "You do not have the authority to delete the survey with the ID " . $noAuthority[0] . ". ";
			}
      			else{
				$errors .= "You do not have the authority to delete the surveys with the following IDs: " . join(", ", $noAuthority) . ". ";
			}
		}
		if($errors != ""){
			if($successes == 1){
				$errors = "Only " . $successes . " survey was successfully deleted. " . $errors;
			}
			else if($successes > 1){
				$errors = "Only " . $successes . " surveys were successfully deleted. " . $errors;
			}
			die("false|" . $errors);
		}
		die("true|");
	}
	die("false|Your log in dissolved. Maybe you logged in on another device.");
?>
