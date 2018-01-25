<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);
session_start();

$tempQuery;

require_once("Database_connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$post = json_decode(file_get_contents("php://input"), true);

    error_log(json_encode($post));

  	$surveyID = $post['surveyID'];
  	$siteID = $post['siteID'];
  	$circle = $post['circle'];
  	$survey = $post['survey'];
  	$timeStart = $post['timeStart'];
  	$temperatureMin = $post['temperatureMin'];
  	$temperatureMax = $post['temperatureMax'];
  	$plantSpecies = $post['plantSpecies'];
  	$herbivory = $post['herbivory'];
  	$mod_notes = $post['mod_notes'];
  	$status = $post['status'];

    //Must check to make sure no fields are null

    if(
      is_null($siteID) ||
      is_null($circle) ||
      is_null($survey) ||
      is_null($timeStart) ||
      is_null($temperatureMin) ||
      is_null($temperatureMax) ||
      is_null($plantSpecies) ||
      is_null($herbivory) ||
      is_null($status)
    ){
      header("HTTP/1.1 501 Not Implemented");
      print("Incomplete Data set");
      exit();
    }
    error_log("Checking Data for errors");

    $modifyingUser = $_SESSION["userID"];

	$mysqli = Database_connection::getMysqli();
    if ($mysqli->connect_errno) {
            header("HTTP/1.1 501 Not Implemented");
            print("Couldn't get database connection");
            exit();
    }

  $tempQuery = "SELECT * FROM tbl_sites WHERE siteID = '" . $siteID ."'";
  error_log($tempQuery."\n");
  $siteExists = $mysqli->query($tempQuery);
  $tempQuery = "SELECT privilegeLevel FROM tbl_users WHERE userID = '" . $modifyingUser . "'";
  error_log($tempQuery."\n");
  $privilegeLevelQuery = $mysqli->query($tempQuery);


  if (is_null($privilegeLevelQuery)){
    header("HTTP/1.1 403 Not Authorized");
    print("Privilidge Query failed");
    exit();
  }

  $userPrivilegeLevel = $privilegeLevelQuery->fetch_assoc()["privilegeLevel"];
  //Check that the site exists
  if($siteExists != false){

    $numCircles = $siteExists->fetch_assoc()["numCircles"];

    //Check that user is allowed to make submissions and that changes are valid
    if($userPrivilegeLevel >= 0
        && $circle <= $numCircles
        && (strcasecmp($survey, "A") == 0
            || (strcasecmp($survey, "B") == 0 )
            || (strcasecmp($survey, "C") == 0 )
            || (strcasecmp($survey, "D") == 0 )
            || (strcasecmp($survey, "E") == 0 ))
        && $herbivory >= 0 && $herbivory <= 4){
      //Mark survey as valid

      $tempQuery = "SELECT * FROM tbl_surveys WHERE surveyID = '" . $surveyID . "'";
      error_log($tempQuery."\n");

      $tbl_surveyQuery = $mysqli->query($tempQuery);

      $existingSurvey = $tbl_surveyQuery->fetch_assoc();
      $returnArray = array(
          "surveyID" => $surveyID,
          "siteID" => $siteID,
          "userID" => $userID,
          "circle" => $circle,
          "survey" => $survey,
          "timeStart" => $timeStart,
          "temperatureMin" => $temperatureMin,
          "temperatureMax" => $temperatureMax,
          "plantSpecies" => $plantSpecies,
          "herbivory" => $herbivory,
          "siteNotes" => $existingSurvey["siteNotes"],
          "leafPhoto" => $existingSurvey["leafPhoto"],
          "mod_notes" => $mod_notes
      );
      //If any editable field was modified, set wasModified as true,
      //else, set wasModified as false.
      if($siteID != $existingSurvey["siteID"]
          || $userID != $existingSurvey["userID"]
          || $circle != $existingSurvey["circle"]
          || $survey != $existingSurvey["survey"]
          || $timeStart != $existingSurvey["timeStart"]
          || $temperatureMin != $existingSurvey["temperatureMin"]
          || $temperatureMax != $existingSurvey["temperatureMax"]
          || $plantSpecies != $existingSurvey["plantSpecies"]
          || $herbivory != $existingSurvey["herbivory"]
      ){
        $returnArray["wasModified"] = "true";
        $wasModified = true;
      }
      else{
        $returnArray["wasModified"] = "false";
        $wasModified = false;
      }
        //tbl_surveys_view is a sql view, mysql will only allow updates to a view if only one table is updated
      $tempQuery = "UPDATE tbl_surveys_view
            SET
              siteID = ".$siteID.",
              circle = ".$circle.",
              survey = '".$survey."',
              timeStart = '".$timeStart."',
              temperatureMin = ".$temperatureMin.",
              temperatureMax = ".$temperatureMax.",
              plantSpecies = '".$plantSpecies."',
              herbivory = ".$herbivory.",
              wasModified = ".$wasModified.",
              mod_notes = '".$mod_notes."'

          WHERE surveyID = ".$surveyID;

      error_log($tempQuery."\n");
      $result = $mysqli->query($tempQuery);
        if(!$result){
            header("HTTP/1.1 500 Database Error");
            print("Update 1 Failed");
            exit();
        }
        $tempQuery = "UPDATE tbl_surveys_view
                    SET
              status = '".$status."'
              WHERE surveyID = ".$surveyID;

        error_log($tempQuery."\n");
        $result = $mysqli->query($tempQuery);
        if(!$result){
            header("HTTP/1.1 500 Database Error");
            print("Update 2 Failed");
            exit();
        }
      if($returnArray == NULL){
        header("HTTP/1.1 533 Not Implemented");
        print("Update Failed");
        exit();
      }else{
          header("HTTP/1.1 200 OK");
          header("Content-Type: application/json");
          print(json_encode($returnArray));
      }
    }
      else{
          header("HTTP/1.1 545 Not Implemented");
          print("Data is out of Bounds");
          exit();
      }
  }else{
    header("HTTP/1.1 545 Not Implemented");
    print("Site doesn't exist");
      exit();
  }
}else{
    header("HTTP/1.1 501 Not Implemented");
    print("HTTP Method not supported");
    exit();
}
?>