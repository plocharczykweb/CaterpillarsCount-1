<?php
  require_once('orm/resources/Keychain.php');
  
  $dbconn = (new Keychain)->getDatabaseConnection();
  
  $firstName = $_GET["first"];
  $lastName = $_GET["last"];
  $email = $_GET["email"];
  $salt = mysqli_real_escape_string($dbconn, hash("sha512", rand() . rand() . rand()));
  $saltedPasswordHash = mysqli_real_escape_string($dbconn, hash("sha512", $salt . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9)));

  mysqli_query($dbconn, "INSERT INTO User (`FirstName`, `LastName`, `DesiredEmail`, `Email`, `Salt`, `SaltedPasswordHash`) VALUES ('$firstName', '$lastName', '$email', '$email', '$salt', '$saltedPasswordHash')");
  $id = intval(mysqli_insert_id($dbconn));
  mysqli_close($dbconn);
  die($id . "");
?>
