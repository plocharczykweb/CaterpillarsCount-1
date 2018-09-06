<?php
  require_once("orm/resources/Keychain.php");
  require_once("orm/Site.php");
  $dbconn = (new Keychain)->getDatabaseConnection();
  
  $description="hello https://google.com, how are you http://yahoo.com https://bing.com https://ask.com?";
  $description = Site::validDescription($dbconn, $description);
  echo $description;
?>
