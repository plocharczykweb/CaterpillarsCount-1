<?php
  header('Access-Control-Allow-Origin: *');
  
  require_once("../orm/Site.php");
  require_once("../orm/resources/mailing.php");
  
  //email4("aaronplo@live.unc.edu", "The Caterpillars Count! Season Has Begun!", "Allen");
  //email5("aaronplo@live.unc.edu", "Need Help Submitting Caterpillars Count! Surveys?", "Allen");
  email6("aaronplo@live.unc.edu", "Touching Base about Example Site", "Example Site");
  email6("plocharczykweb@gmail.com", "Touching Base about Example Site", "Example Site");
  email7("aaronplo@live.unc.edu", "This Week at Example Site...", "17", "85", "Example Site", "248", "19", "beetle", "22", "", "0", "2")
  email7("plocharczykweb@gmail.com", "This Week at Example Site...", "17", "85", "Example Site", "248", "19", "beetle", "22", "", "0", "2")
  //email7("aaronplo@live.unc.edu", "This Week at Example Site...", "17", "85", "Example Site", "248", "19", "2");
  //email8("aaronplo@live.unc.edu", "Check Your Caterpillars Count! Data from This Week!", array(Site::findByID("2")), 57, 3, "hurlbert", true);
?>
