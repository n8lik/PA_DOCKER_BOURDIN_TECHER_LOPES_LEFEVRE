<?php

require_once __DIR__ . "/../../../libraries/response.php";
require_once __DIR__ . "/../../../libraries/body.php";
require_once __DIR__ . "/../../../entities/support.php";
require_once __DIR__ . "/../../../libraries/parameters.php";

$body = getBody();



$userId= $body["userId"];
$subject = $body["subject"];
$message = $body["message"];

$ticket = addTicket($userId, $subject, $message);

if (empty($ticket)) {
    echo(jsonResponse(200, [], [
        "success" => false,
        "message" => "Error while adding ticket"
    ]));
} else {
    echo(jsonResponse(200, [], [
        "success" => true,
        "ticket" => $ticket
    ]));
}