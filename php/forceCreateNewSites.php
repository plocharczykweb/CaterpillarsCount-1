<?php
	require_once('orm/resources/Keychain.php');
	require_once('orm/Site.php');
	require_once('orm/Plant.php');

	$creatorID = $_GET["creatorID"];
	$name = $_GET["name"];
	$description = $_GET["description"];
	$latitude = $_GET["latitude"];
	$longitude = $_GET["longitude"];
	$region = $_GET["region"];
	
	$dbconn = (new Keychain)->getDatabaseConnection();
	
	$salt = mysqli_real_escape_string($dbconn, hash("sha512", rand() . rand() . rand()));
	$saltedPasswordHash = mysqli_real_escape_string($dbconn, hash("sha512", $salt . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9)));
	mysqli_query($dbconn, "INSERT INTO Site (`UserFKOfCreator`, `Name`, `Description`, `Latitude`, `Longitude`, `Region`, `Salt`, `SaltedPasswordHash`, `OpenToPublic`) VALUES ('$creatorID', '$name', '$description', '$latitude', '$longitude', '$region', '$salt', '$saltedPasswordHash', '0')");
	$id = intval(mysqli_insert_id($dbconn)) . "";
	mysqli_close($dbconn);

	$site = Site::findByID($id);
	$a = Plant::create($site, 1, "A");
	$b = Plant::create($site, 1, "B");
	$c = Plant::create($site, 1, "C");
	$d = Plant::create($site, 1, "D");
	$e = Plant::create($site, 1, "E");
	
	die($id);
?>
