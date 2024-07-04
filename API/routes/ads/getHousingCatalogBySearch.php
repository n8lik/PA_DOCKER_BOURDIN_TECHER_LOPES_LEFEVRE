<?php

require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/ads/catalog.php";
require_once __DIR__ . "/../../libraries/parameters.php";

//parametres envoyés en post
$body = getBody();

$destination = $body["destination"];
$startDate = $body["arrivalDate"];
$endDate = $body["departureDate"];
$travelers = $body["travelers"];


$catalog = getHousingCatalogBySearch($destination, $startDate, $endDate, $travelers);

if (empty($catalog)) {
    echo(jsonResponse(200, [], [
        "success" => false,
        "message" => "No catalog found"
    ]));
} else {
    echo(jsonResponse(200, [], [
        "success" => true,
        "catalog" => $catalog
    ]));
}

?>