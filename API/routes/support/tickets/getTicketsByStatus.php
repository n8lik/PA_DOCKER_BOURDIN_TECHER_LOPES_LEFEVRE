<?php
require_once __DIR__ . "/../../../libraries/response.php";
require_once __DIR__ . "/../../../libraries/parameters.php";
require_once __DIR__ . "/../../../entities/support.php";


$parameters = getParametersForRoute("/getTicketsByStatus/:status");
$status = $parameters["status"];

$tickets = getTicketsByStatus($status);

if (empty($tickets)) {
    echo(jsonResponse(404, [], [
        "success" => false,
        "message" => "No ticket found"
    ]));
} else {
    echo(jsonResponse(200, [], [
        "success" => true,
        "tickets" => $tickets
    ]));
}

?>