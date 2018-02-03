<?php
  require_once("orm/Site.php");
  
  $publicSites = Site::findAllPublicSites();
  die(json_encode($publicSites));
?>
