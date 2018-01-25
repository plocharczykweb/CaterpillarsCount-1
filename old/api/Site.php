<?php

//By Pintian Zhang
require_once('User.php');
require_once('PasswordHash.php');
require_once('Database_connection.php');
require_once('Privilege.php');

class Site{
  private $siteID;
	private $siteName;
	private $siteLat;
	private $siteLong;
	private $siteDescription;
	private $siteState;
  private $timeStamp;
  private $isValid;
  private $siteSaltHash;

  //Added by Joshua Helton, new variable numCircles.
  private $numCircles;
  
	private function __construct($siteID,$siteName,$siteLat,$siteLong,$siteDescription,$siteState,$timeStamp,$isValid, $siteSaltHash, $numCircles){
        $this->siteID = $siteID;
        $this->siteName = $siteName;
        $this->siteLat = $siteLat;
        $this->siteLong = $siteLong;
        $this->siteDescription = $siteDescription;
        $this->siteState = $siteState;
        $this->timeStamp = $timeStamp;
        $this->isValid = $isValid;
        $this->siteSaltHash = $siteSaltHash;
        $this->numCircles = $numCircles;
	}  

    //returns null if DB error
    //returns -1 if user don't exist/password incorrect/privilege level not high enough
    //returns User on successful creation
    public static function create($email,$password,$siteName,$siteLat,$siteLong,$siteDescription,$siteState,$sitePassword, $numCircles){
        $mysqli = Database_connection::getMysqli();
        if ($mysqli->connect_errno) {
            return -2;
        }
        $userObj = User::find($email);
        //check if valid Site Admin
        $isValidSiteAdmin = Privilege::isValidSiteAdmin($userObj,$password);
        if($isValidSiteAdmin != 1){
          return $isValidSiteAdmin;
        }
        //insert site
        $siteSaltHash = create_hash($sitePassword);


        $result = $mysqli->query("INSERT INTO tbl_sites (`siteID`, `siteName`, `siteState`, `siteLat`,
                    `siteLong`, `siteSaltHash`, `siteDescription`, `numCircles`) VALUES (0,\""
                 .$siteName."\",\""
                 .$siteState."\","
                 .$siteLat ."," 
                 .$siteLong.",\""
                 .$siteSaltHash."\",\"" 
                 .$siteDescription."\"," 
                 .$numCircles.")");

        if(!$result){
            return -3;
        }
        $newID = $mysqli->insert_id;
        //insert relationship
        $result = $mysqli->query("INSERT INTO `tbl_siteAdmin` (`siteID`, `userID`) VALUES (".$newID.",".$userObj->getID().")");
        if(!$result){
            return -4;
        }
        return Site::find($newID);
    }
    
    //returns null if DB error
    //return -1 on un-recognized action
    //returns all valid sites on success
    public static function getAll($action){
        $mysqli = Database_connection::getMysqli();
        if ($mysqli->connect_errno) {
            return null;
        }

        if ($action == "getAllSiteState") {
          $result = $mysqli->query("SELECT siteID, siteName, siteState FROM tbl_sites WHERE isValid = 1");
        } 
        elseif($action == "getAll"){
        	$result = $mysqli->query("SELECT * FROM tbl_sites WHERE isValid = 1");
        } 
        else {
        	return -1;
        }
        if(!$result){
        	return null;
        }

        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
        	$rows[] = $r;
        }
        return $rows;
    }
    
    //returns null if DB error
    //returns -1 if user don't exist/password incorrect/privilege level not high enough
    //returns 1 success
    public static function changeSitePassword($email,$password,$siteID,$newSitePassword){
        $mysqli = Database_connection::getMysqli();
        if ($mysqli->connect_errno) {
            return null;
        }
        //check if site exist
        $siteObj = Site::find($siteID);
        if(!is_object($siteObj)) return -1;
        $userObj = User::find($email);
        //check if valid Site Admin
        $isValidSiteAdmin = Privilege::isValidSiteAdmin($userObj,$password);
        if($isValidSiteAdmin != 1){
          return $isValidSiteAdmin;
        }
        //check if has authority over site
        $checkAutorityOverSite = Privilege::checkAuthorityOverSite($userObj,$siteID);
        if($checkAutorityOverSite != 1){
          return $checkAutorityOverSite;
        }
        
        //change site password
        $siteSaltHash = create_hash($newSitePassword);
        $result = $mysqli->query("UPDATE tbl_sites SET siteSaltHash='".$siteSaltHash."' WHERE siteID=".$siteID);
        if(!$result){
            return null;
        }
        return 1;
    }
    
    //returns null if DB error
    //returns -1 if user don't exist/password incorrect/privilege level not high enough
    //returns 1 success
    public static function checkSitePassword($siteID,$sitePasswordCheck){
        $mysqli = Database_connection::getMysqli();
        if ($mysqli->connect_errno) {
            return null;
        }

        $siteObj = Site::find($siteID);
        if(!is_object($siteObj)) return null;
        //check if valid Site Admin
        $validSitePassword = validate_password($sitePasswordCheck,$siteObj->getSiteSaltHash());
        $json_rep = array();
        $json_rep['validSitePassword'] = intval($validSitePassword);
        return $json_rep;
    }
	
	//returns null if DB error
	//returns result of the query, or -1 if the query didn't generate any result
	public static function getQueryResult($sqlQuery){
		$mysqli = Database_connection::getMysqli();
		if($mysqli->connect_errno){ //There was an error with the DB connection
			return null;
		}
		$result = $mysqli->query($sqlQuery);
		if($result){
			if(0 == $result->num_rows){ //No results
				return -1;
			}
			return $result;
		}
		return null;
	}
    
    //returns null if DB error
    //returns site object on success
    public static function find($siteID){
		$result = Site::getQueryResult("SELECT * FROM tbl_sites WHERE siteID=" . $siteID);
		if(is_null($result) || $result==-1){
			return $result;
		}
        $site_info = $result->fetch_array();
        return new Site(intval($site_info['siteID']),
			strval($site_info['siteName']),
			intval($site_info['siteLat']),
			intval($site_info['siteLong']),
			strval($site_info['siteDescription']),
			strval($site_info['siteState']),
			strval($site_info['timeStamp']),
			intval($site_info['isValid']),
			strval($site_info['siteSaltHash']),
            intval($site_info['numCircles']));
    }

