<?php
require "../vendor/autoload.php";

use GuzzleHttp\Client;
var_dump($_POST);
session_start();
if (!isConnected()){
    $_SESSION['isConnected'] = "Vous devez être connecté pour accéder à cette page";
    header("Location: /");
 
    die();
}
if (!isset($_POST['action']) || !isset($_SESSION['userId'])) {
    header('Location: /');
    exit();
}
switch ($_POST['action']) {
    case 'addLike':
        if (!isset($_POST['id']) || !isset($_POST['type'])) {
            header('Location: /');
            exit();
        }
        $id = $_POST['id'];
        $type = $_POST['type'];
        $userId = $_SESSION['userId'];

        try{
            $client = new Client([
                'base_uri' => 'https://pcs-all.online:8000'
            ]);
            $like = [
                'userId' => $userId,
                'type' => $type,
                'id' => $id
            ];
            $response = $client->post('/addLike', [
                'json' => $like
            ]);
            $body = json_decode($response->getBody()->getContents(), true);

        } catch (Exception $e) {
            $_SESSION["likeError"] = "Une erreur est survenue";
        }

        $_SESSION["likeSuccess"] = "Annonce ajoutée aux favoris";
        

        break;
    case 'removeLike':
        if (!isset($_POST['id']) || !isset($_POST['type'])) {
            header('Location: /');
            exit();
        }
        $id = $_POST['id'];
        $type = $_POST['type'];
        $userId = $_SESSION['userId'];

        try{
            $client = new Client([
                'base_uri' => 'https://pcs-all.online:8000'
            ]);
            $like = [
                'userId' => $userId,
                'type' => $type,
                'id' => $id
            ];
            $response = $client->post('/removeLike', [
                'json' => $like
            ]);
            $body = json_decode($response->getBody()->getContents(), true);

        } catch (Exception $e) {
            $_SESSION["likeError"] = "Une erreur est survenue";
        }
        $_SESSION["likeSuccess"] = "Annonce retirée des favoris";
        break;
}

//retourner à l'url précédente
header('Location: /ads?id=' . $_POST['id'] . '&type=' . $_POST['type']);
