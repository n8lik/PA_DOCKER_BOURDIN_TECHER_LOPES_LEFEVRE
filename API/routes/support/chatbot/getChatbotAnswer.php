<?php

require_once __DIR__ . "/../../../libraries/response.php";
require_once __DIR__ . "/../../../entities/support.php";
require_once __DIR__ . "/../../../libraries/parameters.php";

$parameters = getParametersForRoute("/getChatbotAnswer/:message");
$message = $parameters["message"];


if (empty($message)) {
    echo(jsonResponse(404, [], [
        "success" => false,
        "message" => "Message is required"
    ]));
    die();
}

$answer=getChatbotAnswer($message);

if (empty($answer)) {
    echo(jsonResponse(404, [], [
        "success" => false,
        "message" => "No answer found"
    ]));
    die();
}

echo(jsonResponse(200, [], [
    "success" => true,
    "message" => $answer
]));