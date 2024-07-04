<?php

require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/users/updateUser.php";
require_once __DIR__ . "/../../libraries/token.php";

$body = getBody();

$userToken = $body["userToken"];
$subid = $body["subId"];

if (is_null($userToken)) {
    echo (jsonResponse(200, [], [
        "success" => false,
        "error" => "User not found"
    ]));
    exit;
}

$user = updateSubId($userToken, $subid);

echo jsonResponse(200, $user , [
    "success" => true,
    "users" => $user
]);


