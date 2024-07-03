<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 

  require '../vendor/autoload.php';
  require '../includes/functions/functions.php';
session_start();
if (!isConnected()){
    $_SESSION['isConnected'] = "Vous devez être connecté pour accéder à cette page";
    header("Location: /");
    die();
}
  use GuzzleHttp\Client;
try {
    $client = new Client([
        'base_uri' => 'https://pcs-all.online:8000'
    ]);
    $response = $client->get('/users');
    $users = json_decode($response->getBody()->getContents(), true);
    
} catch (Exception $e) {
    $users = [];
}

// pour chaque users on vérifie si le vip_status est égale à 1 ou 2 et que vip_date était ya un an alors on change le vip_status à 0 et on met vip_date à null

foreach ($users as $user) {
    if ($user["vip_status"] == 1 || $user["vip_status"] == 2 && $user["vip_type"] == 1){
        $userId = $user["id"];
        try {
            $date = new DateTime($users["vip_date"]);
            $date->modify('+1 year');
        } catch (Exception $e) {
            echo 'Erreur : ', $e->getMessage();
        }
        $now = new DateTime();
        if ($date < $now) {
            $db = connectDB();
            $querypreprared = $db->prepare("UPDATE user SET grade=:grade, vip_status = :vip_status, vip_date =:vip_date, vip_type= :vip_type WHERE id = :userId");
            $querypreprared->execute([
                'grade' => 1,
                'vip_status' => 0,
                'vip_date' => null,
                'userId' => $userId,
                'vip_type' => null
            ]);
        

        }
    }
    else if ($user["vip_status"] == 1 || $user["vip_status"] == 2 && $user["vip_type"] == 0){
        $userId = $user["id"];
        try {
            $date = new DateTime($users["vip_date"]);
            $date->modify('+1 month');
        } catch (Exception $e) {
            echo 'Erreur : ', $e->getMessage();
        }
        $now = new DateTime();
        if ($date < $now) {
            $db = connectDB();
            $querypreprared = $db->prepare("UPDATE user SET grade=:grade, vip_status = :vip_status, vip_date =:vip_date, vip_type= :vip_type WHERE id = :userId");
            $querypreprared->execute([
                'grade' => 1,
                'vip_status' => 0,
                'vip_date' => null,
                'userId' => $userId,
                'vip_type' => null
            ]);
        

        }
    }
}