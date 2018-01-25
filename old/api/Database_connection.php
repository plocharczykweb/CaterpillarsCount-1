<?php
    //By Pintian Zhang
class Database_connection{

	private function __construct(){
	}
    public static function getMysqli(){
        return mysqli_connect(getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_HOST') . ':' . getenv(strtoupper(getenv('DATABASE_SERVICE_NAME')).'_SERVICE_PORT'), $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASSWORD'], "caterpillars");
    }
}
