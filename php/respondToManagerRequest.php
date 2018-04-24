<?php
	require_once('orm/Site.php');

  $managerRequestID = $_GET["managerRequestID"];
  $response = $_GET["response"];
  $email = $_GET["email"];
  $salt = $_GET["salt"];

  $user = User::findBySignInKey($email, $salt);
	if(is_object($user) && get_class($user) == "User"){
    if($response == "approve"){
      if($user->approveManagerRequest($managerRequestID)){
        $dbconn = (new Keychain)->getDatabaseConnection();
        $site = Site::findByID(mysqli_fetch_assoc(mysqli_query($dbconn, "SELECT `SiteFK` FROM `SiteManager` WHERE `ID`='" . $managerRequestID . "' LIMIT 1"))["SiteFK"]);
		    mysqli_close($dbconn);
        die("true|" . $site->getName());
      }
      die("You do not have permission to approve this site manager request.");
    }
    else if($response == "deny"){
      if($user->denyManagerRequest($managerRequestID)){
        die("true|");
      }
      die("You do not have permission to deny this site manager request.");
    }
    die("false|Invalid response.");
  }
  die("false|Your log in dissolved. Maybe you logged in on another device.");
?>
