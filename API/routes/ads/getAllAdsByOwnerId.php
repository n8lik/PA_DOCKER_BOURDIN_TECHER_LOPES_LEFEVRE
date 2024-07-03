<?php


require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/ads/adsInfo.php";
require_once __DIR__ . "/../../entities/users/getUserById.php";
require_once __DIR__ . "/../../libraries/parameters.php";

$parameters = getParametersForRoute("/getAllAdsByOwnerId/:id");
$id = $parameters["id"];

//Vérifier que l'id est bien un nombre et qu'il n'est pas vide
if (!is_numeric($id) || empty($id)) {
    echo(jsonResponse(400, [], [
        "success" => false,
        "message" => "Invalid id"
    ]));
    die();
}

//vérifier que l'utilisateur existe et est bien un bailleur ou prestataire
$user = getUserById($id);
if (empty($user) || ($user["grade"] != 4 && $user["grade"] != 5)) {
    echo(jsonResponse(400, [], [
        "success" => false,
        "message" => "User not found or not a landlord or provider"
    ]));
    die();
}

$ads = getAllAdsByOwnerId($id);

if (empty($ads)) {
    echo(jsonResponse(200, [], [
        "success" => true,
        "ads" => 0
    ]));
} else {
    echo(jsonResponse(200, [], [
        "success" => true,
        "ads" => $ads
    ]));
}

?>