<?php
require_once __DIR__ . "/../libraries/response.php";
require_once __DIR__ . "/../entities/login.php";
require_once __DIR__ . "/../libraries/body.php";

// Necessaires pour le token
require_once __DIR__ . "/../libraries/token.php";
require_once __DIR__ . "/../entities/users/updateUser.php";
require_once __DIR__ . "/../libraries/parameters.php";
session_start();

$body = getBody();

$email = $body["email"];
$password = $body["password"];
$captcha = $body["captcha"];

$user = login($email, $password, $captcha);

if (!$captcha) {
    echo jsonResponse(200, [], [
        "success" => false,
        "error" => "Le captcha est invalide"
    ]);
    die();
}

if (!$user) {
    echo jsonResponse(200, [], [
        "success" => false,
        "error" => "Les identifiants sont incorrects"
    ]);

    die();
}
$token = generateToken($user["id"]);

$_SESSION["token"] = $token;

echo jsonResponse(200, [], [
    "success" => true,
    "token" => $token,
    "grade" => $user["grade"],
    "id" => $user["id"]
    
]);

?>
