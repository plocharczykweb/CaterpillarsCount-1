<?php
	require_once('../orm/User.php');
	require_once('../orm/Plant.php');
	
	$email = $_GET["email"];
	$salt = $_GET["salt"];
	$samplePlantCode = $_GET["samplePlantCode"];
  
  $plant = Plant::findByCode($samplePlantCode);
  if(is_object($plant) && get_class($plant) == "Plant"){
    $site = $plant->getSite();
    if(is_object($site) && get_class($site) == "Site"){
      $user = User::findBySignInKey($email, $salt);
	    if(is_object($user) && get_class($user) == "User"){
        if(in_array($site, $user->getSites())){
          $site->addCircle();
          die("true|");
        }
        die("false|You do not have permission to add a circle to this site.");
      }
      die("false|Your log in dissolved. Maybe you logged in on another device.");
    }
    die("false|The sample plant we extracted from this page does not correspond to an existing site.");
  }
  die("false|The sample plant code we extracted from this page did not correspond to an existing plant.");
?>
