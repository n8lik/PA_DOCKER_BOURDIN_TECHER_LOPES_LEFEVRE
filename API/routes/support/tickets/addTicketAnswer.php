<?php

require_once __DIR__ . "/../../../libraries/response.php";
require_once __DIR__ . "/../../../libraries/body.php";
require_once __DIR__ . "/../../../entities/support.php";

$body = getBody();

$userId= $body["userId"];
$ticketId = $body["ticketId"];
$message = $body["message"];


$answer = addTicketAnswer($userId, $ticketId, $message);

if (empty($answer)) {
    echo(jsonResponse(200, [], [
        "success" => false,
        "message" => "Error while adding ticket answer"
    ]));
} else {
    echo(jsonResponse(200, [], [
        "success" => true,
        "answer" => $answer
    ]));
}

?>