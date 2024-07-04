<?php
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/files.php";
require_once __DIR__ . "/../../libraries/parameters.php";
require_once __DIR__ . "/../../entities/users/getUserById.php";

$body = getBody();
$token = $body["token"];

$grade = $body["grade"];

$id = getUserByToken($token);
$userId = $id["id"];


if ($grade == 4){
    $grade = "landlord";
}
else{
    $grade = "provider";
}

if (!$id) {
    echo (jsonResponse(200, [], [
        "success" => false,
        "error" => "User not found"
    ]));
    exit;
}

$files = getAllFilesByUserId($userId, $grade);
if (!$files) {
    echo (jsonResponse(200, [], [
        "success" => false,
        "message" => "Pas de fichier trouvé"
    ]));
    exit;
}
echo (jsonResponse(200, [], [
    "success" => true,
    "files" => $files,
    "message" => "Trouvay"
]));