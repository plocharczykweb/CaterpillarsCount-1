<?php
  require_once("orm/User.php");
  
  $users = User::findAll();
  for($i = 0; $i < count($users); $i++){
    if($users[$i]->getEmail() != ""){
      $users[$i]->setINaturalistObserverID();
      echo $users[$i]->getINaturalistObserverID() . "<br/>";
    }
  }
?>
