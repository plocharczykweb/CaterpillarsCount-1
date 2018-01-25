
<?php

session_start();

//Upload a picture to the Database, works for surveys and orders

require_once("Database_connection.php");
require_once("Survey_full.php");
require_once("Order_full.php");

$uploaddir = "/opt/app-root/src/pictures/";//Uploading to same directory as PHP file


if (!is_null($_SESSION['userID'])) {
    $file = $uploaddir . basename($_FILES['file']['name']);
    $result = move_uploaded_file($_FILES['file']['tmp_name'], $file);

    if ($result) {
        $orderID = $_GET['orderID'];
        $surveyID = $_GET['surveyID'];

        //TODO error handling
        if (!is_null($surveyID)) {

            Survey::updateSurveyPicture(basename($_FILES['file']['name']), $surveyID);

        } else if (!is_null($orderID)) {
            Order::updateOrderPicture(basename($_FILES['file']['name']), $orderID);
        } else {

            header("HTTP/1.1 400 Bad Request");
            exit();

        }

        header("HTTP/1.1 200 OK");
        print($file." Was inserted into directory");
        exit();
    }
}else{
    header("HTTP/1.1 403 Forbidden");
    print(" Not Authorized");
}

?>
