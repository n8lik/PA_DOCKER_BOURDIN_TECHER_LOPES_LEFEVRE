<?php
session_start();
require "functions/functions.php";
require '../vendor/autoload.php';

use GuzzleHttp\Client;

if (isset($_POST['loginsubmit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $client = new Client([
            'base_uri' => 'http://api'
        ]);
        $test = [
            'email' => $email,
            'password' => $password

        ];

        $response = $client->post('/login', [
            'json' => $test

        ]);

        $body = json_decode($response->getBody()->getContents(), true);
        
        if ($body['success'] == true){

            $_SESSION['token'] = $body['token'];
            $_SESSION['grade'] = $body['grade'];
            $_SESSION['userId'] = $body['id'];
            header('Location: /');
        } else {
            $_SESSION['ERRORS']['nouser'] = $body['error'];
            header('Location: /login.php');
        }
    } catch (Exception $e) {
        echo $e->getMessage();
        die();
    }
}
