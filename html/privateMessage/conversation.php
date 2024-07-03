<?php

$pageTitle = "Conversation";

require '../vendor/autoload.php';
require '../includes/header.php';
if (!isConnected()){
    $_SESSION['isConnected'] = "Vous devez être connecté pour accéder à cette page";
    header("Location: /");
 
    die();
}
$id = $_GET['id'];

use GuzzleHttp\Client;

$client = new Client();
$response = $client->get('https://pcs-all.online:8000/private-message/' . $id);
$conversation = json_decode($response->getBody()->getContents(), true)['privateMessage'];



if (isset($_POST["submit"])) {

    $message = $_POST["message"];

    try {
        $client = new Client([
            'base_uri' => 'https://pcs-all.online:8000'
        ]);
        $test = [
            'content' => $message,
            'userId' => $_SESSION['userId'],
            'id' => $id
        ];

        $response = $client->post('/private-message', [
            'json' => $test
        ]);

        $body = json_decode($response->getBody()->getContents(), true);
        if ($body['success']) {
            unset($_POST);
        }
    } catch (Exception $e) {
        echo $e->getMessage();
        die();
    }
}


//pour toutes les conversations afficher dans l'odre des dates les "content" et "message_date"

?>
<link rel="stylesheet" href="../css/privatemessage.css">
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Conversation</h3>
    </div>
    <div class="panel-body">
        <?php
        foreach ($conversation as $message) {
            //si l'id de l'utilisateur est égal à l'id de l'utilisateur qui a envoyé le message
            if ($_SESSION['userId'] == $message['from_user_id']) {
        ?>
                <div class="alert alert-info">
                    <div><strong><?php echo $message['content']; ?></strong>
                    </div>
                    <div class="date">
                        <p><?php $date = new DateTime($message['message_date']);
                            echo $date->format('d/m/y à H:i'); ?></p>
                    </div>
                </div>

            <?php } else { ?>
                <div class="alert alert-success">
                    <div><strong><?php echo $message['content']; ?></strong>
                    </div>
                    <div class="date">
                        <p><?php $date = new DateTime($message['message_date']);
                            echo $date->format('d/m/y à H:i'); ?></p>
                    </div>
                </div>
        <?php
            }
        }
        ?>
    </div>
    <form action="" method="post">
        <div class="input-group">
            <input type="text" name="message" class="form-control" placeholder="Enter Message">
            <input type="hidden" name="conversation_id" value="<?php echo $id; ?>">
            <span class="input-group-btn">
                <button class="btn btn-success" name="submit" type="submit">Send</button>
            </span>
        </div>
    </form>
</div>
<script>



</script>