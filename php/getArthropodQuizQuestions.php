<?php
	require_once('orm/resources/Keychain.php');
	
	$dbconn = (new Keychain)->getDatabaseConnection();
	$query = mysqli_query($dbconn, "SELECT * FROM `ArthropodQuizQuestions` ORDER BY RAND() LIMIT 10");
	mysqli_close($dbconn);
		
	$questionsArray = array();
	while($questionRow = mysqli_fetch_assoc($query)){
		$question = array($questionRow["PhotoURL"], $questionRow["Answer"]);
		array_push($questionsArray, $question);
	}
	die(json_encode($questionsArray));
	
?>
