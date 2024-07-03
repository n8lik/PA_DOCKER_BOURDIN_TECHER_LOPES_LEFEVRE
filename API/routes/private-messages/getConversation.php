<?php
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/private-message/privateMessage.php";
require_once __DIR__ . "/../../libraries/parameters.php";


$params = getParametersForRoute("/getConversation/:userId");
$userId = $params['userId'];

if (empty($userId)) {
    jsonResponse(200,  [], "Missing parameters");
}

$privateMessages = getConversationsByUserId($userId);

if (!$privateMessages) {
    jsonResponse(200, [], "Private messages not found");
}

echo jsonResponse(200, [], [
    "success" => true,
    "privateMessages" => $privateMessages
]);