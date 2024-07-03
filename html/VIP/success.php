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

$plan = $_SESSION["PaymentIntent"]["plan"];
$price = $_SESSION["PaymentIntent"]["price"];
$token = $_SESSION["token"];

if ($plan == 2 || $plan == 4){
    $vip_type = 1;
} else if ($plan == 1 || $plan == 3){
    $vip_type = 0;
}


try {
    $client = new Client(['base_uri' => 'https://pcs-all.online:8000']);
    $response = $client->post('/VIPUser', [
        'json' => [
            'vip_status' => $plan,
            'userId' => $_SESSION["userId"],
            'vip_type' => $vip_type
        ]
    ]);
    $booking = json_decode($response->getBody()->getContents(), true);
   
   
    if ($booking["success"] == true) {

        unset($_SESSION["PaymentIntent"]);
        
        header('location: /VIP/sendmail?id='.$plan.'&user='.$token);
   
        

    } else {
        $_SESSION["error"] = "Une erreur est survenue lors de la création de votre abonnement";

        header('location: /VIP/VIP');
        unset($_SESSION["PaymentIntent"]);
        
    }

} catch (Exception $e) {
    echo $e->getMessage();
    die();
} 

