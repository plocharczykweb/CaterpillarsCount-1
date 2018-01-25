<?php
//By: Pintian Zhang and Derek Gu and Steven Thomas
require_once("Domain.php");
require_once("User.php");
require_once("Database_connection.php");

class Survey {

    private $surveyID;
    private $siteID;
    private $userID;
    private $circle;
    private $survey;
    private $timeStart;
    private $timeSubmit;
    private $temperatureMin;
    private $temperatureMax;
    private $siteNotes;
    private $plantSpecies;
    private $herbivory;
    private $leavePhoto;
    private $status;
    private $surveyType;
    private $leafCount;
    private $source;

    public function __construct($surveyBuilder) {
        $this->surveyID = $surveyBuilder->getSurveyID();
        $this->siteID = $surveyBuilder->getSiteID();
        $this->userID = $surveyBuilder->getUserID();
        $this->circle = $surveyBuilder->getCircle();
        $this->survey = $surveyBuilder->getSurvey();
        $this->timeStart = $surveyBuilder->getTimeStart();
        $this->timeSubmit = $surveyBuilder->getTimeSubmit();
        $this->temperatureMin = $surveyBuilder->getTemperatureMin();
        $this->temperatureMax = $surveyBuilder->getTemperatureMax();
        $this->siteNotes = $surveyBuilder->getSiteNotes();
        $this->plantSpecies = $surveyBuilder->getPlantSpecies();
        $this->herbivory = $surveyBuilder->getHerbivory();
        $this->leavePhoto = $surveyBuilder->getLeavePhoto();
        $this->status = $surveyBuilder->getStatus();
        $this->surveyType = $surveyBuilder->getSurveyType();
        $this->leafCount = $surveyBuilder->getLeafCount();
        $this->source = $surveyBuilder->getSource();

    }
    //return null on db error
    //return -1 on invalid user
    //return survey object on success
    public static function create($survey) {
        $mysqli = new mysqli(getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_HOST') . ':' . getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_PORT'),
            $_ENV['MYSQL_USER'],
            $_ENV['MYSQL_PASSWORD'],
            "caterpillars");
        if ($mysqli->connect_errno) {
            return null;
        }
        //check valid user
        $userObj = User::findByID($survey->userID);
        if (!is_object($userObj) || !($userObj->checkValid())) {
            return -1;
        }

        error_log("INSERT INTO tbl_surveys (siteID, userID,circle,survey,
            timeStart,temperatureMin,temperatureMax,siteNotes,plantSpecies,herbivory,status,surveyType,
            leafCount,source)
             VALUES (" 
                . $survey->siteID . "," 
                . $survey->userID . "," 
                . $survey->circle . ",\"" 
                . $survey->survey . "\",\"" 
                . $survey->timeStart . "\"," 
                . $survey->temperatureMin . "," 
                . $survey->temperatureMax . ",\"" 
                . $survey->siteNotes . "\",\"" 
                . $survey->plantSpecies . "\"," 
                . $survey->herbivory . "," 
                . $survey->status . "," 
                . $survey->surveyType . ","
                . $survey->leafCount . ",\""
                . $survey->source ."\")");

        $result = $mysqli->query("INSERT INTO tbl_surveys (siteID, userID,circle,survey,
            timeStart,temperatureMin,temperatureMax,siteNotes,plantSpecies,herbivory,status,surveyType,
            leafCount,source)
             VALUES (" 
                . $survey->siteID . "," 
                . $survey->userID . "," 
                . $survey->circle . ",\"" 
                . $survey->survey . "\",\"" 
                . $survey->timeStart . "\"," 
                . $survey->temperatureMin . "," 
                . $survey->temperatureMax . ",\"" 
                . $survey->siteNotes . "\",\"" 
                . $survey->plantSpecies . "\"," 
                . $survey->herbivory . ",\"" 
                . $survey->status . "\",\"" 
                . $survey->surveyType . "\","
                . $survey->leafCount . ",\""
                . $survey->source ."\")"
        );

        $newID = $mysqli->insert_id;
        if (!$result) {
            return null;
        }

