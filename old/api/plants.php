<?php 
//By Joshua Helton
//Given a siteID, circle, survey, this method will return all pertinent information about the plant at that loction
//includes the 'official' record, plus all user names for it, plus any photo urls.
session_start();
require_once('Database_connection.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$post = json_decode(file_get_contents("php://input"), true);

	if(is_null($post['action'])||
		is_null($post['siteID'])||
		is_null($post['circle'])||
		is_null($post['survey'])){

		header("HTTP/1.1 400 Bad Request");
		print("Format Not Recognized.");
	}else{

		$action = $post['action'];
		$siteID = $post['siteID'];
		$circle = $post['circle'];
		$survey = $post['survey'];
		$plantSpecies = $post['plantSpecies'];
		$mysqli = Database_connection::getMysqli();
		if($action == 'getPlantData'){

			$sqlRequest = "SELECT DISTINCT plantSpecies, COUNT(*) as total ". 
										"FROM tbl_surveys WHERE ".
										"siteID = ".$siteID." AND ".
										"circle = ".$circle." AND ".
										"survey = '".$survey."'". 
										"GROUP BY plantSpecies";
			//error_log($sqlRequest);

			$historyResult = $mysqli->query($sqlRequest);

			$sqlRequest = "SELECT plantSpecies FROM tbl_surveyTrees WHERE ".
								" siteID = ".$siteID.
								" AND circle = ".$circle.
								" AND survey = '".$survey."'";

			$officialNameResult = $mysqli->query($sqlRequest);

			$sqlRequest = "SELECT leavePhoto from tbl_surveys where ".
							"siteID = ".$siteID." AND ".
							"circle = ".$circle." AND ".
							"survey = '".$survey."'"." AND ".
							"leavePhoto NOT LIKE '' AND
								leavePhoto IS NOT NULL";
			$photoResult = $mysqli->query($sqlRequest); 

			if($historyResult != false && ($historyResult->num_rows > 0)){
				$output = array();

				if($officialNameResult == false){
				$output['officialName'] = null;
				}else{
				$output['officialName'] = $officialNameResult->fetch_array(MYSQLI_ASSOC)["plantSpecies"];
				}
				if($photoResult == false){
					$output['photoURLs'] = null;
				}else{
					$photoURLs = $photoResult->fetch_all();

					foreach($photoURLs as $key => $value){
						 $photoURLs[$key] = "/pictures/".$value[0];
					}
					$output['photoURLs'] = $photoURLs;
				}
				if($historyResult == false){
					$output['plantHistory'] = null;
				}else{
					$output['plantHistory'] = $historyResult->fetch_all(MYSQLI_ASSOC);	
				}
				

				print(json_encode($output));
			}else{
				header("HTTP/1.1 500 Internal Server Error");
				print("There was a database error");			
			}

		}else if ($action = "changeOfficialRecord"){
			$sqlquery = "INSERT INTO tbl_surveyTrees SET
							siteID = ".$siteID.",
							circle = ".$circle.",
							survey = '".$survey."',
							plantSpecies = '".$plantSpecies."'
							ON DUPLICATE KEY UPDATE
							plantSpecies = '".$plantSpecies."'";

			error_log($sqlquery);

			$result = $mysqli->query($sqlquery);

			if ($result == false){
				header("HTTP/1.1 500 Database Error");
				print("An error has occured");
				exit();
			}
			$output['plantSpecies']=$plantSpecies;
			header ("HTTP/1.1 200 OK");
			header("Content-Type: application/json");
			print(json_encode($output));
		}
	}

}




?>