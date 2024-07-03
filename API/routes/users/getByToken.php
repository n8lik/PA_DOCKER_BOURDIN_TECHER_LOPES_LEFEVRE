<?php

require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../entities/isAuthentified.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/users/getUserById.php";
require_once __DIR__ . "/../../libraries/parameters.php";

$body = getBody();

$parameters = getParametersForRoute("/usersbytoken/:user");
$id = $parameters["user"];


if (is_null($id)) {
    echo (jsonResponse(200, [], [
        "success" => false,
        "error" => "User not found"
    ]));
    exit;
}

$user = getUserByToken($id);

echo jsonResponse(200, $user , [
    "success" => true,
    "users" => $user
]);