        $sqlquery = "INSERT INTO tbl_surveys_clean (surveyID, siteID, userID,circle,survey,
            timeStart,temperatureMin,temperatureMax,plantSpecies,herbivory,surveyType,
            leafCount)
             VALUES ("
                .$newID."," 
                . $survey->siteID . "," 
                . $survey->userID . "," 
                . $survey->circle . ",\"" 
                . $survey->survey . "\",\"" 
                . $survey->timeStart . "\"," 
                . $survey->temperatureMin . "," 
                . $survey->temperatureMax . ",\"" 
                . $survey->plantSpecies . "\"," 
                . $survey->herbivory . ",\""
                . $survey->surveyType . "\","
                . $survey->leafCount . ")";

        error_log($sqlquery);

        $result = $mysqli->query($sqlquery);

        if (!$result) {
            return null;
        }


        //create leavePhoto URL according to userID and newly generated surveyID
        //$leavePhoto = Domain::getDomain() . "survey" . $survey->userID . "-" . $survey->newID . ".jpg";
        //update the tuple in the database with leavePhoto URL
        // $result = $mysqli->query("UPDATE tbl_surveys SET leavePhoto ='" 
        //     . $leavePhoto . "' WHERE surveyID =" . $newID);
        // if (!$result) {
        //     return null;
        // }
        //return survey object

        return Survey::findByID($newID);
    }
    //return null on db error
    //return survey object on success
    public static function findByID($surveyID) {
        $mysqli = new mysqli(getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_HOST') . ':' . getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_PORT'),
            $_ENV['MYSQL_USER'],
            $_ENV['MYSQL_PASSWORD'], "caterpillars");
        if ($mysqli->connect_errno)
            return null;

