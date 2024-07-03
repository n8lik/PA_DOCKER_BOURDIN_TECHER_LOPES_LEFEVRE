<?php
//On inclut les fichiers nécessaires
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../entities/tasks/deleteTask.php";
require_once __DIR__ . "/../../entities/isAuthentified.php";
require_once __DIR__ . "/../../libraries/body.php";

//Si le jeton n'est pas dans les entete on renvoie une erreur ou qu'il ne correspond pas à un utilisateur on renvoie une erreur
if (isAuthentified("USER")) {
    die(jsonResponse(401, [], [
        "success" => false,
        "error" => "Provide an Authorization: Bearer token"
    ]));
}

//On récupère l'id de la taches situé dans l'url
$task = getBody();
$exists = deleteTask($task["task"]);
//Si la description n'est pas présente on renvoie une erreur
if (!$exists) {
    die(jsonResponse(404, [], [
        "success" => false,
        "error" => "Task not found"
    ]));
}

//On renvoie une réponse de succès
echo jsonResponse(200, [], [
    "success" => true,
    "message" => "Deleted"
]);