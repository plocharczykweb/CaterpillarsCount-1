<?php
	require_once('orm/User.php');
	$email = $_GET["email"];
	$salt = $_GET["salt"];
  
  	$user = User::findBySignInKey($email, $salt);
	if(is_object($user) && get_class($user) == "User" && ($user->getEmail() == "plocharczykweb@gmail.com" || $user->getEmail() == "hurlbert@bio.unc.edu")){
    		$files = array_values(scandir("../yds3jk92345bfjHU874eD"));
    		for($i = 0; $i < count($files); $i++){
			if(strpos($files[$i], ".csv") === false){
				unset($files[$i]);
			}
    		}
    		die("true|" . json_encode($files));
  	}
  	die("false|");
?>
