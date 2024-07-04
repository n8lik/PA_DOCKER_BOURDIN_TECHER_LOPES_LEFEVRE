<?php

require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/ads/adsInfo.php";

$body= getBody();

$ad_id = $body["id"];
$ad_type = $body["type"];

$average = getAdsAverageRate($ad_id,$ad_type);

if(!$average){

    echo(jsonResponse(200, [], [
        "success" => true,
        "average" => $average
    ]));
}

