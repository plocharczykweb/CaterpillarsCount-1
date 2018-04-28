<?php
  require_once('orm/resources/Keychain.php');
	require_once('orm/User.php');
	
	$email = rawurldecode($_GET["email"]);
	$salt = $_GET["salt"];
	
	$user = User::findBySignInKey($email, $salt);
	if(is_object($user) && get_class($user) == "User"){
    		if($user->getEmail() == "plocharczykweb@gmail.com" || $user->getEmail() == "hurlbert@bio.unc.edu"){
      			$dbconn = (new Keychain)->getDatabaseConnection();
      
      			//get all emails
      			$query = mysqli_query($dbconn, "SELECT `ID`, `Email` FROM `User` WHERE 1");
      			$emailsArray = array();
		  	while($row = mysqli_fetch_assoc($query)){
				if(trim($row["Email"]) != ""){
						$hardCodedManagers = array("plocharczykweb@gmail.com", "hurlbert@bio.unc.edu", "ssnell@live.unc.edu", "gdicecco@live.unc.edu", "science@gsmit.org", "ecu.caterpillarscount@gmail.com", "vancechalcrafth@ecu.edu", "bunnella@ecu.edu", "dowa05@students.ecu.edu", "stanoe@ecu.edu");
          					$emailsArray[(string)$row["ID"]] = array(
            					"email" => $row["Email"], 
            					"authority" => in_array($row["Email"], $hardCodedManagers),
          				);
        			}
		  	}
      
      			//mark the creators and managers
      			$query = mysqli_query($dbconn, "SELECT `UserFKOfCreator` FROM `Site` WHERE 1");
		  	while($row = mysqli_fetch_assoc($query)){
				$emailsArray[(string)$row["UserFKOfCreator"]]["authority"] = true;
		  	}
      			$query = mysqli_query($dbconn, "SELECT `UserFKOfManager` FROM `ManagerRequest` WHERE `Status`='Approved'");
		  	while($row = mysqli_fetch_assoc($query)){
				$emailsArray[(string)$row["UserFKOfManager"]]["authority"] = true;
		 	}
      
		  	mysqli_close($dbconn);
		  	die("true|" . json_encode($emailsArray));
    		}
    		die("false|You do not have permission to get emails from the Caterpillars Count! database.");
	}
	die("false|Your log in dissolved. Maybe you logged in on another device.");
?>
