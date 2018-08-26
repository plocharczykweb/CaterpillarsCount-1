<?php
  require_once('php/orm/resources/Keychain.php');
  //require_once('orm/resources/mailing.php');

  $colHeaders = array("SiteName", 
    "SiteDescription", 
    "Latitude", 
    "Longitude", 
    "Region", 
    "LocalDate", 
    "LocalTime", 
    "SurveyLocationCode", 
    "Circle", 
    "Orientation", 
    "PlantSpeciesMarkedByObserver", 
    "OfficialPlantSpecies", 
    "ObservationMethod", 
    "SurveyNotes", 
    "WetLeaves", 
    "NumberOfLeaves", 
    "AverageLeafLength", 
    "HerbivoryScore", 
    "ArthropodGroup", 
    "ArthropodLength", 
    "ArthropodQuantity", 
    "ArthropodPhotoURL", 
    "ArthropodNotes", 
    "IsCaterpillarAndIsHairy", 
    "IsCaterpillarAndIsInLeafRoll", 
    "IsCaterpillarAndIsInSilkTent");

  function getArrayFromTable(){
    global $colHeaders;
    $tableArray = array();
    
    $dbconn = (new Keychain)->getDatabaseConnection();
    $query = mysqli_query($dbconn, "SELECT Survey.ID, Survey.LocalDate, SUBSTR(Survey.LocalTime, 1, 5) AS `LocalTime`, Plant.Code AS SurveyLocationCode, Plant.Circle, Plant.Orientation, Survey.PlantSpecies AS PlantSpeciesMarkedByObserver, Plant.Species AS OfficialPlantSpecies, Site.Name AS SiteName, Site.Description AS SiteDescription, Site.Latitude, Site.Longitude, Site.Region, ArthropodSighting.Group AS ArthropodGroup, ArthropodSighting.Length AS ArthropodLength, ArthropodSighting.Quantity AS ArthropodQuantity, IF(ArthropodSighting.PhotoURL='','',CONCAT('https://caterpillarscount.unc.edu/images/arthropods/', ArthropodSighting.PhotoURL)) AS ArthropodPhotoURL, ArthropodSighting.Notes AS ArthropodNotes, ArthropodSighting.Hairy AS IsCaterpillarAndIsHairy, ArthropodSighting.Rolled AS IsCaterpillarAndIsInLeafRoll, ArthropodSighting.Tented AS IsCaterpillarAndIsInSilkTent, Survey.ObservationMethod, Survey.Notes AS SurveyNotes, Survey.WetLeaves, Survey.NumberOfLeaves, Survey.AverageLeafLength, Survey.HerbivoryScore FROM ArthropodSighting JOIN Survey ON ArthropodSighting.SurveyFK=Survey.ID JOIN Plant ON Survey.PlantFK=Plant.ID JOIN Site ON Plant.SiteFK=Site.ID WHERE Site.ID<>'2' ORDER BY Survey.LocalDate DESC, Survey.LocalTime DESC");
    
    //ROWS
    $surveyIDsWithSightings = array();
    while ($row = mysqli_fetch_assoc($query)){
      $rowArray = array();
      for($i = 0; $i < count($colHeaders); $i++){
        $rowArray[] = $row[$colHeaders[$i]];
      }
      $tableArray[] = $rowArray;
      $surveyIDsWithSightings[] = $row["ID"];
    }
    
    $query = mysqli_query($dbconn, "SELECT Survey.LocalDate, SUBSTR(Survey.LocalTime, 1, 5) AS `LocalTime`, Plant.Code AS SurveyLocationCode, Plant.Circle, Plant.Orientation, Survey.PlantSpecies AS PlantSpeciesMarkedByObserver, Plant.Species AS OfficialPlantSpecies, Site.Name AS SiteName, Site.Description AS SiteDescription, Site.Latitude, Site.Longitude, Site.Region, Survey.ObservationMethod, Survey.Notes AS SurveyNotes, Survey.WetLeaves, Survey.NumberOfLeaves, Survey.AverageLeafLength, Survey.HerbivoryScore FROM Survey JOIN Plant ON Survey.PlantFK=Plant.ID JOIN Site ON Plant.SiteFK=Site.ID WHERE Survey.ID NOT IN (" . join(", ", $surveyIDsWithSightings) . ") AND Site.ID<>'2'");
    mysqli_close($dbconn);
    while ($row = mysqli_fetch_assoc($query)){
      $rowArray = array();
      for($i = 0; $i < count($colHeaders); $i++){
        if(array_key_exists($colHeaders[$i], $row)){
          $rowArray[] = $row[$colHeaders[$i]];
        }
        else if($colHeaders[$i] == "ArthropodGroup"){
          $rowArray[] = "None";
        }
        else{
          $rowArray[] = "";
        }
      }
      $tableArray[] = $rowArray;
    }
    return $tableArray;
  }

  function customSort($a, $b){
    $alphabeticalResult = strcmp($a[0], $b[0]);
    if($alphabeticalResult != 0){
      return $alphabeticalResult;
    }
    $aTime = date_create_from_format("Y-m-d H:i", $a[5] . " " . $a[6]);
    $aTime = $aTime->getTimestamp();
    $bTime = date_create_from_format("Y-m-d H:i", $b[5] . " " . $b[6]);
    $bTime = $bTime->getTimestamp();
    return $bTime - $aTime;
  }
  
  if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['download'])){
    $tableArray = getArrayFromTable();
    usort($tableArray, "customSort");
    array_unshift($tableArray, $colHeaders);
    die(json_encode($tableArray));
    $filename = "CaterpillarsCountDataAtTimestamp_" . time() . ".csv";
    $fp = fopen($filename, 'w');
    foreach ($tableArray as $line) fputcsv($fp, $line);

    header('Content-Type: application/octet-stream');
    header("Content-Transfer-Encoding: Binary"); 
    header("Content-disposition: attachment; filename=\"" . basename($filename) . "\"");

    readfile($filename);
    //note that each line in this data pertains to a specific arthropod sighting, so surveys which contained no arthropod sightings are excluded from this data.
    unlink($filename);
  }
