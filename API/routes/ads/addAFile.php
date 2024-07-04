<?php

require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/ads/house.php";
require_once __DIR__ . "/../../entities/files.php";
require_once __DIR__ . "/../../libraries/parameters.php";
file_put_contents('/var/log/apilog/logpost.log', print_r($_POST, true), FILE_APPEND);
file_put_contents('/var/log/apilog/logfile.log', print_r($_FILES, true), FILE_APPEND);

$file = $_FILES["file"];
$usertype = $_POST["type"];
$userid = $_POST["userId"];
$adsId = $_POST["adsId"];
$filetype = $_POST["filetype"];


//si l'extension du fichier n'est pas : pdf, docx, png, jpeg, jpg, on refuse
$allowed =  array('pdf','docx','png' ,'jpeg', 'jpg');
$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
if(!in_array($ext,$allowed) ) {
    echo jsonResponse(
        200,
        [],
        [
            "success" => false,
            "message" => "Extension de fichier non autorisée"
        ]
    );
}



$upload = uploadFile($usertype, $userid, $adsId, $file , $filetype);

if ($upload != "Le fichier " . htmlspecialchars(basename($file["name"])) . " a été téléchargé.") {
    echo jsonResponse(
        200,
        [],
        [
            "success" => false,
            "message" => $upload
        ]
    );
    exit;
}

echo jsonResponse(
    200,
    [],
    [
        "success" => true,
        "message" => "Fichier ajouté",
        "file" => $filetype
    ]
);
