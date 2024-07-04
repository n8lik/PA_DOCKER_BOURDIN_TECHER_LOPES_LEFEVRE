<?php
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/private-message/privateMessage.php";
require_once __DIR__ . "/../../libraries/parameters.php";


$body = getBody();

$id = $body['id'];
$type = $body['type'];
$userId = $body['userId'];

if (empty($id) || empty($type) || empty($userId)) {
    jsonResponse(400,  [], "Missing parameters");
}

$idConv = addConversation($userId, $type, $id);


if (!$idConv) {
    jsonResponse(404, [], "Conversation not found");
}

echo jsonResponse(200, [], [
    "success" => true,
    "idConv" => $idConv
]);
