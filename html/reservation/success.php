<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require '../vendor/autoload.php';


session_start();

use GuzzleHttp\Client;


if (!isset($_SESSION["userId"])) {
    header("Location: /login");
    die();
}

if (!isset($_SESSION["PaymentIntent"])) {
    header("Location: /");
    die();
}
$token = $_SESSION["token"];
$userId = $_SESSION["userId"];
$paymentIntent = $_SESSION["PaymentIntent"];
$id = $paymentIntent["id"];
$type = $paymentIntent["type"];
$price = $paymentIntent["price"];
$s_date = $paymentIntent["s-date"]; 
$hour_start = $paymentIntent["hour_start"];
$hour_end = $paymentIntent["hour_end"]; 


if ($type == "performance") {
    $start_date_string = $s_date . ' ' . $hour_start;
    $start_date = date("Y-m-d H:i:s", strtotime($start_date_string));

} else {
    $start_date = $paymentIntent["s-date"];
}
if ($type == "performance") {
    $end_date_string = $s_date . ' ' . $hour_end;
    $end_date = date("Y-m-d H:i:s", strtotime($end_date_string));

}  else {
    $end_date = $paymentIntent["e-date"];
}
if ($type == "performance") {
    $amount_people = null;
} else {
    $amount_people = $paymentIntent["amount_people"];
}

$title = $paymentIntent["title"];

echo $id . " " . $type . " " . $price . " " . $start_date . " " . $end_date . " " . $amount_people . " " . $title . " " . $userId;
   
try {
    $client = new Client(['base_uri' => 'https://pcs-all.online:8000']);
    if ($type == "performance") {
    $response = $client->post('/addBooking', [
        'json' => [
            'title' => $title,
            'id' => $id,
            'type' => $type,
            'price' => $price,
            's_date' => $start_date,
            'e_date' => $end_date,
            'userId' => $userId
        ]
    ]);}
    else if ($type == "housing") {
        
        $response = $client->post('/addBooking', [
            'json' => [
                'title' => $title,
                'id' => $id,
                'type' => $type,
                'price' => $price,
                's_date' => $start_date,
                'e_date' => $end_date,
                'amount_people' => $amount_people,
                'userId' => $userId
            ]
        ]);}
    $booking = json_decode($response->getBody()->getContents(), true);
    $idresa = $booking["id"];

    if ($booking["success"]) {
        unset($_SESSION["PaymentIntent"]);
        $_SESSION["booking"] = 0;
        header('location: /pdf/sendmail?id=' . $idresa . '&user=' . $token . '&type=' . $type);
    } else {
        unset($_SESSION["PaymentIntent"]);
        $_SESSION["booking"] = 1;
    }
} catch (Exception $e) {
    echo $e->getMessage();
    die();
}
