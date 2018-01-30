<?php

require_once('resources/Keychain.php');
require_once('Site.php');

class Plant
{
//PRIVATE VARS
	private $id;							//INT
	private $site;							//Site object
	private $circle;
	private $orientation;					//STRING			email that has been signed up for but not necessarilly verified
	private $code;
	
	private $deleted;

//FACTORY
	public static function create($site, $circle, $orientation) {
		$dbconn = (new Keychain)->getDatabaseConnection();
		if(!$dbconn){
			return "Cannot connect to server.";
		}
		
		$site = self::validSite($dbconn, $site);
		$circle = self::validCircleFormat($dbconn, $circle);
		$orientation = self::validOrientationFormat($dbconn, $orientation);
		
		$failures = "";
		
		if($site === false){
			$failures .= "Invalid site. ";
		}
		if($circle === false){
			$failures .= "Enter a circle. ";
		}
		if($orientation === false){
			$failures .= "Enter an orientation. ";
		}
		if($failures == "" && is_null(self::findBySiteAndPosition($site, $circle, $orientation)) === false){
			$failures .= "Enter a unique circle/orientation set for this site. ";
		}
		
		if($failures != ""){
			return $failures;
		}
		
		mysqli_query($dbconn, "INSERT INTO Plant (`SiteFK`, `Circle`, `Orientation`) VALUES ('" . $site->getID() . "', '$circle', '$orientation')");
		$id = intval(mysqli_insert_id($dbconn));
		
		$code = self::IDToCode($id);
		mysqli_query($dbconn, "UPDATE Plant SET `Code`='$code' WHERE `ID`='$id'");
		mysqli_close($dbconn);
		
		return new Plant($id, $site, $circle, $orientation, $code);
	}
	private function __construct($id, $site, $circle, $orientation, $code) {
		$this->id = intval($id);
		$this->site = $site;
		$this->circle = $circle;
		$this->orientation = $orientation;
		$this->code = $code;
		
		$this->deleted = false;
	}

//FINDERS
	public static function findByID($id) {
		$dbconn = (new Keychain)->getDatabaseConnection();
		$id = mysqli_real_escape_string($dbconn, $id);
		$query = mysqli_query($dbconn, "SELECT * FROM `Plant` WHERE `ID`='$id' LIMIT 1");
		mysqli_close($dbconn);
		
		if(mysqli_num_rows($query) == 0){
			return null;
		}
		
		$plantRow = mysqli_fetch_assoc($query);
		
		$site = Site::findByID($plantRow["SiteFK"]);
		$circle = $plantRow["Circle"];
		$orientation = $plantRow["Orientation"];
		$code = $plantRow["Code"];
		
		return new Plant($id, $site, $circle, $orientation, $code);
	}
	
	public static function findByCode($code) {
		$dbconn = (new Keychain)->getDatabaseConnection();
		$code = self::validCode($dbconn, $code);
		if($code === false){
			return null;
		}
		$query = mysqli_query($dbconn, "SELECT `ID` FROM `Plant` WHERE `Code`='$code' LIMIT 1");
		mysqli_close($dbconn);
		if(mysqli_num_rows($query) == 0){
			return null;
		}
		return self::findByID(intval(mysqli_fetch_assoc($query)["ID"]));
	}
	
	public static function findBySiteAndPosition($site, $circle, $orientation) {
		$dbconn = (new Keychain)->getDatabaseConnection();
		$site = self::validSite($dbconn, $site);
		$circle = self::validCircleFormat($dbconn, $circle);
		$orientation = validOrientationFormat($dbconn, $orientation);
		if($site === false || $circle === false || $orientation === false){
			return null;
		}
		$query = mysqli_query($dbconn, "SELECT `ID` FROM `Plant` WHERE `SiteFK`='" . $site->getID() . "' AND `Circle`='$circle' AND `Orientation`='$orientation' LIMIT 1");
		mysqli_close($dbconn);
		if(mysqli_num_rows($query) == 0){
			return null;
		}
		return self::findByID(intval(mysqli_fetch_assoc($query)["ID"]));
	}
	
