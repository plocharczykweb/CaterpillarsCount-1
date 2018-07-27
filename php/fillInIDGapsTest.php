<?php
require_once('orm/resources/Keychain.php');
$dbconn = (new Keychain)->getDatabaseConnection();
  $query = mysqli_query($dbconn, "SELECT t1.ID+1 AS NextID FROM `Plant` AS t1 LEFT JOIN `Plant` AS t2 ON t1.ID+1=t2.ID WHERE t2.ID IS NULL");
			while(($row = mysqli_fetch_assoc($query) && $id = intval($row["NextID"])) || $id += 1){
				echo $id;
        if($id > 3700){break;}
        //if(mysqli_num_rows(mysqli_query($dbconn, "SELECT `ID` FROM `Plant` WHERE `Code`='" . self::IDToCode($id) . "' LIMIT 1")) == 0){
					//break;
				//}
			}
?>
