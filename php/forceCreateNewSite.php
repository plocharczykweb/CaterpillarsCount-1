<?php
  require_once('orm/resources/Keychain.php');
  
  $dbconn = (new Keychain)->getDatabaseConnection();
  
  $salt = mysqli_real_escape_string($dbconn, hash("sha512", rand() . rand() . rand()));
  $saltedPasswordHash = mysqli_real_escape_string($dbconn, hash("sha512", $salt . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9)));
  mysqli_query($dbconn, "INSERT INTO Site (`UserFKOfCreator`, `Name`, `Description`, `Latitude`, `Longitude`, `Region`, `Salt`, `SaltedPasswordHash`, `OpenToPublic`) VALUES ('940', 'NC Museum of Life and Science', 'Our interactive science park includes a two-story science center, one of the largest butterfly conservatories on the East Coast and beautifu', '36.0294', '-78.9016', 'NC', '$salt', '$saltedPasswordHash', '0')");
  $id = intval(mysqli_insert_id($dbconn));
  mysqli_close($dbconn);
  die($id . "");
  require_once('orm/Site.php');
require_once('orm/Plant.php');
$site = Site::findByID("112");
  $a = Plant::create($site, 1, "A");
				$b = Plant::create($site, 1, "B");
				$c = Plant::create($site, 1, "C");
				$d = Plant::create($site, 1, "D");
				$e = Plant::create($site, 1, "E");
?>
