<?php

require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/ads/house.php";
require_once __DIR__ . "/../../libraries/parameters.php";

$params = getParametersForRoute("/deleteHouse/:id");

$id = $params['id'];

if (empty($id)) {
    jsonResponse(200,  [], "Missing parameters");
}

$house = deleteHouse($id);

if (!$house) {
    jsonResponse(200, [], "House not found");
}

echo jsonResponse(200, [], [
    "success" => true,
    "house" => $house
]);