?>

<html>
	<head>
		<!-- Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-113319025-1"></script>
		<script>
  			window.dataLayer = window.dataLayer || [];
  			function gtag(){dataLayer.push(arguments);}
  			gtag('js', new Date());
			gtag('config', 'UA-113319025-1');
		</script>
		<!-- End of Google Analytics -->

		<title>Data Download | Caterpillars Count!</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
		<link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Fanwood+Text:400i" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">
		<link href="../css/template.css" rel="stylesheet">
		<script src="../js/template.js?v=1"></script>
		<script>
			$(document).ready(function(){
				loadBackgroundImage($("#splashImage"), "../images/splash.png");
			});
		</script>
	</head>
	<body>
		<div id="managerRequest">
			<div id="managerRequestMessage"></div>
			<div id="managerRequestButtons">
				<div class="managerRequestButton" onclick="hideNotice();respondToManagerRequest('deny');">Deny</div>
				<div class="managerRequestButton" onclick="hideNotice();respondToManagerRequest('approve');">Accept</div>
			</div>
		</div>
		<div id="error" onclick="hideNotice();"></div>
		<div id="confirmation" onclick="hideNotice();"></div>
		<div id="alert" onclick="hideNotice();"></div>
		<div id="promptInteractionBlock"></div>
		<div id="noticeInteractionBlock" onclick="hideNotice();"></div>
		<div id="confirm">
			<div></div>
			<div>
				<button>OK</button>
				<button>Cancel</button>
				<div class="clearBoth"></div>
			</div>
		</div>

		<div id="splash">
			<div id="splashImage"></div>
			<div id="splashOverlay">
				<div id="splashIntroText">Welcome to</div>
				<div id="splashMainText">Caterpillars Count!</div>
				<button id="splashButton" onclick="this.blur();scrollToPanel(1);">Explore maps & graphs</button>
			</div>
		</div>
		<header>
			<h1><a href="../">Caterpillars Count!</a></h1>
			<div id="hamburger" onclick="toggleNav();">
				<div></div>
				<div></div>
				<div></div>
			</div>
			<div id="navKnockDown" class="clearBoth"></div>
			<nav class="loadingNav">
				<ul>
					<li onclick="accessSubMenu(this);">
						<span>Participate</span>
						<ul onclick="event.stopPropagation();">
							<li class="closeSubmenu" onclick="closeSubmenu(this.parentNode);"><img src="../images/arrow.png"/></li>
							<li><a href="../getStarted">Get Started</a></li>
							<li><a href="../conductASurvey">Conduct a Survey</a></li>
							<li><a href="../submitObservations">Submit Observations</a></li>
							<li><a href="../hostASurveySite">Host a Survey Site</a></li>
							<li><a href="../resources">Resources</a></li>
						</ul>
					</li>
					<li onclick="accessSubMenu(this);">
						<span>Explore</span>
						<ul onclick="event.stopPropagation();">
							<li class="closeSubmenu" onclick="closeSubmenu(this.parentNode);"><img src="../images/arrow.png"/></li>
							<li><a href="../mapsAndGraphs">Maps & Graphs</a></li>
							<li><a href="https://www.inaturalist.org/observations?place_id=any&subview=grid&user_id=caterpillarscount&verifiable=any">Recent Observations</a></li>
						</ul>
					</li>
					<li onclick="accessSubMenu(this);">
						<span>Learn</span>
						<ul onclick="event.stopPropagation();">
							<li class="closeSubmenu" onclick="closeSubmenu(this.parentNode);"><img src="../images/arrow.png"/></li>
							<li><a href="../identificationSkills">Identification Skills</a></li>
							<li><a href="../forEducators">For Educators</a></li>
							<li><a href="../faq">FAQ</a></li>
						</ul>
					</li>
					<li onclick="window.location = '../news';">
						<span>News</span>
					</li>
					<li onclick="window.location = '../signIn';">
						<span>Sign In</span>
						<ul onclick="event.stopPropagation();">
							<li class="closeSubmenu" onclick="closeSubmenu(this.parentNode);"><img src="../images/arrow.png"/></li>
							<li><a href="../createNewSite">Create New Site</a></li>
							<li><a href="../manageMySites">Manage My Sites</a></li>
							<li><a href="../manageMySurveys">Manage My Surveys</a></li>
							<li><a href="../settings">Settings</a></li>
							<li><a href="" onclick="logOut();">Sign Out</a></li>
						</ul>
					</li>
				</ul>
			</nav>
			<div id="navBack" onclick="resetMenu(false);">&#10094;</div>
		</header>
		<main>
			<div class="panel">
				<h2>Data Download</h2>
				<div class="tagline">...will be coming soon</div>
        <form action="" method="post">
          <input type="submit" name="download" value="Download" />
        </form>
			</div>
		</main>
		<footer>
			<div>Part of the <a href="http://pheno-mismatch.org" target="_blank">Pheno Mismatch</a> project funded by the National Science Foundation</div>

			<div><img src="../images/unc.png"/></div><div>
				<a target="_blank" href="https://www.facebook.com/Caterpillars-Count-1854259101283140/"><img src="../images/facebook.png" alt="facebook"/></a><a target="_blank" href="https://twitter.com/CaterpillarsCt"><img src="../images/twitter.png" alt="twitter"/></a>
			</div>

			<div>Contact us: <a href="mailto:caterpillarscount@gmail.com">caterpillarscount@gmail.com</a></div>

			<div>View our <a href="../privacyPolicy">privacy policy</a></div>
		</footer>
	</body>
</html>
