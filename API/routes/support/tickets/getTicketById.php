<?php

require_once __DIR__ . "/../../../libraries/response.php";
require_once __DIR__ . "/../../../entities/support.php";


$parameters = getParametersForRoute("/getTicketById/:id");
$id = $parameters["id"];

$ticket = getTicketById($id);

if (empty($ticket)) {
    echo(jsonResponse(200, [], [
        "success" => false,
        "message" => "No ticket found"
    ]));
} else {
    echo(jsonResponse(200, [], [
        "success" => true,
        "ticket" => $ticket
    ]));
}
