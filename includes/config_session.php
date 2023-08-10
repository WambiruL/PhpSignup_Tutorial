<?php
//Must haves anytime you have sessions
ini_set('session.user_only_cookies', 1); 
ini_set('session.user_strict_mode',1);

session_set_cookie_params([
    'lifetime'=>1800, //how long the cookie will last
    'domain'=>'localhost', //which domain will it be on
    'path'=>'/',
    'secure'=>true, //only use cookie in a secure connection https
    'httponly'=>true //avoid the user to change anything about the cookie by inserting a script
]);

//Generating new session id every 30mins
session_start(); //start session
if(isset($_SESSION["user_id"])) /*check if there is a user logged in. Will create an id if user is logged in*/{
    if(!isset($_SESSION["last_regeneration"])) /*checks if session does not exist*/{
        regenerate_session_id_logged_in(); 
    
    }else{
        $interval=60*30; //how long it will pass until we have to generate a new session id
        if(time()- $_SESSION["last_regeneration"]>=$interval){
            regenerate_session_id_logged_in();
    
    
        }
    }
}else{
   /*If the user is not logged in*/ if(!isset($_SESSION["last_regeneration"])) /*checks if session does not exist*/{
        regenerate_session_id(); 
    
    }else{
        $interval=60*30; //how long it will pass until we have to generate a new session id
        if(time()- $_SESSION["last_regeneration"]>=$interval){
            regenerate_session_id();
    
    
        }
    }
}

function regenerate_session_id_loggedin(){
    session_regenerate_id(true); 
     
    $userId=$_SESSION["user_id"];
    $newSessionId= session_create_id();
    $sessionId=$newSessionId. "_". $userId;
    session_id($sessionId);

    $_SESSION["last_regeneration"]=time(); //set last regeneration equal to current time
}

function regenerate_session_id(){
    session_regenerate_id(true); 
    $_SESSION["last_regeneration"]=time(); //set last regeneration equal to current time
}