<?php

//By: Pintian Zhang

require_once('User.php');

header("Access-Control-Allow-Origin: *");


if ($_SERVER['REQUEST_METHOD'] == 'POST'){


  //Create: $email, $password, $name
  //Login: $email, $password
  //Find User Obj by Email: $email
  //Find User Obj by userID: $id
  //Mark User as Invalid: $id, $mark_invalid = 1
  //Request password recovery email: $email, $recover = 1

  $post = json_decode(file_get_contents("php://input"), true);

  $id = $post['userID'];
  $email = $post['email'];
  $password = $post['password'];
  $name = $post['name'];
  $mark_invalid = $post['mark_invalid'];
  $recover = $post['recover'];
  $recoveryToken = $post['recoveryToken'];


  //Create user
  if(!is_null($email) && !is_null($password) && !is_null($name)){

    $user = User::create($email, $password, $name);

    if($user == -1){

      header("HTTP/1.1 409 Conflict");
      print("Email address is already registered");
      exit();

    }

    if (is_null($user)){

      header("HTTP/1.1 500 Internal Server Error");
      print("User creation failed");
      exit();
    }

  header("Content-type: application/json");
  print($user->getJSON());
  exit();

  }

  //Login
  if(!is_null($email) && !is_null($password) && is_null($name)){

    $validate = User::validatePassword($email, $password);

    if (is_null($validate)){

      header("HTTP/1.1 404 Not Found");
      print("Resource requested not found");
      exit();
    }

    if($validate == -1){

      header("Content-type: application/json");
      $json_rep = array();
      $json_rep['valid'] = false;
      print(json_encode($json_rep));
      exit();

    }

    header("Content-type: application/json");
    print(json_encode($validate));
    exit();



  }

  //Get UserObj by email
  if(!is_null($email) && is_null($password) && is_null($name) && is_null($recover)){


    $user = User::find($email);


    if (is_null($user)){

      header("HTTP/1.1 404 Not Found");
      print("Resource requested not found");
      exit();
    }


    header("Content-type: application/json");
    print($user->getJSON());
    exit();



  }

  //Get User Obj by looking up userID
  if(!is_null($id) && is_null($mark_invalid) && is_null($recover) && is_null($recoveryToken)){
      $user = User::findByID($id);


    if (is_null($user)){

      header("HTTP/1.1 404 Not Found");
      print("Resource requested not found");
      exit();
    }


    header("Content-type: application/json");
    print($user->getJSON());
    exit();
  }

  //mark user as invalid
  if($mark_invalid == 1 && !is_null($id)){
      $result = User::markInvalid($id);

      if(!$result){
            header("HTTP/1.1 404 Not Found");
            print("Resource requested not found");
            exit();
        }

        header("HTTP/1.1 200 OK");
        print("Successfully marked user invalid.");
        exit();
  }

  //Recover password by email address

  if(!is_null($recover) && !is_null($email)){

    $result = User::requestPasswordRecovery($email);

    if(is_null($result)){
            header("HTTP/1.1 404 Not Found");
            print("Resource requested not found");
            exit();

      }

      if($result == -1){

            header("HTTP/1.1 409 Conflict");
            print("A recovery email has recently been sent to " . strval($email));
            exit();


      }

      header("HTTP/1.1 200 OK");
      print("Successfully sent recovery email to " . strval($email));
      exit();


  }

  //Change password

  if(!is_null($recoveryToken) && !is_null($id) && !is_null($password)){

    $result = User::changePassword($id, $recoveryToken, $password);

      if(is_null($result)){
            header("HTTP/1.1 404 Not Found");
            print("Resource requested not found");
            exit();

      }

      if($result == -1){
        header("HTTP/1.1 403 Forbidden");
        print("Recovery URL is expired or fraudulent");
        exit();

      }

      header("HTTP/1.1 200 OK");
      print("Successfully changed password");
      exit();


  }



  header("HTTP/1.1 400 Bad Request");
  print("Format not recognized");
  exit();

}

//acivate user: $id, $activate
if ($_SERVER['REQUEST_METHOD'] == 'GET'){

  //Activate: $id, $activate
  //Recover: $id, $recoveryToken

  //$get = json_decode(file_get_contents("php://input"), true);
  $id = intval($_GET['userID']);
  $activate = intval($_GET['activate']);
  $recoveryToken = strval($_GET['recoveryToken']);



  //Activate: $id, $activate
  if (!is_null($id) && !is_null($activate)){
    $result = User::activate($id);

    //header("Content-type: application/json");
    //print(json_encode($result));
    header('Content-Type:text/html');
		print("<h1>Welcome to Caterpillars Count!</h1>
				<p>Your account has been <b>successfully activated</b>.<p>");
    exit();
  }





  header("HTTP/1.1 400 Bad Request");
  print("Format not recognized");
  exit();

}


?>
