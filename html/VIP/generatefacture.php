<?php


//DEBUG
error_reporting(E_ALL);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
session_start();
require '../includes/functions/functions.php';
if (!isConnected()){
    $_SESSION['isConnected'] = "Vous devez être connecté pour accéder à cette page";
    header("Location: /");
    die();
}
require '../vendor/autoload.php';
require '../dompdf/autoload.inc.php';
Use GuzzleHttp\Client;
use Dompdf\Dompdf;
$plan = $_GET["id"];
$userToken = $_GET["user"];

$date = new DateTime();

if ($plan == 1) {
    $plan = 'Back Packer mensuel';
    $details = "
        <ul>
            <li>Prix : 9,90€/mois</li>
            <li>Commenter et publier des avis</li>
            <li>Réduction permanente de 5% sur les prestations</li>
            <li>1 prestation offerte par an dans la limite d'une prestation d'un montant inférieur à 80€</li>
            <li>L'abonnement sera actif de ". date('d/m/Y') ." à ". date('d/m/Y', strtotime('+1 month')) ."</li>
        </ul>
    ";
    $price = "9,90€ / mois;";
} else if ($plan == 2) {
    $plan = 'Back Packer annuel';
    $details = "
        <ul>
            <li>Prix : 113€/an</li>
            <li>Commenter et publier des avis</li>
            <li>Réduction permanente de 5% sur les prestations</li>
            <li>1 prestation offerte par semestre</li>
            <li>Réduction de 10% du montant de l'abonnement en cas de renouvellement, valable uniquement sur le tarif annuel</li>
            <li>L'abonnement sera actif de ". date('d/m/Y') ." à ". date('d/m/Y', strtotime('+1 year')) ."</li>
        </ul>
    ";
    $price = "113€ / an";
} else if ($plan == 3){
    $plan = 'Explorateur mensuel';
    $details = "
        <ul>
            <li>Prix : 19,90€/mois</li>
            <li>Commenter et publier des avis</li>
            <li>Réduction permanente de 10% sur les prestations</li>
            <li>1 prestation offerte par semestre, sans limitation du montant</li>
            <li>Accès prioritaire à certaines prestations et aux prestations VIP</li>
            <li>L'abonnement sera actif de ". date('d/m/Y') ." à ". date('d/m/Y', strtotime('+1 month')) ."</li>
        </ul>
    ";
    $price = "19,90€ / mois";
} else if ($plan == 4){
    $plan = 'Explorateur annuel';
    $details = "
        <ul>
            <li>Prix : 220€ /an</li>
            <li>Commenter et publier des avis</li>
            <li>Réduction permanente de 10% sur les prestations</li>
            <li>1 prestation offerte par semestre</li>
            <li>Accès prioritaire à certaines prestations et aux prestations VIP</li>
            <li>Réduction de 10% du montant de l'abonnement en cas de renouvellement, valable uniquement sur le tarif annuel</li>
            <li>L'abonnement sera actif de ". date('d/m/Y') ." à ". date('d/m/Y', strtotime('+1 year')) ."</li>
        </ul>
    ";
    $price = "220€ / an";

}



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

// Initialiser Dompdf avec des options
$dompdf = new Dompdf();

// Charger le contenu HTML
$html =
'<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Facture de l\'abonnement '.$plan.'</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .details {
            margin-top: 20px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        ul li {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="https://pcs-all.online/assets/logos/darkLogo.png" alt="PCS-ALL" style="width: 200px; display: block; margin: 0 auto;">
        <h1>Facture de l\'abonnement '.$plan.'</h1>
        <p>Merci d\'avoir souscrit à notre plan <strong>'.$plan.'</strong>!</p>
        <div class="details">
            <h2>Détails de l\'abonnement :</h2>
            '.$details.'
        </div>
        <div class="details">
            <h2>Prix :</h2>
            <p>'.$price.'</p>
        </div>
    </div>
</body>
</html>
';

$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'portrait');

$dompdf->render();
$pdfOutput = $dompdf->output();

$filePath = "facture_booking_".$plan."_user_".$users["pseudo"].".pdf";
file_put_contents($filePath, $pdfOutput);

