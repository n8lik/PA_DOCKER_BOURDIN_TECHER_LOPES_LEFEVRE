<?php

function resetPasswordVerifyUser($email, $token)
{
    require_once __DIR__ . "/../database/connection.php";
    $conn=connectDB();
    $req=$conn->prepare("SELECT pwd_token FROM user WHERE email = :email");
    $req->execute(['email' => $email]);
    $user=$req->fetch();
    if($user['pwd_token'] == $token){
        return true;
    }
    return false;
}


function resetPassword($email, $password)
{
    require_once __DIR__ . "/../database/connection.php";
    $password=password_hash($password, PASSWORD_DEFAULT);
    $conn=connectDB();
    $req=$conn->prepare("UPDATE user SET password = :password, pwd_token = NULL WHERE email = :email");
    $req->execute(['password' => $password, 'email' => $email]);
    return true;
}