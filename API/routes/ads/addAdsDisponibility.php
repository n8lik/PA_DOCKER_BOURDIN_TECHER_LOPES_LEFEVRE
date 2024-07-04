<?php

require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/ads/adsDisponibility.php";
require_once __DIR__ . "/../../libraries/parameters.php";

$body = getBody();

$ad_id = $body["id"];
$ad_type = $body["type"];
$ad_date= $body["date"];
if ($ad_type == 'performance') {
    $hour_start = $body["hour_start"];
    $hour_end = $body["hour_end"];
    $hour_duration = $body["hour_duration"];
} else {
    $hour_start = null;
    $hour_end = null;
    $hour_duration = null;
}
if (!isset($ad_id) || !isset($ad_type) || !isset($ad_date) ) {
    echo jsonResponse(200, [], [
        "success" => false,
        "error" => "Les paramètres sont incorrects"
    ]);

    die();
}


$dispo = addAdsDisponibility($ad_id,$ad_type,$ad_date,$hour_start,$hour_end,$hour_duration);


if (!$dispo) {
    echo jsonResponse(200, [], [
        "success" => false,
        "error" => "Les identifiants sont incorrects"
    ]);

    die();
}



echo jsonResponse(200, [], [
    "success" => true,
    "dispo" => $dispo
]);


