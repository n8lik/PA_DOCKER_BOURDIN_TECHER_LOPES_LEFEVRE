<?php

require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/ads/adsInfo.php";
require_once __DIR__ . "/../../libraries/parameters.php";

$parameters = getParametersForRoute("/performanceAdsImages/:id");
$id = $parameters["id"];


$images = getAdsImages($id,"performance");

if (empty($images)) {
    echo(jsonResponse(200, [], [
        "success" => false,
        "message" => "No images found"
    ]));
} else {
    echo(jsonResponse(200, [], [
        "success" => true,
        "images" => $images
    ]));
}


?>