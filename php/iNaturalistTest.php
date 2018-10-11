<?php
  require_once("orm/Site.php");

  $plantSpecies = "Oak spp.";
  $date = "2018-04-28";
  $site = Site::findByID(55);
  $arthropodNotes = "";

  $ch = curl_init('https://www.inaturalist.org/oauth/token');
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, "client_id=" . getenv("iNaturalistAppID") . "&client_secret=" . getenv("iNaturalistAppSecret") . "&grant_type=password&username=caterpillarscountdev&password=" . getenv("iNaturalistPassword"));
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

  $token = json_decode(curl_exec($ch), true)["access_token"];

  $url = "http://www.inaturalist.org/observations.json?" . 
                "observation[species_guess]=" + preg_replace('!\s+!', '-', $plantSpecies) . 
                "&observation[id_please]=1" . 
                "&observation[observed_on_string]=" + $date . 
                "&observation[place_guess]= " + preg_replace('!\s+!', '-', $site->getName()) . 
                "&observation[latitude]=" + $site->getLatitude() . 
                "&observation[longitude]=" + $site->getLongitude() . 
				$arthropodNotes;
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, "access_token=" . $token);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

  $obs_result = curl_exec($ch);
  
  die($obs_result);
?>
