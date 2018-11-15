<?php
  header('Access-Control-Allow-Origin: *');
  
  require_once("../orm/Site.php");
  require_once("../orm/resources/mailing.php");
  
  email4("hurlbert@bio.unc.edu", "The Caterpillars Count! Season Has Begun!", "Allen");
  email5("hurlbert@bio.unc.edu", "Need Help Submitting Caterpillars Count! Surveys?", "Allen");
  email6("hurlbert@bio.unc.edu", "Touching Base about Example Site", "Example Site");
  email7("hurlbert@bio.unc.edu", "This Week at Example Site...", "17", "85", "Example Site", "248", "19", "2");
  email8("hurlbert@bio.unc.edu", "Check Your Caterpillars Count! Data from This Week!", array(Site::findByID("2")), 57, 3, "hurlbert", true);
?>
