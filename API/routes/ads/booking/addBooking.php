<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/../../../libraries/response.php";
require_once __DIR__ . "/../../../libraries/body.php";
require_once __DIR__ . "/../../../entities/ads/booking.php";
require_once __DIR__ . "/../../../libraries/parameters.php";

$body = getBody();

$id = $body["id"];
$type = $body["type"];
$start_date = $body["s_date"];
$end_date = $body["e_date"];
if (isset($body["amount_people"])) {
    $amount_people = $body["amount_people"];
} else {
    $amount_people = null;
}
$price = $body["price"];
$userId = $body["userId"];
$title = $body["title"];



if (!isset($id) || !isset($type) || !isset($start_date) || !isset($end_date) || !isset($price) || !isset($userId) || !isset($title)) {
    echo jsonResponse(400, [], [
        "success" => false,
        "message" => "Missing parameters"
    ]);
    die();
}

$id=addBooking($id, $type, $start_date, $end_date, $amount_people, $price, $userId, $title);

if (!$id) {
    echo jsonResponse(200, [], [
        "success" => false,
        "message" => "Booking not added"
    ]);
    die();
}

echo jsonResponse(200, [], [
    "success" => true,
    "message" => "Booking added",
    "id" => $id
]);
