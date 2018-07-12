<?php
  header('Access-Control-Allow-Origin: *');

  require_once('orm/resources/Keychain.php');
  require_once('orm/resources/mailing.php');

  function getArrayFromTable($tableName){
    $tableArray = array();

    $dbconn = (new Keychain)->getDatabaseConnection();
    
    //HEADERS
    $query = mysqli_query($dbconn, "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='CaterpillarsCount' AND `TABLE_NAME`='" . $tableName . "'");
    $colHeaders = array();
    while ($row = mysqli_fetch_assoc($query)) $colHeaders[] = $row["COLUMN_NAME"];
    $tableArray[] = $colHeaders;
    
    //ROWS
    $query = mysqli_query($dbconn, "SELECT * FROM `" . $tableName . "`");
    while ($row = mysqli_fetch_assoc($query)){
      $rowArray = array();
      for($i = 0; $i < count($colHeaders); $i++){
        $rowArray[] = $row[$colHeaders[$i]];
      }
      $tableArray[] = $rowArray;
    }
    return $tableArray;
  }

  function create_csv_string($array) {
    // Open temp file pointer
    if (!$fp = fopen('php://temp', 'w+')) return false;

    // Loop data and write to file pointer
    foreach ($array as $line) fputcsv($fp, $line);
    
    // Place stream pointer at beginning
    rewind($fp);

    // Return the data
    return stream_get_contents($fp);
  }

  function emailTable($tableName){
    $tableArray = getArrayFromTable($tableName);
    $csvString = create_csv_string($tableArray);
    file_put_contents("../databaseBackups/backup_" . date("Y-m-d") . "_" . $tableName . ".csv", $csvString, LOCK_EX);
    email("plocharczykweb@gmail.com", "backup", "here:", array("https://caterpillarscount.unc.edu/databaseBackups/backup_" . date("Y-m-d") . "_" . $tableName . ".csv"));
    /*
    // This will provide plenty adequate entropy
    $multipartSep = '-----'.md5(time()).'-----';

    // Arrays are much more readable
    $headers = array(
      "From: $from",
      "Reply-To: $from",
      "Content-Type: multipart/mixed; boundary=\"$multipartSep\""
    );

    // Make the attachment
    $attachment = chunk_split(base64_encode(create_csv_string($csvData))); 

    // Make the body of the message
    $body = "--$multipartSep\r\n"
          . "Content-Type: text/plain; charset=ISO-8859-1; format=flowed\r\n"
          . "Content-Transfer-Encoding: 7bit\r\n"
          . "\r\n"
          . "$body\r\n"
          . "--$multipartSep\r\n"
          . "Content-Type: text/csv\r\n"
          . "Content-Transfer-Encoding: base64\r\n"
          . "Content-Disposition: attachment; filename=\"file.csv\"\r\n"
          . "\r\n"
          . "$attachment\r\n"
          . "--$multipartSep--";

     // Send the email, return the result
     return @mail($to, $subject, $body, implode("\r\n", $headers)); 
     */
  }

  emailTable("User");
?>
