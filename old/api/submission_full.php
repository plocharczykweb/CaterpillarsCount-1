<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

//By: Pintian Zhang and Steven Thomas
require_once("Survey_full.php");
require_once("Order_full.php");
header("Access-Control-Allow-Origin: *");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //Survey Submission: $type = "survey", $siteID, $userID;
  //Order Submission: $type = "order", $surveyID;

  $post = json_decode(file_get_contents("php://input"), true);
  
  $type = $post['type'];

	
  $siteID = $post['siteID'];
  $userID = $post['userID'];
  $hasPhoto = $post['hastPhoto'];
	//$surveyID = $post['surveyID'];
	//survey
	$circle = $post['circle'];
	$survey = $post['survey'];
	$timeStart = $post['timeStart'];
	$temperatureMin = $post['temperatureMin'];
	$temperatureMax = $post['temperatureMax'];
	$siteNotes = $post['siteNotes'];
	$plantSpecies = $post['plantSpecies'];
	$herbivory = $post['herbivory'];
  //survey
  $temperatureMin;
  $temperatureMax;
    $circle;
    $survey;
    $timeStart;
    
    $siteNotes;
    $plantSpecies;
    $herbivory;

    $status = "new";
    $surveyType;
    $leafCount;
    $source;
    //order
    $surveyID ;
    $orderArthropod;
    $orderLength;
    $orderNotes;
    $orderCount;
    $siteID;
    $userID = $post['userID'];


  if ($type == 'survey'){

    $temperatureMin = $post['temperatureMin'];
    $temperatureMax = $post['temperatureMax'];
    $circle = $post['circle'];
    $survey = $post['survey'];
    $timeStart = $post['timeStart']; 
    $siteNotes = $post['siteNotes'];
    $plantSpecies = $post['plantSpecies'];
    $herbivory = $post['herbivory'];
    $surveyType = $post['surveyType'];
    $leafCount = $post['leafCount'];
    $source = $post['source'];
    $siteID = $post['siteID'];

  } else {
    $surveyID = $post['surveyID'];
    //survey
    
    //order
    $orderArthropod = $post['orderArthropod'];
    $orderLength = $post['orderLength'];
    $orderNotes = $post['orderNotes'];
    $orderCount = $post['orderCount'];

    if($orderArthropod == "Caterpillars (Lepidoptera larvae)"){
        $hairyOrSpiny = $post["hairyOrSpiny"];
        $leafRoll = $post["leafRoll"];
        $silkTent = $post["silkTent"];
    }

  }
	
    //new survey submission
    if (!is_null($type) && $type == "survey" && !is_null($siteID) && !is_null($userID)) {
        
        
        $surveyReturn = Survey::create ((new SurveyBuilder())

                            //->surveyID($surveyID)

                            ->siteID($siteID)
                            ->userID($userID)
                            ->circle($circle)
                            ->survey($survey)
                            ->timeStart($timeStart)
                            ->temperatureMin($temperatureMin)
                            ->temperatureMax($temperatureMax)
                            ->siteNotes($siteNotes)
                            ->plantSpecies($plantSpecies)
                            ->herbivory($herbivory)
                            ->status($status)
                            ->surveyType($surveyType)
                            ->leafCount($leafCount)
                            ->source($source)
                            ->build()
        ); 
                          

        if (is_null($surveyReturn)) {
            header("HTTP/1.1 500 Internal Server Error");
            print("Survey submission failed");
            exit();
        }
        if ($surveyReturn == -1) {
            header("HTTP/1.1 401 Unauthorized");
            print("User not authorized");
            exit();
        }
        header("Content-type: application/json");
        print(str_replace( '\/', '/', json_encode($surveyReturn->getJSONSimple())));
        exit();
    }

    //new order submission
    if (!is_null($type) && $type == "order" && !is_null($surveyID)) {
        $order = Order::create( (new OrderBuilder())
                ->surveyID($surveyID)
                ->orderArthropod($orderArthropod)
                ->orderLength($orderLength)
                ->orderNotes($orderNotes)
                ->orderCount($orderCount)
                ->hairyOrSpiny($hairyOrSpiny)
                ->leafRoll($leafRoll)
                ->silkTent($silkTent)
                ->build()
        );

        if (is_null($order)) {
            header("HTTP/1.1 500 Internal Server Error");
            print("Order submission failed");
            exit();
        }
        if ($order == -1) {
            header("HTTP/1.1 401 Unauthorized");
            print("User not authorized");
            exit();
        }
        header("Content-type: application/json");
        print(str_replace( '\/', '/', json_encode($order->getJSONSimple())));
        exit();
    }



    header("HTTP/1.1 400 Bad Request");
    print("Format not recognized");
    exit();
}

?>
