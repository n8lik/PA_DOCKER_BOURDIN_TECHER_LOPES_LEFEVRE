<?php

//Si on recoit une requete GET
if (isGetMethod()) {
    //On inclut le fichier de connexion à la base de données
    require_once __DIR__ . "/../../database/connection.php";
    //On inclut le fichier de fonctions
    require_once __DIR__ . "/../../entities/users/getAllUsers.php";
    //On inclut le fichier de réponse
    require_once __DIR__ . "/../../libraries/response.php";
    //On récupère tous les utilisateurs
    $users = getAllUsers();
    //On renvoie un code 200 et la liste des utilisateurs
    echo jsonResponse(200, [], $users);
    die();
}