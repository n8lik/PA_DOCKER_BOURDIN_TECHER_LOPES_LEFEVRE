<?php
require_once __DIR__ . "/../../../libraries/response.php";
require_once __DIR__ . "/../../../entities/ads/booking.php";
require_once __DIR__ . "/../../../libraries/parameters.php";



$parameters = getParametersForRoute("/getBookingByTravelerId/:id");

$userId = $parameters["id"];

$bookings = getBookingByUserId($userId, "traveler");
if (empty($bookings)) {
    echo(jsonResponse(200, [], [
        "success" => false,
        "message" => "No booking found"
    ]));
} else {
    echo(jsonResponse(200, [], [
        "success" => true,
        "bookings" => $bookings
    ]));
}
?>

