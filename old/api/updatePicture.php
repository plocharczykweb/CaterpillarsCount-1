<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	    $post = json_decode(file_get_contents("php://input"), true);
		$picturePath = $post['photoLocation'];
		move_uploaded_file( $_FILES['photo']['tmp_name'], $picturePath );
        header("HTTP/1.1 200 OK");
        exit();
}
    header("HTTP/1.1 400 Bad Request");
    print("Format not recognized");
    exit();
?> 