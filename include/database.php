<?php

// Connexion à la base de données
try{
    $pdo = new PDO('mysql:host=localhost;dbname=boutique_konexio','root','root',
                    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, 
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
}catch(PDOException $e){
    echo 'Erreur : ' . $e->getMessage() . '<br>';
    echo 'N° : ' . $e->getCode() . '<br>';
    die('Connexion au serveur impossible.');
}