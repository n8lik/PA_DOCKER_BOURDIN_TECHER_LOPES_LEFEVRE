<?php
session_start();
require "../vendor/autoload.php";
use GuzzleHttp\Client;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


//Affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isConnected()){
    $_SESSION['isConnected'] = "Vous devez être connecté pour accéder à cette page";
    header("Location: /");
 
    die();
}
//####################Modification en bdd################
$client = new Client([
    'base_uri' => 'https://pcs-all.online:8000/',
    'timeout'  => 2.0,
]);
$response = $client->delete('deleteUserById/'.$_SESSION['userId']);


//###################Envoyer un mail pour confirmer la suppression ###############
//Récupérer le mail
$client=new Client([
    'base_uri'=>'https://pcs-all.online:8000/'
]);

$response=$client->get('users/'.$_SESSION['userId']);
$user=json_decode($response->getBody(),true)["users"];

$email=$user['email'];
$mail = new PHPMailer(true);

try {
    //Paramètres du serveur
    $mail->isSMTP();
    $mail->Host = 'localhost'; 
    $mail->SMTPAuth = false;
    $mail->Port = 25;          //Port SMTP de Postfix

    //Expéditeur
    $mail->setFrom('no-reply@pcs-all.online', 'PCS-ALL');

    //Destinataire
    $mail->addAddress($email);

    //Contenu
    $mail->isHTML(true);
    $mail->Subject = 'PCS - Suppression de votre compte';
    $mail->Body    = 'Bonjour, votre compte PCS-ALL a été supprimé. Si vous n\'êtes pas à l\'origine de cette action, veuillez contacter le support. <p>Si vous avez supprimé votre compte, vous pouvez ignorer cet email.</p>';
    $mail->send();
} catch (Exception $e) {
    echo "L'envoi de l'email a échoué. Erreur: {$mail->ErrorInfo}";
}

header('Location: ../logout.php');


