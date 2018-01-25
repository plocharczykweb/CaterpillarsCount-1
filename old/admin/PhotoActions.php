<?php

try
{
	//Open database connection
	$mysqli = new mysqli(getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_HOST') . ':' . getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_PORT'),
			$_ENV['MYSQL_USER'],
			$_ENV['MYSQL_PASSWORD'], "caterpillars");
			
			
		if($mysqli->connect_errno) die("Error: " . mysqli_error($mysqlCon));

	//Getting records (listAction)
	if($_GET["action"] == "list")
	{
		//Get record count
		$result = $mysqli->query("SELECT COUNT(*) AS RecordCount FROM quiz_photos;");
		$row = mysqli_fetch_array($result);
		$recordCount = $row['RecordCount'];

		//Get records from database
		$result = $mysqli->query("SELECT * FROM quiz_photos ORDER BY " . $_GET["jtSorting"] . " LIMIT " . $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"] . ";");
		
		//Add all records to an array
		$rows = array();
		while($row = mysqli_fetch_array($result))
		{
		    $rows[] = $row;
		}

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['TotalRecordCount'] = $recordCount;
		$jTableResult['Records'] = $rows;
		print json_encode($jTableResult);
	}
	//Updating a record (updateAction)
	else if($_GET["action"] == "update")
	{
		//Update record in database
		$result = $mysqli->query("UPDATE quiz_photos SET classification = '" . $_POST["classification"] . "', url = '" . $_POST["url"] . "' WHERE id = " . $_POST["id"]);

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}
	//Deleting a record (deleteAction)
	else if($_GET["action"] == "delete")
	{
		//Delete from database
		$result = $mysqli->query("DELETE FROM quiz_photos WHERE id = " . $_POST["id"]);

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}

	//Close database connection
	mysqli_close($mysqli);

}
catch(Exception $ex)
{
    //Return error message
	$jTableResult = array();
	$jTableResult['Result'] = "ERROR";
	$jTableResult['Message'] = $ex->getMessage();
	print json_encode($jTableResult);
}
	
?>