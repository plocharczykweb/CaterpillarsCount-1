<?php
	header('Access-Control-Allow-Origin: *');
	
	require_once('orm/User.php');
	
	$email = $_GET["email"];
	$salt = $_GET["salt"];
	
	$user = User::findBySignInKey($email, $salt);
	if(is_object($user) && get_class($user) == "User"){
		$sites = $user->getSites();
    		$sitesWithUnsetPlantSpecies = array();
    		for($i = 0; $i < count($sites); $i++){
      			$plants = $sites[$i]->getPlants();
      			for($j = 0; $j < count($plants); $j++){
        			if($plants[$j]->getSpecies() == "N/A"){
          				$sitesWithUnsetPlantSpecies[] = '"' . $sites[$i]->getName() . '"';
          				break;
        			}
      			}
    		}
    		$numberOfSitesWithUnsetPlantSpecies = count($sitesWithUnsetPlantSpecies);
    		if($numberOfSitesWithUnsetPlantSpecies > 0){
      			$sitesWithUnsetPlantSpecies = join(", ", $sitesWithUnsetPlantSpecies);
      			if($numberOfSitesWithUnsetPlantSpecies > 2){
        			$sitesWithUnsetPlantSpecies = "your sites (" . substr_replace($sitesWithUnsetPlantSpecies, ", and", strrpos($sitesWithUnsetPlantSpecies, ","), 1) . ")";
      			}
			else if($numberOfSitesWithUnsetPlantSpecies > 1){
        			$sitesWithUnsetPlantSpecies = "your sites (" . substr_replace($sitesWithUnsetPlantSpecies, " and", strrpos($sitesWithUnsetPlantSpecies, ","), 1) . ")";
      			}
			else{
				$sitesWithUnsetPlantSpecies = "your site (" . $sitesWithUnsetPlantSpecies . ")";
			}
      			die("true|" . $sitesWithUnsetPlantSpecies);
    		}
	}
	die("false|");
?>
