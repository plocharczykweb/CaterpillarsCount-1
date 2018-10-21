<?php
  require_once("orm/User.php");
  
  $user = User::findByID(1203);
  $user->setINaturalistObserverID();
?>
