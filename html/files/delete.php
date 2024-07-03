<?php
require '../vendor/autoload.php';
session_start() ;
if (!isConnected()){
    $_SESSION['isConnected'] = "Vous devez être connecté pour accéder à cette page";
    header("Location: /");
 
    die();
}
Use GuzzleHttp\Client;
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
    $response = $client->post('/deleteFile', [
        'json' => $test

    ]);

    $body = json_decode($response->getBody()->getContents(), true);
    if ($body["success"] == true){
        $_SESSION["success"] = "Fichier supprimé";
        header("Location: files.php");
    }
    else{
        $_SESSION["error"] = "Erreur lors de la suppression du fichier";
        header("Location: files.php");
    }
} catch (Exception $e) {
    
    echo $e->getMessage();
}