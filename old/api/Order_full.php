<?php
//By Pintian Zhang and Steven Thomas
require_once("Domain.php");
require_once("User.php");

class Order {

    private $orderID;
    private $surveyID;
    private $orderArthropod;
    private $orderLength;
    private $orderNotes;
    private $orderCount;
    private $insectPhoto;
    private $timeStamp;
    private $isValid;
    private $hairyOrSpiny;
    private $leafRoll;
    private $silkTent;

    public function __construct($orderBuilder) {
        $this->orderID = $orderBuilder->getOrderID();
        $this->surveyID = $orderBuilder->getSurveyID();
        $this->orderArthropod = $orderBuilder->getOrderArthropod();
        $this->orderLength = $orderBuilder->getOrderLength();
        $this->orderNotes = $orderBuilder->getOrderNotes();
        $this->orderCount = $orderBuilder->getOrderCount();
        $this->insectPhoto = $orderBuilder->getInsectPhoto();
        $this->timeStamp = $orderBuilder->getTimeStamp();
        $this->isValid = $orderBuilder->getIsValid();
        $this->hairyOrSpiny = $orderBuilder->getHairyOrSpiny();
        $this->leafRoll = $orderBuilder->getLeafRoll();
        $this->silkTent = $orderBuilder->getSilkTent();
    }

    //return null on db error
    //return -1 on invalid user
    //return order object on success
    public static function create($order) {
        $mysqli = new mysqli(getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_HOST')
            . ':' . getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_PORT'),
            $_ENV['MYSQL_USER'],
            $_ENV['MYSQL_PASSWORD'],
            "caterpillars");

        if ($mysqli->connect_errno) {
            return null;
        }

       $sqlquery = "INSERT INTO tbl_orders (orderID,
         surveyID, orderArthropod, orderLength, orderNotes, orderCount)
            VALUES (0,"
            . $order->surveyID . ",\""
            . $order->orderArthropod . "\","
            . $order->orderLength . ",\""
            . $order->orderNotes . "\","
            . $order->orderCount . ")";

        error_log($sqlquery);

        $result = $mysqli->query($sqlquery);

        $newID = $mysqli->insert_id;

        if (!$result) {
            return null;
        }

        $sqlquery = "INSERT INTO tbl_orders_clean (orderID,
         surveyID, orderArthropod, orderLength, orderCount)
            VALUES ("
                .$newID.", "
            . $order->surveyID . ",\""
            . $order->orderArthropod . "\","
            . $order->orderLength . ", "
            . $order->orderCount . ")";

        $result = $mysqli->query($sqlquery);

        if (!$result) {
            return null;
        }

        if ($order->orderArthropod == "Caterpillars (Lepidoptera larvae)"){

            error_log("making caterpillar extras field\n");




            $sqlquery = "INSERT INTO tbl_caterpillar_extras (orderID, hairyOrSpiny, leafRoll, silkTent)
                            VALUES ("
                                .$newID.", "
                                .$order->hairyOrSpiny.", "
                                .$order->leafRoll.", "
                                .$order->silkTent.")";

            error_log("$sqlquery");
            $result = $mysqli->query($sqlquery);
            if(!$result){
                return null;
            }

        }

        //create insectPhoto URL according to userID and newly generated surveyID
//        $insectPhoto = Domain::getDomain() . "order" . $order->surveyID . "-" . $newID . ".jpg";
//        //update the tuple in the database with insectPhoto URL
//        $result = $mysqli->query("UPDATE tbl_orders SET insectPhoto ='"
//            . $order->insectPhoto . "' WHERE orderID =" . $newID);
//
//        if (!$result) {
//            return null;
//        }

        return Order::findByID($newID);
    }

    //return null on db error
    //return order object on success
    public static function findByID($orderID) {

        $mysqli = new mysqli(getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_HOST') . ':'
            . getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_PORT'),
            $_ENV['MYSQL_USER'],
            $_ENV['MYSQL_PASSWORD'],
            "caterpillars");

        if ($mysqli->connect_errno) {
            return null;
        }
        $sqlquery = "SELECT * FROM tbl_orders WHERE orderID = " . $orderID;
        error_log($sqlquery);
        $result = $mysqli->query($sqlquery);
        if (!$result || 0 == $result->num_rows) {
            return null;
        }

        $order_info = $result->fetch_array();

        return (new OrderBuilder())
            ->orderID(intval($order_info['orderID']))
            ->surveyID(intval($order_info['surveyID']))
            ->orderArthropod(strval($order_info['orderArthropod']))
            ->orderLength(intval($order_info['orderLength']))
            ->orderNotes(strval($order_info['orderNotes']))
            ->orderCount(intval($order_info['orderCount']))
            ->insectPhoto(strval($order_info['insectPhoto']))
            ->timeStamp(strval($order_info['timeStamp']))
            ->isValid(intval($order_info['isValid']))
            ->build();
    }

	//Updates the insect photo of a given order
	//Parameters: new picture path and the order id whose picture we want to update
	public static function updateOrderPicture($picturePath, $orderId){
		$mysqli = new mysqli(getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_HOST') . ':'
            . getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_PORT'),
            $_ENV['MYSQL_USER'],
            $_ENV['MYSQL_PASSWORD'],
            "caterpillars");
        if ($mysqli->connect_errno){
            return null;
		}

		$mysqli->query("UPDATE tbl_orders SET insectPhoto = '"
            . $picturePath . "' WHERE orderID = " . $orderId);
	}

    //By Derek Gu
    //return null on db error or invalid surveyID or no result found
    //return list of order for a given surveyID on sucess
    public static function getAllBySurveyID($surveyID) {
        $mysqli = new mysqli(getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_HOST') . ':'
            . getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_PORT'),
            $_ENV['MYSQL_USER'],
            $_ENV['MYSQL_PASSWORD'],
            "caterpillars");
        if ($mysqli->connect_errno) {
            return null;
        }

        $result = $mysqli->query("SELECT * FROM tbl_orders WHERE surveyID = " . $surveyID);

        if(!$result || $result->num_rows == 0){
            return null;
        }

        while($row = $result->fetch_array()){
            $orders[] = (new OrderBuilder())
                    ->orderID(intval($row['orderID']))
                    ->surveyID(intval($row['surveyID']))
                    ->orderArthropod(strval($row['orderArthropod']))
                    ->orderLength(intval($row['orderLength']))
                    ->orderNotes(strval($row['orderNotes']))
                    ->orderCount(intval($row['orderCount']))
                    ->insectPhoto(strval($row['insectPhoto']))
                    ->timeStamp(strval($row['timeStamp']))
                    ->isValid(intval($row['isValid']))
                    ->build();
        }
        return $orders;
    }

    //By Derek Gu
    //return null on db error or already invalid
    //return 1 on sucess
    public static function markInvalid($orderID){
        $mysqli = new mysqli(getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_HOST') . ':'
            . getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_PORT'),
             $_ENV['MYSQL_USER'],
             $_ENV['MYSQL_PASSWORD'],
             "caterpillars");
         if ($mysqli->connect_errno) {
            //echo $mysqli->connect_error;
            return null;
        }

        $result = $mysqli->query("UPDATE tbl_orders SET isValid = 0 WHERE orderID =" . $orderID);

        return $result && $mysqli->affected_rows != 0;
    }


    public function getOrderID() {
        return $this->orderID;
    }

    public function getSurveyID() {
        return $this->surveyID;
    }

    public function getOrderArthropod() {
        return $this->orderArthropod;
    }

    public function getOrderLength() {
        return $this->orderLength;
    }

    public function getOrderNotes() {
        return $this->orderNotes;
    }

    public function getOrderCount() {
        return $this->orderCount;
    }

    public function getInsectPhoto() {
        return $this->insectPhoto;
    }

    public function getTimeStamp() {
        return $this->timeStamp;
    }

    public function isValid() {
        return $this->isValid == 1;
    }

    public function getJSON() {
        $json_obj = array(
            'orderID' => $this->orderID,
            'surveyID' => $this->surveyID,
            'orderArthropod' => $this->orderArthropod,
            'orderLength' => $this->orderLength,
            'orderNotes' => $this->orderNotes,
            'orderCount' => $this->orderCount,
            'insectPhoto' => $this->insectPhoto,
            'timeStamp' => $this->timeStamp,
            'isValid' => $this->isValid
        );
        return $json_obj;
    }

    public function getJSONSimple() {
        $json_obj = array(
            'orderID' => $this->orderID,
            'surveyID' => $this->surveyID,
            'insectPhoto' => $this->insectPhoto
        );
        return $json_obj;
    }

}

class OrderBuilder {
    private $orderID;
    private $surveyID;
    private $orderArthropod;
    private $orderLength;
    private $orderNotes;
    private $orderCount;
    private $insectPhoto;
    private $timeStamp;
    private $isValid;

