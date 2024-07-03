<?php
session_start();
require "functions/functions.php";
require '../vendor/autoload.php';

use GuzzleHttp\Client;






if (isset($_POST['submit'])) {
    $grade = $_POST['grade'];
    $pseudo = $_POST['username'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['passwordConfirm'];
    $phone_number = $_POST['phone_number'];
    $extension = $_POST['extension'];
    $country = $_POST['country'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $postal_code = $_POST['postal_code'];

    try {
        $client = new Client([
            'base_uri' => 'https://pcs-all.online:8000'
        ]);
        $test = [
            'email' => $email,
            'password' => $password,
            'passwordConfirm' => $passwordConfirm,
            'g-recaptcha-response' => $_POST['g-recaptcha-response'],
            'grade' => $grade,
            'username' => $pseudo,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'phone_number' => $phone_number,
            'extension' => $extension,
            'country' => $country,
            'address' => $address,
            'city' => $city,
            'postal_code' => $postal_code

        ];
        $response = $client->post('/register', [
            'json' => $test

        ]);

        $body = json_decode($response->getBody()->getContents(), true);

        if ($body['success'] == true) {
            $_SESSION['token'] = $body['token'];
            $_SESSION['grade'] = $body['grade'];
            $_SESSION['userId'] = $body['id'];
            header('Location: /');
        } else {
            $_SESSION['listOfErrors'] = $body['error'];
            header('Location: /register.php');
        }
    } catch (Exception $e) {

        echo $e->getMessage();
        die();
    }
}
?>