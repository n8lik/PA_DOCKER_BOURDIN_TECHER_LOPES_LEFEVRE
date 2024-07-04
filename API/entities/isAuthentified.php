<?php

function isAuthentified(string $role): bool
{
    //On récupère les entêtes de la requête pour récupérer le jeton
    $token = $_SESSION["token"];


    if (!$token) {
        return false;
    }


    //On récupère la connexion à la base de données
    require_once __DIR__ . "/../database/connection.php";
    $pdo = connectDB();
    //On prépare la requête
    $getUserQuery = $pdo = $pdo->prepare("SELECT grade FROM users WHERE token = :token");
    //On exécute la requête
    $result = $getUserQuery->execute([
        "token" => $bearerToken
    ]);
    if (!$result) {
        return false;
    }
    //On récupère le résultat
    $user = $getUserQuery->fetch(PDO::FETCH_ASSOC);
    //Si l'utilisateur n'existe pas on renvoie une erreur
    if (!$user) {
        return false;
    }
    //Si l'utilisateur n'a pas le bon rôle on renvoie une erreur; c'est le cas si le rôle de l'utilisateur n'est pas égal au rôle passé en paramètre
    if ($user["grade"] !== $role) {
        return false;
    }
    return true;
}
