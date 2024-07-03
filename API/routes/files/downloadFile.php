<?php

require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/files.php";
require_once __DIR__ . "/../../libraries/parameters.php";
require_once __DIR__ . "/../../entities/users/getUserById.php";
$body = getBody();

$token = $body["token"];
$file = $body["filename"];


$id = getUserByToken($token);
$userId = $id["id"];
$parts = explode('/', $file);
var_dump($parts);
if ($userId != $parts[2]) {
    echo (jsonResponse(200, [], [
        "success" => false,
        "error" => "Accès refusé"
    ]));
    exit;
}
if (!$id) {
    echo (jsonResponse(200, [], [
        "success" => false,
        "error" => "User not found"
    ]));
    exit;
}


$filePath = $file;
if (file_exists($filePath)) {

    //si l'extension est pdf

    $ext = pathinfo($parts[5], PATHINFO_EXTENSION);
    
    if ($ext == "pdf") {
     

    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . $parts[5] . '"');
    header('Expires: ' . gmdate(DATE_RFC1123, filemtime($filePath)));
    header('Last-Modified: ' . gmdate(DATE_RFC1123, filemtime($filePath)));
    header('Date: ' . gmdate(DATE_RFC1123, filemtime($filePath)));
    header('Pragma: public');
    header('Content-Length: ' . filesize($filePath));
    header('Cache-Control: must-revalidate, pre-check=0, post-check=0, max-age=0');
    header('Content-Tranfer-Encoding: none');
    header('Content-MD5: ' . base64_encode(md5_file($filePath)));
    
    readfile($filePath);
    }
    //pareil avec : 'pdf','docx','png' ,'jpeg', 'jpg'
    elseif ($ext == "docx") {
        header('Content-Type: application/docx');
        header('Content-Disposition: attachment; filename="' . $parts[5] . '"');
        header('Expires: ' . gmdate(DATE_RFC1123, filemtime($filePath)));
        header('Last-Modified: ' . gmdate(DATE_RFC1123, filemtime($filePath)));
        header('Date: ' . gmdate(DATE_RFC1123, filemtime($filePath)));
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        header('Cache-Control: must-revalidate, pre-check=0, post-check=0, max-age=0');
        header('Content-Tranfer-Encoding: none');
        header('Content-MD5: ' . base64_encode(md5_file($filePath)));
        
        readfile($filePath);
    }
    elseif ($ext == "png") {
        header('Content-Type: application/png');
        header('Content-Disposition: attachment; filename="' . $parts[5] . '"');
        header('Expires: ' . gmdate(DATE_RFC1123, filemtime($filePath)));
        header('Last-Modified: ' . gmdate(DATE_RFC1123, filemtime($filePath)));
        header('Date: ' . gmdate(DATE_RFC1123, filemtime($filePath)));
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        header('Cache-Control: must-revalidate, pre-check=0, post-check=0, max-age=0');
        header('Content-Tranfer-Encoding: none');
        header('Content-MD5: ' . base64_encode(md5_file($filePath)));
        
        readfile($filePath);
    }
    elseif ($ext == "jpeg") {
        header('Content-Type: application/jpeg');
        header('Content-Disposition: attachment; filename="' . $parts[5] . '"');
        header('Expires: ' . gmdate(DATE_RFC1123, filemtime($filePath)));
        header('Last-Modified: ' . gmdate(DATE_RFC1123, filemtime($filePath)));
        header('Date: ' . gmdate(DATE_RFC1123, filemtime($filePath)));
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        header('Cache-Control: must-revalidate, pre-check=0, post-check=0, max-age=0');
        header('Content-Tranfer-Encoding: none');
        header('Content-MD5: ' . base64_encode(md5_file($filePath)));
        
        readfile($filePath);
    }
    elseif ($ext == "jpg") {
        header('Content-Type: application/jpg');
        header('Content-Disposition: attachment; filename="' . $parts[5] . '"');
        header('Expires: ' . gmdate(DATE_RFC1123, filemtime($filePath)));
        header('Last-Modified: ' . gmdate(DATE_RFC1123, filemtime($filePath)));
        header('Date: ' . gmdate(DATE_RFC1123, filemtime($filePath)));
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        header('Cache-Control: must-revalidate, pre-check=0, post-check=0, max-age=0');
        header('Content-Tranfer-Encoding: none');
        header('Content-MD5: ' . base64_encode(md5_file($filePath)));
        
        readfile($filePath);
    }
    else{
        echo (jsonResponse(200, [], [
            "success" => false,
            "error" => "Extension non supportée"
        ]));
        exit;
    }
}


 echo (jsonResponse(200, $headers, [
    "success" => true,
    "message" => "Fichier téléchargé"
])); 
