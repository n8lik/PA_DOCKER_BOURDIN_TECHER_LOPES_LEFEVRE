<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require 'vendor/autoload.php';
Use GuzzleHttp\Client;


try {
    $client = new Client([
        'base_uri' => 'https://pcs-all.online:8000'
    ]);
    // premier jour du mois actuel et dernier jour du mois actuel
    $firstDay = date('Y-m-01');
    $lastDay = date('Y-m-t');
    $id = $_SESSION['userId'];
    $test = [
        'firstDay' => $firstDay,
        'lastDay' => $lastDay,
        'id' => $id
    ];
    $response = $client->get('/getBookingByDate', [
        'json' => $test
    ]);
    $data = json_decode($response->getBody()->getContents(), true);
    var_dump($data);
} catch (Exception $e) {
    $data = [];
}