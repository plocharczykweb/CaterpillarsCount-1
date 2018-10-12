<?php
	require_once("orm/Plant.php");

	function cleanParam($param){
		return preg_replace('!\s+!', '-', trim(preg_replace('/[^a-zA-Z0-9.]/', ' ', (string)$param)));
	}
	
	function submitINaturalistObservation($userTag, $plantCode, $date, $order, $arthropodQuantity, $arthropodLength, $arthropodPhotoFile, $arthropodNotes, $numberOfLeaves, $herbivoryScore){
		//GET AUTHORIZATION
		$ch = curl_init('https://www.inaturalist.org/oauth/token');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "client_id=" . getenv("iNaturalistAppID") . "&client_secret=" . getenv("iNaturalistAppSecret") . "&grant_type=password&username=caterpillarscountdev&password=" . getenv("iNaturalistPassword"));
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$token = json_decode(curl_exec($ch), true)["access_token"];
		
		//CREATE OBSERVATION
		$plant = Plant::findByCode($plantCode);
		$site = $plant->getSite();
		$url = "http://www.inaturalist.org/observations.json?observation[species_guess]=" . cleanParam($order) . "&observation[id_please]=1&observation[observed_on_string]=" . cleanParam($date) . "&observation[place_guess]=" . cleanParam($site->getName()) . "&observation[latitude]=" . cleanParam($site->getLatitude()) . "&observation[longitude]=" . cleanParam($site->getLongitude());
		if($arthropodNotes != ""){
			$url .= "&observation[description]=" . cleanParam($arthropodNotes);
		}
		$params = [["1289", $arthropodLength], ["1194", $site->getName()], ["5715", $plant->getCircle()], ["1422", $plantCode], ["306", $plant->getSpecies()], ["5712", $numberOfLeaves], ["5711", $herbivoryScore], ["5748", $arthropodQuantity], ["5710", $userTag]];
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
	//echo $url;

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "access_token=" . $token);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$observation = json_decode(curl_exec($ch), true)[0];
	//echo "<br/><br/>" . $observation["id"];

		//LINK OBSERVATION TO CATERPILLARS COUNT PROJECT
		$ch = curl_init("http://www.inaturalist.org/project_observations");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "access_token=" . $token . "&project_observation[observation_id]=" . $observation["id"] . "&project_observation[project_id]=5443");
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	//echo "<br/><br/>" . curl_exec($ch);

		//ADD PHOTO TO OBSERVATION
		$tmpfile = $arthropodPhotoFile['tmp_name'];
		if(is_uploaded_file($tmpfile)){
			$filename = basename($arthropodPhotoFile['name']);
			$data = array(
				'params' => array("access_token"=> $token, "&observation_photo[observation_id]"=> $observation["id"]),
				'uploaded_file' => curl_file_create($tmpfile, $arthropodPhotoFile['type'], $filename)
			);
			$ch = curl_init("http://www.inaturalist.org/project_observations");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		}
	//echo "<br/><br/>" . curl_exec($ch);
	}

//submitINaturalistObservation("ccdev", "EJK", "2018-02-20", "bee", 2, 12, "", "", 40, 2);
?>
