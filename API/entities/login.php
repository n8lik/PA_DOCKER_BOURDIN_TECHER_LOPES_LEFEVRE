<?php
//Si l'email  n'existe pas en base de données on renvoie une erreur
function login(string $email, string $password, string $captcha)
{
    require_once __DIR__ . "/../database/connection.php";

    $databaseConnection = connectDB();



    $getUserQuery = $databaseConnection->prepare("SELECT id, password, grade,is_deleted FROM user WHERE email = :email");

    $success = $getUserQuery->execute([
        "email" => $email
    ]);

    if (!$success) {
        return false;
    }

    $user = $getUserQuery->fetch(PDO::FETCH_ASSOC);


    if (!$user || $user["is_deleted"] == 1) {
        return false;
    }

    $isPasswordValid = password_verify($password, $user["password"]);

    if (!$isPasswordValid) {
        return false;
    }
    


    return $user;
}


function loginAssistance(string $email, string $password)
{
    require_once __DIR__ . "/../database/connection.php";
    $db = connectDB();
    $req= $db-> prepare("SELECT id, password, grade FROM user WHERE email = :email");
    $req->execute([
        "email" => $email
    ]);
    $user = $req->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        return false;
    }
    $isPasswordValid = password_verify($password, $user["password"]);
    if (!$isPasswordValid) {
        return false;
    }
    return $user;
}