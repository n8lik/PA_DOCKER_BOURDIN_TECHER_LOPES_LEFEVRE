<?php
require '/var/www/html/vendor/autoload.php';
session_start() ;
Use GuzzleHttp\Client;
$token = $_GET["token"];
$grade = $_GET["grade"];
$filename = $_GET['file'];
try {
    $client = new Client([
        'base_uri' => 'https://pcs-all.online:8000'
    ]);
    $test = [
        'grade' => $grade,
        'token' => $token,
        'filename' => $filename
    ];
    $response = $client->post('/downloadFile', [
        'json' => $test

    ]);

    
    $headers = $response->getHeaders();
    foreach ($headers as $name => $values) {
        foreach ($values as $value) {
            header($name . ': ' . $value);
        }
    }
    echo $response->getBody();
    $_SESSION["success"] = "Fichier téléchargé avec succès";

} catch (Exception $e) {
    
    
    echo $e->getMessage();
}