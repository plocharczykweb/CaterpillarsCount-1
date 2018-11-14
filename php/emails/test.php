<?php
  header('Access-Control-Allow-Origin: *');
  
  require_once("../orm/resources/mailing.php");
  
  cookieCutterEmail("plocharczykweb@gmail.com", "Need Help Submitting Caterpillars Count! Surveys?", 5);
?>
