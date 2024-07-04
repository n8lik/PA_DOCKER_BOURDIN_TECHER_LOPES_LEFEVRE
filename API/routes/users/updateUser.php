<?php

//On inclut les fichiers nécessaires    

require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/users/updateUser.php";
require_once __DIR__ . "/../../entities/files.php";
require_once __DIR__ . "/../../libraries/parameters.php";
file_put_contents('/var/log/apilog/logpost.log', print_r($_POST, true), FILE_APPEND);
file_put_contents('/var/log/apilog/logfile.log', print_r($_FILES, true), FILE_APPEND);

$pseudo = $_POST["pseudo"];
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$phone = $_POST["phone"];
$extension = $_POST["extension"];
$userId = $_POST["userId"];


if (strlen($pseudo) < 3 || strlen($pseudo) > 20) {
    echo jsonResponse(
        200,
        [],
        [
            "success" => false,
            "message" => "Le pseudo doit contenir entre 3 et 20 caractères"
        ]
    );
    die();
}

if (strlen($firstname) < 3 || strlen($firstname) > 20) {
    echo jsonResponse(
        200,
        [],
        [
            "success" => false,
            "message" => "Le prénom doit contenir entre 3 et 20 caractères"
        ]
    );
    die();
}

if (strlen($lastname) < 3 || strlen($lastname) > 20) {
    echo jsonResponse(
        200,
        [],
        [
            "success" => false,
            "message" => "Le nom doit contenir entre 3 et 20 caractères"
        ]
    );
    die();
}

if (strlen($phone) < 10 || strlen($phone) > 10 && !is_numeric($phone)) {
    echo jsonResponse(
        200,
        [],
        [
            "success" => false,
            "message" => "Le numéro de téléphone doit contenir 10 chiffres"
        ]
    );
    die();
}

if (strlen($extension) != 3 && !is_numeric($extension)) {
    echo jsonResponse(
        200,
        [],
        [
            "success" => false,
            "message" => "L'extension doit contenir 3 chiffres"
        ]
    );
    die();
}


$insert = updateUser($pseudo, $firstname, $lastname, $phone, $extension, $userId);




if (!$insert) {
    echo jsonResponse(
        400,
        [],
        [
            "success" => false,
            "message" => "Erreur lors de la mise à jour de l'utilisateur"
        ]
    );
    die();
}

if (!isset($_FILES["file"])) {
    echo jsonResponse(
        200,
        [],
        [
            "success" => true,
            "message" => "Utilisateur mis à jour"
        ]
    );
    die();
}
//2mo

if ($_FILES["file"]["size"] > 2000000) {
    echo jsonResponse(
        200,
        [],
        [
            "success" => false,
            "message" => "Fichier trop volumineux"
        ]
    );
    die();
}

$file = $_FILES["file"];
$usertype = "pp";

$test = uploadFile($usertype, $userId, NULL, $file, NULL);


echo jsonResponse(200, [], [
    "success" => true,
    "message" => "Utilisateur mis à jour"
]);
 