    private $hairyOrSpiny;
    private $leafRoll;
    private $silkTent;


    public function getOrderID()    {    return $this->orderID;     }

    public function getSurveyID()   {    return $this->surveyID;    }

    public function getOrderArthropod() { return $this->orderArthropod;}

    public function getOrderLength()    { return $this->orderLength;    }

    public function getOrderNotes() {    return $this->orderNotes;  }

    public function getOrderCount() {    return $this->orderCount;  }

    public function getInsectPhoto(){    return $this->insectPhoto; }

    public function getTimeStamp()  {    return $this->timeStamp;   }

    public function getIsValid()       {    return $this->isValid == 1;    }

    //Added functionaility for extra caterpillar fields
    public function getHairyOrSpiny() { return $this->hairyOrSpiny; }
    public function getLeafRoll() { return $this->leafRoll; }
    public function getSilkTent() { return $this ->silkTent; }



    public function orderID($orderID) {$this->orderID = $orderID; return $this;}
    public function surveyID($surveyID) {$this->surveyID = $surveyID; return $this;}
    public function orderArthropod($orderArthropod) {$this->orderArthropod = $orderArthropod; return $this;}
    public function orderLength($orderLength) {$this->orderLength = $orderLength; return $this;}
    public function orderNotes($orderNotes) {$this->orderNotes = $orderNotes; return $this;}
    public function orderCount($orderCount) {$this->orderCount = $orderCount; return $this;}
    public function insectPhoto($insectPhoto) {$this->insectPhoto = $insectPhoto; return $this;}
    public function timeStamp($timeStamp) {$this->timeStamp = $timeStamp; return $this;}
    public function isValid($isValid) {$this->isValid = $isValid; return $this;}

    public function hairyOrSpiny($hairyOrSpiny) { $this->hairyOrSpiny = $hairyOrSpiny; return $this; }
    public function leafRoll($leafRoll) {  $this->leafRoll = $leafRoll; return $this; }
    public function silkTent($silkTent) {  $this ->silkTent = $silkTent; return $this; }

    public function build() { return new Order($this); }

}

?>
