<?php
	require_once("orm/Plant.php");
	
	$ch = curl_init('https://www.inaturalist.org/oauth/token');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "client_id=" . getenv("iNaturalistAppID") . "&client_secret=" . getenv("iNaturalistAppSecret") . "&grant_type=password&username=caterpillarscountdev&password=" . getenv("iNaturalistPassword"));
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	$token = json_decode(curl_exec($ch), true)["access_token"];

$plantCode = "EJJ";
$plant = Plant::findByCode($plantCode);
$site = $plant->getSite();
$numberOfLeaves = "50";
$date = "2018-04-28";
$herbivoryScore = "4";
$order = "ant";
$arthropodNotes = "test run";
$arthropodLength = "21";
$arthropodQuantity = "5";
$userTag = "ccdev";
	$url = "http://www.inaturalist.org/observations.json?observation[species_guess]=" . $order . "&observation[id_please]=1&observation[observed_on_string]=" . $date . "&observation[place_guess]=" . $site->getName() . "&observation[latitude]=" . $site->getLatitude() . "&observation[longitude]=" . $site->getLongitude();
	if($arthropodNotes != ""){
		$url .= "&observation[description]=" . $arthropodNotes);
	}
	$params = [["1289", $arthropodLength], ["1194", $site->getName()], ["5715", $plant->getCircle()], ["1422", $plantCode], ["306", $plant->getSpecies()], ["5712", $numberOfLeaves], ["5711", $herbivoryScore], ["5748", $arthropodQuantity], ["5710", $userTag]];
        $observationFieldIDString = "&observation[observation_field_values_attributes]";
	for($i = 0; $i < count($params); $i++){
		$url .= $observationFieldIDString . "[" . $i . "][observation_field_id]=" . $params[$i][0] . $observationFieldIDString . "[" . $i . "][value]=" . $params[$i][1];
	}
	if(strpos($order, "caterpillar") !== false){
		$url .= $observationFieldIDString . "[10][observation_field_id]=3441" . $observationFieldIDString . "[10][value]=caterpillar";
		$url .= $observationFieldIDString . "[11][observation_field_id]=325" . $observationFieldIDString . "[11][value]=larva";
	}
	if(strpos($order, "moth") !== false){
		$url .= $observationFieldIDString . "[10][observation_field_id]=3441" . $observationFieldIDString . "[10][value]=adult";
		$url .= $observationFieldIDString . "[11][observation_field_id]=325" . $observationFieldIDString . "[11][value]=adult";
	}

	echo $url;

	$ch = curl_init(urlencode(preg_replace('!\s+!', '-', $url)));
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "access_token=" . $token);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	$result = curl_exec($ch);

	echo $result;
?>
