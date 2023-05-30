<?php

// Connexion à la base de données
$db_host = "eu-cdbr-west-03.cleardb.net";
$db_user = "bd8300fbdc9d13";
$db_pass = "212166c7";
$db_name = "heroku_5f3275f3bc4a15a";
/* try{
    $pdo = new PDO('mysql:host=localhost;dbname=boutique_konexio','root','root',
                    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, 
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
}catch(PDOException $e){
    echo 'Erreur : ' . $e->getMessage() . '<br>';
    echo 'N° : ' . $e->getCode() . '<br>';
    die('Connexion au serveur impossible.');
}
*/
$connect = mysqli_connect($db_host, $db_user, $db_pass, $db_name) or die("Database Connection Error");
