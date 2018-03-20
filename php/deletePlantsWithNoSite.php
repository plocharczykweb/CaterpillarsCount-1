<?php
  require_once('orm/Plant.php');
  require_once('orm/Site.php');
  require_once('orm/resources/Keychain.php');
  
  $dbconn = (new Keychain)->getDatabaseConnection();
  
  $query = mysqli_query($dbconn, "SELECT * FROM `Plant`");
  while($plantRow = mysqli_fetch_assoc($query)){
      $id = $plantRow["ID"];
			$siteFK = $plantRow["SiteFK"];
      $site = Site::findByID($siteFK);
      if(is_null($site)){
        Plant::findByID($id)->permanentDelete();
      }
		}
?>
