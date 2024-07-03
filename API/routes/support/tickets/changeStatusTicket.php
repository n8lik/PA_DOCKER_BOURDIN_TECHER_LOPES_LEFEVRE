<?php
require_once __DIR__ . "/../../../libraries/response.php";
require_once __DIR__ . "/../../../libraries/body.php";
require_once __DIR__ . "/../../../entities/support.php";


$body = getBody();
$ticketId = $body["ticketId"];
$status = $body["status"];

$ticket = changeStatusTicket($ticketId, $status);

if (empty($ticket)) {
    echo(jsonResponse(200, [], [
        "success" => false,
        "message" => "Error while changing ticket status"
    ]));
} else {
    echo(jsonResponse(200, [], [
        "success" => true,
        "ticket" => $ticket
    ]));
}
?>

