<?php
	/*
	$mysqli = new mysqli(getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_HOST') . ':' . getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_PORT'),
			$_ENV['MYSQL_USER'],
			$_ENV['MYSQL_PASSWORD'], "caterpillars");
	
	echo getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_HOST') . getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_PORT') . $_ENV['MYSQL_USER'] . $_ENV['MYSQL_PASSWORD'];
		
	if($mysqli->connect_errno) die("Error: " . mysqli_error($mysqlCon));
	
	echo 'sucessfully connected<br>';
	
	$mysqli->query("drop table if exists quiz_photos");
	$mysqli->query("create table quiz_photos ( " .
       "id int primary key not null auto_increment, " .
       "classification char(50) not null, " .
       "url varchar(100) not null)");
	
	$orders = array("Araneae", "Auchenorrhyncha", "Coleoptera", "Diptera", "Formicidae","Heteroptera", "Hymenoptera", "Lepidoptera", "Lepidoptera larvae", "Opiliones", "Orthoptera", "Sternorrhyncha");
	
	for ($i = 0; $i < count($orders); $i++) {
		$json = null;
		if (strcmp($orders[$i],"Lepidoptera larvae") == 0){
			$json = json_decode(file_get_contents("https://www.inaturalist.org/observations.json?has[]=photos&field:butterfly%252Fmoth%20life%20stage=caterpillar&quality_grade=research"), true);
		} else {
			$json = json_decode(file_get_contents("https://www.inaturalist.org/observations.json?has[]=photos&quality_grade=research&taxon_name=" . $orders[$i]), true);
		}
		
		for ($j = 0; $j < 20; $j++) {
			$url = $json[$j]['photos'][0]['medium_url'];
			$result = $mysqli->query("insert into quiz_photos values (0,'" . $orders[$i] . "', '" . $url . "')");
			if($result == null) {
				echo 'query error<br>';
			} else {
				echo 'successfully added a photo of' . $orders[$i] . '<br>';
			}
		}
	}
	
	
	$mysqli->close();
	*/
?>