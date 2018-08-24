<?php
  require_once('orm/resources/Keychain.php');
  
  $dbconn = (new Keychain)->getDatabaseConnection();
  
  $firstName = rawurldecode($_GET["first"]);
  $lastName = rawurldecode($_GET["last"]);
  $email = rawurldecode($_GET["email"]);

  if(mysqli_num_rows(mysqli_query($dbconn, "SELECT `ID` FROM `User` WHERE `Email`='" . $email . "' LIMIT 1")) == 0){
    $salt = mysqli_real_escape_string($dbconn, hash("sha512", rand() . rand() . rand()));
    $saltedPasswordHash = mysqli_real_escape_string($dbconn, hash("sha512", $salt . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9)));

    mysqli_query($dbconn, "INSERT INTO User (`FirstName`, `LastName`, `DesiredEmail`, `Email`, `Salt`, `SaltedPasswordHash`) VALUES ('$firstName', '$lastName', '$email', '$email', '$salt', '$saltedPasswordHash')");
    $id = intval(mysqli_insert_id($dbconn));
    mysqli_close($dbconn);
    die($id . "");
  }
  die($email);
?>
