<?php



require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/ads/catalog.php";
require_once __DIR__ . "/../../libraries/parameters.php";

$body=getBody();

$date = $body["date"];
$activity= $body["activity"];


$catalog = getPerformanceCatalogBySearch($date,$activity);

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