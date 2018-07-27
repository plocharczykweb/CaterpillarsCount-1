<?php
	require_once('orm/resources/Keychain.php');
	require_once('orm/Plant.php');
	$dbconn = (new Keychain)->getDatabaseConnection();
	$id = 1261;
	echo Plant::IDToCode($id) . "<br/>";
	$query = mysqli_query($dbconn, "SELECT t1.ID+1 AS NextID FROM `Plant` AS t1 LEFT JOIN `Plant` AS t2 ON t1.ID+1=t2.ID WHERE t2.ID IS NULL");
	while($row = mysqli_fetch_assoc($query)){
		$id = intval($row["NextID"]);
		while(mysqli_num_rows(mysqli_query($dbconn, "SELECT `ID` FROM `Plant` WHERE `ID`='" . $id . "' LIMIT 1")) == 0){
			echo $id;
			if($id > 3700){
				break 2;
			}
			$id++;
		}
	}
?>
