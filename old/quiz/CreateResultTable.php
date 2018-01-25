<?php
	/*
	$mysqli = new mysqli(getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_HOST') . ':' . getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_PORT'),
			$_ENV['MYSQL_USER'],
			$_ENV['MYSQL_PASSWORD'], "caterpillars");
	
	echo getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_HOST') . getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_PORT') . $_ENV['MYSQL_USER'] . $_ENV['MYSQL_PASSWORD'];
		
	if($mysqli->connect_errno) die("Error: " . mysqli_error($mysqlCon));
	
	echo 'sucessfully connected<br>';
	
	$mysqli->query("drop table if exists quiz_results");
	$mysqli->query("create table quiz_results ( " .
       "id int primary key not null auto_increment, " .
       "username char(50) not null, " .
       "quiz_time datetime not null, " .
	   "score int not null, " . 
	   "med_diff int not null)");
	
	
	$mysqli->close();
	*/
?>