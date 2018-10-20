<?php
  require_once("orm/user.php");
  
  $users = User::findAll();
  for($i = 0; $i < count($users); $i++){
    if($user->getEmail() != ""){
      user->setINaturalistObserverID();
    }
  }
?>
