<?php
	if(getenv("Openshift") == 1){
		private static $HOST = getenv("CATERPILLARSV2_SERVICE_HOST");
		private static $HOST_USERNAME = getenv("HOST_USERNAME");
		private static $HOST_PASSWORD = getenv("HOST_PASSWORD");
		private static $DATABASE_NAME = getenv("DATABASE_NAME");
	}
	else{
		private static $HOST = "localhost";
		private static $HOST_USERNAME = "username";
		private static $HOST_PASSWORD = "password";
		private static $DATABASE_NAME = "CaterpillarsCount";
	}
	
	$dbconn = mysqli_connect($HOST, $HOST_USERNAME, $HOST_PASSWORD, $DATABASE_NAME);
	$query = mysqli_query($dbconn, "SELECT * FROM `ArthropodQuizQuestions` ORDER BY RAND() LIMIT 10");
	mysqli_close($dbconn);
		
	$questionsArray = array();
	while($questionRow = mysqli_fetch_assoc($query)){
		$question = array($questionRow["PhotoURL"], $questionRow["Answer"]);
		array_push($questionsArray, $question);
	}
	die(json_encode($questionsArray));
	
?>
