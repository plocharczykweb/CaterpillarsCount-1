<?php
  header('Access-Control-Allow-Origin: *');
  
  require_once("../orm/Site.php");
  require_once("../orm/resources/mailing.php");
  
  /*
  email3("hurlbert@bio.unc.edu", "Preparing for a new Caterpillars Count! Season", "Example Site", "10", "2", "2", "21", "15", "427", "14", "1932", "187", "9.27");
  email3("sarah.yelton@unc.edu", "Preparing for a new Caterpillars Count! Season", "Example Site", "10", "2", "2", "21", "15", "427", "14", "1932", "187", "9.27");
  email4("hurlbert@bio.unc.edu", "The Caterpillars Count! Season Has Begun!", "Allen");
  email4("sarah.yelton@unc.edu", "The Caterpillars Count! Season Has Begun!", "Allen");
  email5("hurlbert@bio.unc.edu", "Need Help Submitting Caterpillars Count! Surveys?", "Allen");
  email5("sarah.yelton@unc.edu", "Need Help Submitting Caterpillars Count! Surveys?", "Allen");
  email6("hurlbert@bio.unc.edu", "Caterpillars Count! at Example Site", "Example Site");
  email6("sarah.yelton@unc.edu", "Caterpillars Count! at Example Site", "Example Site");
  email7("hurlbert@bio.unc.edu", "This Week at Example Site...", "17", "85", "Example Site", "248", "19", "beetle", "22", "ant", "19", "7/12", "19.11", "2");
  email7("sarah.yelton@unc.edu", "This Week at Example Site...", "17", "85", "Example Site", "248", "19", "beetle", "22", "ant", "19", "7/12", "19.11", "2");
  email8("hurlbert@bio.unc.edu", "Your Caterpillars Count! weekly summary", array(Site::findByID("2")), 57, 3, "hurlbert", true);
  email8("sarah.yelton@unc.edu", "Your Caterpillars Count! weekly summary", array(Site::findByID("2")), 57, 3, "hurlbert", true);
  */
  
  email3("paul.plocharczyk@ihop.com", "Preparing for a new Caterpillars Count! Season", "Example Site", "10", "2", "2", "21", "15", "427", "14", "1932", "187", "9.27");
  email4("paul.plocharczyk@ihop.com", "The Caterpillars Count! Season Has Begun!", "Allen");
  email5("paul.plocharczyk@ihop.com", "Need Help Submitting Caterpillars Count! Surveys?", "Allen");
  email6("paul.plocharczyk@ihop.com", "Caterpillars Count! at Example Site", "Example Site");
  email7("paul.plocharczyk@ihop.com", "This Week at Example Site...", "17", "85", "Example Site", "248", "19", "beetle", "22", "ant", "19", "7/12", "19.11", "2");
  email8("paul.plocharczyk@ihop.com", "Your Caterpillars Count! weekly summary", array(Site::findByID("2")), 57, 3, "hurlbert", true);
  
?>
