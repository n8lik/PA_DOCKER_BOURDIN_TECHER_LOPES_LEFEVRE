<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../vendor/autoload.php';
session_start();
if (!isConnected()){
    $_SESSION['isConnected'] = "Vous devez être connecté pour accéder à cette page";
    header("Location: /");
 
    die();
}
use GuzzleHttp\Client;

$userId = $_SESSION["userId"];

var_dump($_FILES);

if (isset($_POST['submit'])) {

    $pseudo = $_POST['pseudo'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $phone = $_POST['phone'];
    $extension = $_POST['extension'];

    
    if ($_FILES['file']['size'] > 0) {
        $file = [
            'name' => 'file',
            'contents' => fopen($_FILES['file']['tmp_name'], 'r'),
            'filename' => $_FILES['file']['name']
        ];
    } else {
        $file = [
            'name' => '',
            'contents' => '',
            'filename' => ''
        
        ];
    }


    $client = new Client(['base_uri' => 'https://pcs-all.online:8000']);


    $multipart = [

        ['name' => 'pseudo', 'contents' => $pseudo],
        ['name' => 'firstname', 'contents' => $firstname],
        ['name' => 'lastname', 'contents' => $lastname],
        ['name' => 'phone', 'contents' => $phone],
        ['name' => 'extension', 'contents' => $extension],
        ['name' => 'userId', 'contents' => $userId],
        $file
    ];

    try {
        // Envoyer la requête multipart
        $response = $client->post('https://pcs-all.online:8000/updateUser', [
            'multipart' => $multipart
        ]);

        $body = json_decode($response->getBody()->getContents(), true);
        
        if ($body["success"]== true) {
            $_SESSION['profileUpdateOk'] = $body["message"];
        } else {
            $_SESSION['profileUpdateError'] =  $body["message"];
        }
    } catch (Exception $e) {
        echo $e->getMessage();
        die();
    }
    finally{
        header('Location: ../profile.php');
    
    }
}

if(isset($_POST["submit-password"])){ 
    try {
        $client = new Client([
            'base_uri' => 'https://pcs-all.online:8000'
        ]);
        $test = [
            
            'userId' => $userId,
            'newPassword' => $_POST['newPassword'],

        ];

        $response = $client->post('/updatePassword', [
            'json' => $test

        ]);

        $body = json_decode($response->getBody()->getContents(), true);
        if ($body["success"]== true) {
            $_SESSION['passwordUpdateOk'] = $body["message"];
        } else {
            $_SESSION['passwordUpdateError'] =  $body["message"];
        }
    } catch (Exception $e) {
        echo $e->getMessage();
        die();
    }
    finally{
        header('Location: ../profile.php');
    }
    
}