//basically duped from find function. Should try to overload original find fucntion instead of creating new one
    public static function findName($siteName){
        $result = Site::getQueryResult("SELECT * FROM tbl_sites WHERE siteName=" . $siteName);
		if(is_null($result) || $result==-1){
			return $result;
		}
        $site_info = $result->fetch_array();
        return new Site(intval($site_info['siteID']),
			strval($site_info['siteName']),
			intval($site_info['siteLat']),
			intval($site_info['siteLong']),
			strval($site_info['siteDescription']),
			strval($site_info['siteState']),
			strval($site_info['timeStamp']),
			intval($site_info['isValid']),
			strval($site_info['siteSaltHash']),
            intval($site_info['numCircles']));
    }
	
	//returns null if DB error
	//Returns JSON object with site statistics (site name, site description, number of unique users, number of unique arthropod orders, number of surveys) on success
	public static function getSiteStatistics($siteID){
		$description = Site::getQueryResult("SELECT siteName, siteDescription FROM tbl_sites WHERE siteID=" . $siteID);
		$statistics = Site::getQueryResult("SELECT COUNT(DISTINCT surveyID) as count_surveys, COUNT(DISTINCT userID) as unique_users, COUNT(DISTINCT orderArthropod) as unique_species FROM tbl_surveys NATURAL JOIN tbl_orders WHERE siteID=" . $siteID);
		$recentSurvey = Site::getQueryResult("SELECT timeSubmit FROM tbl_surveys WHERE isValid=1 AND siteID=" . $siteID . " ORDER BY timeSubmit DESC LIMIT 1");
        if(is_null($description) || (is_numeric($description) && $description==-1)){
			return $description;
		}
		if(is_null($statistics) || (is_numeric($description) && $statistics==-1)){
			return $statistics;
		}
		$siteDescription = $description->fetch_array();
		$siteStatistics = $statistics->fetch_array();
        $siteRecentSurvey = $recentSurvey->fetch_array();
		return array(
			'siteName' => strval($siteDescription['siteName']), 
			'siteDescription' => strval($siteDescription['siteDescription']),
			'countSurveys' => intval($siteStatistics['count_surveys']),
			'countUsers' => intval($siteStatistics['unique_users']),
			'countArthropods' => intval($siteStatistics['unique_species']),
            'recentSurvey' => strval($siteRecentSurvey['timeSubmit'])
		);
	}
	
	// Returns null of there is a DB connection error
	//Otherwise returns the statistic element (plant or arthropod) and how many times that element appears in the observations
	public static function getStatisticElementComposition($query, $elementName){
		$elementsResult = Site::getQueryResult($query);
		if(is_null($elementsResult) || (is_numeric($elementsResult) && $elementsResult==-1)){
			return $elementsResult;
		}
		$result = array();
		while($tuple = mysqli_fetch_assoc($elementsResult)) {
        	$result[strval($tuple[$elementName])] = intval($tuple['abundance']);
        }
		return $result;
	}
	
	// Returns null of there is a DB connection error
	//Otherwise returns the different plants present in the surveys of the given site and how many times that plant appears in the observations
	public static function getPlantComposition($siteID){
		return Site::getStatisticElementComposition("SELECT plantSpecies, COUNT(*) as abundance"
			. " FROM tbl_surveys" 
			. " WHERE isValid=1 AND siteID=" . $siteID
			. " GROUP BY plantSpecies"
			. " ORDER BY abundance DESC", 'plantSpecies');
	}
	
	// Returns null of there is a DB connection error
	//Otherwise returns the different arthropods present in the surveys of the given site and how many times that arthropod appears in the observations
	public static function getArthropodComposition($siteID){
		return Site::getStatisticElementComposition("SELECT * FROM (SELECT orderArthropod, SUM(orderCount) as abundance"
			. " FROM tbl_surveys NATURAL JOIN tbl_orders"
			. " WHERE isValid=1 AND siteID=" . $siteID . " AND orderArthropod IN ('Spiders (Araneae)', 'Caterpillars (Lepidoptera larvae)', 'Beetles (Coleoptera)', 'Leaf hoppers and Cicadas (Auchenorrhyncha)', 'Ants (Formicidae)', 'Aphids and Psyllids (Sternorrhyncha)', 'Flies (Diptera)', 'Daddy longlegs (Opiliones)', 'Bees and Wasps (Hymenoptera, excluding ants)')"
			. " GROUP BY orderArthropod"
			. " UNION "
			. " SELECT 'Other' as orderArthropod, SUM(orderCount) as abundance"
			. " FROM tbl_surveys NATURAL JOIN tbl_orders"
			. " WHERE isValid=1 AND siteID=" . $siteID . " AND orderArthropod NOT IN ('Spiders (Araneae)', 'Caterpillars (Lepidoptera larvae)', 'Beetles (Coleoptera)', 'Leaf hoppers and Cicadas (Auchenorrhyncha)', 'Ants (Formicidae)', 'Aphids and Psyllids (Sternorrhyncha)', 'Flies (Diptera)', 'Daddy longlegs (Opiliones)', 'Bees and Wasps (Hymenoptera, excluding ants)')) as tbl_res"
			. " WHERE (orderArthropod, abundance) NOT IN (SELECT 'Other' as orderArthropod, 0 as abundance)", "orderArthropod");
	}
	
	/*
		It gets all the submissions of a given site and returns for each submission the order arthropod, the number of times that arthropod was
		seen in that survey and the plant species of the survey.
	*/
	public static function getAllSubmissions($siteID){
		$elementsResult = Site::getQueryResult("SELECT * FROM tbl_surveys NATURAL JOIN tbl_orders WHERE siteID = " . $siteID);
		if(is_null($elementsResult) || (is_numeric($elementsResult) && $elementsResult==-1)){
			return $elementsResult;
		}
		$result = array();
		while($tuple = mysqli_fetch_assoc($elementsResult)) {
			$result[] = array('orderArthropod' => strval($tuple['orderArthropod']),
				'orderCount' => intval($tuple['orderCount']),
				'plantSpecies' => strval($tuple['plantSpecies']));
		}
		return $result;
	}
	
	/*
		This function checks the input values passed in the request, and if such values were not passed, then default ones are assigned
	*/
	public static function nullTester($arthropodSelect, $plantSelect){
        if(is_null($arthropodSelect)){
            $arthropodSelect = '%';
        }
          if(is_null($plantSelect)){
            $plantSelect = '%';
        }
        return array('arthropodSelect' => $arthropodSelect, 'plantSelect' => $plantSelect);
    }
	
	private static function createFilterQuery($arthropodSelect, $plantSelect, $minSize){
		$nonNullParameters = Site::nullTester($arthropodSelect, $plantSelect);
        return  "SELECT A.siteID, A.siteName, A.siteLat, A.siteLong, BC.abundance, BC.surveyCount FROM (\n"
            . " (SELECT siteID, siteName, siteLat, siteLong FROM tbl_sites) as A\n"
            . " INNER JOIN (\n"
            . " SELECT B.siteID, B.abundance, C.surveyCount FROM (\n"
            . " (SELECT siteID, SUM(orderCount) as abundance FROM tbl_surveys NATURAL JOIN tbl_orders WHERE isValid=1 AND plantSpecies LIKE \"%" . $plantSelect . "%\" AND orderArthropod LIKE \"%" . $arthropodSelect . "%\" AND orderLength >= " . $minSize . " GROUP BY siteID) as B\n"
            . " INNER JOIN\n"
            . " (SELECT siteID, COUNT(*) as surveyCount FROM tbl_surveys WHERE isValid=1 GROUP BY siteID) as C\n"
            . " ON B.siteID=C.siteID)\n"
            . " ) AS BC\n"
            . " ON A.siteID=BC.siteID\n"
            . " )";
    }

    public static function getFilteredSites($arthropodSelect, $plantSelect, $minSize){
        $query = Site::createFilterQuery($arthropodSelect, $plantSelect, $minSize);
        $result = Site::getQueryResult($query);
        if(is_null($result) || (is_numeric($result) && $result==-1)){
            return $result;
        }
        $maxResult = Site::getQueryResult("SELECT MAX(density) FROM \n"
            . " (SELECT B.siteID, B.abundance/C.surveyCount as density FROM\n"
            . " (SELECT siteID, SUM(orderCount) as abundance FROM tbl_surveys NATURAL JOIN tbl_orders WHERE isValid=1 AND plantSpecies LIKE \"%" . $plantSelect . "%\" AND orderArthropod LIKE \"%" . $arthropodSelect . "%\" AND orderLength >= " . $minSize . " GROUP BY siteID) as B\n"
            . " INNER JOIN\n"
            . " (SELECT siteID, COUNT(*) as surveyCount FROM tbl_surveys WHERE isValid=1 GROUP BY siteID) as C\n"
            . " ON B.siteID=C.siteID) as A");
      
        $minResult = Site::getQueryResult("SELECT MIN(density) FROM \n"
            . " (SELECT B.siteID, B.abundance/C.surveyCount as density FROM\n"
            . " (SELECT siteID, SUM(orderCount) as abundance FROM tbl_surveys NATURAL JOIN tbl_orders WHERE isValid=1 AND plantSpecies LIKE \"%" . $plantSelect . "%\" AND orderArthropod LIKE \"%" . $arthropodSelect . "%\" AND orderLength >= " . $minSize . " GROUP BY siteID) as B\n"
            . " INNER JOIN\n"
            . " (SELECT siteID, COUNT(*) as surveyCount FROM tbl_surveys WHERE isValid=1 GROUP BY siteID) as C\n"
            . " ON B.siteID=C.siteID) as A");

        $max = floatval(mysqli_fetch_all($maxResult));
        $min = floatval(mysqli_fetch_all($minResult));
        
        $resultArray = array();
        while($tuple = mysqli_fetch_assoc($result)) {
            $siteObject = array(
            'siteName' => strval($tuple['siteName']),
            'siteID' => intval($tuple['siteID']),
            'siteLat' => floatval($tuple['siteLat']),
            'siteLong' => floatval($tuple['siteLong']),
            //'abundance' => ((((log10(floatval($tuple['abundance'])/floatval($tuple['surveyCount']))) + 3)/4) * 17) + 3
            'abundance' => ((log10(floatval($tuple['abundance'])/floatval($tuple['surveyCount']))) + 3)/4
            );
            array_push($resultArray, $siteObject);
        }
        return $resultArray;
    }

    //Returns a list of sites that admin is authorized to modify or curate
    public static function getAllAuthorized($userID){
        $mysqli = Database_connection::getMysqli();
        $query = "Select validUser, privilegeLevel from tbl_users where userID = ".$userID;

        $result = $mysqli->query($query);


        if (is_null($result) || !$result){
            $output['status'] = "Database error";
            return $output;
        }elseif ($result->num_rows == 0){
            $output['status'] = 'User not Found';
            return $output;
        }else{
            $row = $result->fetch_assoc();

            $privilegeLevel = intval($row['privilegeLevel']);
            $validUser = intval($row['validUser']);

            if($validUser == 0 || $privilegeLevel == 0) {
                $output['status'] = 'User is not an Admin';
                return $output;
            }
            $output['status'] = 'OK';

            if($privilegeLevel == 5){
                $sqlquery = "SELECT * from tbl_sites WHERE siteID IN (SELECT siteID from tbl_siteAdmin
                              where userID = ".$userID.")";
                $result = $mysqli->query($sqlquery);

                if(!$result){
                    $output['status']='Failed to perform site search';
                }
                $output['sites'] = [];

                while ($row = $result->fetch_assoc()){
                    $output['sites'][] = $row;
                }
                return $output;

            }else{
                $output['sites']=self::getAll('getAll');
                return $output;
            }
        }
    }

    public static function getYearsActive($siteID){
        if(is_null($mysqli = Database_connection::getMysqli())){
            return null;
        }
        $sqlquery = "Select distinct YEAR(timeStart) as year FROM tbl_surveys where siteID = ".$siteID.
            " ORDER BY year ASC";
        $result = $mysqli->query($sqlquery);
        if(!$result){
            return $mysqli->error();
        }
        $output = [];
        while(!is_null($row = $result->fetch_assoc())){
            $output[] = $row['year'];
        }
        return $output;
    }
    //This should only be used with a numeric array

    public static function getOrderDensity($siteID, $plantSpecies, $orders, $year){
        if(is_null($mysqli = Database_connection::getMysqli())){
            return null;
        }

        $orderString = concatArgs("orderArthropod", $orders);
        $plantString = concatArgs("plantSpecies", $plantSpecies);

        $sqlquery = "SELECT DAYOFYEAR(timeStart) as day, SUM(orderCount) as count
							FROM tbl_surveys NATURAL JOIN tbl_orders WHERE
							siteID = ".$siteID." AND
							YEAR(timeStart) = ".$year." AND
							(".$orderString.") AND (".$plantString.") GROUP BY day ORDER by day";
        //print($sqlquery."\n");
        $result = $mysqli->query($sqlquery);
        if(!$result){
            return $mysqli->error();
        }
        $orderCount = [];
        while(!is_null($row = $result->fetch_assoc())){
            $orderCount[intval($row['day'])] = floatval($row['count']);
        }
        $sqlquery = "SELECT DAYOFYEAR(timeStart) as day, COUNT(*) as numSurveys
							FROM tbl_surveys WHERE
							siteID = ".$siteID." AND
							YEAR(timeStart) = ".$year." AND
							(".$plantString.") GROUP BY day ORDER by day";
        //print($sqlquery."\n");

        $result = $mysqli->query($sqlquery);
        if(!$result){
            return $mysqli->error();
        }
        $surveyCount = [];
        while(!is_null($row = $result->fetch_assoc())){
            $surveyCount[intval($row['day'])] = floatval($row['numSurveys']);
        }
        $output = [];
        foreach($surveyCount as $key => $value){
            if (is_null($orderCount[$key])){
                $output[] = array('day'=>$key,'density'=>0);
            }else{
                $output[] = array('day'=>$key,'density'=>($orderCount[$key]/$value));
            }
        }
        return $output;
    }
    public static function getPlantList($siteID){
        if(is_null($mysqli = Database_connection::getMysqli())){
            return null;
        }
        $query = "SELECT plantSpecies from
						(SELECT DISTINCT plantSpecies FROM tbl_surveys WHERE siteID = ".$siteID."

						UNION SELECT DISTINCT plantSpecies from tbl_surveyTrees where siteID = ".$siteID.")
						AS a WHERE plantSpecies != '' ORDER BY plantSpecies";
        $result = $mysqli->query($query);
        if(!$result){
            return $mysqli->error();
        }
        $output = [];
        while(!is_null($row = $result->fetch_assoc())){
            $output[] = $row['plantSpecies'];
        }
        return $output;
    }
    
    public function getSiteID(){
      return $this->siteID;
    }
    public function getSiteName(){
      return $this->siteName;
    }
    public function getSiteLat(){
      return $this->siteLat;
    }
    public function getSiteLong(){
      return $this->siteLong;
    }
    public function getSiteDescription(){
      return $this->siteDescription;
    }
    public function getSiteState(){
      return $this->siteState;
    }
    public function getTimeStamp(){
      return $this->timeStamp;
    }
    public function getIsValid(){
      return $this->isValid;
    }
    public function getSiteSaltHash(){
      return $this->siteSaltHash;
    }
    public function getJSON(){
      $json_rep = array();
      $json_rep['siteID'] = $this->siteID;
      $json_rep['siteName'] = $this->siteName;
      $json_rep['siteLat'] = $this->siteLat;
      $json_rep['siteLong'] = $this->siteLong;
      $json_rep['siteDescription'] = $this->siteDescription;
      $json_rep['siteState'] = $this->siteState;
      $json_rep['timeStamp'] = $this->timeStamp;
      $json_rep['isValid'] = $this->isValid;
      $json_rep['numCircles'] = $this->numCircles;
      return $json_rep;
    }


}
//Only use this function with a numeric variable
function concatArgs($variable, $args){
    $output = "";
    foreach ($args as $key=>$value){
        $output = $output." ".$variable." LIKE '%".$value."%'";

        if ($key < count($args)-1){
            $output = $output." OR ";
        }
    }
    return $output;
}