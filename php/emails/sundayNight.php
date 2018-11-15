<?php
	header('Access-Control-Allow-Origin: *');
	
	require_once("../orm/Site.php");
	require_once("../orm/User.php");
	require_once("../orm/resources/Keychain.php");
	require_once("../orm/resources/mailing.php");
	
	$sites = Site::findAll();
	$dbconn = (new Keychain)->getDatabaseConnection();
	$today = date("Y-m-d");
	$sundayOffset = date('w', strtotime($today));
    	$monday = date("Y-m-d", strtotime($today . " -" . (6 + $sundayOffset) . " days"));
	for($i = 0; $i < count($sites); $i++){
		$query = mysqli_query($dbconn, "SELECT COUNT(Survey.*) AS SurveyCount, COUNT(DISTINCT(Survey.UserFKOfObserver)) AS UserCount FROM Survey JOIN Plant ON Survey.PlantFK=Plant.ID WHERE `SiteFK`='" . $$sites[$i]->getID() . "' AND Survey.LocalDate>='$monday'");
		$surveyCount = intval(mysqli_fetch_assoc($query)["SurveyCount"]);
		$userCount = intval(mysqli_fetch_assoc($query)["UserCount"]);
		if($surveyCount > 0){
			//site with surveys since monday email
			$query = mysqli_query($dbconn, "SELECT SUM(ArthropodSighting.Quantity) AS ArthropodCount FROM ArthropodSighting JOIN Survey ON ArthropodSighting.SurveyFK=Survey.ID JOIN Plant ON Survey.PlantFK=Plant.ID WHERE `SiteFK`='" . $$sites[$i]->getID() . "' AND Survey.LocalDate>='$monday'");
			$arthropodCount = intval(mysqli_fetch_assoc($query)["ArthropodCount"]);
			
			$query = mysqli_query($dbconn, "SELECT SUM(ArthropodSighting.Quantity) AS CaterpillarCount FROM ArthropodSighting JOIN Survey ON ArthropodSighting.SurveyFK=Survey.ID JOIN Plant ON Survey.PlantFK=Plant.ID WHERE `SiteFK`='" . $$sites[$i]->getID() . "' AND Survey.LocalDate>='$monday' AND ArthropodSighting.Group='caterpillar'");
			$caterpillarCount = intval(mysqli_fetch_assoc($query)["CaterpillarCount"]);
			
			$emails = $sites[$i]->getAuthorityEmails();
			for($j = 0; $j < count($emails); $j++){
				email7($emails[$j], "This Week at " . $sites[$i]->getName() . "...", $userCount, $surveyCount, $sites[$i]->getName(), $arthropodCount, $caterpillarCount, $sites[$i]->getID());
			}
		}
	}
	mysqli_close($dbconn);
?>
