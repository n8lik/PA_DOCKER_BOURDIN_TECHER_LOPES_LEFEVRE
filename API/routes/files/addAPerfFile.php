<?php
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/ads/house.php";
require_once __DIR__ . "/../../entities/files.php";
require_once __DIR__ . "/../../libraries/parameters.php";
file_put_contents('/var/log/apilog/logpost.log', print_r($_POST, true), FILE_APPEND);
file_put_contents('/var/log/apilog/logfile.log', print_r($_FILES, true), FILE_APPEND);

$file = $_FILES["file"];
$usertype = "performance";
$userId = $_POST["userId"];
$idAds = $_POST["idAds"];

        

uploadImageforHouse($usertype, $userId, $idAds, $file);


echo jsonResponse(200, [], [
    "success" => true,
    "message" => "Fichier ajouté avec succès"
]);
 