//        $sqlquery = "SELECT clean.surveyID,
//                            clean.siteID,
//                            clean.userID,
//                            clean.circle,
//                            clean.survey,
//                            clean.timeStart,
//                            raw.timeSubmit,
//                            clean.temperatureMin,
//                            clean.temperatureMax,
//                            raw.siteNotes,
//                            clean.mod_notes,
//                            clean.plantSpecies,
//                            clean.herbivory,
//                            raw.leavePhoto,
//                            clean.status,
//                            clean.surveyType,
//                            clean.leafCount,
//                            raw.source
//                             FROM tbl_surveys as raw JOIN tbl_surveys_clean as clean on (raw.surveyID = clean.surveyID)
//                             WHERE raw.surveyID = ".$surveyID;

        $sqlquery = "SELECT * from tbl_surveys_view where surveyID = ".$surveyID;

        $result = $mysqli->query($sqlquery);
        if (!$result || 0 == $result->num_rows) {
            return null;
        }
        $survey_info = $result->fetch_array();
        return (new SurveyBuilder())
                ->surveyID(intval($survey_info['surveyID']))
                ->siteID(intval($survey_info['siteID']))
                ->userID(intval($survey_info['userID']))
                ->circle(intval($survey_info['circle']))
                ->survey(strval($survey_info['survey']))
                ->timeStart(strval($survey_info['timeStart']))
                ->timeSubmit(strval($survey_info['timeSubmit']))
                ->temperatureMin(intval($survey_info['temperatureMin']))
                ->temperatureMax(intval($survey_info['temperatureMax']))
                ->siteNotes(strval($survey_info['siteNotes']))
                ->plantSpecies(strval($survey_info['plantSpecies']))
                ->herbivory(intval($survey_info['herbivory']))
                ->leavePhoto(strval($survey_info['leavePhoto']))
                ->status(strval($survey_info['status']))
                ->surveyType(strval($survey_info['surveyType']))
                ->leafCount(intval($survey_info['leafCount']))
                ->source(strval($survey_info['source']))
                ->build();
    }
    
    //Updates the leave photo of a given survey
    //Parameters: new picture path and the survey id whose picture we want to update
    public static function updateSurveyPicture($picturePath, $surveyId){
        $mysqli = new mysqli(getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_HOST') . ':' . getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_PORT'),
            $_ENV['MYSQL_USER'],
            $_ENV['MYSQL_PASSWORD'], "caterpillars");
        if ($mysqli->connect_errno){
            return null;
        }
        $mysqli->query("UPDATE tbl_surveys SET leavePhoto = '" 
            . $picturePath . "'WHERE surveyID = " . $surveyId);
    }
    //By Derek Gu
    //return null if db error or siteIDs invalid or no survey found
    //return list of sites found on sucess
    public static function getAllBySiteID($siteID, $startDate, $endDate) {
        $mysqli = new mysqli(getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_HOST') . ':' . getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_PORT'),
            $_ENV['MYSQL_USER'],
            $_ENV['MYSQL_PASSWORD'], "caterpillars");
        if ($mysqli->connect_errno)
            return null;
        $query = "SELECT * FROM tbl_surveys_view WHERE siteID =" . $siteID;
        if ($startDate) {
            $query.= " AND DATE(timeStart) >= '" . $startDate."'";
        }
        if ($endDate) {
            $query.= " AND DATE(timeStart) <= '" . $endDate."'";
        }
        $result = $mysqli->query($query);
        if ($result) {
            if (0 == $result->num_rows) {
                return null;
            }
            while ($row = $result->fetch_array()) {
                $surveys[] = (new SurveyBuilder())
                        ->surveyID(intval($row['surveyID']))
                        ->siteID(intval($row['siteID']))
                        ->userID(intval($row['userID']))
                        ->circle(intval($row['circle']))
                        ->survey(strval($row['survey']))
                        ->timeStart(strval($row['timeStart']))
                        ->timeSubmit(strval($row['timeSubmit']))
                        ->temperatureMin(intval($row['temperatureMin']))
                        ->temperatureMax(intval($row['temperatureMax']))
                        ->siteNotes(strval($row['siteNotes']))
                        ->plantSpecies(strval($row['plantSpecies']))
                        ->herbivory(intval($row['herbivory']))
                        ->leavePhoto(strval($row['leavePhoto']))
                        ->status(strval($row['status']))
                        ->surveyType(strval($row['surveyType']))
                        ->leafCount(intval($row['leafCount']))
                        ->source(strval($row['source']))
                        ->build();
            }
            return $surveys;
        } else
            return null;
    }
    //By Derek Gu
    // Takes an array of siteIDs as parameter
    // returns an array of surveys if sucess
    // returns null if db error or siteIDs invalid or no survey found
    public static function getAllBySiteIDArray($siteIDs, $startDate = '', $endDate = '') {
        $mysqli = new mysqli(getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_HOST') . ':' . getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_PORT'),
            $_ENV['MYSQL_USER'],
            $_ENV['MYSQL_PASSWORD'], "caterpillars");
        if ($mysqli->connect_errno)
            return null;
        $query = "SELECT * FROM tbl_surveys_view WHERE (siteID = " . $siteIDs[0];
        for ($i = 1; $i < count($siteIDs); $i++) {
            $query.= " OR siteID = " . $siteIDs[$i];
        }
        $query.=")";
        if ($startDate) {
            $query.= " AND DATE(timeStart) >= '" . $startDate."'";
        }
        if ($endDate) {
            $query.= " AND DATE(timeStart) <= '" . $endDate."'";
        }
        //print($query);
        $result = $mysqli->query($query);
        if ($result) {
            if (0 == $result->num_rows) {
                return null;
            }
            while ($row = $result->fetch_assoc()) {
                $surveys[] = $row;
            }
            return $surveys;
        } else
            return null;
    }

    public static function getAllNewSurveys() {
        $mysqli = new mysqli(getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_HOST') . ':' . getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_PORT'),
            $_ENV['MYSQL_USER'],
            $_ENV['MYSQL_PASSWORD'], "caterpillars");
        if ($mysqli->connect_errno)
            return null;
        $query = "SELECT * FROM tbl_surveys_view WHERE status = new";
        $result = $mysqli->query($query);

        if ($result) {
            if (0 == $result->num_rows) {
                return null;
            }
            while ($row = $result->fetch_array()) {
                $surveys[] = (new SurveyBuilder())
                        ->surveyID(intval($row['surveyID']))
                        ->siteID(intval($row['siteID']))
                        ->userID(intval($row['userID']))
                        ->circle(intval($row['circle']))
                        ->survey(strval($row['survey']))
                        ->timeStart(strval($row['timeStart']))
                        ->timeSubmit(strval($row['timeSubmit']))
                        ->temperatureMin(intval($row['temperatureMin']))
                        ->temperatureMax(intval($row['temperatureMax']))
                        ->siteNotes(strval($row['siteNotes']))
                        ->plantSpecies(strval($row['plantSpecies']))
                        ->herbivory(intval($row['herbivory']))
                        ->leavePhoto(strval($row['leavePhoto']))
                        ->status(strval($row['status']))
                        ->surveyType(strval($row['surveyType']))
                        ->leafCount(intval($row['leafCount']))
                        ->source(strval($row['source']))
                        ->build();
            }
            return $surveys;
        } else {
            return null;
        }
    }

    public static function getAllNewSurveysBySiteIDANDDate($siteID, $dateList){
        $mysqli = Database_connection::getMysqli();

        $sqlquery = "Select * from tbl_surveys_view where siteID = ".$siteID." and ( ";



        $dateString = "";
        for ($i = 0; $i < count($dateList); $i++) {
            $dateString = $dateString."date(timeStart) = '".$dateList[$i]."'";

            if ($i < count($dateList)-1){
                $dateString = $dateString." or ";
            }
            error_log($dateString);
        }
        $dateString = $dateString.") ";
        $sqlquery = $sqlquery.$dateString;

        error_log($sqlquery);
        $result = $mysqli->query($sqlquery);

        $result = $result->fetch_all(MYSQLI_ASSOC);

        error_log(json_encode($result));

        foreach($result as &$value){

            error_log(json_encode($value));

            $siteID = $value ['siteID'];
            $circle = $value['circle'];
            $survey = $value['survey'];

            $sqlquery = "Select * from tbl_surveyTrees where siteID = ".$siteID." and
                                                             circle = ".$circle." and
                                                             survey = '".$survey."'";

            error_log($sqlquery);

            $plantResult = $mysqli->query($sqlquery);

            $officialPlantSpecies = "N/A";

            if ($plantResult->num_rows>0){
                $row = $plantResult->fetch_row();
                error_log(json_encode($row));
                $officialPlantSpecies = $row[3];

            }else{
                $sqlquery = "Select plantSpecies, count(*) from tbl_surveys_view
                                                        where siteID = ".$siteID." and
                                                             circle = ".$circle." and
                                                             survey = '".$survey."'

                                                        group by plantSpecies
                                                        order by COUNT(*) DESC";

                error_log($sqlquery);
                $plantResult = $mysqli->query($sqlquery);

                if ($plantResult->num_rows > 0){
                    $row = $plantResult->fetch_row();
                    error_log(json_encode($row));
                    $officialPlantSpecies = $row[0].": ".$row[1];
                }


            }
            error_log($officialPlantSpecies);
            $value['officialPlantSpecies'] = $officialPlantSpecies;
            error_log(json_encode($value));

        }
        error_log(json_encode($result));
        return $result;

    }
    public static function markValid($surveyArray){
        $mysqli = Database_connection::getMysqli();

        $sqlquery = "Update tbl_surveys SET status = 'valid' where ";

        for ($i = 0; $i < count($surveyArray); $i++){
            $sqlquery = $sqlquery."surveyID = ".$surveyArray[$i];
            if($i < count($surveyArray)-1){
                $sqlquery = $sqlquery." OR ";
            }
        }

        $result = $mysqli->query($sqlquery);

        if (!$result){
            return ['status' => false];
        }else{
            return ['status' => 'OK'];
        }

    }

    public function getSurveyID() {
        return $this->surveyID;
    }
    public function getSiteID() {
        return $this->siteID;
    }
    public function getUserID() {
        return $this->userID;
    }
    public function getCircle() {
        return $this->circle;
    }
    public function getSurvey() {
        return $this->survey;
    }
    public function getTimeStart() {
        return $this->timeStart;
    }
    public function getTimeSubmit() {
        return $this->timeSubmit;
    }
    public function getTemperatureMin() {
        return $this->temperatureMin;
    }
    public function getTemperatureMax() {
        return $this->temperatureMax;
    }
    public function getSiteNotes() {
        return $this->siteNotes;
    }
    public function getPlantSpecies() {
        return $this->plantSpecies;
    }
    public function getHerbivory() {
        return $this->herbivory;
    }
    public function getLeavePhoto() {
        return $this->leavePhoto;
    }
    public function getStatus() {
        return $this->status;
    }

    public function getSurveyType() {
        return $this->surveyType;
    }

    public function getLeafCount() {
        return $this->leafCount;
    }

    public function getSource() {
        return $this->source;
    }


    public function getJSON() {
        $json_obj = array(
            'surveyID' => $this->surveyID,
            'siteID' => $this->siteID,
            'userID' => $this->userID,
            'circle' => $this->circle,
            'survey' => $this->survey,
            'timeStart' => $this->timeStart,
            'timeSubmit' => $this->timeSubmit,
            'temperatureMin' => $this->temperatureMin,
            'temperatureMax' => $this->temperatureMax,
            'siteNotes' => $this->siteNotes,
            'plantSpecies' => $this->plantSpecies,
            'herbivory' => $this->herbivory,
            'leavePhoto' => $this->leavePhoto,
            'status' => $this->status,
            'surveyType' => $this->surveyType,
            'leafCount' => $this->leafCount,
            'source' => $this->source
        );
        return $json_obj;
    }
    public function getJSONSimple() {
        $json_obj = array(
            'surveyID' => $this->surveyID,
            'siteID' => $this->siteID,
            'userID' => $this->userID,
            'leavePhoto' => $this->leavePhoto
        );
        return $json_obj;
    }
}

