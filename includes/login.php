<?php

if($_SERVER["REQUEST_METHOD"]==="POST"){
    $username=$_POST["username"];
    $pwd=$_POST["pwd"];

    try {
        require_once 'databasehandler.php';
        require_once 'login_model.php';
        require_once 'login_controller.php';
        
        //ERROR HANDLERS->Ensures everything input is filled
       $errors=[];

       if (is_input_empty($username, $pwd)){
          $errors["empty_input"]="Fill in all fields!";
       }

       $result= get_user($pdo, $username);
       
       if(is_username_wrong($result)){
           $errors["login_incorrect"]="Incorrect login info!";
       }

       if(!is_username_wrong($result) && is_password_wrong($pwd,$result["pwd"])){
          $errors["login_incorrect"]="Incorrect login info!";
       }
       
       

       //start session
       require_once 'config_session.php';
       if($errors) //will return as true if there are errors
       {
        $_SESSION["errors_login"]=$errors;

        header("Location:../index.php");
        die();
       }

       //create a new session id
       $newSessionId= session_create_id();
       $sessionId=$newSessionId. "_". $result["id"];
       session_id($sessionId);

       $_SESSION["user_id"]=$result["id"];
       $_SESSION["user_username"]=htmlspecialchars($result["username"]);
       
       $_SESSION["last_regeneration"]=time(); //set last regeneration equal to current time
       
       header("Location:../index.php?login=success");
       $pdo=null;
       $stmt=null;
       die();

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
       
    }

} else{
    header("Location:../index.php");
    die();
}