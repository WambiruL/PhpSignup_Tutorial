<?php
//querying the database. Will only interact with the database.

declare(strict_types=1); //allows our code to have type declarations

function get_username(object $pdo, string $username){
    $query="SELECT username FROM users WHERE username=:username;";
    $stmt=$pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $result=$stmt->fetch(PDO::FETCH_ASSOC /*Can access data in the database using the name of the column*/);
    return $result;

}

function get_email(object $pdo, string $email){
    $query="SELECT email FROM users WHERE email=:email;";
    $stmt=$pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    $result=$stmt->fetch(PDO::FETCH_ASSOC /*Can access data in the database using the name of the column*/);
    return $result;

}

function set_user(object $pdo, string $username, string $pwd, string $email){
    $query="INSERT INTO users(username,pwd,email) VALUES
    (:username, :pwd, :email)";
    $stmt=$pdo->prepare($query);

    $options=[
        'cost'=>12
    ];
    $hashedPwd=password_hash($pwd, PASSWORD_BCRYPT,$options);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":pwd", $hashedPwd);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    $result=$stmt->fetch(PDO::FETCH_ASSOC /*Can access data in the database using the name of the column*/);
    return $result;

}
