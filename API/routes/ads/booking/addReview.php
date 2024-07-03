<?php


require_once __DIR__ . "/../../../libraries/response.php";
require_once __DIR__ . "/../../../libraries/body.php";
require_once __DIR__ . "/../../../entities/ads/booking.php";
require_once __DIR__ . "/../../../entities/users/getUserById.php";


$body= getBody();

$rate = $body["rate"];
$comment = $body["comment"];
$id = $body["id"];

$userId = getBookingById($id)["userId"];

$user = getUserById($userId);

if ($user['vip_status'] == 0) {
    echo jsonResponse(200, [], [
        "success" => false,
        "message" => "L'utilisateur n'est pas VIP"
    ]);
    die();
}

$review = addReview($rate, $comment, $id);

if (empty($review)) {
    echo jsonResponse(200, [], [
        "success" => false,
        "message" => "Une erreur a eu lieu lors de l'ajout de l'avis"
    ]);
    die();
}else{
    echo jsonResponse(200, [], [
        "success" => true,
        "message" => "Review added"
    ]);
    die();
}
