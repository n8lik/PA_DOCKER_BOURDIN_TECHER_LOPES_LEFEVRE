<?php
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/users/getInfoUser.php";
require_once __DIR__ . "/../../libraries/parameters.php";


$parameters = getParametersForRoute("/getPpById/:id");
$id = $parameters["id"];
$data = getPpByUserID($id);


if (empty($data)) {
    echo (jsonResponse(200, [], [
        "success" => false,
        "message" => "No user found"
    ]));
} else {
    echo (jsonResponse(200, [], [
        "success" => true,
        "users" => $data
    ]));
}
