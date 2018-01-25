<?php

//Created by Erqian Li, Nov 27 2016.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  

  $post = json_decode(file_get_contents("php://input"), true);
  $action = $post['action'];

    if (!is_null($action) && $action == "getiNaturalistLogin" ){
        //actual app_id=f288a4e448fb2157ca940efcd471b5148fbb26f5de7dea47593fd863f978ddcb
        //actual app_secret=7ff165db65f1477b5b91a7d0b625a725f44a9eee929224c19f792fcfc37a4351
        //we need to do this try to hide the true login with maybe fake hashes
        //true appid is in 7
        //true appsecret in 11
        $result=array();
        $result['1']='2f9b97da2b4aa0cf4029b4200e6c6f99bc33300f0f0963de48ea7599b16986b7';
        $result['2']='eb0b24e5eec8c94329607dfb54e90361a0e6b6a73f49de95089a0d1fd1fa2f18';
        $result['3']='11c96e9bfa1f962b1d909dac028963bfc0e4adcc061c9dda18f0e48390c1c052';
        $result['4']='63c78d36256941dac74bb9092d8c76f2bbfc6859ef5c2135c9080ed182de6ccc';
        $result['5']='d2aab7bcabd52f5d3ec0fb699fa607942f7a304f1f08450cfb11ec12505780d2';
        $result['6']='f0f097a70fd1ef9df3303c66d5f7ee8f5b64b1fba6a92c346cb4f88a36b76028';
        $result['7']='f288a4e448fb2157ca940efcd471b5148fbb26f5de7dea47593fd863f978ddcb';
        $result['8']='723b3b0c62fe0b2b6881c0c4a1ae4583bb68774c9de29a4b9e2cb672cc9648f9';
        $result['9']='dq2farq3rfr2qf3esftdfr2989pfae9p8frh3rfra23r3a3d2q3edfaefrfwaq2d';
        $result['10']='wdae2rea23dfefar234r2534564r4earaw243er5w4ar42q546qr6a424re2qwea';
        $result['11']='7ff165db65f1477b5b91a7d0b625a725f44a9eee929224c19f792fcfc37a4351';
        $result['12']='ared2re4q2r56q3r2fr364a5d46a5r4a6237r4f63ar746q47236473683r7e45w';
        $result['13']='dqer2542qe852qer543r5425q3r652q6req28qrew564daw5d34re56w4e55r4ee';
        $result['14']='3er5665d6asd568e5d6r63w5e4d65r3e65d4ew6dse5d569s8r65wed6sre5d8ed';
        $result['15']='ewr7rs6drf4d565rfrw+r683f+8s+df68+6es5d+6fd6s3e8r39+e8+6+d56f9sd';
        header("Content-type: application/json");    
        print(json_encode($result));
        exit();
    }



    header("HTTP/1.1 400 Bad Request");
    print("Format not recognized");
    exit();
}
?>