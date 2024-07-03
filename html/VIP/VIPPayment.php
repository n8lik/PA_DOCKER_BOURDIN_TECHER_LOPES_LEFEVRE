<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require '../vendor/autoload.php';
require '../includes/functions/functions.php';
require '../reservation/secrets.php';
use GuzzleHttp\Client;
session_start();
/* if (!isConnected()){
    $_SESSION['isConnected'] = "Vous devez être connecté pour accéder à cette page";
    header("Location: /");
    die();
} */
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

if ($users["grade"] == 2 && $_POST["plan"] == 1) {
    $_SESSION["error"] = "Vous êtes déjà abonné à ce plan";
    header('location: /VIP/VIP');
    die();

}
if ($users["grade"] == 3 && $_POST["plan"] == 1) {
    $_SESSION["error"] = "Vous êtes déjà abonné à un plan, veuillez attendre la date d'expiration de votre abonnement pour en choisir un autre";
    header('location: /VIP/VIP');
    die();

}
if ($users["grade"] == 2 && $_POST["plan"] == 2) {
    $_SESSION["error"] = "Vous êtes déjà abonné à un plan, veuillez attendre la date d'expiration de votre abonnement pour en choisir un autre";
    header('location: /VIP/VIP');
    die();

}
if ($users["grade"] == 3 && $_POST["plan"] == 2) {
    $_SESSION["error"] = "Vous êtes déjà abonné à ce plan";
    header('location: /VIP/VIP');
    die();
}

$_SESSION["PaymentIntent"] = $_POST;
if ($_POST['plan'] == 1) {
    $plan = 'Abonnement Back Packer mensuel';
    \Stripe\Stripe::setApiKey($stripeSecretTest);
    $product_id = 'prod_QOw1DNZNKKGQII';	
    try {
        // Récupérer les prix associés au produit
        $prices = \Stripe\Price::all([
            'product' => $product_id,
            'active' => true,
        'type' => 'recurring',
    ]);
    
        // Vérifier si des prix existent pour ce produit
        if (empty($prices->data)) {
            throw new Exception("Aucun prix trouvé pour le produit ID : $product_id");
        }
    
        // Utiliser le premier prix trouvé
        $price_id = $prices->data[0]->id;
    
        // Créez une session de paiement
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                
                'price' => $price_id,
                'quantity' => 1,
            ]],
            
            'client_reference_id' => $userToken,
            'mode' => 'subscription',
            'success_url' => 'https://pcs-all.online/VIP/success',
            'cancel_url' => 'https://pcs-all.online/VIP/cancel',
        ]);
    
        header ("Location: " . $session->url);
        
    } catch (Exception $e) {
        echo 'Erreur : ' . $e->getMessage();
    }

}
if ($_POST['plan'] == 2) {
    $plan = 'Abonnement  Back Packer Annuel';
    \Stripe\Stripe::setApiKey($stripeSecretTest);
    $product_id = 'prod_QOw0HPWxtrDkgJ';	
    try {
        // Récupérer les prix associés au produit
        $prices = \Stripe\Price::all([
            'product' => $product_id,
            'active' => true,
        'type' => 'recurring',
    ]);
    
        // Vérifier si des prix existent pour ce produit
        if (empty($prices->data)) {
            throw new Exception("Aucun prix trouvé pour le produit ID : $product_id");
        }
    
        // Utiliser le premier prix trouvé
        $price_id = $prices->data[0]->id;
    
        // Créez une session de paiement
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                
                'price' => $price_id,
                'quantity' => 1,
            ]],
            
            'client_reference_id' => $userToken,
            'mode' => 'subscription',
            'success_url' => 'https://pcs-all.online/VIP/success',
            'cancel_url' => 'https://pcs-all.online/VIP/cancel',
        ]);
    
        header ("Location: " . $session->url);
        
    } catch (Exception $e) {
        echo 'Erreur : ' . $e->getMessage();
    }


}
if ($_POST['plan'] == 3) {
    $plan = 'Abonnement Explorateur Mensuel';
    \Stripe\Stripe::setApiKey($stripeSecretTest);
    $product_id = 'prod_QOw1DNZNKKGQII';	
    try {
        // Récupérer les prix associés au produit
        $prices = \Stripe\Price::all([
            'product' => $product_id,
            'active' => true,
        'type' => 'recurring',
    ]);
    
        // Vérifier si des prix existent pour ce produit
        if (empty($prices->data)) {
            throw new Exception("Aucun prix trouvé pour le produit ID : $product_id");
        }
    
        // Utiliser le premier prix trouvé
        $price_id = $prices->data[0]->id;
    
        // Créez une session de paiement
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                
                'price' => $price_id,
                'quantity' => 1,
            ]],
            
            'client_reference_id' => $userToken,
            'mode' => 'subscription',
            'success_url' => 'https://pcs-all.online/VIP/success',
            'cancel_url' => 'https://pcs-all.online/VIP/cancel',
        ]);
    
        header ("Location: " . $session->url);
        
    } catch (Exception $e) {
        echo 'Erreur : ' . $e->getMessage();
    }

}
if ($_POST['plan'] == 4) {
    $plan = 'Abonnement Explorateur Annuel';
    \Stripe\Stripe::setApiKey($stripeSecretTest);
    $product_id = 'prod_QOw0HPWxtrDkgJ';	
    try {
        // Récupérer les prix associés au produit
        $prices = \Stripe\Price::all([
            'product' => $product_id,
            'active' => true,
        'type' => 'recurring',
    ]);
    
        // Vérifier si des prix existent pour ce produit
        if (empty($prices->data)) {
            throw new Exception("Aucun prix trouvé pour le produit ID : $product_id");
        }
    
        // Utiliser le premier prix trouvé
        $price_id = $prices->data[0]->id;
    
        // Créez une session de paiement
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                
                'price' => $price_id,
                'quantity' => 1,
            ]],
            
            'client_reference_id' => $userToken,
            'mode' => 'subscription',
            'success_url' => 'https://pcs-all.online/VIP/success',
            'cancel_url' => 'https://pcs-all.online/VIP/cancel',
        ]);
    
        header ("Location: " . $session->url);
        
    } catch (Exception $e) {
        echo 'Erreur : ' . $e->getMessage();
    }

}



