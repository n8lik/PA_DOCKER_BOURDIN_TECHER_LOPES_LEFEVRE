<?php require 'includes/header.php';
require 'vendor/autoload.php';

use GuzzleHttp\Client;

ini_set('display_errors', 'on');
error_reporting(E_ALL);

//stocker 2 tableau des messages en session
if (!isset($_SESSION["Usermessages"])) {
    $_SESSION["Usermessages"] = [];
}
if (!isset($_SESSION["Chatmessages"])) {
    $_SESSION["Chatmessages"] = [];
}

//si on a un retour du ticket, afficher
if (isset($_SESSION["ticketok"])) {
    echo '<div class="alert alert-success" role="alert" style="text-align:center !important" staticTotranslate="support_ticket_success">' . $_SESSION["ticketok"] . '</div>';
    unset($_SESSION["ticketok"]);
}
if (isset($_SESSION["ticketerror"])) {
    echo '<div class="alert alert-danger" role="alert" style="text-align:center !important" staticTotranslate="support_ticket_error">' . $_SESSION["ticketerror"] . '</div>';
    unset($_SESSION["ticketerror"]);
}

//si on a un retour POST du chatbot, l'ajouter au tableau des messages
if (isset($_POST['message'])) {
    $message = htmlspecialchars($_POST['message']);
    if (!empty($message)) {
        array_push($_SESSION["Usermessages"], $message);
    }
    try {
        $client = new Client([
            'base_uri' => 'https://pcs-all.online:8000'
        ]);
        $response = $client->get('/getChatbotAnswer/' . $message);
        $chatbotResponse = json_decode($response->getBody()->getContents(), true);
        array_push($_SESSION["Chatmessages"], $chatbotResponse['message']);
    } catch (Exception $e) {
        echo '<div class="alert alert-danger" role="alert" staticTotranslate="support_error_retrieval">Erreur lors de la récupération des informations</div>';
    }
    unset($_POST['message']);
}

//Switch pour ticket ou bot
if (isset($_GET['type'])) {
    $type = $_GET['type'];
    switch ($type) {
        case 'ticket':
            if (!isset($_SESSION['userId'])) {
?>
                <div class="container" style="margin-top: 5%;">
                    <div class="alert alert-danger" role="alert" style="text-align: center;" staticTotranslate="need_login">
                        Vous devez être connecté pour accéder à cette page.
                    </div>
                    <div class="alert alert-info" role="alert" style="text-align: center;">
                        <a href="login.php" staticTotranslate="login">Se connecter</a>
                    </div>
                </div>
            <?php
            } else {
                $idUser = $_SESSION['userId'];
                try {
                    $client = new Client();
                    $response = $client->get('https://pcs-all.online:8000/users/' . $idUser);
                    $user = json_decode($response->getBody(), true)['users'];
                } catch (Exception $e) {
                    echo '<div class="alert alert-danger" role="alert" staticTotranslate="support_error_retrieval">Erreur lors de la récupération des informations</div>';
                }
            ?>
                <div class="support-container">
                    <h2 staticTotranslate="support_create_ticket">Créer un ticket</h2>
                    <form action="/includes/support/tickets" method="post" class="support-form">
                        <label for="email" staticTotranslate="support_email">Votre adresse mail</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?php echo $user['email']; ?>" readonly>
                        <label for="subject" staticTotranslate="support_subject">Quel est le sujet de votre demande?</label>
                        <select name="subject" id="subject" class="form-control" required>
                            <option value="1" staticTotranslate="support_subject_login">Problème de connexion</option>
                            <option value="2" staticTotranslate="support_subject_payment">Problème de paiement</option>
                            <option value="3" staticTotranslate="support_subject_feature">Problème de fonctionnalité</option>
                            <option value="4" staticTotranslate="support_subject_other">Autre</option>
                        </select>

                        <label for="message" staticTotranslate="support_message">Entrez votre message</label>
                        <textarea name="message" id="message" class="form-control" required></textarea>
                        <button type="submit" class="btn btn-primary" staticTotranslate="send">Envoyer</button>
                    </form>
                </div>
            <?php
            }
            break;
        case 'chatbot':
            ?>
            <link rel="stylesheet" href="/css/chatbot.css">
            <div class="chatbot-container">
                <div class="chatbot">
                    <div class="chatbot-header">
                        <h2 staticTotranslate="chatbot">Chatbot</h2>
                    </div>
                    <div class="chatbot-body">
                        <div class="chatbot-message">
                            <p staticTotranslate="support_chatbot_intro">Bonjour, je suis un chatbot, comment puis-je vous aider?</p>
                        </div>
                        <?php
                        //Afficher en quinconce les messages de l'utilisateur et du chatbot
                        for ($i = 0; $i < count($_SESSION["Usermessages"]); $i++) {
                        ?>
                            <div class="user-message">
                                <p><?php echo $_SESSION["Usermessages"][$i]; ?></p>
                            </div>
                            <div class="chatbot-message">
                                <p><?php echo $_SESSION["Chatmessages"][$i]; ?></p>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <form action="" method="post">
                        <div class="chatbot-input">
                            <input type="text" placeholder="Votre message" name="message" staticTotranslate="support_message_placeholder">
                            <button staticTotranslate="support_send">Envoyer</button>
                        </div>
                    </form>
                </div>
            </div>
<?php

            break;
        default:
            header('Location: /');
            break;
    }
} else {
    require 'support_chatbot.php';
}
require 'includes/footer.php'; ?>
