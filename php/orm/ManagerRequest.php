<?php
class ManagerRequest
{
  public static function create($site, $manager){
    if(is_object($site) && get_class($site) == "Site"){
      if(is_object($manager) && get_class($manager) == "User"){
        if($manager->getID() != $site->creator->getID()){
			$dbconn = (new Keychain)->getDatabaseConnection();
			$query = mysqli_query($dbconn, "SELECT * FROM `SiteManager` WHERE `UserFKOfManager`='" . $manager->getID() . "' AND `SiteFK`='" . $this->id . "' LIMIT 1");
			if(mysqli_num_rows($query) == 0){
				mysqli_query($dbconn, "INSERT INTO SiteManager (`UserFKOfManager`, `SiteFK`, `Approved`) VALUES ('" . $manager->getID() . "', '" . $this->id . "', '0')");
				//$id = intval(mysqli_insert_id($dbconn));
				$message = "<div style=\"text-align:center;border-radius:5px;padding:20px;font-family:'Segoe UI', Frutiger, 'Frutiger Linotype', 'Dejavu Sans', 'Helvetica Neue', Arial, sans-serif;\"><div style=\"text-align:left;color:#777;margin-bottom:40px;font-size:20px;\">" . $this->getCreator()->getFullName() . " would like you to be a manager of the \"" . $this->getName() . "\" site in " . $this->getRegion() . ". Please sign in to <a href='https://caterpillarscount.unc.edu/signIn'>caterpillarscount.unc.edu</a> using this email address (" . $manager->getEmail() . ") to approve or deny this request.</div><a href='https://caterpillarscount.unc.edu/signIn'><button style=\"border:0px none transparent;background:#fed136; border-radius:5px;padding:20px 40px;font-size:20px;color:#fff;font-family:'Segoe UI', Frutiger, 'Frutiger Linotype', 'Dejavu Sans', 'Helvetica Neue', Arial, sans-serif;font-weight:bold;cursor:pointer;\">SIGN IN NOW</button></a><div style=\"padding-top:40px;margin-top:40px;margin-left:-40px;margin-right:-40px;border-top:1px solid #eee;color:#bbb;font-size:14px;\"></div></div>";
				email($manager->getEmail(), "New Caterpillars Count! site manager request!", $message);
			}
			else if(mysqli_fetch_assoc($query)["Approved"] == -1){
				mysqli_query($dbconn, "UPDATE SiteManager SET `Approved`='0' WHERE `UserFKOfManager`='" . $manager->getID() . "' AND `SiteFK`='" . $this->id . "'");
				$message = "<div style=\"text-align:center;border-radius:5px;padding:20px;font-family:'Segoe UI', Frutiger, 'Frutiger Linotype', 'Dejavu Sans', 'Helvetica Neue', Arial, sans-serif;\"><div style=\"text-align:left;color:#777;margin-bottom:40px;font-size:20px;\">" . $this->getCreator()->getFullName() . " would like you to reconsider being a manager of the \"" . $this->getName() . "\" site in " . $this->getRegion() . ". Please sign in to <a href='https://caterpillarscount.unc.edu/signIn'>caterpillarscount.unc.edu</a> using this email address (" . $manager->getEmail() . ") to approve or deny this request.</div><a href='https://caterpillarscount.unc.edu/signIn'><button style=\"border:0px none transparent;background:#fed136; border-radius:5px;padding:20px 40px;font-size:20px;color:#fff;font-family:'Segoe UI', Frutiger, 'Frutiger Linotype', 'Dejavu Sans', 'Helvetica Neue', Arial, sans-serif;font-weight:bold;cursor:pointer;\">SIGN IN NOW</button></a><div style=\"padding-top:40px;margin-top:40px;margin-left:-40px;margin-right:-40px;border-top:1px solid #eee;color:#bbb;font-size:14px;\"></div></div>";
				email($manager->getEmail(), "New Caterpillars Count! site manager request!", $message);
			}
			mysqli_close($dbconn);
			return true;
		}
		return false;
  }
  
  public static function findByID(){}
  
  public static function findBySite(){
    $dbconn = (new Keychain)->getDatabaseConnection();
		$query = mysqli_query($dbconn, "SELECT * FROM `SiteManager` WHERE `SiteFK`='" . $this->id . "'");
		mysqli_close($dbconn);
		
		//LOOP THROUGH ALL MANAGERS AND CONSTRUCT AN ARRAY OF MANAGERS TO RETURN
		$managersArray = array();
		while($managerRow = mysqli_fetch_assoc($query)){
			$userFKOfManager = intval($managerRow["UserFKOfManager"]);
			$manager = User::findByID($userFKOfManager);
			
			if(is_object($manager) && get_class($manager) == "User"){
				$managerArray = array(
					"id" => $userFKOfManager,
					"approved" => $managerRow["Approved"],
					"fullName" => $manager->getFullName(),
					"email" => $manager->getEmail(),
				);
				
				array_push($managersArray, $managerArray);
			}
		}
		return $managersArray;
  }
  
  public static function findPendingManagerRequestsByManager($manager){
    $dbconn = (new Keychain)->getDatabaseConnection();
		$query = mysqli_query($dbconn, "SELECT * FROM `SiteManager` WHERE `UserFKOfManager`='" . $this->id . "' AND `Approved`='0'");
		mysqli_close($dbconn);
		
		//LOOP THROUGH ALL MANAGERS AND CONSTRUCT AN ARRAY OF MANAGERS TO RETURN
		$requestsArray = array();
		while($requestRow = mysqli_fetch_assoc($query)){
			$site = Site::findByID($requestRow["SiteFK"]);
			if(is_object($site) && get_class($site) == "Site"){
				$requestArray = array(
					"id" => intval($requestRow["ID"]),
					"requester" => $site->getCreator()->getFullName(),
					"siteName" => $site->getName(),
					"siteDescription" => $site->getDescription(),
					"siteCoordinates" => $site->getLatitude() . ", " . $site->getLatitude(),
					"siteRegion" => $site->getRegion(),
					"siteOpenToPublic" => $site->getOpenToPublic(),
				);
				
				array_push($requestsArray, $requestArray);
			}
		}
		return $requestsArray;
  }
  
  public function getID(){}
  
  public function getRequester(){}
  
  public function getManager(){}
  
  public function getSite(){}
  
  public function getStatus(){}
  
  public function setStatus($status){
    //approve
    $managerRequestID = intval($managerRequestID);
		$dbconn = (new Keychain)->getDatabaseConnection();
		$query = mysqli_query($dbconn, "SELECT `UserFKOfManager` FROM `SiteManager` WHERE `ID`='" . $managerRequestID . "' LIMIT 1");
		if(intval(mysqli_fetch_assoc($query)["UserFKOfManager"]) == $this->getID()){
			mysqli_query($dbconn, "UPDATE `SiteManager` SET `Approved`='1' WHERE `ID`='" . $managerRequestID . "'");
			mysqli_close($dbconn);
			return true;
		}
		return false;
    
    //deny
    $managerRequestID = intval($managerRequestID);
		$dbconn = (new Keychain)->getDatabaseConnection();
		$query = mysqli_query($dbconn, "SELECT `UserFKOfManager` FROM `SiteManager` WHERE `ID`='" . $managerRequestID . "' LIMIT 1");
		if(intval(mysqli_fetch_assoc($query)["UserFKOfManager"]) == $this->getID()){
			mysqli_query($dbconn, "UPDATE `SiteManager` SET `Approved`='-1' WHERE `ID`='" . $managerRequestID . "'");
			mysqli_close($dbconn);
			return true;
		}
		return false;
  }
  
  public function permanentDelete(){
    if(is_object($manager) && get_class($manager) == "User" && $manager->getID() != $this->creator->getID()){
			$dbconn = (new Keychain)->getDatabaseConnection();
			$query = mysqli_query($dbconn, "SELECT `Approved` FROM `SiteManager` WHERE `UserFKOfManager`='" . $manager->getID() . "' AND `SiteFK`='" . $this->id . "' LIMIT 1");
			if(mysqli_num_rows($query) > 0){
				$approved = intval(mysqli_fetch_assoc($query)["Approved"]);
				$query = mysqli_query($dbconn, "DELETE FROM `SiteManager` WHERE `UserFKOfManager`='" . $manager->getID() . "' AND `SiteFK`='" . $this->id . "'");
				if($approved > -1){
					$approvedMessageAddOn = "";
					if($approved == 1){
						$approvedMessageAddOn = " Thank you for the time you've dedicated to managing this site in the past.";
					}
					$message = "<div style=\"text-align:center;border-radius:5px;padding:20px;font-family:'Segoe UI', Frutiger, 'Frutiger Linotype', 'Dejavu Sans', 'Helvetica Neue', Arial, sans-serif;\"><div style=\"text-align:left;color:#777;margin-bottom:40px;font-size:20px;\">" . $this->getCreator()->getFullName() . " no longer requires your services as a manager of the \"" . $this->getName() . "\" Caterpillars Count! site in " . $this->getRegion() . "." . $approvedMessageAddOn . "</div><div style=\"padding-top:40px;margin-top:40px;margin-left:-40px;margin-right:-40px;border-top:1px solid #eee;color:#bbb;font-size:14px;\"></div></div>";
					email($manager->getEmail(), "Your Caterpillars Count! \"" . $this->getName() . "\" managment services are no longer required.", $message);
				}
			}
			mysqli_close($dbconn);
			return true;
		}
		return false;
  }
}
?>
