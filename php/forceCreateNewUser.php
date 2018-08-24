<?php
  require_once('orm/resources/Keychain.php');
  
  $dbconn = (new Keychain)->getDatabaseConnection();
  
  $firstName = $_GET["first"];
  $lastName = $_GET["last"];
  $email = $_GET["email"];
  $salt = "";
  $saltedPasswordHash = "";
  
  mysqli_query($dbconn, "INSERT INTO User (`FirstName`, `LastName`, `DesiredEmail`, `Email`, `Salt`, `SaltedPasswordHash`) VALUES ('$firstName', '$lastName', '$email', '$email', '$salt', '$saltedPasswordHash')");
  $id = intval(mysqli_insert_id($dbconn));
  mysqli_close($dbconn);
  die($id);
?>
