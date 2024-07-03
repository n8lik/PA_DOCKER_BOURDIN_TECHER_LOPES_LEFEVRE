<?php

require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/ads/adsDisponibility.php";
require_once __DIR__ . "/../../libraries/parameters.php";

$body = getBody();

$parameters = getParametersForRoute("/performanceDisponibility/:id");
$id = $parameters["id"];

$dispo = getAdsDisponibilitybyID($id,"performance");

if ($dispo == null) {
    echo(jsonResponse(200, [], [
        "success" => false,
        "message" => "No disponibility found"
    ]));
} else {
    echo(jsonResponse(200, [], [
        "success" => true,
        "disponibility" => $dispo
    ]));
}

?>
