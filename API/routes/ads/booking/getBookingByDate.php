<?php


require_once __DIR__ . "/../../../libraries/response.php";
require_once __DIR__ . "/../../../entities/ads/booking.php";
require_once __DIR__ . "/../../../entities/users/getUserById.php";
require_once __DIR__ . "/../../../libraries/parameters.php";
require_once __DIR__ . "/../../../libraries/body.php";


$body = getBody();
$ownerId = $body['id'];
$start_date = $body['firstDay'];
$end_date = $body['lastDay'];

if (empty($ownerId) || empty($start_date) || empty($end_date)) {
    echo(jsonResponse(400, [], "Missing parameters"));
    die();
}

$bookings = getBookingByDate($ownerId,$start_date,$end_date );

if (!$bookings) {
    echo(jsonResponse(200, [], 
[
    "success" => false,
    "message" => "no booking found"
   
] ));
    die();
}

echo(jsonResponse(200, [], 
[
    "success" => true,
    "bookings" => $bookings
]
));