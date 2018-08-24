<?php
  require_once('orm/Site.php');
require_once('orm/Plant.php');
$site = Site::findByID("112");
  $a = Plant::create($site, 1, "A");
				$b = Plant::create($site, 1, "B");
				$c = Plant::create($site, 1, "C");
				$d = Plant::create($site, 1, "D");
				$e = Plant::create($site, 1, "E");
?>
