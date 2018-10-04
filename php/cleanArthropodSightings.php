<?php
	require_once('orm/resources/Keychain.php');
	
	$dbconn = (new Keychain)->getDatabaseConnection();
  
	$query = mysqli_query($dbconn, "DELETE FROM `ArthropodSighting` WHERE `SurveyFK` NOT IN (SELECT `ID` FROM `Survey`)");
?>
