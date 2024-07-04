<?php

require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../entities/isAuthentified.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/users/getUserById.php";
require_once __DIR__ . "/../../libraries/parameters.php";

$body = getBody();

$parameters = getParametersForRoute("/users/:user");
$id = $parameters["user"];


if (is_null($id)) {
    echo (jsonResponse(200, [], [
        "success" => false,
        "error" => "User not found"
    ]));
    exit;
}

$user = getUserById($id);

echo jsonResponse(200, $user , [
    "success" => true,
    "users" => $user
]);
exit;
