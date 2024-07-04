<?php
require_once __DIR__ . "/../../../libraries/response.php";
require_once __DIR__ . "/../../../entities/ads/booking.php";
require_once __DIR__ . "/../../../entities/users/getUserById.php";
require_once __DIR__ . "/../../../libraries/parameters.php";

$params = getParametersForRoute("/booking/:id");

$id = $params['id'];
if (empty($id)) {
    echo(jsonResponse(400, [], "Missing parameters"));
    die();
}

$booking = getBookingById($id);

if (!$booking) {
    echo(jsonResponse(200, [], "No booking found"));
    die();
}


echo(jsonResponse(200, [], 
[
    "success" => true,
    "booking" => $booking
]
));