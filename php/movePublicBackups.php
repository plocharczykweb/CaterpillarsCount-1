<?php
  $files = scandir("../" . getenv("USER_BACKUPS"));
  for($i = 0; $i < count($files); $i++){
    if(strpos($files[$i], "User") === false){
      rename("../" . getenv("USER_BACKUPS") . "/" . $files[$i], "../backups/" . $files[$i]);
    }
  }
?>
