<?php
	require_once('orm/User.php');
	require_once('orm/Plant.php');
	require_once('orm/Survey.php');
	
	$email = $_POST["email"];
	$salt = $_POST["salt"];
	$plantCode = $_POST["plantCode"];
	$sitePassword = $_POST["sitePassword"];
	$date = $_POST["date"];
	$time = $_POST["time"];
	$observationMethod = $_POST["observationMethod"];
	$siteNotes = $_POST["siteNotes"];			//String
	$wetLeaves = $_POST["wetLeaves"];			//"true" or "false"
	$arthropodData = json_decode($_POST["arthropodData"]);		//JSON
	//$plantSpecies = $_POST["plantSpecies"];
	$numberOfLeaves = $_POST["numberOfLeaves"];		//number
	$averageLeafLength = $_POST["averageLeafLength"];	//number
	$herbivoryScore = $_POST["herbivoryScore"];		//String
	
  $user = User::findBySignInKey($email, $salt);
	if(is_object($user) && get_class($user) == "User"){
		$plant = Plant::findByCode($plantCode);
		if(!is_object($plant)){
			die("false|Enter a valid survey location code.");
		}
		
		$site = $plant->getSite();
		if($site->validateUser($user, $sitePassword)){
			$user->setObservationMethodPreset($site, $observationMethod);
			//submit data to database
			$survey = Survey::create($user, $plant, $date, $time, $observationMethod, $siteNotes, $wetLeaves, $plantSpecies, $numberOfLeaves, $averageLeafLength, $herbivoryScore, $submittedThroughApp);
			
			if(is_object($survey) && get_class($survey) == "Survey"){
				//$arthropodData = orderType, orderLength, orderQuantity, orderNotes, hairy, leafRoll, silkTent, fileInput
				$arthropodSightingFailures = "";
				for($i = 0; $i < count($arthropodData); $i++){
					if($arthropodData[$i][0] != "caterpillar"){
						$arthropodData[$i][4] = false;
						$arthropodData[$i][5] = false;
						$arthropodData[$i][6] = false;
					}
					$arthropodSighting = $survey->addArthropodSighting($arthropodData[$i][0], $arthropodData[$i][1], $arthropodData[$i][2], $arthropodData[$i][3], $arthropodData[$i][4], $arthropodData[$i][5], $arthropodData[$i][6]);
					if(is_object($arthropodSighting) && get_class($arthropodSighting) == "ArthropodSighting"){
						$attachResult = attachPhotoToArthropodSighting($_FILES['file' . $i], $arthropodSighting);
						if($attachResult != "File not uploaded." && !($attachResult === true)){
							$arthropodSightingFailures .= strval($attachResult);
						}
					}
					else{
						$arthropodSightingFailures .= $arthropodSighting;
					}
				}
				if($arthropodSightingFailures != ""){
					die("false|" . $arthropodSightingFailures);
				}
				die("true|");
			}
			die("false|" . $survey);
		}
		die("false|Enter a valid password.");
	}
	die("false|Your log in dissolved. Maybe you logged in on another device.");
?>
