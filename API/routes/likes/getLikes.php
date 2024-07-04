<?php


require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/ads/catalog.php";
require_once __DIR__ . "/../../libraries/parameters.php";

$parameters = getParametersForRoute('getLikes/:id');
$id = $parameters["id"];

$favorites = getLikesByUserId($id);

if (empty($favorites)) {
    echo (jsonResponse(200, [], [
        "success" => false,
        "message" => "No favorites found"
    ]));
} else {
    echo (jsonResponse(200, [], [
        "success" => true,
        "favorites" => $favorites
    ]));
}

?>