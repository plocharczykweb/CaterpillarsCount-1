<?php
  require_once("orm/User.php");
  
  $users = User::findAll();
  for($i = 0; $i < count($users); $i++){
    if($user->getEmail() != ""){
      $user->setINaturalistObserverID();
      echo $user->getINaturalistObserverID() . "<br/>";
    }
  }
?>
