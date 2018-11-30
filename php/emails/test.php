<?php
  header('Access-Control-Allow-Origin: *');
  
  require_once("../orm/Site.php");
  require_once("../orm/resources/mailing.php");
  
  email3("aaronplo@live.unc.edu", "Preparing for a new Caterpillars Count! Season", "Example Site", "10", "2", "2", "21", "15", "427", "14", "1932", "187", "9.27");
  email3("plocharczykweb@gmail.com", "Preparing for a new Caterpillars Count! Season", "Example Site", "10", "2", "2", "21", "15", "427", "14", "1932", "187", "9.27");
  email4("aaronplo@live.unc.edu", "The Caterpillars Count! Season Has Begun!", "Allen");
  email4("plocharczykweb@gmail.com", "The Caterpillars Count! Season Has Begun!", "Allen");
  email5("aaronplo@live.unc.edu", "Need Help Submitting Caterpillars Count! Surveys?", "Allen");
  email5("plocharczykweb@gmail.com", "Need Help Submitting Caterpillars Count! Surveys?", "Allen");
  email6("aaronplo@live.unc.edu", "Caterpillars Count! at Example Site", "Example Site");
  email6("plocharczykweb@gmail.com", "Caterpillars Count! at Example Site", "Example Site");
  email7("aaronplo@live.unc.edu", "This Week at Example Site...", "17", "85", "Example Site", "248", "19", "beetle", "22", "ant", "19", "7/12", "19.11", "2");
  email7("plocharczykweb@gmail.com", "This Week at Example Site...", "17", "85", "Example Site", "248", "19", "beetle", "22", "ant", "19", "7/12", "19.11", "2");
  email8("aaronplo@live.unc.edu", "Your Caterpillars Count! weekly summary", array(Site::findByID("2")), 57, 3, "hurlbert", true);
  email8("plocharczykweb@gmail.com", "Your Caterpillars Count! weekly summary", array(Site::findByID("2")), 57, 3, "hurlbert", true);
?>
