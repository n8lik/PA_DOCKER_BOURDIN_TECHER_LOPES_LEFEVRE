<?php
//On inclut les fichiers nécessaires
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../entities/tasks/getTasks.php";
require_once __DIR__ . "/../../entities/isAuthentified.php";

try {
    //Si le jeton n'est pas dans les entete on renvoie une erreur ou qu'il ne correspond pas à un utilisateur on renvoie une erreur
    if (isAuthentified("USER")) {
        die(jsonResponse(401, [], [
            "success" => false,
            "error" => "Provide an Authorization: Bearer token"
        ]));
    }
    //On récupère les tâches
    $tasks = getTasks();

    //Si on a pas de tâches on renvoie une erreur
    if (!$tasks) {
        die(jsonResponse(404, [], [
            "success" => false,
            "error" => "No tasks found"
        ]));
    }

    //On renvoie les tâches s'il y en a
    echo jsonResponse(200, $tasks, [
        "success" => true,
        "message" => "Tasks found"
    ]);
    
} catch (Exception $exception) {
    echo jsonResponse(500, [], [
        "success" => false,
        "error" => $exception->getMessage()
    ]);
}
