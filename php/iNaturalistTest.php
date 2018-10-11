<?php
  $ch = curl_init('https://www.inaturalist.org/oauth/token');
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, "client_id=" . getenv("iNaturalistAppID") . "&client_secret=" . getenv("iNaturalistAppSecret") . "&grant_type=password&username=caterpillarscountdev&password=" . getenv("iNaturalistPassword"));
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

  $token = curl_exec($ch)["access_token"];
  die($token);
?>