	public static function findPlantsBySite($site){
		$dbconn = (new Keychain)->getDatabaseConnection();
		$query = mysqli_query($dbconn, "SELECT `ID` FROM `Plant` WHERE `SiteFK`='" . $site->getID() . "'");
		mysqli_close($dbconn);
		
		$plantsArray = array();
		while($plantRow = mysqli_fetch_assoc($query)){
			$plant = self::findByID($plantRow["ID"]);
			array_push($plantsArray, $plant);
		}
		return $plantsArray;
	}

//GETTERS
	public function getID() {
		if($this->deleted){return null;}
		return intval($this->id);
	}
	
	public function getSite() {
		if($this->deleted){return null;}
		return $this->site;
	}
	
	public function getSpecies() {
		if($this->deleted){return null;}
		return "N/A";
	}
	
	public function getCircle() {
		if($this->deleted){return null;}
		return $this->circle;
	}
	
	public function getOrientation() {
		if($this->deleted){return null;}
		return $this->orientation;
	}
	
	public function getColor(){
		if($this->deleted){return null;}
		if($this->orientation == "A"){
			return "#ff7575";//red
		}
		else if($this->orientation == "B"){
			return "#75b3ff";//blue
		}
		else if($this->orientation == "C"){
			return "#5abd61";//green
		}
		else if($this->orientation == "D"){
			return "#ffc875";//orange
		}
		else if($this->orientation == "E"){
			return "#9175ff";//purple
		}
		return false;
	}
	
	public function getCode() {
		if($this->deleted){return null;}
		return $this->code;
	}
	
//SETTERS
	
	
//REMOVER
	public function permanentDelete()
	{
		if(!$this->deleted)
		{
			$dbconn = (new Keychain)->getDatabaseConnection();
			mysqli_query($dbconn, "DELETE FROM `Plant` WHERE `ID`='" . $this->id . "'");
			$this->deleted = true;
			mysqli_close($dbconn);
			return true;
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

//validity ensurance
	public static function validSite($dbconn, $site){
		if(is_null($site) || get_class($site) != "Site"){
			return false;
		}
		return $site;
	}
	
	public static function validCircleFormat($dbconn, $circle){
		$circle = intval(preg_replace("/[^0-9]/", "", $circle));
		if($circle >= 0){
			return $circle;
		}
		return false;
	}
	
	public static function validOrientationFormat($dbconn, $orientation){
		if(in_array($orientation, array("A", "B", "C", "D", "E"))){
			return $orientation;
		}
		return false;
	}
	
	public static function validCode($dbconn, $code){
		$code = mysqli_real_escape_string($dbconn, str_replace("0", "O", preg_replace('/\s+/', '', strtoupper($code))));
		
		if($code == ""){
			return false;
		}
		return $code;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

//FUNCTIONS
	public static function IDToCode($id){
		$chars = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
		
		//get the length of the code we will be returning
		$codeLength = 0;
		$previousIterations = 0;
		while(true){
			$nextIterations = pow(count($chars), ++$codeLength);
			if($id <= $previousIterations + $nextIterations){
				break;
			}
			$previousIterations += $nextIterations;
		}
		
		//and, for every character that will be in the code...
		$code = "";
		$index = $id - 1;
		$iterationsFromPreviousSets = 0;
		for($i = 0; $i < $codeLength; $i++){
			//generate the character from the id
			if($i > 0){
				$iterationsFromPreviousSets += pow(count($chars), $i);
			}
			$newChar = $chars[floor(($index - $iterationsFromPreviousSets) / pow(count($chars), $i)) % count($chars)];
			
			//and add it to the code
			$code = $newChar . $code;
		}
		
		//then, return a sanitized version of the full code that is safe to use with a MySQL query
		$dbconn = (new Keychain)->getDatabaseConnection();
		$code = mysqli_real_escape_string($dbconn, $code);
		mysqli_close($dbconn);
		return $code;
	}
}		
?>
