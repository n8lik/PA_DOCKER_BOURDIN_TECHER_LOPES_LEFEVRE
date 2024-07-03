<?php

require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/ads/house.php";
require_once __DIR__ . "/../../libraries/parameters.php";

$parameters = getParametersForRoute("/housing/:id");
$id = $parameters["id"];

$housing = getHousingById($id);

if (empty($housing)) {
    echo(jsonResponse(200, [], [
        "success" => false,
        "message" => "No images found"
    ]));
} else {
    echo(jsonResponse(200, [], [
        "success" => true,
        "housing" => $housing
    ]));
}

?>
