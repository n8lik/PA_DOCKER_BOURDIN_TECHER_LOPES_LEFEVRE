<?php
require "generatePDFformail.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$mail = new PHPMailer(true);
    try {
        // Paramètres du serveur
        $mail->isSMTP();
        $mail->Host = 'localhost'; // Assurez-vous que Postfix est configuré pour écouter sur localhost
        $mail->SMTPAuth = false;   // Désactiver l'authentification SMTP
        $mail->Port = 25;          // Port SMTP de Postfix

        // Expéditeur
        $mail->setFrom('no-reply@pcs-all.online', 'PCS-ALL-RESERVATION');

        // Destinataire
        $mail->addAddress($users["email"]);

        // Contenu
        $mail->isHTML(true);
        $mail->CharSet = "UTF-8";
        $mail->Subject = 'Facture de la réservation '.$bookingId;
        $mail->Body    = '
    <html>
    <meta charset="UTF-8">
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f4f4f4;
            }
            .container {
                width: 80%;
                margin: auto;
                padding: 20px;
                background-color: #ffffff;
                border: 1px solid #ddd;
                border-radius: 10px;
            }
            h1 {
                color: #4CAF50;
                text-align: center;
            }
            p {
                font-size: 16px;
                color: #333;
            }
            .footer {
                margin-top: 20px;
                text-align: center;
                font-size: 12px;
                color: #777;
            }
            .logo {
                text-align: left;
            }
        </style>
    </head>
    <body>
    <div class="logo">
        <img src="/assets/logos/darkLogo.png" alt="PCS-ALL">
    </div>
        <div class="container">
            <h2>Bonjour,</h1>
            <p>Veuillez trouver ci-joint le PDF que vous avez demandé.</p>
            <p>Nous espérons que ce document répondra à vos attentes.</p>
            <p>Si vous avez des questions, n\'hésitez pas à nous contacter.</p>
            <div class="footer">
                <p>Cordialement,<br>PCS-ALL</p>
            </div>
        </div>
    </body>
    </html>';
        $mail->AltBody = 'Bonjour,
            Veuillez trouver ci-joint le PDF que vous avez demandé.
            Nous espérons que ce document répondra à vos attentes.
            Si vous avez des questions, n\'hésitez pas à nous contacter.';
        $mail->addAttachment($filePath);
        $mail->send();

        unlink($filePath);



        
        
    }
    catch (Exception $e) {
        echo "L'envoi de l'email a échoué. Erreur: {$mail->ErrorInfo}";
    }
    header("Location: /reservation/booking?id=".$housing["id"]."&type=$type");