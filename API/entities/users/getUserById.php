<?php
function getUserById($id)
{
    require_once __DIR__ . "/../../database/connection.php";
    $db = connectDB();
    $req = $db->prepare("SELECT * FROM user WHERE id = :id");
    $req->execute(['id' => $id]);

    return $req->fetch();
}


function getUserByEmail($email)
{
    require_once __DIR__ . "/../../database/connection.php";
    $db = connectDB();
    $req = $db->prepare("SELECT * FROM user WHERE email = :email");
    $req->execute(['email' => $email]);

    return $req->fetch();
}

function getUserByPseudo($pseudo)
{
    require_once __DIR__ . "/../../database/connection.php";
    $db = connectDB();
    $req = $db->prepare("SELECT * FROM user WHERE pseudo = :pseudo");
    $req->execute(['pseudo' => $pseudo]);

    return $req->fetch();
}

function getUserByAdsId($adsid, $type)
{
    require_once __DIR__ . "/../../database/connection.php";
    $db = connectDB();

    if ($type == "performance") {

        $req = $db->prepare("SELECT * FROM performances WHERE id = :id");
        $req->execute(['id' => $adsid]);
    } else {
        $req = $db->prepare("SELECT * FROM housing WHERE id = :id");
        $req->execute(['id' => $adsid]);
    }
    
    $ads = $req->fetch();
    return $ads;
    
}

function getUserByToken($token)
{
    require_once __DIR__ . "/../../database/connection.php";
    $db = connectDB();
    $req = $db->prepare("SELECT * FROM user WHERE token = :token");
    $req->execute(['token' => $token]);

    return $req->fetch();
}
