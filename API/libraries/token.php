<?php
require_once __DIR__ . "/../database/connection.php";
//Fonction pour génerer un token d'authentification
function generateToken($id)
{
    $token = bin2hex(random_bytes(32));
    $db = connectDB();
    $req = $db->prepare("UPDATE user SET token = :token WHERE id = :id");
    $req->execute(['token' => $token, 'id' => $id]);
    return $token;
}

function getToken($id)
{
    $db = connectDB();
    $req = $db->prepare("SELECT token FROM user WHERE id = :id");
    $req->execute(['id' => $id]);
    $token = $req->fetch();
}
 
