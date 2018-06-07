<?php
  require_once('orm/User.php');
	require_once('orm/Plant.php');
	
	$email = $_GET["email"];
	$salt = $_GET["salt"];
	$code = $_GET["code"];
	$password = $_GET["password"];
  
  $user = User::findBySignInKey($email, $salt);
	if(is_object($user) && get_class($user) == "User"){
		$plant = Plant::findByCode($code);
		if(!is_object($plant)){
			die("false|Enter a valid survey location code.");
		}
    $site = $plant->getSite();
    if(is_object($user) && get_class($user) == "User"){
      if($site->validateUser($user, $password)){
        die("true|");
      }
      die("false|Invalid site password.");
    }
    die("false|Could not find plant's site.");
  }
  die("false|Your log in dissolved. Maybe you logged in on another device.");
?>
