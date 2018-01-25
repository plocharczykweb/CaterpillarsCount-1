<?php
//returns a list of days and the number of surveys on that date, used in the curate data admin page
session_start();
require_once('Database_connection.php');

$siteID = $_GET['siteID'];

if(!is_null($siteID) && $_SERVER['REQUEST_METHOD'] == 'GET'){
	$mysqli = Database_connection::getMysqli();

	$sqlString = "SELECT DATE(timeStart) as date, COUNT(*) as count FROM tbl_surveys_view WHERE status = 'new' and siteID = ".$siteID." GROUP BY DATE(timeStart)";

	$result = $mysqli->query($sqlString);

	$output;

	if ($result != false){
		$output['hasNewData'] = true;
		$output['data'] = $result->fetch_all(MYSQLI_ASSOC);
		
	}else{
		$output['hasNewData'] = false;
	}
	print(json_encode($output));

}else{
	header("HTTP/1.1 400 Bad Request");
	print("Format Not Recognized.");
}


?>