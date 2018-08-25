<?php
	require_once('orm/resources/Keychain.php');
	require_once('orm/Site.php');
	require_once('orm/Plant.php');
	$creatorID = '1031';
	$names = array("BBS 27-041-11", "BBS 27-041-32", "BBS 63-022-05", "BBS 63-031-05", "BBS 63-031-17", "BBS 63-906-15", "BBS 63-906-27", "BBS 63-906-44", "BBS 63-909-09", "BBS 63-909-44", "BBS 63-910-06", "BBS 63-910-28", "BBS 63-911-08", "BBS 63-911-38", "BBS 82-042-06", "BBS 82-042-19", "BBS 82-042-40", "BBS 82-902-43", "BBS 82-903-39", "BBS 82-903-44", "BBS 88-900-09", "BBS 88-900-29", "BBS 88-902-23", "BBS 88-902-36", "BBS 88-905-17", "BBS 88-905-38", "BBS 88-907-21", "BBS 88-907-45", "BBS 88-920-25", "BBS 88-920-36", "BBS 88-921-12", "BBS 88-921-30", "BBS 88-922-17", "BBS 88-922-42", "BBS 88-923-05", "BBS 88-923-46");
	$descriptions = array("Breeding Bird Survey in Georgia, route 41, point count stop 32", "Breeding Bird Survey in North Carolina, route 22, point count stop 5", "Breeding Bird Survey in North Carolina, route 31, point count stop 5", "Breeding Bird Survey in North Carolina, route 31, point count stop 17", "Breeding Bird Survey in North Carolina, route 906, point count stop 15", "Breeding Bird Survey in North Carolina, route 906, point count stop 27", "Breeding Bird Survey in North Carolina, route 906, point count stop 44", "Breeding Bird Survey in North Carolina, route 909, point count stop 9", "Breeding Bird Survey in North Carolina, route 909, point count stop 44", "Breeding Bird Survey in North Carolina, route 910, point count stop 6", "Breeding Bird Survey in North Carolina, route 910, point count stop 28", "Breeding Bird Survey in North Carolina, route 911, point count stop 8", "Breeding Bird Survey in North Carolina, route 911, point count stop 38", "Breeding Bird Survey in Tennessee, route 42, point count stop 6", "Breeding Bird Survey in Tennessee, route 42, point count stop 19", "Breeding Bird Survey in Tennessee, route 42, point count stop 40", "Breeding Bird Survey in Tennessee, route 902, point count stop 43", "Breeding Bird Survey in Tennessee, route 903, point count stop 39", "Breeding Bird Survey in Tennessee, route 903, point count stop 44", "Breeding Bird Survey in Virginia, route 900, point count stop 9", "Breeding Bird Survey in Virginia, route 900, point count stop 29", "Breeding Bird Survey in Virginia, route 902, point count stop 23", "Breeding Bird Survey in Virginia, route 902, point count stop 36", "Breeding Bird Survey in Virginia, route 905, point count stop 17", "Breeding Bird Survey in Virginia, route 905, point count stop 38", "Breeding Bird Survey in Virginia, route 907, point count stop 21", "Breeding Bird Survey in Virginia, route 907, point count stop 45", "Breeding Bird Survey in Virginia, route 920, point count stop 25", "Breeding Bird Survey in Virginia, route 920, point count stop 36", "Breeding Bird Survey in Virginia, route 921, point count stop 12", "Breeding Bird Survey in Virginia, route 921, point count stop 30", "Breeding Bird Survey in Virginia, route 922, point count stop 17", "Breeding Bird Survey in Virginia, route 922, point count stop 42", "Breeding Bird Survey in Virginia, route 923, point count stop 5", "Breeding Bird Survey in Virginia, route 923, point count stop 46");
	$latitudes = array("34.9052", "34.972", "35.4416", "36.0494", "36.0909", "35.7216", "35.7373", "35.7753", "35.8795", "35.919", "35.0275", "35.0357", "35.2041", "35.1564", "36.288", "36.2383", "36.1736", "35.322", "35.628", "35.623", "37.7387", "37.727", "37.5402", "37.517", "37.5304", "37.5955", "38.3889", "38.2907", "36.6846", "36.7176", "38.6157", "38.5467", "38.2563", "38.1479", "38.8946", "38.7536");
	$longitudes = array("-83.4784", "-83.465", "-83.8522", "-81.8589", "-81.8108", "-83.0743", "-83.0409", "-82.9594", "-81.8331", "-81.8046", "-83.2122", "-83.1746", "-83.5848", "-83.6398", "-82.0659", "-82.0275", "-82.0653", "-84.0661", "-83.174", "-83.1914", "-79.2707", "-79.2448", "-79.5683", "-79.6178", "-80.2033", "-80.1508", "-78.5134", "-78.6244", "-81.5506", "-81.5224", "-78.3505", "-78.389", "-78.6668", "-78.775", "-78.1976", "-78.2981");
	$regions = array("GA", "GA", "NC", "NC", "NC", "NC", "NC", "NC", "NC", "NC", "NC", "NC", "NC", "NC", "TN", "TN", "TN", "TN", "TN", "TN", "VA", "VA", "VA", "VA", "VA", "VA", "VA", "VA", "VA", "VA", "VA", "VA", "VA", "VA", "VA", "VA");
	
	$dbconn = (new Keychain)->getDatabaseConnection();
	for($i = 0; $i < count($names); $i++){
		$name = trim($names[$i]);
		$description = trim($descriptions[$i]);
		$latitude = trim($latitudes[$i]);
		$longitude = trim($longitudes[$i]);
		$region = trim($regions[$i]);


		$salt = mysqli_real_escape_string($dbconn, hash("sha512", rand() . rand() . rand()));
		$saltedPasswordHash = mysqli_real_escape_string($dbconn, hash("sha512", $salt . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9)));
		mysqli_query($dbconn, "INSERT INTO Site (`UserFKOfCreator`, `Name`, `Description`, `Latitude`, `Longitude`, `Region`, `Salt`, `SaltedPasswordHash`, `OpenToPublic`) VALUES ('$creatorID', '$name', '$description', '$latitude', '$longitude', '$region', '$salt', '$saltedPasswordHash', '0')");
		$id = intval(mysqli_insert_id($dbconn)) . "";

		$site = Site::findByID($id);
		$a = Plant::create($site, 1, "A");
		$b = Plant::create($site, 1, "B");
		$c = Plant::create($site, 1, "C");
		$d = Plant::create($site, 1, "D");
		$e = Plant::create($site, 1, "E");

		echo $id . "<br/>";
	}
	mysqli_close($dbconn);
?>
