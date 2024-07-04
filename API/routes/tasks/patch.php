<?php
//On inclut les fichiers nécessaires
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../entities/tasks/patchTask.php";
require_once __DIR__ . "/../../entities/isAuthentified.php";
require_once __DIR__ . "/../../libraries/body.php";


//Si le jeton n'est pas dans les entete on renvoie une erreur ou qu'il ne correspond pas à un utilisateur on renvoie une erreur
if (isAuthentified("USER")) {
    die(jsonResponse(401, [], [
        "success" => false,
        "error" => "Provide an Authorization: Bearer token"
    ]));
}

//On récupère les données de la requête
$task = getBody();
//Si  la description n'est pas présente on renvoie une erreur
if (!isset($task["description"])) {
    die(jsonResponse(400, [], [
        "success" => false,
        "error" => "Description is a mandatory"
    ]));
}

//si la description est vide on renvoie une erreur
if (empty($task["description"])) {
    die(jsonResponse(400, [], [
        "success" => false,
        "error" => "Description can't be empty"
    ]));
}


$exists = patchTask($task["task"], $task["description"]);

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
    "message" => "Updated"
]);