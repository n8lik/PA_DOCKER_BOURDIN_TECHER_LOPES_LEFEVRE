<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
if (!isConnected()){
    $_SESSION['isConnected()'] = "Vous devez être connecté pour accéder à cette page";
    header("Location: /");
    die();
}
$mail = new PHPMailer(true);

try {
    // Paramètres du serveur
    $mail->isSMTP();
    $mail->Host = 'localhost'; // Assurez-vous que Postfix est configuré pour écouter sur localhost
    $mail->SMTPAuth = false;   // Désactiver l'authentification SMTP
    $mail->Port = 25;          // Port SMTP de Postfix

    // Expéditeur
    $mail->setFrom('no-reply@pcs-all.online', 'PCS-ALL');

    // Destinataire
    $mail->addAddress('kyllian.lefevre@icloud.com');

    // Contenu
    $mail->isHTML(true);
    $mail->Subject = 'Sujet du Test';
    $mail->Body    = 'Ceci est un message de test';
    $mail->AltBody = 'Ceci est un message de test en texte brut';

    $mail->send();
    echo 'Email envoyé avec succès';
} catch (Exception $e) {
    echo "L'envoi de l'email a échoué. Erreur: {$mail->ErrorInfo}";
}
?>