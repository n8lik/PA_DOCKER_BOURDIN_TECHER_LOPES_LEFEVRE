<?php
require_once __DIR__ . "/../../../libraries/response.php";
require_once __DIR__ . "/../../../libraries/parameters.php";
require_once __DIR__ . "/../../../entities/support.php";


$parameters = getParametersForRoute("/getTicketsByUserId/:id");
$id = $parameters["id"];

$tickets = getTicketsByUserId($id);

if (empty($tickets)) {
    echo(jsonResponse(400, [], [
        "success" => false,
        "message" => "No ticket found"
    ]));
} else {
    echo(jsonResponse(200, [], [
        "success" => true,
        "tickets" => $tickets
    ]));
}