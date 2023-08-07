<?php

$host='localhost';
$dbname='myfirstdatabase';
$dbusername='root';
$dbpassword='';

try{
$pdo=new PDO("mysql:host=$host;dbname=$dbname", $dbusername,$dbpassword); 
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//Try some code and if there is an error it throws an error message
}catch(PDOException $e){
    die("Connection failed: " . $e->getMessage());

}