class SurveyBuilder {
    private $surveyID;
    private $siteID;
    private $userID;
    private $circle;
    private $survey;
    private $timeStart;
    private $timeSubmit;
    private $temperatureMin;
    private $temperatureMax;
    private $siteNotes;
    private $plantSpecies;
    private $herbivory;
    private $leavePhoto;
    private $status;
    private $surveyType;
    private $leafCount;
    private $source;

    public function __construct(){}


    public function getSurveyID()   {    return $this->surveyID;    }
    public function getSiteID()     {   return $this->siteID;       }
    public function getUserID()     {    return $this->userID;      }
    public function getCircle()     {   return $this->circle;       }
    public function getSurvey()     {    return $this->survey;      }
    public function getTimeStart()  {    return $this->timeStart;   }
    public function getTimeSubmit() {    return $this->timeSubmit;  }
    public function getTemperatureMin() {    return $this->temperatureMin;  }
    public function getTemperatureMax() {    return $this->temperatureMax;  }
    public function getSiteNotes()      {    return $this->siteNotes;       }
    public function getPlantSpecies()   {    return $this->plantSpecies;    }
    public function getHerbivory()      {    return $this->herbivory;       } 
    public function getLeavePhoto()     {    return $this->leavePhoto;      }
    public function getStatus()         {    return $this->status;  }
    public function getSurveyType() {    return $this->surveyType;  }
    public function getLeafCount()  {    return $this->leafCount;   }
    public function getSource()     {    return $this->source;  }



