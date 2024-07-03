<?php
//On inclut les fichiers nécessaires
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/tasks/createTask.php";
require_once __DIR__ . "/../../entities/isAuthentified.php";

try{
    //Si le jeton n'est pas dans les entete on renvoie une erreur ou qu'il ne correspond pas à un utilisateur on renvoie une erreur
    if (isAuthentified("USER")) {
        die(jsonResponse(401, [], [
            "success" => false,
            "error" => "Provide an Authorization: Bearer token"
        ]));
    }

    //On récupère les données de la requête
    $task = getBody();

    //Si la description n'est pas présente on renvoie une erreur
    if (!isset($task["description"])) {
        die(jsonResponse(400, [], [
            "success" => false,
            "error" => "Description not found"
        ]));
    } 


    //Si la description n'es pas une chaine de caractère on renvoie une erreur
    if (!is_string($task["description"])) {
        die(jsonResponse(400, [], [
            "success" => false,
            "error" => "Description is not a string"
        ])); 
    }
    
    //Si la requete est valide on crée la tâche
    $task = createTask($task["description"]);

    //On renvoie le résultat
    echo jsonResponse(200,[], [
        "success" => true,
        "message" => "Created"
    ]);

} catch (Exception $exception) {
    echo jsonResponse(500, [], [
        "success" => false,
        "error" => $exception->getMessage()
    ]);
}