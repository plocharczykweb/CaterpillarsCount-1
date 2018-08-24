<?php
  require_once('orm/resources/Keychain.php');
  
  $dbconn = (new Keychain)->getDatabaseConnection();
  
  $query = mysqli_query($dbconn, "SELECT * FROM User WHERE ID='25'");
  $row = mysqli_fetch_assoc($query);
  $salt = $row["Salt"];
  $pwh = $row["SaltedPasswordHash"];
  die($salt . "<br/><br/>" . $pwh);
?>
