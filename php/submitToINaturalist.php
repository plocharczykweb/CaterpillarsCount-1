<?php
	require_once("orm/Plant.php");

	function cleanParam($param){
		return preg_replace('!\s+!', '-', trim(preg_replace('/[^a-zA-Z0-9.]/', ' ', (string)$param)));
	}
	
	function submitINaturalistObservation($userTag, $plantCode, $date, $order, $arthropodQuantity, $arthropodLength, $arthropodPhotoURL, $arthropodNotes, $numberOfLeaves, $herbivoryScore){
		//GET AUTHORIZATION
		$ch = curl_init('https://www.inaturalist.org/oauth/token');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "client_id=" . getenv("iNaturalistAppID") . "&client_secret=" . getenv("iNaturalistAppSecret") . "&grant_type=password&username=caterpillarscountdev&password=" . getenv("iNaturalistPassword"));
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$token = json_decode(curl_exec($ch), true)["access_token"];
		curl_close ($ch);
		
		//CREATE OBSERVATION
		$plant = Plant::findByCode($plantCode);
		$site = $plant->getSite();
		$url = "http://www.inaturalist.org/observations.json?observation[species_guess]=" . cleanParam($order) . "&observation[id_please]=1&observation[observed_on_string]=" . cleanParam($date) . "&observation[place_guess]=" . cleanParam($site->getName()) . "&observation[latitude]=" . cleanParam($site->getLatitude()) . "&observation[longitude]=" . cleanParam($site->getLongitude());
		if($arthropodNotes != ""){
			$url .= "&observation[description]=" . cleanParam($arthropodNotes);
		}
		$herbivoryScores = array("0%", "1-5%", "6-10%", "11-25%", "> 25%");
		$params = [["9670", $arthropodLength . " mm"], ["1194", $site->getName()], ["9671", $plant->getCircle()], ["1422", $plantCode], ["6609", $plant->getSpecies()], ["2926", $numberOfLeaves], ["9672", $herbivoryScore . " - " . $herbivoryScores[intval($herbivoryScore)]], ["5176", $arthropodQuantity], ["9673", $userTag]];
		$observationFieldIDString = "&observation[observation_field_values_attributes]";
		for($i = 0; $i < count($params); $i++){
			$url .= $observationFieldIDString . "[" . $i . "][observation_field_id]=" . cleanParam($params[$i][0]) . $observationFieldIDString . "[" . $i . "][value]=" . cleanParam($params[$i][1]);
		}
		if(strpos($order, "caterpillar") !== false){
			$url .= $observationFieldIDString . "[10][observation_field_id]=3441" . $observationFieldIDString . "[10][value]=caterpillar";
			$url .= $observationFieldIDString . "[11][observation_field_id]=325" . $observationFieldIDString . "[11][value]=larva";
		}
		if(strpos($order, "moth") !== false){
			$url .= $observationFieldIDString . "[10][observation_field_id]=3441" . $observationFieldIDString . "[10][value]=adult";
			$url .= $observationFieldIDString . "[11][observation_field_id]=325" . $observationFieldIDString . "[11][value]=adult";
		}

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "access_token=" . $token);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:multipart/form-data"));
		$observation = json_decode(curl_exec($ch), true)[0];
		curl_close ($ch);
		
		//ADD PHOTO TO OBSERVATION
		$ch = curl_init();
		if(function_exists('curl_file_create')){//PHP 5.5+
			$cFile = curl_file_create("../images/arthropods/" . $arthropodPhotoURL);
		}
		else{
			curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
			$cFile = '@' . realpath("../images/arthropods/" . $arthropodPhotoURL);
		}
		$post = array('access_token' => $token, 'observation_photo[observation_id]' => $observation["id"], 'file'=> $cFile);
		curl_setopt($ch, CURLOPT_URL,"http://www.inaturalist.org/observation_photos");
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:multipart/form-data"));
		curl_close ($ch);
		
		//LINK OBSERVATION TO CATERPILLARS COUNT PROJECT
		$ch = curl_init("http://www.inaturalist.org/project_observations");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "access_token=" . $token . "&project_observation[observation_id]=" . $observation["id"] . "&project_observation[project_id]=5443");
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_close ($ch);
	}
?>
