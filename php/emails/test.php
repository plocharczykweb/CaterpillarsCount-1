<?php
  header('Access-Control-Allow-Origin: *');
  
  require_once("../orm/Site.php");
  require_once("../orm/resources/mailing.php");
  
  email4("plocharczykweb@gmail.com", "The Caterpillars Count! Season Has Begun!", "Aaron");
  email5("plocharczykweb@gmail.com", "Need Help Submitting Caterpillars Count! Surveys?", "Aaron");
  email6("plocharczykweb@gmail.com", "Touching Base about Example Site", "Example Site");
  email7("plocharczykweb@gmail.com", "This Week at Example Site...", "17", "85", "Example Site", "248", "19", "2");
  email8("plocharczykweb@gmail.com", "Check Your Caterpillars Count! Data from This Week 1!", array(Site::findByID("2")), 57, 3, "plocharczykweb");
?>
