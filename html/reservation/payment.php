<?php
require '../vendor/autoload.php';
require '../includes/functions/functions.php';

require 'secrets.php';
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$_SESSION["PaymentIntent"] = $_POST;
Use GuzzleHttp\Client;
\Stripe\Stripe::setApiKey($stripeSecretTest);
\Stripe\Stripe::setApiVersion("2024-04-10");

$id = $_GET["id"];
$type = $_GET["type"];


if ($type == 'performance'){
    $hourStart = $_POST['hour_start'];
    $hourEnd = $_POST['hour_end'];
    $hourDuration = $_POST['hour_duration'];

    
//conversion en format date de ref (janvier 1970) 
$hourStart = date("Y-m-d H:i:s", strtotime($hourStart));
$hourEnd = date("Y-m-d H:i:s", strtotime($hourEnd));

function convertToDurationInSeconds($hours) {
    if (!is_numeric($hours)) {
        return false;
    }

    // Calcule la durée en secondes
    return $hours * 3600;
}

$hourDurationInSeconds = convertToDurationInSeconds($hourDuration);


$_SESSION["Erreur"] = [];
$startTimestamp = strtotime($hourStart);
$endTimestamp = strtotime($hourEnd);
$durationInSeconds = $endTimestamp - $startTimestamp;

echo $startTimestamp . " " . $endTimestamp . " " . $durationInSeconds;
if ($endTimestamp < $startTimestamp) {
    $_SESSION["Erreur"][0] = '<div class="alert alert-danger" role="alert" style="text-align:center !important">L\'heure de fin doit être supérieure à l\'heure de début</div>';
} elseif ($endTimestamp == $startTimestamp) {
    $_SESSION["Erreur"][1] = '<div class="alert alert-danger" role="alert" style="text-align:center !important">L\'heure de fin doit être différente de l\'heure de début</div>';
} elseif ($hourDurationInSeconds > $durationInSeconds) {
    $_SESSION["Erreur"][2] = '<div class="alert alert-danger" role="alert" style="text-align:center !important">La durée de la prestation doit être supérieure ou égale à la durée de la prestation</div>';
}
}


if (isset($_SESSION["Erreur"]) && count($_SESSION["Erreur"]) > 0){
foreach ($_SESSION["Erreur"] as $erreur){
    echo $erreur;
}
 
}

if (isset($_SESSION["free_perf_end_date"])){
    setFreePerfTo1WhereId($_SESSION["userId"], $_SESSION["free_perf_end_date"]);
    $price = 0;
}else{
$price = $_POST['price'] * 100;
}
$session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [[
        'price_data' => [
            'currency' => 'eur',
            'product_data' => [
                'name' => $_POST['title'],
            ],
            'unit_amount' => $price,
        ],
        'quantity' => 1,
    ]],
    'mode' => 'payment',
    'success_url' => 'https://pcs-all.online/reservation/success',
    'cancel_url' => 'https://pcs-all.online/reservation/cancel',
]);
header ('Location: ' . $session->url);


