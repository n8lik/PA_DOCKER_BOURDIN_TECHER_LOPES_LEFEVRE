<?php
require '../vendor/autoload.php';
session_start() ;
Use GuzzleHttp\Client;


if (!isConnected()){
    $_SESSION['isConnected'] = "Vous devez être connecté pour accéder à cette page";
    header("Location: /");
 
    die();
}
$token = $_SESSION["token"];
$grade = $_SESSION["grade"];
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
    
} catch (Exception $e) {
    
    echo $e->getMessage();
}