<?php
  require_once('orm/Plant.php');
  require_once('orm/Site.php');
	require_once('orm/resources/Keychain.php');
	
	$dbconn = (new Keychain)->getDatabaseConnection();
  
  echo "DELETING PLANTS from sites that no longer exist...<br/>";
  $query = mysqli_query($dbconn, "SELECT * FROM `Plant`");
  while($plantRow = mysqli_fetch_assoc($query)){
      $id = $plantRow["ID"];
			$siteFK = $plantRow["SiteFK"];
      $site = Site::findByID($siteFK);
	  $plant = Plant::findByID($id);
      if(is_null($site) && !is_null($plant)){
        $plant->permanentDelete();
      }
		}
	
  echo "DONE. <br/><br/>DELETING SURVEYS AND ARTHROPOD SIGHTINGS from plants that no longer exist...<br/>";
	$query = mysqli_query($dbconn, "SELECT * FROM `Survey` WHERE 1");
	
	while($row = mysqli_fetch_assoc($query)){
		if(mysqli_num_rows(mysqli_query($dbconn, "SELECT `ID` FROM `Plant` WHERE `ID`='" . $row["PlantFK"] . "'")) == 0){
			mysqli_query($dbconn, "DELETE FROM `ArthropodSighting` WHERE `SurveyFK`='" . $row["ID"] . "'");
			mysqli_query($dbconn, "DELETE FROM `Survey` WHERE `ID`='" . $row["ID"] . "'");
		}
	}
  
  echo "DONE. <br/><br/>DELETING MANAGER REQUESTS from sites and users that no longer exist...<br/>";
  $query = mysqli_query($dbconn, "SELECT * FROM `ManagerRequest` WHERE 1");
	
	while($row = mysqli_fetch_assoc($query)){
		if(mysqli_num_rows(mysqli_query($dbconn, "SELECT `ID` FROM `Site` WHERE `ID`='" . $row["SiteFK"] . "'")) == 0 || mysqli_num_rows(mysqli_query($dbconn, "SELECT `ID` FROM `User` WHERE `ID`='" . $row["UserFKOfManager"] . "'")) == 0){
			mysqli_query($dbconn, "DELETE FROM `ManagerRequest` WHERE `ID`='" . $row["ID"] . "'");
		}
	}
  
  echo "DONE. <br/><br/>DELETING OBSERVATION METHOD PRESETS from sites and users that no longer exist...<br/>";
  $query = mysqli_query($dbconn, "SELECT * FROM `SiteUserPreset` WHERE 1");
	
	while($row = mysqli_fetch_assoc($query)){
		if(mysqli_num_rows(mysqli_query($dbconn, "SELECT `ID` FROM `Site` WHERE `ID`='" . $row["SiteFK"] . "'")) == 0 || mysqli_num_rows(mysqli_query($dbconn, "SELECT `ID` FROM `User` WHERE `ID`='" . $row["UserFK"] . "'")) == 0){
			mysqli_query($dbconn, "DELETE FROM `SiteUserPreset` WHERE `ID`='" . $row["ID"] . "'");
		}
	}
  
  echo "DONE. <br/><br/>DELETING AUTOMATIC SITE VALIDATIONS from sites and users that no longer exist...<br/>";
  $query = mysqli_query($dbconn, "SELECT * FROM `SiteUserValidation` WHERE 1");
	
	while($row = mysqli_fetch_assoc($query)){
		if(mysqli_num_rows(mysqli_query($dbconn, "SELECT `ID` FROM `Site` WHERE `ID`='" . $row["SiteFK"] . "'")) == 0 || mysqli_num_rows(mysqli_query($dbconn, "SELECT `ID` FROM `User` WHERE `ID`='" . $row["UserFK"] . "'")) == 0){
			mysqli_query($dbconn, "DELETE FROM `SiteUserValidation` WHERE `ID`='" . $row["ID"] . "'");
		}
	}
  
  echo "DONE. <br/><br/>Data from sites that no longer exist has been deleted.";
?>
