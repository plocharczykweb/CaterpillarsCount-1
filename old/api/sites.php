<?php

//By Pintian Zhang
require_once('Site.php'); require_once('RequestValidation.php');

session_start();

function checkResults($output){
    if (is_null($output)){
        header("HTTP/1.1 503 Service Unavailable");
        print("there was a Database error");
        exit();
    }
    elseif(!$output){
        header("HTTP/1.1 503 Internal Service Error");
        print("I suck at SQL");
        exit();
    }else{
        header("HTTP/1.1 200 OK");
        header("Content-Type: application/json");
        print(json_encode($output));
        exit();
    }
}
function checkArgs($argument, $argumentName){
    if (is_null($argument)){
        header("HTTP/1.1 400 Bad Request");
        print($argumentName." not given\n");
        print(json_encode($_GET));
        exit();
    }else{
        return $argument;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

  //Get all site (short version, has sites & states): $action= "getAllSiteState"
  //Get all site (full version): $action= "getAll"
  //Get one site by ID: $action= "getOneByID", $siteID
  //Create new site: $action= "create", $email,$password,$siteName,$siteLat,$siteLong,$siteDescription,$siteState,$sitePassword
  //check site password: action="checkSitePassword", $siteID,$sitePasswordCheck
  //change site password: action="changeSitePassword", $email,$password,$siteID,$newSitePassword
  
  $post = json_decode(file_get_contents("php://input"), true);

  $action = $post['action'];
  $email = $post['email'];
  $password = $post['password'];
  $siteName = $post['siteName'];
  $siteLat = $post['siteLat'];
  $siteLong = $post['siteLong'];
  $siteDescription = $post['siteDescription'];
  $siteState = $post['siteState'];
  $sitePassword = $post['sitePassword'];
  $sitePasswordCheck = $post['sitePasswordCheck'];
  $numCircles = $post['numCircles'];
  
  $siteID = $post['siteID'];
  $newSitePassword = $post['newSitePassword'];

  //Get all site & states
  if(!is_null($action) && ($action == "getAllSiteState" || $action == "getAll")){

    $site = Site::getAll($action);

    if($site == -1){

      header("HTTP/1.1 501 Not Implemented");
      print("un-supported action");
      exit();

    }

    if (is_null($site)){

      header("HTTP/1.1 500 Internal Server Error");
      print("Get sites failed");
      exit();
    }

  header("Content-type: application/json");    
  print(json_encode($site));
  exit();

  }
  
  //Get one site
  if(!is_null($action) && $action == "getOneByID"){

    $site = Site::find($siteID);

    if($site == -1){
      header("HTTP/1.1 501 Not Implemented");
      print("un-supported action");
      exit();
    }

    if (is_null($site)){
      header("HTTP/1.1 500 Internal Server Error");
      print("Get sites failed");
      exit();
    }

  header("Content-type: application/json");    
  print(json_encode($site->getJSON()));
  exit();

  }

   //Create new site
  if(!is_null($action) && $action == "create"){

    $site = Site::create($email,$password,$siteName,$siteLat,$siteLong,$siteDescription,$siteState,$sitePassword,$numCircles);
    if($site == -1){

      header("HTTP/1.1 401 Unauthorized");
      print("User not authorized");
      exit();

    }
    if($site == -2){

      header("HTTP/1.1 500 Internal Server Error");
      print("Error Connecting to Databse");
      exit();

    }
    if($site == -3){

      header("HTTP/1.1 500 Internal Server Error");
      print("Error Inserting site");
      exit();

    }
    if($site == -4){

      header("HTTP/1.1 500 Internal Server Error");
      print("Error Inserting into site Admin ");
      exit();

    }
    if (is_null($site)){

      header("HTTP/1.1 500 Internal Server Error");
      print("sites creation failed");
      print("INSERT INTO tbl_sites (`siteID`, `siteName`, `siteState`, `siteLat`,"
                 ."`siteLong`, `siteSaltHash`, `siteDescription`, 'numCircles') VALUES (0,\""
                 .$siteName."\",\""
                 .$siteState."\","
                 .$siteLat."," 
                 .$siteLong.",\""
                 .$siteSaltHash."\",\"" 
                 .$siteDescription."\"," 
                 .$numCircles.")");
      exit();
    }

  header("Content-type: application/json");   
  print(json_encode($site->getJSON()));
  exit();

  }
  
  //check site password
  if(!is_null($action) && $action == "checkSitePassword" && !is_null($siteID) && !is_null($sitePasswordCheck)){
    $result = Site::checkSitePassword($siteID,$sitePasswordCheck);
    if (is_null($result)){

      header("HTTP/1.1 500 Internal Server Error");
      print("site password change failed");
      exit();
    }
  header("Content-type: application/json");
  print(json_encode($result));
  exit();
  }
  
  //modify site password
  if(!is_null($action) && $action == "changeSitePassword"){
    $site = Site::changeSitePassword($email,$password,$siteID,$newSitePassword);
    if($site == -1){

      header("HTTP/1.1 401 Unauthorized");
      print("User not authorized");
      exit();

    }
    if (is_null($site)){

      header("HTTP/1.1 500 Internal Server Error");
      print("site password change failed");
      exit();
    }
  header("HTTP/1.1 200 OK");    
  print("Site Pass word change successful");
  exit();
  }

  header("HTTP/1.1 400 Bad Request");
  print("Format not recognized");
  exit();

}
if ($_SERVER['REQUEST_METHOD'] == 'GET'){ //Get request method since it's not going to delete, post or put anything in the database. We just want to read information

    $path = explode("/",$_SERVER['PATH_INFO'])[1];
    if (is_null($path)||$path == ''){
        $output = Site::getAll("getAll");
        checkResults($output);
    }elseif($path == 'Statistics'){
        $siteID = checkArgs($_GET['siteID'], 'siteID');
        $output = Site::getSiteStatistics($siteID);
        checkResults($output);
    }elseif($path == 'Filter'){
        $minSize = checkArgs($_GET['minSize'], 'minSize');
        $plantSelect = checkArgs($_GET['plantSelect'],'plantSelect');
        $arthropodSelect = checkArgs($_GET['arthropodSelect'],'arthropodSelect');
        $output = Site::getFilteredSites($arthropodSelect,$plantSelect,$minSize);
        checkResults($output);
    }elseif($path == 'PlantComposition'){
        $siteID = checkArgs($_GET['siteID'], 'siteID');
        $output = Site::getPlantComposition($siteID);
        checkResults($output);
    }elseif($path == 'ArthropodComposition'){
        $siteID = checkArgs($_GET['siteID'], 'siteID');
        $output = Site::getArthropodComposition($siteID);
        checkResults($output);
    }elseif($path == 'SurveysAndOrders'){
        $siteID = checkArgs($_GET['siteID'], 'siteID');
        $output = Site::getAllSubmissions($siteID);
        checkResults($output);
    }elseif($path == 'YearsActive'){
        $siteID = checkArgs($_GET['siteID'], 'siteID');
        $output = Site::getYearsActive($siteID);
        checkResults($output);
    }elseif($path == 'Plants'){
        $siteID = checkArgs($_GET['siteID'], 'siteID');
        $output = Site::getPlantList($siteID);
        checkResults($output);
    }elseif($path == 'OrderDensity'){
        $siteID = checkArgs($_GET['siteID'], 'siteID');

        $plantSpecies = checkArgs($_GET['plantSpecies'],'plantSpecies');
        $orders = checkArgs($_GET['orders'],'orders');
        $year = checkArgs($_GET['year'],'year');
        $output = Site::getOrderDensity($siteID,$plantSpecies,$orders,$year);
        checkResults($output);
    }elseif($path == 'AllAuthorized'){
        $userID = $_SESSION['userID'];
        if (is_null($userID)){
            header("HTTP/1.1 403 Not Authorized");
            print("You are not logged in\n");
            print(json_encode($_SESSION));
            exit();
        }else{
            $output = Site::getAllAuthorized($userID);
            header("HTTP/1.1 200 OK");
            header("Content-type: application/json");
            print(json_encode($output));
            exit();
        }
    }else{
        header("HTTP/1.1 501 Not Implemented");
        print("This GET request ".$path." not supported at the time");
        exit();
    }


//    $action = $_GET['action'];
//	$siteID = $_GET['siteID'];
//
//
//	if(is_null($action)){ //action parameter wasn't specified
//		header("HTTP/1.1 400 Bad Request");
//		print("Undefined action");
//		exit();
//	}else if ($action == 'getAllAuthorized'){
//
//    }
//
//	header("Content-type: application/json");
//	switch($action){
//		case "getSiteStatistics": RequestValidation::siteIDNotNull($siteID); print(Site::getSiteStatistics($siteID)); break;
//		case "getPlantComposition": RequestValidation::siteIDNotNull($siteID); print(Site::getPlantComposition($siteID)); break;
//		case "getArthropodComposition": RequestValidation::siteIDNotNull($siteID); print(Site::getArthropodComposition($siteID)); break;
//		case "getFilterResults": print(Site::getFilteredSites($_GET['arthropodSelect'], $_GET['plantSelect'], $_GET['minSize'])); break;
//		case "getSurveysAndOrders": RequestValidation::siteIDNotNull($siteID); print(Site::getAllSubmissions($siteID)); break;
//		default: header("HTTP/1.1 400 Bad Request"); print("Undefined action");
//	}
//	exit();
}

?>