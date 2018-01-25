<?php 
//By Erqian Li
//Given a siteID, circle, survey, this method will return offical plant species of a individual survey or all the plants in a site

//note: this API may overlap with plants.php. In general, that API have more function but this one is more percise
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once('Database_connection.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$post = json_decode(file_get_contents("php://input"), true);

	if(is_null($post['action'])||is_null($post['siteID'])){

		header("HTTP/1.1 400 Bad Request");
		print("Format Not Recognized.");
	}else{

		$action = $post['action'];
		$siteID = $post['siteID'];
		$circle = $post['circle'];
		$survey = $post['survey'];
		$plantSpecies = $post['plantSpecies'];
        $log_pathname = "../../logs/php.log";
		$mysqli = Database_connection::getMysqli(); 
		if($action == 'getPlantData'){
            if(is_null($circle)||is_null($survey)){
                header("HTTP/1.1 400 Bad Request");
                print("Some Parameters are null");
                exit();
            }
			$sqlRequest = "SELECT plantSpecies FROM tbl_surveyTrees WHERE siteID = ".$siteID." AND circle = ".$circle." AND survey = '".$survey."'";

			$official = $mysqli->query($sqlRequest);
            $result=array();
            if($official== false||$official->num_rows==0){
                $result['plantSpecies']='NONE';
            }else{
                $result['plantSpecies']=$official->fetch_array(MYSQLI_ASSOC)["plantSpecies"];
            }
            header("Content-type: application/json");    
            print(json_encode($result));
            exit();
		}else if ($action == "getAll"){
            
			$sqlRequest = "SELECT `circle`, `survey`, `plantSpecies` FROM `tbl_surveyTrees` WHERE ".
								"`siteID` = ".$siteID;

			$all = $mysqli-> query($sqlRequest);
             
            $result=array();
            if($all=== false||$all->num_rows==0){
                $result['number']=0;
                $result['status'] = "Error";
                print(json_encode($result));
            }else{
                $result['number']=$all->num_rows;
                $result['status'] = "OK";
                $plants=array();
                $i=0;
                while($row = $all->fetch_assoc()) { //originally $row = $result->fetch_assoc()
                    $plants[$i]=array();
                    $plants[$i]['circle']=$row["circle"];
                    $plants[$i]['survey']=$row["survey"];
                    $plants[$i]['plantSpecies']=$row["plantSpecies"];
                    $i++;
                }
                $all->close();
                $result['plants']=$plants;

            }
            header("Content-type: application/json");    
            print(json_encode($result));
            $mysqli->close();
            exit();
        
        
        }else if ($action == "changeRecord"){
            if(is_null($plantSpecies)||is_null($circle)||is_null($survey)){
                header("HTTP/1.1 400 Bad Request");
                print("Some Parameters are null");
                exit();
            }
            
            $sqlquery = "UPDATE `tbl_surveyTrees` SET `plantSpecies` = '".$plantSpecies."' WHERE `siteID` = ".$siteID." AND `circle` = ".$circle." AND `survey` = '".$survey."'";
           
            $output = $mysqli->query($sqlquery);

			if (($output == false)||($mysqli->connect_errno)){
				header("HTTP/1.1 500 Database Error");
				exit();
			}

            $update= array();
            $update['result'] = $output;
            $update['affected'] = $mysqli->affected_rows;
			header("Content-Type: application/json");
			print(json_encode($update)); 
            $mysqli->close();
            exit();
		}
	}
}
?>