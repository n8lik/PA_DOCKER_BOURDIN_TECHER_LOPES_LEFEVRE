<?php
require '../../vendor/autoload.php';
session_start();
use GuzzleHttp\Client;

//Si le formulaire est envoyé
if (isset($_POST['email']) && isset($_POST['subject']) && isset($_POST['message'])) {
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);
    //On envoie le ticket
    try {
        $client = new Client([
            'base_uri' => 'https://pcs-all.online:8000'
        ]);
        $ticket = [
            'userId' => $_SESSION['userId'],
            'subject' => $subject,
            'message' => $message
        ];
        $response = $client->post('/addTicket', [
            'json' => $ticket
        ]);
        $body = json_decode($response->getBody()->getContents(), true);

        var_dump($body);


        if ($body['success']) {
            $_SESSION["ticketok"] = "Votre ticket a bien été envoyé";
            header('Location: /support.php?type=ticket');
        } else {
            $_SESSION["ticketerror"] = "Une erreur est survenue";
            header('Location: /support.php?type=ticket');
        }
    } catch (Exception $e) {
        $_SESSION["ticketerror"] = "Une erreur est survenue";
        header('Location: /support.php?type=ticket');
    }
}

//Si une réponse a un ticket est envoyée en get
if ($_GET['id'] == "answer") {
    //Verifier que la reponse n'est pas vide
    if (!empty($_POST['message'])) {
        try{
            $client = new Client([
                'base_uri' => 'https://pcs-all.online:8000'
            ]);
            $answer = [
                'userId' => $_SESSION['userId'],
                'ticketId' => $_POST['ticketId'],
                'message' => $_POST['message']
            ];
            $response = $client->post('/addTicketAnswer', [
                'json' => $answer
            ]);
            $body = json_decode($response->getBody()->getContents(), true);
        } catch (Exception $e) {
            $_SESSION["ticketerror"] = "Une erreur est survenue";
            header('Location: /myTicket.php?id=' . $_POST['ticketId']);
        }
        $_SESSION["ticketok"] = "Votre réponse a bien été envoyée";
        header('Location: /myTicket.php?id=' . $_POST['ticketId']);
    } else {
        $_SESSION["ticketerror"] = "Veuillez remplir le message";
        //retour à la page précédente
        header('Location: /myTicket.php?id=' . $_POST['ticketId']);
    }
}

//Si on ferme un ticket
if ($_GET['id'] == "close") {
    try{
        $client = new Client([
            'base_uri' => 'https://pcs-all.online:8000'
        ]);
        $ticket = [
            'ticketId' => $_POST['ticketId'],
            'status' => 2
        ];
        $response = $client->post('/changeStatusTicket', [
            'json' => $ticket
        ]);
        $body = json_decode($response->getBody()->getContents(), true);
    } catch (Exception $e) {
        $_SESSION["ticketerror"] = "Une erreur est survenue";
        header('Location: /myTicket.php?id=' . $_POST['ticketId']);
    }
    $_SESSION["ticketok"] = "Le ticket a bien été fermé";
    header('Location: /myTicket.php?id=' . $_POST['ticketId']);
}
