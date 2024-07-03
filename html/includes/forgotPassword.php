<?php
require '/var/www/html/vendor/autoload.php';
require '/var/www/html/includes/functions/functions.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
$email=$_POST['email'];

//Vérifier si l'email existe
$conn=connectDB();
$req=$conn->prepare('SELECT * FROM user WHERE email=:email');
$req->execute(array(
    'email'=>$email
));
$user=$req->fetch();
if(!$user){
    echo 'Si cet email existe, un email de réinitialisation vous sera envoyé';
    exit();
}
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
    $token=bin2hex(random_bytes(30));
    //Ajout du token dans la base de données
    $req=$conn->prepare('UPDATE user SET pwd_token=:token WHERE email=:email');
    $req->execute(array(
        'token'=>$token,
        'email'=>$email
    ));

    //Contenu
    $mail->isHTML(true);
    $mail->Subject = 'PCS - Reinitialisation de votre mot de passe';
    $mail->Body    = 'Bonjour, cliquez sur ce lien pour réinitialiser votre mot de passe: <a href="https://pcs-all.online/resetPassword?email='.$email.'&token='.$token.'">Réinitialiser</a> <p>Si vous n\'avez pas demandé de réinitialisation de mot de passe, ignorez cet email.</p>';
    $mail->send();
    echo 'Si cet email existe, un email de réinitialisation vous sera envoyé';
} catch (Exception $e) {
    echo "L'envoi de l'email a échoué. Erreur: {$mail->ErrorInfo}";
}
?>