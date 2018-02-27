<?php
	require_once("orm/Site.php");
	
	$publicSites = Site::findAllPublicSites();
	$publicSitesArray = array();
	for($i = 0; $i < count($publicSites); $i++){
		//send email in parts to avoid spam spiders
		$email = $publicSites[$i]->getCreator()->getEmail();
		$atIndex = strrpos($email, "@");
		$beforeAt = substr($email, 0, $atIndex);
		$afterAt = substr($email, ($atIndex + 1));
		
		$publicSitesArray[$i] = array(
			"creatorEmailParts" => array($beforeAt, $afterAt),
			"siteName" => $publicSites[$i]->getName(),
			"description" => $publicSites[$i]->getDescription(),
			"region" => $publicSites[$i]->getRegion(),
			"latitude" => $publicSites[$i]->getLatitude(),
			"longitude" => $publicSites[$i]->getLongitude(),
		);
	}

	$staticSites = array(
		array(
			"creatorEmailParts" => array("cappaert", "comcast.net"),
		    	"siteName" => "Environmental Sciences Magnet School",
		    	"description" => "Landscaped campus of the Environmental Sciences Magnet School, 440 Broadview Terrace, Hartford, CT 06106",
		    	"region" => "CT",
		    	"latitude" => 41.7409,
		    	"longitude" => -72.7024,
		),
		array(
			"creatorEmailParts" => array("cappaert", "comcast.net"),
		    	"siteName" => "Matianuck State Park",
		    	"description" => "A state park with beech/oak/pine forest near sand dune remnants",
		    	"region" => "CT",
		    	"latitude" => 41.8136,
		    	"longitude" => -72.6827,
		),
		array(
			"creatorEmailParts" => array("mckinnontara1", "gmail.com"),
		    	"siteName" => "Red Top Mountain State Park",
		    	"description" => "Red Top Mountain is a 1,776 acre park located on Lake Allatoona. It has hiking, camping, an outdoor classroom, and is mostly forested.",
		    	"region" => "GA",
		    	"latitude" => 34.15491,
		    	"longitude" => -84.702294,
		),
		array(
			"creatorEmailParts" => array("edalton", "manomet.org"),
		    	"siteName" => "Manomet Bird Observatory",
		    	"description" => "Long-term bird banding station and center for conservation science",
		    	"region" => "MA",
		    	"latitude" => 41.8333,
		    	"longitude" => -70.5,
		),/*
		array(
			"creatorEmailParts" => array("si_citizenscience", "schoodicinstitute.org"),
		    	"siteName" => "Acadia NP - Alder",
		    	"description" => "Located at the Schoodic Education and Research Center, Winter Harbor Maine, where the phenology of birds, plants, and insects are being monitored.",
		    	"region" => "ME",
		    	"latitude" => 44.3424,
		    	"longitude" => -68.0528,
		),
		array(
			"creatorEmailParts" => array("si_citizenscience", "schoodicinstitute.org"),
		    	"siteName" => "Acadia NP - Sundew",
		    	"description" => "Located at the Schoodic Education and Research Center, Winter Harbor Maine, where the phenology of birds, plants, and insects are being monitored.",
		    	"region" => "ME",
		    	"latitude" => 44.3393,
		    	"longitude" => -68.0657,
		),
		array(
			"creatorEmailParts" => array("contact", "naturecenter.org"),
		    	"siteName" => "Kalamazoo Nature Center",
		    	"description" => "A nature center with 1,100 acres of wooded, rolling countryside ",
		    	"region" => "MI",
		    	"latitude" => 42.3604,
		    	"longitude" => -85.5836,
		),*/
		array(
			"creatorEmailParts" => array("bonnie.nevel", "dukeschool.org"),
		    	"siteName" => "Duke School",
		    	"description" => "Duke School is an independent preschool through eighth grade project-based school.",
		    	"region" => "NC",
		    	"latitude" => 35.9998,
		    	"longitude" => -78.966,
		),
		array(
			"creatorEmailParts" => array("vancechalcrafth", "ecu.edu"),
		    	"siteName" => "East Carolina University",
		    	"description" => "ECU campus",
		    	"region" => "NC",
		    	"latitude" => 35.6064,
		    	"longitude" => -77.3663,
		),
		array(
			"creatorEmailParts" => array("max.cawley", "lifeandscience.org"),
		    	"siteName" => "North Carolina Museum of Life and Science",
		    	"description" => "Our interactive science park includes a two-story science center, one of the largest butterfly conservatories on the East Coast and beautifully landscaped outdoor exhibits",
		    	"region" => "NC",
		    	"latitude" => 36.0294,
		    	"longitude" => -78.9016,
		),
		array(
			"creatorEmailParts" => array("hurlbert", "bio.unc.edu"),
		    	"siteName" => "North Carolina Botanical Garden",
		    	"description" => "Survey sites are along the Streamside Trail of the North Carolina Botanical Garden.",
		    	"region" => "NC",
		    	"latitude" => 35.8994,
		    	"longitude" => -79.0339,
		),
		array(
			"creatorEmailParts" => array("terryagates", "gmail.com"),
		    	"siteName" => "North Carolina State University",
		    	"description" => "North Carolina State University campus",
		    	"region" => "NC",
		    	"latitude" => 35.782,
		    	"longitude" => -78.675,
		),
		array(
			"creatorEmailParts" => array("chris.goforth", "naturalsciences.org"),
		    	"siteName" => "Prairie Ridge Ecostation",
		    	"description" => "Prairie Ridge Ecostation is an outdoor nature center, part of the NC Museum of Natural Sciences, with 45 acres of Piedmont prairie, forest, ponds, a stream and sustainable building features integrated with a wildlife-friendly landscape.",
		    	"region" => "NC",
		    	"latitude" => 35.8117,
		    	"longitude" => -78.7139,
		),
		array(
			"creatorEmailParts" => array("wildspiriteducation", "gmail.com"),
		    	"siteName" => "Wild Spirit Education",
		    	"description" => "Wild Spirit offers a wide variety of Environmental Education programs",
		    	"region" => "NY",
		    	"latitude" => 42.4997,
		    	"longitude" => -78.4351,
		),
		array(
			"creatorEmailParts" => array("murrenc", "cofc.edu"),
		    	"siteName" => "Caw Caw Interpretive Center",
		    	"description" => "A low-impact wildlife preserve with interpretive exhibits and displays, miles of trails, and environmental and social studies education programs",
		    	"region" => "SC",
		    	"latitude" => 32.782937,
		    	"longitude" => -80.193718,
		),
		array(
			"creatorEmailParts" => array("tbausti", "g.clemson.edu"),
		    	"siteName" => "Roxbury Park",
		    	"description" => "A public park (open weekends) owned and operated by the Town of Meggett, SC.",
		    	"region" => "SC",
		    	"latitude" => 32.6824,
		    	"longitude" => -80.3473,
		),
		array(
			"creatorEmailParts" => array("tiffany", "gsmit.org"),
		    	"siteName" => "Great Smoky Mountains Institute at Tremont",
		    	"description" => "Monitoring Avian Productivity and Surivorship (MAPS) station at the Great Smoky Mountains Institute at Tremont",
		    	"region" => "TN",
		    	"latitude" => 35.6402,
		    	"longitude" => -83.6888,
		),
	);

	$publicSitesArray = array_merge($publicSitesArray, $staticSites);

	die(json_encode($publicSitesArray));
?>
