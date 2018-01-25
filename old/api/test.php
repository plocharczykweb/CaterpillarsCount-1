<?php

header("HTTP/1.1 200 OK");

print("The value of bullshit is ".$_GET["bullshit"])."\n";

foreach ($_ENV as $key => $value){
    print($key.": ".$value."\n");
}

?>