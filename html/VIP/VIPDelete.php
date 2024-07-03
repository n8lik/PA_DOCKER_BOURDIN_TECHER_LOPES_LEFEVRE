<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require '../vendor/autoload.php';

require '../reservation/secrets.php';
session_start();
require '../includes/functions/functions.php';
if (!isConnected()){
    $_SESSION['isConnected'] = "Vous devez être connecté pour accéder à cette page";
    header("Location: /");
    die();
}

use GuzzleHttp\Client;
$userToken = $_SESSION["token"];
try {
    $client = new Client([
        'base_uri' => 'https://pcs-all.online:8000'
    ]);
    $response = $client->get('/usersbytoken/' . $userToken);
    $body = json_decode($response->getBody()->getContents(), true);
    $users = $body["users"];
} catch (Exception $e) {
    $users = [];
}
$stripe = new \Stripe\StripeClient($stripeSecretTest);

$stripe->subscriptions->update(
    $users["sub_id"],
    ['cancel_at_period_end' => true]
);
try {
    $client = new Client(['base_uri' => 'https://pcs-all.online:8000']);
    $response = $client->post('/VIPUser', [
        'json' => [
            'vip_status' => 5,
            'userId' => $_SESSION["userId"],
            'vip_type' => null
        ]
    ]);
    $booking = json_decode($response->getBody()->getContents(), true);
    var_dump($booking); 
    if ($booking["success"] == true) {
        $_SESSION["success"] = "Votre abonnement a bien été supprimé";
        header('location: /VIP/VIP');
    } else {
        $_SESSION["error"] = "Une erreur est survenue lors de la suppression de votre abonnement";
        header('location: /VIP/VIP');
    }

} catch (Exception $e) {
    echo $e->getMessage();
    die();
} 

