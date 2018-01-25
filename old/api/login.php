<?php

//By Derek Gu
/*
 * Server side that monitors login status of the admin tool
 * Use both session and cookies. Cookies time out in an hour.
 * Cookies store userID of admin.
 */

session_start();
require_once("User.php");

header("Access-Control-Allow-Origin: *");

//Log out
if ($_SERVER['REQUEST_METHOD']=='GET' && $_GET['signout'] == 1) {
    if(is_null($_SESSION['userID'])){
        header("HTTP/1.1 403 Forbidden");
        print("You do not have access to this website.");
        exit();
    }else{
        $_SESSION['userID'] = null;
        print(htmlspecialchars($_REQUEST['resource']));
        session_destroy();
        exit();
    } 
//Get login Identification, returns full User Info   
}else if ($_SERVER['REQUEST_METHOD'] == GET){
    $userID = $_SESSION['userID'];
    $user = User::findByID($userID);
    if (is_null($userID)){
        header("HTTP/1.1 403 Forbidden");
        print("You do not have access to this website.");
        exit();
    }else if (is_null($user)) {
        header("HTTP/1.1 500 Internal Server Error");
        print("Internal Server Error");
        exit();
    }else{
        header("Content-type: application/json");
        print($user->getJSON());
        exit(); 
    }
}

/*
 * Login: email, password
 */

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $post = json_decode(file_get_contents("php://input"), true);
    $email = $post['email'];
    $password = $post['password'];

    if (!is_null($password) && !is_null($email)) {

        $validInfo = User::validatePassword($email, $password);

        $validate = array('validUser' => $validInfo['validUser'],
                            'validPw' => $validInfo['validPw'],
                            'active' => $validInfo['active'],);

        if (is_null($validate)) {

            header("HTTP/1.1 404 Not Found");
            print("Resource requested not found");
            exit();
        }

        if ($validate['validUser'] == 1 && $validate['validPw'] == 1 && $validate['active'] == 1) {
            //Login success
            
            $_SESSION['userID'] = intval($validInfo["userID"]);
            header("Content-type: application/json");
            $validate['privilegeLevel'] = $validInfo['privilegeLevel'];
            $validate['userID'] = intval($validInfo["userID"]);
            print(json_encode($validate));
            exit();    
            
        } else {
            header("Content-type: application/json");
            print(json_encode($validate));
            exit();
        }
    }
}

header("HTTP/1.1 400 Bad Request");
    print("Format not recognized");
    exit();
?>