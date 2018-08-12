<?php
  require_once('orm/resources/Keychain.php');
  require_once('orm/Site.php');
  
  $siteIDs = json_decode($_GET["siteIDs"]);
  $breakdown = $_GET["breakdown"]; //site, year, species, none
  $comparisonMetric = $_GET["comparisonMetric"]; //occurrence, absoluteDensity, relativeProportion
  
  $dbconn = (new Keychain)->getDatabaseConnection();
  $readableArthropods = array(
		"ant" => "Ants",
		"aphid" => "Aphids and Psyllids",
		"bee" => "Bees and Wasps",
		"beetle" => "Beetles",
		"caterpillar" => "Caterpillars",
		"daddylonglegs" => "Daddy Longlegs",
		"fly" => "Flies",
		"grasshopper" => "Grasshoppers and Crickets",
		"leafhopper" => "Leaf Hoppers and Cicadas",
		"moths" => "Butterflies and Moths",
		"spider" => "Spiders",
		"truebugs" => "True Bugs",
		"other" => "Other",
		"unidentified" => "Unidentified"
	);
  $siteID = intval($siteIDs[0]);

  function getArthropodOccurrence($dbconn, $readableArthropods, $siteID, $extraSQL){
    //surveys with arthropod at site during year
    $arthropodSurveys = array();
    $query = mysqli_query($dbconn, "SELECT ArthropodSighting.Group, COUNT(DISTINCT ArthropodSighting.SurveyFK) AS SurveysWithArthropodCount FROM `ArthropodSighting` JOIN Survey ON ArthropodSighting.SurveyFK = Survey.ID JOIN Plant ON Survey.PlantFK = Plant.ID WHERE Plant.SiteFK = '$siteID'" . $extraSQL . " GROUP BY ArthropodSighting.Group");
    while($row = mysqli_fetch_assoc($query)){
      $arthropodSurveys[$row["Group"]] = floatval($row["SurveysWithArthropodCount"]);
    }

    //surveys at site during year
    $query = mysqli_query($dbconn, "SELECT COUNT(*) AS TotalSurveyCount FROM `Survey` JOIN Plant ON Survey.PlantFK=Plant.ID WHERE Plant.SiteFK='$siteID'" . $extraSQL);
    $totalSurveyCount = floatval(mysqli_fetch_assoc($query)["TotalSurveyCount"]);

    $arthropodOccurrence = array();
    $keys = array_keys($arthropodSurveys);
    for($i = 0; $i < count($keys); $i++){
      $arthropodOccurrence[$readableArthropods[$keys[$i]]] = round(($arthropodSurveys[$keys[$i]] / $totalSurveyCount) * 100, 2);
    }
    return $arthropodOccurrence;
  }
  
  if($breakdown == "site" || $breakdown == "none"){
    if($comparisonMetric == "occurrence"){//multi site occurrence
      $arthropodOccurrences = array();
      for($i = 0; $i < count($siteIDs); $i++){
        $siteID = intval($siteIDs[$i]);
        $site = Site::findByID($siteID);
		    if(!is_object($site) || get_class($site) != "Site"){continue;}
        $siteName = $site->getName();
        $arthropodOccurrences[strval($siteName)] = getArthropodOccurrence($dbconn, $readableArthropods, $siteID, "");
      }
      die(json_encode($arthropodOccurrences));
    }
    else if($comparisonMetric == "absoluteDensity"){//multi site absolute denity
      for($i = 0; $i < count($siteIDs); $i++){
        $siteID = intval($siteIDs[$i]);
        $site = Site::findByID($siteID);
		    if(!is_object($site) || get_class($site) != "Site"){continue;}
        $siteName = $site->getName();
        
        
      }
    }
    else{//relativeProportion
      for($i = 0; $i < count($siteIDs); $i++){//multi site relative proportion
        $siteID = intval($siteIDs[$i]);
        $site = Site::findByID($siteID);
		    if(!is_object($site) || get_class($site) != "Site"){continue;}
        $siteName = $site->getName();
        
        
      }
    }
  }
  else if($breakdown == "year"){
    if($comparisonMetric == "occurrence"){//multi year occurrence
      //get years
      $years = array();
      $query = mysqli_query($dbconn, "SELECT DISTINCT YEAR(LocalDate) AS Year FROM Survey JOIN Plant ON Survey.PlantFK=Plant.ID WHERE Plant.SiteFK='$siteFK'");
      while($row = mysqli_fetch_assoc($query)){
        $years[] = $row["Year"];
      }
      
      //for each year, get arthropod occurrences
      $arthropodOccurrences = array();
      for($i = 0; $i < count($years); $i++){
        $arthropodOccurrences[strval($years[$i])] = getArthropodOccurrence($dbconn, $readableArthropods, $siteID, "YEAR(Survey.LocalDate)='" . $years[$i] . "'");
      }
      die(json_encode($arthropodOccurrences));
    }
    else if($comparisonMetric == "absoluteDensity"){//multi year absolute density
      
    }
    else{//multi year relative proportion
      
    }
  }
  else{//species
    if($comparisonMetric == "occurrence"){//multi species occurrence
      //get species
      $species = array();
      $query = mysqli_query($dbconn, "SELECT DISTINCT Species FROM Plant WHERE SiteFK='77'");
      while($row = mysqli_fetch_assoc($query)){
        $species[] = $row["Species"];
      }
      
      //for each species, get arthropod occurrences
      $arthropodOccurrences = array();
      for($i = 0; $i < count($species); $i++){
        $arthropodOccurrences[strval($species[$i])] = getArthropodOccurrence($dbconn, $readableArthropods, $siteID, "Plant.Species='" . $species[$i] . "'");
      }
      die(json_encode($arthropodOccurrences));
    }
    else if($comparisonMetric == "absoluteDensity"){//multi species absolute density
      
    }
    else{//multi species relative proportion
      
    }
  }
?>
