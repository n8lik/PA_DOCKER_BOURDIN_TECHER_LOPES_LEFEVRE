<?php

require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/ads/adsInfo.php";

$body= getBody();

$ad_id = $body["id"];
$ad_type = $body["type"];

$comments = getAdsComments($ad_id,$ad_type);

if (empty($comments)) {
    echo jsonResponse(200, [], [
        "success" => false,
        "message" => "Error while getting comments"
    ]);
    die();

}else{
    echo jsonResponse(200, [], [
        "success" => true,
        "comments" => $comments
    ]);
    die();
}
?>