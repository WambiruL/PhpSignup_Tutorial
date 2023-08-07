<?php

if($_SERVER["REQUEST_METHOD"]==="POST")/*Checks if the user got to the page correctly or illegally*/{
   $username=$_POST["username"];
   $pwd=$_POST["pwd"];
   $email=$_POST["email"];

   try {
       //order is important
       require_once 'databasehandler.php';
       require_once 'signup_model.php';
       require_once 'signup_controller.php';

       //ERROR HANDLERS->Ensures everything input is filled
       $errors=[];

       if (is_input_empty($username, $pwd, $email)){
          $errors["empty_input"]="Fill in all fields!";
       } 
       if(is_email_invalid($email)){
        $errors["invalid_email"]="Invalid email used!";

       }
       if(is_username_taken($pdo, $username)){
        $errors["username_taken"]="Username already taken!";

       }
       if(is_email_registered($pdo,$email)){
        $errors["email_used"]="Email already registered!";
       }

       //start session
       require_once 'config_session.php';
       if($errors) //will return as true if there are errors
       {
        $_SESSION["errors_signup"]=$errors;
        
        //if user inputs something wrong, his data will still be saved so that he doesnt have to type everything everything again, except the password
        $signupData=[
            "username"=>$username,
            "email"=>$email
        ];
        $_SESSION["signup_data"]=$signupData;

        header("Location:../index.php");
        die();
       }

       create_user($pdo, $username, $pwd, $email);
       header("Location:../index.php?signup=success");
       $pdo=null;
       $stmt=null;
       die();

    } catch(PDOException $e){
      die("Query failed: " . $e->getMessage());
    }

}else{
    header("Location:../index.php"); //redirect user if page was accessed illegaly
    die();
}