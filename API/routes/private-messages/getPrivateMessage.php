<?php


require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/private-message/privateMessage.php";
require_once __DIR__ . "/../../libraries/parameters.php";


$params = getParametersForRoute("/private-message/:id");

$id = $params['id'];

if (empty($id)) {
    jsonResponse(400,  [], "Missing parameters");
}

$privateMessage = getPrivateMessageById($id);

if (!$privateMessage) {
    jsonResponse(404, [], "Private message not found");
}


//afficher tous les $privateMessage['content'] 

echo jsonResponse(200, [], [
    "privateMessage" => $privateMessage
]);