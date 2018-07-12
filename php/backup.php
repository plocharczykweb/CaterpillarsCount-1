<?php
  header('Access-Control-Allow-Origin: *');

  require_once('orm/resources/Keychain.php');

  // Open temp file pointer
  if (!$fp = fopen('php://temp', 'w+')) die("1");

  $dbconn = (new Keychain)->getDatabaseConnection();
  //HEADERS
  $query = mysqli_query($dbconn, "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='CaterpillarsCount' AND `TABLE_NAME`='User'");
  $colHeaders = array();
  while ($row = mysqli_fetch_assoc($query)) $colHeaders[] = $row["COLUMN_NAME"];
  fputcsv($fp, $colHeaders);

  // Loop data and write to file pointer
  $query = mysqli_query($dbconn, "SELECT * FROM `User`");
  while ($line = mysqli_fetch_assoc($query)) fputcsv($fp, $line);

  // Place stream pointer at beginning
  rewind($fp);

  // Return the data
  die(stream_get_contents($fp));
?>
