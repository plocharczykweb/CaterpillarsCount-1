<?php
  require_once('orm/User.php');
  
  $email = $_GET["email"];
	$salt = $_GET["salt"];
  
  $user = User::findBySignInKey($email, $salt);
	if(($email == "plocharczykweb@gmail.com" || $email == "hurlbert@bio.unc.edu") && is_object($user) && get_class($user) == "User"){
    $files = scandir("../yds3jk92345bfjHU874eD");
    for($i = 0; $i < count($files); $i++){
      if(strpos($files[$i], ".csv") === false){
        unset($files[$i]);
      }
    }
    die("true|" . json_encode($files));
  }
  die("false|");
?>
