<?php
	require_once('orm/User.php');
	require_once('orm/Survey.php');
	
	$email = $_GET["email"];
	$salt = $_GET["salt"];
	$surveyIDs = json_decode($_GET["surveyIDs"]);
	
	$user = User::findBySignInKey($email, $salt);
	if(is_object($user) && get_class($user) == "User"){
    		$errors = "";
    		for($i = 0; $i < count($surveyIDs); $i++){
      			$survey = Survey::findByID($surveyIDs[$i]);
      			if(is_object($survey) && get_class($survey) == "Survey"){
        			if($survey->getObserver() === $user || in_array($survey->getPlant()->getSite(), $user->getSites(), true)){
          				$survey->permanentDelete();
        			}
        			else{
          				$errors .= "You do not have the authority to delete the survey with id: " . $surveyIDs[$i] . ". ";
        			}
      			}
      			else{
        			$errors .= "Could not identify survey with ID: " . $surveyIDs[$i] . ". ";
      			}
    		}
    		if($errors == ""){
      			die("true|");
    		}
		die("false|" . $errors);
	}
	die("false|Your log in dissolved. Maybe you logged in on another device.");
?>
