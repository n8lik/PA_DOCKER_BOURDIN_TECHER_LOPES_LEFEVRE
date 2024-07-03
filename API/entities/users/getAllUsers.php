<?php

require_once __DIR__ . "/../../database/connection.php";

//Fonction Get ALL Users, retourner la réponse
function getAllUsers(): array
{
    //On récupère la connexion à la base de données
    $databaseConnection = connectDB();
    //On prépare la requête
    $req=$databaseConnection->prepare("SELECT * FROM user");
    //On execute la requête
    $req->execute();
    //On retourne les résultats
    return $req->fetchAll();
}