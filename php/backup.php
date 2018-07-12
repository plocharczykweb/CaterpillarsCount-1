<?php
  header('Access-Control-Allow-Origin: *');

  require_once('orm/resources/Keychain.php');

  $dbconn = (new Keychain)->getDatabaseConnection();
  //mysql_connect(HOST, USERNAME, PASSWORD);
  //mysql_select_db(DATABASE);
  
  $query = mysqli_query($dbconn, "SELECT * FROM `User`");
  //$data = mysql_query('SELECT id, company, name, company_account_number, email, phone_number, invoice FROM carlofontanos_table');

  // Open temp file pointer
  if (!$fp = fopen('php://temp', 'w+')) die("1");

  //HEADERS
  //fputcsv($fp, array('ID', 'Company', 'Name', 'Company Account Number', 'Email', 'Phone Number', 'Invoice'));

  // Loop data and write to file pointer
  while ($line = mysqli_fetch_assoc($query)) fputcsv($fp, $line);

  // Place stream pointer at beginning
  rewind($fp);

  // Return the data
  die(stream_get_contents($fp));
?>
