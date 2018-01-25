<?php

class RequestValidation {
	public static function siteIDNotNull($siteID){
		if(is_null($siteID) || !is_numeric($siteID)){ //The siteID wasn't passed as a parameter or is not a number
			header("HTTP/1.1 400 Bad Request");    
			print("Undefined or invalid site id");
			exit();
		}
	}

}