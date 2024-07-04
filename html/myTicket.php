<?php
require "includes/header.php";
require "vendor/autoload.php";

use GuzzleHttp\Client;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//Si l'utilisateur n'est pas connecté
if (!isConnected()){
    $_SESSION['isConnected'] = "Vous devez être connecté pour accéder à cette page";
    header("Location: /");
    die();
}
if (isset($_GET["id"])) {
    //Récupération du ticket
    $client = new Client();
    $response = $client->get('localhost:8000/getTicketById/' . $_GET["id"]);
    $ticket = json_decode($response->getBody()->getContents(), true)['ticket'];

    //Récupération des réponses
    try {
        $response = $client->get('localhost:8000/getTicketAnswers/' . $_GET["id"]);
        $answers = json_decode($response->getBody()->getContents(), true)['answers'];
    } catch (Exception $e) {
        $answers = [];
    }


    $id = $_GET["id"];
    //Si le ticket n'existe pas
    if ($ticket == null) {
        header("Location: /");
    } else {
        //Si l'utilisateur est connecté
        if (isset($_SESSION['userId'])) {
            //Si l'utilisateur est l'auteur du ticket
            if ($_SESSION['userId'] == $ticket["id_user"]) {
                //On affiche le ticket proprement
?>
                <div class="p-background">
                    <center>
                        <h1> Ticket #<?php echo $ticket["id"]; ?> - <?php echo $ticket["status"]; ?> </h1>
                        <h3><?php echo $ticket["subject"]; ?></h3>
                    </center>

                    <div class="ticket-content">
                        <div class="user-answer">
                            <p><?php echo $ticket["content"]; ?></p>
                            <p><?php $date = new DateTime($ticket['creation_date']);
                                echo $date->format('d/m/y à H:i'); ?></p>
                        </div>
                        <?php
                        foreach ($answers as $answer) {
                            $isUserAnswer = ($_SESSION['userId'] == $answer["id_user"]);
                        ?>
                            <div class="<?php echo $isUserAnswer ? 'user-answer' : 'other-answer'; ?>">
                                <p style="color:black; font-weight:bolder;"><?php echo $isUserAnswer ? "Vous:" : "Support:"; ?></p>
                                <p><?php echo $answer["content"]; ?></p>

                                <p><?php $date = new DateTime($answer['creation_date']);
                                    echo $date->format('d/m/y à H:i'); ?></p>
                            </div>
                        <?php
                        }
                        ?>
                    </div>

                    <?php
                    if (isset($_SESSION["ticketok"])) {
                    ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $_SESSION["ticketok"]; ?>
                        </div>
                    <?php
                        unset($_SESSION["ticketok"]);
                    }
                    if (isset($_SESSION["ticketerror"])) {
                    ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $_SESSION["ticketerror"]; ?>
                        </div>
                    <?php
                        unset($_SESSION["ticketerror"]);
                    }

                    if ($ticket["status"] == "En attente" || $ticket["status"] == "En cours") {?>
                        <form action="includes/support/tickets?id=answer" method="post" class="support-form" style="text-align: center;">
                            <div class="form-group" style="width:60% !important;">
                                <textarea class="form-control" id="message" name="message" style="height:20% !important;" required></textarea>
                                <input type="hidden" name="ticketId" value="<?php echo $ticket["id"]; ?>">
                                <input type="hidden" name="subject" value="<?php echo $ticket["subject"]; ?>">
                                <button type="submit" class="btn btn-primary" staticTotranslate="answer" >Répondre</button>
                            </div>
                        </form>
                        <form action="includes/support/tickets?id=close" method="post" class="support-form" style="text-align: center;">
                            <input type="hidden" name="ticketId" value="<?php echo $ticket["id"]; ?>">
                            <button type="submit" class="btn btn-danger" staticTotranslate="ticket_close">Clore mon ticket</button>
                        </form>
                    <?php } ?>
                </div>
<?php
            } else {
                header("Location: /profile.php");
            }
        } else {
            header("Location: index.php");
        }
    }
}



include "includes/footer.php";
?>