<?php
	require_once('orm/User.php');
	$email = $_GET["email"];
	$salt = $_GET["salt"];
  
  	$user = User::findBySignInKey($email, $salt);
	if(is_object($user) && get_class($user) == "User" && ($user->getEmail() == "plocharczykweb@gmail.com" || $user->getEmail() == "hurlbert@bio.unc.edu")){
    		$files = array_values(scandir("../" . getenv("USER_BACKUPS")));
    		for($i = (count($files) - 1); $i >= 0; $i--){
			if(strpos($files[$i], ".csv") === false){
				unset($files[$i]);
			}
			else{
				$files[$i] = "../" . getenv("USER_BACKUPS") . "/" . $files[$i];
			}
    		}
    		die("true|" . json_encode(array_values($files)));
  	}
  	die("false|");
?>