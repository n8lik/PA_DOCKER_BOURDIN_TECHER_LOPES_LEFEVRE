<?php


//DEBUG
require '../vendor/autoload.php';
require '../dompdf/autoload.inc.php';
session_start();

Use GuzzleHttp\Client;
use Dompdf\Dompdf;
$bookingId = $_GET["id"];
$userToken = $_GET["user"];


try {
    $client = new Client([
        'base_uri' => 'https://pcs-all.online:8000'
    ]);
    $response = $client->get('/booking/' .$bookingId);
    $data = json_decode($response->getBody()->getContents(), true);
    $booking = $data["booking"];
    var_dump($booking);
} catch (Exception $e) {
    $booking = [];
}

if ($type == "housing"){
$housingId = $booking["housing_id"];
} else {
    $housingId = $booking["performance_id"];
}
try {
    $client = new Client([
        'base_uri' => 'https://pcs-all.online:8000'
    ]);
    $response = $client->get('/housing/' .$housingId);
    $data = json_decode($response->getBody()->getContents(), true);
    $housing = $data["housing"];
} catch (Exception $e) {
    $housing = [];
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

if ($type == "housing"){
$details = '<div class="details">
    
            <h2>Informations sur le logement</h2>
            <p><strong>Titre:</strong> '.$housing["title"].'</p>
            <p><strong>Type de maison:</strong> '.$housing["type_house"].'</p>
            <p><strong>Type de location:</strong> '.$housing["type_location"].'</p>
            <p><strong>Nombre de pièces:</strong> '.$housing["amount_room"].'</p>
            <p><strong>Capacité d\'accueil:</strong> '.$housing["guest_capacity"].' personnes</p>
            <p><strong>Surface de la propriété:</strong> '.$housing["property_area"].' m²</p>
            <p><strong>Adresse:</strong> '.$housing["address"].', '.$housing["city"].', '.$housing["postal_code"].'</p>
        </div>';
} else if ($type == "performance"){
    $details = '<div class="details">
    
            <h2>Informations sur la prestation</h2>
            <p><strong>Titre:</strong> '.$housing["title"].'</p>
            <p><strong>Type de prestation:</strong> '.$housing["performance_type"].'</p>
            
            <p><strong>Adresse:</strong> '.$housing["place"].'</p>
        </div>';
}

// Charger le contenu HTML
$html = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Facture de la réservation '.$bookingId.'</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background: #f9f9f9;
        }
        h1 {
            text-align: center;
            color: #4CAF50;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .details {
            margin-top: 20px;
        }
        .details p {
            margin: 5px 0;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Facture de la réservation '.$bookingId.'</h1>
        <div class="details">
            <h2>Informations sur la réservation</h2>
            <p><strong>ID de la réservation:</strong> '.$bookingId.'</p>
            <p><strong>Prix:</strong> '.$booking["price"].' €</p>
            <p><strong>Date de début:</strong> '.$booking["start_date"].'</p>
            <p><strong>Date de fin:</strong> '.$booking["end_date"].'</p>
        </div>
        '.$details.'
        <div class="details">
            <h2>Informations sur le client</h2>
            <p><strong>Prénom:</strong> '.$users["firstname"].'</p>
            <p><strong>Nom:</strong> '.$users["lastname"].'</p>
            <p><strong>Email:</strong> '.$users["email"].'</p>
            <p><strong>Numéro de téléphone:</strong> '.$users["phone_number"].'</p>
        </div>
        <div class="footer">
            <p>Merci pour votre réservation.</p>
        </div>
    </div>
</body>
</html>
';

$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

$dompdf->stream("facture_booking_".$bookingId."_user_".$users["pseudo"].".pdf", array("Attachment" => true));
