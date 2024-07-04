<?php


require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/ads/catalog.php";
require_once __DIR__ . "/../../libraries/parameters.php";

$parameters = getParametersForRoute("/getPerformanceCatalogByType/:type");
$type = $parameters["type"];

$catalog = getPerformanceCatalogByType($type);

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