    public function surveyID($surveyID) {$this->surveyID = $surveyID; return $this;}
    public function siteID($siteID) {$this->siteID = $siteID; return $this;}
    public function userID($userID) {$this->userID = $userID; return $this;}
    public function circle($circle) {$this->circle = $circle; return $this;}
    public function survey($survey) {$this->survey =$survey ; return $this;}
    public function timeStart($timeStart) {$this->timeStart =$timeStart; return $this;}
    public function timeSubmit($timeSubmit) {$this->timeSubmit =$timeSubmit; return $this;}
    public function temperatureMin($temperatureMin) {$this->temperatureMin =$temperatureMin; return $this;}
    public function temperatureMax($temperatureMax) {$this->temperatureMax =$temperatureMax; return $this;}
    public function siteNotes($siteNotes) {$this->siteNotes =$siteNotes; return $this;}
    public function plantSpecies($plantSpecies) {$this->plantSpecies =$plantSpecies; return $this;}
    public function herbivory($herbivory) {$this->herbivory =$herbivory; return $this;}
    public function leavePhoto($leavePhoto) {$this->leavePhoto =$leavePhoto; return $this;}
    public function status($status) {$this->status =$status; return $this;}
    public function surveyType($surveyType) {$this->surveyType =$surveyType; return $this;}
    public function leafCount($leafCount) {$this->leafCount =$leafCount; return $this;}
    public function source($source) {$this->source =$source; return $this;}

    public function build() { return new Survey($this); }

}


?>