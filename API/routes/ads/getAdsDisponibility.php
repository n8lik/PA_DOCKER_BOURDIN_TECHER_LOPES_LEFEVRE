<?php

require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/ads/adsDisponibility.php";
require_once __DIR__ . "/../../libraries/parameters.php";

$body = getBody();

$id = $body["id"];
$id_dispo = $body["id_dispo"];

$dispo = getAdsDisponibilitybyIDandIdDispo($id,"performance",$id_dispo);

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
