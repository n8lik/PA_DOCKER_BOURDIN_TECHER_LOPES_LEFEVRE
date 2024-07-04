<?php


require_once __DIR__ . "/../../../libraries/response.php";
require_once __DIR__ . "/../../../entities/ads/booking.php";
require_once __DIR__ . "/../../../entities/users/getUserById.php";
require_once __DIR__ . "/../../../libraries/parameters.php";
require_once __DIR__ . "/../../../libraries/body.php";



$body = getBody();
$ownerId = $body['id'];
$adsType = $body['adsType'];
if (empty($ownerId)) {
    echo(jsonResponse(400, [], "Missing parameters"));
    die();
}

$bookings = getAllBookingByOwnerId($ownerId,$adsType );

if (!$bookings) {
    echo(jsonResponse(200, [], 
[
    "success" => false,
    "message" => "no booking found"
   
] ));
    die();
}
$traveler = $bookings[0]['user_id'];
$username = getUserById($traveler);

echo(jsonResponse(200, [], 
[
    "success" => true,
    "bookings" => $bookings,
    "username" => $username
]
));

