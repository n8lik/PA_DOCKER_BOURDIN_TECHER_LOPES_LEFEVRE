<?php

//On inclut les fichiers nécessaires    

require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/users/updateUser.php";
require_once __DIR__ . "/../../entities/files.php";

$body = getBody();

$userId = $body["userId"];
$newPassword = $body["newPassword"];

if (strlen($newPassword) < 8 || strlen($newPassword) > 20 && !preg_match('/[A-Z]/', $newPassword) && !preg_match('/[a-z]/', $newPassword) && !preg_match('/[0-9]/', $newPassword)) {
    echo jsonResponse(
        200,
        [],
        [
            "success" => false,
            "message" => "Le mot de passe doit contenir entre 8 et 20 caractères, une majuscule, une minuscule et un chiffre"
        ]
    );
    die();
}
$update = updatePassword($userId, $newPassword);
if ($update) {
    echo jsonResponse(
        200,
        [],
        [
            "success" => true,
            "message" => "Mot de passe modifié"
        ]
    );
    die();
} else {
    echo jsonResponse(
        200,
        [],
        [
            "success" => false,
            "message" => "Erreur lors de la modification du mot de passe"
        ]
    );
    die();
}
