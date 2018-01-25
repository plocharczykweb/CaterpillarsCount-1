<?php

	//Request for counts of photos in database
	if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_REQUEST['action']) && $_REQUEST['action'] == "count") {
		
		$mysqli = new mysqli(getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_HOST') . ':' . getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_PORT'),
			$_ENV['MYSQL_USER'],
			$_ENV['MYSQL_PASSWORD'], "caterpillars");
		
		if($mysqli->connect_errno) die("Error: " . mysqli_error($mysqlCon));
		
		$orders = array("Araneae", "Auchenorrhyncha", "Coleoptera", "Diptera", "Formicidae","Heteroptera", "Hymenoptera", "Lepidoptera", "Lepidoptera larvae", "Opiliones", "Orthoptera", "Sternorrhyncha");
		$counts = array();
		
		foreach ($orders as $order) {
			
			$result = $mysqli->query("select count(*) as num from quiz_photos where classification='" . $order . "'");
			if (!$result) {
				echo "Error 1: " . $mysqli->error;
			}
			$row = $result->fetch_assoc();
			if (!$row) {
				echo "Error 2: " . $mysqli->error;
			}
			$count = $row['num'];
			$counts[$order] = $count;
		}
		
		mysqli_close($mysqli);
		
		header("Content-type: application/json");
		print(json_encode($counts));
		exit();
		
	//Request to check if a url is the that of an image. Also checks if the file exists.	
	} else if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_REQUEST['url'])) {
		$imgExts = array(".gif", ".jpg", ".jpeg", ".png", ".tiff", ".tif");
		$file = $_REQUEST['url'];
		
		if (substr($file, 0, 4) != "http") {
			header('Content-Type:text/plain');
			print("is not complete. It needs to start with http or https");
			exit();
		}
		
		$fileLC = strtolower($file);
		
		for ($x = 0; $x < count($imgExts); $x++) {
			if (strpos($fileLC, $imgExts[$x])) {
				break;
			}
			if ($x == count($imgExts) - 1) {
				header('Content-Type:text/plain');
				print("is not the path for an image");
				exit();
			}
		}
		
		$file_headers = get_headers($file);
		//print_r($file_headers);
		
		if($file_headers[0] == 'HTTP/1.0 404 Not Found' || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
			header('Content-Type:text/plain');
			print("does not exist");
			exit();
		}
		else {
			header('Content-Type:text/plain');
			print("does exist");
			exit();
		}

	//Request to add photos to database
	} else if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_REQUEST['url']) &&  isset($_REQUEST['order'])) {
		
		$url = $_REQUEST['url'];
		$order = $_REQUEST['order'];
		
		$response = addToDatabase($order, $url);
		
		header('Content-Type:text/plain');
		print_r($response);
		exit();

	//Request to add X random photos of each order from iNaturalist to database
	} else if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_REQUEST['num'])) {
		
		$reponse = "";
		$numToAdd = intval($_REQUEST['num']);
		
		$numCatLeft = getNumCatLeft();
		
		if ($numToAdd <= $numCatLeft) {
			$response = addRandPhotosOfEachOrder($numToAdd);
		} else {
			$response = "The amount of new photos you want to add is too much. There are only this many new caterpillar photos left in iNaturalist: " . $numCatLeft;
		}
		
		header('Content-Type:text/plain');
		print_r($response);
		exit();
		
	} else if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_REQUEST['action']) && $_REQUEST['action'] == "test") {
		
		if ($_REQUEST['testnum'] == "1") {
			$base= "https://www.inaturalist.org/observations.json?has[]=photos&field:butterfly%252Fmoth%20life%20stage=caterpillar&per_page=120&order_by=observed_on";
			$jList = json_decode(file_get_contents($base), true);
			$goodURLs = getGoodURLs($jList);
			echo sizeof($goodURLs);
		} else if ($_REQUEST['testnum'] == "2") {
			$response = addRandPhotosOfOrder("Araneae", 5);
			echo $response;
		}
		
	}
	
	
	function getNumCatLeft() {
			$mysqli = new mysqli(getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_HOST') . ':' . getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_PORT'),
			$_ENV['MYSQL_USER'],
			$_ENV['MYSQL_PASSWORD'], "caterpillars");
		
			if($mysqli->connect_errno) die("Error: " . mysqli_error($mysqlCon));
			
			$result = $mysqli->query("select count(*) as num from quiz_photos where classification='Lepidoptera larvae'");
			$row = $result->fetch_assoc();
			$numInDB = $row['num'];
			
			$base= "https://www.inaturalist.org/observations.json?has[]=photos&field:butterfly%252Fmoth%20life%20stage=caterpillar&per_page=120&order_by=observed_on";
			$jList = json_decode(file_get_contents($base), true);
			$numAtINat = sizeof($jList);
			
			return $numAtINat - $numInDB;
	}
	
	
	function addRandPhotosOfEachOrder($numToAdd) {
		$orders = array("Araneae", "Auchenorrhyncha", "Coleoptera", "Diptera", "Formicidae","Heteroptera", "Hymenoptera", "Lepidoptera", "Lepidoptera larvae", "Opiliones", "Orthoptera", "Sternorrhyncha");
		$response = "";
		foreach ($orders as $order) {
			$response = $response . " " . addRandPhotosOfOrder($order, $numToAdd);
		}
		return $response;
	}
	
	
	function addRandPhotosOfOrder($order, $numToAdd) {
		
		$limit = 100;
		$goodURLs = array();
		
		// At this point, there should be enough new photos of larvae and opiliones in the corresponding jList
		if ($order == "Lepidoptera larvae") {
			$base= "https://www.inaturalist.org/observations.json?has[]=photos&field:butterfly%252Fmoth%20life%20stage=caterpillar&per_page=120&order_by=observed_on";
			$jList = json_decode(file_get_contents($base), true);
			$goodURLs = getGoodURLs($jList);
			if (sizeof($goodURLs) < $numToAdd) {
				return "Stopping. Tried to add photos of Lepidoptera larvae. The number of new photos left is " . sizeof($goodURLs) . "\n";
			}
			
		} else if ($order == "Opiliones") {
			$base = "https://www.inaturalist.org/observations.json?&taxon_name=Opiliones&per_page=200&has[]=photos&quality_grade=research&order_by=observed_on";
			$jList = json_decode(file_get_contents($base), true);
			$goodURLs = getGoodURLs($jList);
			if (sizeof($goodURLs) < $numToAdd) {
				return "Stopping. Tried to add photos of Opiliones. The number of new photos left is " . sizeof($goodURLs) . "\n";
			}
			
		} else {
			
			for ($i = 0; $i < $limit; $i++) {
				$y = rand(2010, 2015);
				$m = rand(1,12);
				
				$base = "https://www.inaturalist.org/observations.json?has[]=photos&quality_grade=research&order_by=observed_on&taxon_name=";
				$jList = json_decode(file_get_contents($base . $order . "&year=" . $y . "&month=" . $m), true);
				
				if (sizeof($jList) != 0) {
					
					$goodURLs = array_merge($goodURLs, getGoodURLs($jList));
					if (sizeof($goodURLs) >= $numToAdd) {
						break;
					}
				}
				
				if ($i == $limit - 1) {
					return "Stopping. Tried " . $limit . " times to get a " . $order . " photo. The size of the latest json array is :" . sizeof($jList) . ". Year: " . $y . ". Month: ". $m . "\n";
				}
			
			}
		}	
		
		$response = "";
		
		for ($i = 0; $i < $numToAdd; $i++) {
			$response = $response . addToDatabase($order, $goodURLs[$i]);
		}
		
		return $response;
		
	}
	
	function getGoodURLs($jList) {
		$goodURLs = array();
		for ($i = 0; $i < sizeOf($jList); $i++) {
			$url = $jList[$i]['photos'][0]['medium_url'];
			if (!urlIsInDatabase($url)){
				array_push($goodURLs, $url);
			}
				
		}
		return $goodURLs;
	}
	
	function addToDatabase($order, $url) {
		$mysqli = new mysqli(getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_HOST') . ':' . getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_PORT'),
			$_ENV['MYSQL_USER'],
			$_ENV['MYSQL_PASSWORD'], "caterpillars");
			
		if($mysqli->connect_errno) die("Error: " . mysqli_error($mysqlCon));
		$result = $mysqli->query("insert into quiz_photos values (0,'" . $order . "', '" . $url . "')");
		
		$response = null;
		
		if ($result) {
			$response = "sucesssully added quiz photo of " . $order . "\n";
		} else {
			$response = "failed to add photo" . $order . "\n";
		}
		
		mysqli_close($mysqli);
		
		return $response;
	}
	
	
	function urlIsInDatabase($url) {
		$mysqli = new mysqli(getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_HOST') . ':' . getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_PORT'),
			$_ENV['MYSQL_USER'],
			$_ENV['MYSQL_PASSWORD'], "caterpillars");
			
		if($mysqli->connect_errno) die("Error: " . mysqli_error($mysqlCon));
		$result = $mysqli->query("select count(*) as num from quiz_photos where url='" . $url . "'");
		if (!$result) {
			echo "Error 1: " . $mysqli->error;
		}
		$row = $result->fetch_assoc();
		if (!$row) {
			echo "Error 2: " . $mysqli->error;
		}
		$count = intval($row['num']);
		
		mysqli_close($mysqli);
		
		if ($count == 0) {
			return false;
		} else {
			return true;
		}
		
	}
	

?>