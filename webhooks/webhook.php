<?php
header('Content-Type: text/plain; charset=UTF-8');
file_put_contents('webhook_debug.txt', "Webhook received\n", FILE_APPEND);

require 'vendor/autoload.php';
require 'secrets.php';
require 'functions.php';
use GuzzleHttp\Client;

session_start();
$stripe = new \Stripe\StripeClient($stripeSecretTest);
$endpoint_secret = 'whsec_opMUGhcnpJi0i1xTjXl0VCc3vcfaXh3n';

$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
$event = null;

try {
    $event = \Stripe\Webhook::constructEvent(
        $payload, $sig_header, $endpoint_secret
    );
} catch (\UnexpectedValueException $e) {
    file_put_contents('webhook_debug.txt', "Invalid payload\n", FILE_APPEND);
    http_response_code(400);
    exit();
} catch (\Stripe\Exception\SignatureVerificationException $e) {
    file_put_contents('webhook_debug.txt', "Invalid signature\n", FILE_APPEND);
    http_response_code(400);
    exit();
}

// Gérer l'événement
if ($event->type == 'checkout.session.completed') {
    $session = $event->data->object;

    // Récupérer l'ID de la subscription
    if (isset($session->subscription)) {
        $subscription_id = $session->subscription;
        $userToken = $session->client_reference_id;

        file_put_contents('webhook_debug.txt', "Subscription ID: $subscription_id, User Token: $userToken\n", FILE_APPEND);

        try {
            $client = new Client(['base_uri' => 'https://pcs-all.online:8000']);
            $response = $client->post('/webhook', [
                'json' => [
                    'userToken' => $userToken,
                    'subId' => $subscription_id
                ]
            ]);
            $booking = json_decode($response->getBody()->getContents(), true);
            
           
        } catch (Exception $e) {
            echo $e->getMessage();
            die();
        }  
    }
}

http_response_code(200);
?>