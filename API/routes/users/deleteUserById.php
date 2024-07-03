<?php

require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../entities/isAuthentified.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/users/deleteUser.php";
require_once __DIR__ . "/../../libraries/parameters.php";

$body = getBody();

$parameters = getParametersForRoute("/deleteUserById/:id");
$id = $parameters["id"];

if (is_null($id)) {
    echo (jsonResponse(200, [], [
        "success" => false,
        "error" => "User not found"
    ]));
    exit;
}

$user = deleteUser($id);

echo jsonResponse(200, $user , [
    "success" => true,
    "users" => $user
]);
exit;