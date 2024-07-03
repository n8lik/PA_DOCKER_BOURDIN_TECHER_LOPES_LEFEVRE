<?php
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/private-message/privateMessage.php";
require_once __DIR__ . "/../../libraries/parameters.php";

$body = getBody();

$id = $body['id'];
$content = $body['content'];
$type = getTypeById($id);
$userId = $body['userId'];

$to_user = getUserIdInConv($id, $userId);
$adsId = getPerfOrHousingIdById($id);


if (empty($id) || empty($content) || empty($type) || empty($userId)) {
    jsonResponse(400,  [], "Missing parameters");
}

$message = addMessage($id, $content, $type, $userId, $to_user, $adsId);

if (!$message) {
    jsonResponse(404, [], "Private message not found");
}

echo jsonResponse(200, [], [
    "success" => true,
    "message" => "gg"
]);
