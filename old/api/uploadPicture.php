<?php

require_once("Survey_full.php");
require_once("Order_full.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$post = json_decode(file_get_contents("php://input"), true);
	$type = $post['type'];
	error_log("TYPE: " . $type);
    //Update leaf picture
    if (!is_null($type) && $type == "survey") {
        $survey = $post['survey'];
		$picturePath = $post['picture'];
		Survey::updateSurveyPicture($picturePath, $survey);
        header("HTTP/1.1 200 OK");
        exit();
    }

    //Update order picture
    if (!is_null($type) && $type == "order") {
        $order = $post['order'];
		$picturePath = $post['picture'];
		error_log("TYPE: " . $type . ". ORDER: " . $order . ". PICTURE: " . $picturePath);
        Order::updateOrderPicture($picturePath, $order);
        header("HTTP/1.1 200 OK");
        exit();
    }



    header("HTTP/1.1 400 Bad Request");
    print("Format not recognized");
    exit();
}
?>