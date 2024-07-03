<?php


require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/ads/catalog.php";
require_once __DIR__ . "/../../libraries/parameters.php";

$body= getBody();
$id = $body["id"];
$type = $body["type"];
$userId = $body["userId"];

$favorites = addLike($id, $type, $userId);

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