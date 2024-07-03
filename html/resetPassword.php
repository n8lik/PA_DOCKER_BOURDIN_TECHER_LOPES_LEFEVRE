<?php
require '/var/www/html/includes/header.php';
require "vendor/autoload.php";

use GuzzleHttp\Client;

if (!isset($_GET['email']) || !isset($_GET['token'])) {
    echo "manque qqch";
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$client = new Client([
    'base_uri' => 'https://pcs-all.online:8000'
]);
$data=[
    'email' => $_GET['email'],
    'token' => $_GET['token']
];

$response = $client->post('/resetPasswordVerifyUser', [
    'json' => $data
]);
$body = json_decode($response->getBody()->getContents(), true);
var_dump($body);

if ($body['success']) {
    if (isset($_POST['resetPassword'])) {
        $password = $_POST['password'];
        $passwordconfirm = $_POST['passwordconfirm'];

        if (empty($password) || empty($passwordconfirm)) {
            $_SESSION['ERRORS']['emptyfields'] = "Veuillez remplir tous les champs";
        } else if ($password !== $passwordconfirm) {
            $_SESSION['ERRORS']['passwordconfirm'] = "Les mots de passe ne correspondent pas";
        }else if(strlen($password) < 8){
            $_SESSION['ERRORS']['password'] = "Le mot de passe doit contenir au moins 8 caractères";
        }else if(!preg_match('/[A-Z]/', $password)){
            $_SESSION['ERRORS']['password'] = "Le mot de passe doit contenir au moins une lettre majuscule";
        }else if(!preg_match('/[a-z]/', $password)){
            $_SESSION['ERRORS']['password'] = "Le mot de passe doit contenir au moins une lettre minuscule";
        }else if(!preg_match('/[0-9]/', $password)){
            $_SESSION['ERRORS']['password'] = "Le mot de passe doit contenir au moins un chiffre";
        } else {
            $client = new Client([
                'base_uri' => 'https://pcs-all.online:8000'
            ]);
            $data=[
                'email' => $_GET['email'],
                'password' => $password
            ];
            $response = $client->post('/resetPassword', [
                'json' => $data
            ]);
            $body = json_decode($response->getBody()->getContents(), true);

            if ($body['success']) {
                $_SESSION['SUCCESS']['password'] = "Votre mot de passe a été réinitialisé avec succès";
                header('Location: /login.php');
                exit();
            } else {
                $_SESSION['ERRORS']['password'] = $body['message'];
            }
        }
    }
?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center mb-4">Réinitialiser votre mot de passe</h1>
                <form action="" method="POST">
                    <div class="mb-3">
                        <?php
                        // Si une erreur existe, on l'affiche 
                        if (isset($_SESSION['ERRORS']['emptyfields'])) {
                        ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $_SESSION['ERRORS']['emptyfields']; ?>
                            </div>
                        <?php
                            unset($_SESSION['ERRORS']['emptyfields']);
                        }
                        if (isset($_SESSION['ERRORS']['password'])) {
                        ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $_SESSION['ERRORS']['password']; ?>
                            </div>
                        <?php
                            unset($_SESSION['ERRORS']['password']);
                        }
                        if (isset($_SESSION['ERRORS']['passwordconfirm'])) {
                        ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $_SESSION['ERRORS']['passwordconfirm']; ?>
                            </div>
                        <?php
                            unset($_SESSION['ERRORS']['passwordconfirm']);
                        }if (isset($_SESSION['ERRORS']['password'])) {
                        ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $_SESSION['ERRORS']['password']; ?>
                            </div>
                        <?php
                            unset($_SESSION['ERRORS']['password']);
                        }
                        ?>
                        <label for="signin-email" class="form-label">Nouveau mot de passe</label>
                        <input type="password" class="form-control" id="signin-email" name="password" placeholder="Mot de passe" required>
                    </div>
                    <div class="mb-3">
                        <label for="signin-email" class="form-label">Confirmer le mot de passe</label>
                        <input type="password" class="form-control" id="signin-email" name="passwordconfirm" placeholder="Confirmer le mot de passe" required>
                    </div>
                    <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">
                    <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
                    <button type="submit" class="btn btn-primary" name="resetPassword">Réinitialiser</button>
                </form>
            </div>
        </div>
    </div>
<?php
} else {
    
    header('Location: /login');
    exit();
}

include 'includes/footer.php';

?>