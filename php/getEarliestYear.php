<?php
	require_once('orm/resources/Keychain.php');
	
	$dbconn = (new Keychain)->getDatabaseConnection();
  
	$query = mysqli_query($dbconn, "SELECT YEAR(LocalDate) AS EarliestYear FROM Survey ORDER BY LocalDate ASC LIMIT 1");
	die(mysqli_fetch_assoc($query)["EarliestYear"]);
?>
