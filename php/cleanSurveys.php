<?php
	require_once('orm/resources/Keychain.php');
	
	$dbconn = (new Keychain)->getDatabaseConnection();
	
	$query = mysqli_query($dbconn, "SELECT * FROM `Survey` WHERE 1");
	
	while($row = mysqli_fetch_assoc($query)){
		if(mysqli_num_rows(mysqli_query($dbconn, "SELECT `ID` FROM `Plant` WHERE `ID`=" . $row["PlantFK"])) == 0){
			mysqli_query($dbconn, "DELETE FROM `Survey` WHERE `ID`=" . $row["ID"]);
		}
	}
?>
