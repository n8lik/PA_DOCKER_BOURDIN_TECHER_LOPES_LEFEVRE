<?php

require "includes/header.php";
require "vendor/autoload.php";

use GuzzleHttp\Client;
if (!isConnected()){
    $_SESSION['isConnected'] = "Vous devez être connecté pour accéder à cette page";
    header("Location: /");
    die();
}
$idUser = $_SESSION['userId'];
//Réception des informations de l'utilisateur
try {
    $client = new Client();
    $response = $client->get('https://pcs-all.online:8000/users/' . $idUser);
    $user = json_decode($response->getBody(), true)['users'];
} catch (Exception $e) {
    echo '<div class="alert alert-danger" role="alert" staticTotranslate="profile_error_retrieving_info">Erreur lors de la récupération des informations</div>';
}

//Récéption de la photo de profil
try {
    $client = new Client();
    $response = $client->get('https://pcs-all.online:8000/getPpById/' . $idUser);
    $userpdp = json_decode($response->getBody(), true)["users"];
} catch (Exception $e) {
    echo '<div class="alert alert-danger" role="alert" staticTotranslate="profile_error_retrieving_photo">Erreur lors de la récupération de la photo de profil</div>';
}

?>

<div class="p-background">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link p-nav active" id="InfosPerso-tab" data-bs-toggle="tab" href="#InfosPerso" role="tab" aria-controls="InfosPerso" aria-selected="true" staticTotranslate="profile_personal_info_tab">Informations personnelles</a>
            <a class="nav-item nav-link p-nav" id="Security-tab" data-bs-toggle="tab" href="#Security" role="tab" aria-controls="Security" aria-selected="false" staticTotranslate="profile_security_tab">Connexion & sécurité</a>
            <a class="nav-item nav-link p-nav" id="Payment-tab" data-bs-toggle="tab" href="#Payment" role="tab" aria-controls="Payment" aria-selected="false" staticTotranslate="profile_payment_tab">Moyens de paiement</a>
            <a class="nav-item nav-link p-nav" id="Notifications-tab" data-bs-toggle="tab" href="#Notifications" role="tab" aria-controls="Notifications" aria-selected="false" staticTotranslate="profile_notifications_tab">Notifications</a>
            <a class="nav-item nav-link p-nav" id="Tickets-tab" data-bs-toggle="tab" href="#Tickets" role="tab" aria-controls="Tickets" aria-selected="false" staticTotranslate="profile_tickets_tab">Tickets</a>
            <?php if ($user['grade']== 1 || $user['grade']== 2 || $user['grade']== 3){
            echo'<a class="nav-item nav-link p-nav" id="VIP-tab" data-bs-toggle="tab" href="#VIP" role="tab" aria-controls="VIP" aria-selected="false" staticTotranslate="profile_vip_tab">VIP</a>';
            }?>

        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="InfosPerso" role="tabpanel" aria-labelledby="InfosPerso-tab">
            <center>
                <h2 staticTotranslate="profile_personal_info_title">Mes informations personnelles</h2>
                <?php
                //On affiche le résultat si changement a eu lieu
                if (isset($_SESSION['profileUpdateOk'])) {
                    echo '<div class="alert alert-success" role="alert">' . $_SESSION['profileUpdateOk'] . '</div>';
                    unset($_SESSION['profileUpdateOk']);
                } elseif (isset($_SESSION['profileUpdateError'])) {
                    echo '<div class="alert alert-danger" role="alert">' . $_SESSION['profileUpdateError'] . '</div>';
                    unset($_SESSION['profileUpdateError']);
                }
                ?>
                <?php
                if (isset($_SESSION['passwordUpdateOk'])) {
                    echo '<div class="alert alert-success" role="alert">' . $_SESSION['passwordUpdateOk'] . '</div>';
                    unset($_SESSION['passwordUpdateOk']);
                } elseif (isset($_SESSION['passwordUpdateError'])) {
                    echo '<div class="alert alert-danger" role="alert">' . $_SESSION['passwordUpdateError'] . '</div>';
                    unset($_SESSION['passwordUpdateError']);
                }
                switch ($user["grade"]) {
                    case "1":
                        $grade = "Free";
                        break;
                    case "2":
                        $grade = "Bag Packer";
                        break;
                    case "3":
                        $grade = "Explorator";
                        break;
                    case "4":
                        $grade = "Bailleur";
                        break;
                    case "5":
                        $grade = "Prestataire";
                        break;
                    case "6":
                        $grade = "Admin";
                        break;
                    }
                ?>
                <img src="<?= $userpdp[0]; ?>" alt="Photo de profil" style="width: 200px; height: 200px; border-radius: 50%; margin-bottom: 20px;" staticTotranslate="profile_photo">
                <form action="includes/updateUser" method="post" class="support-form" enctype="multipart/form-data">
                    <label for="pp" staticTotranslate="profile_change_photo">Changer de photo de profil</label>
                    <input type="file" name="file" id="pp" class="form-control" style="width: 80% !important;">
                    <label for="pseudo" staticTotranslate="profile_pseudo">Votre pseudo</label>
                    <input type="pseudo" name="pseudo" id="pseudo" class="form-control" value="<?php echo $user['pseudo']; ?>" style="width: 80% !important;">
                    <label for="email" staticTotranslate="profile_email">Votre adresse mail</label>
                    <input type="email" name="email" id="email" class="form-control" value="<?php echo $user['email']; ?>" style="width: 80% !important;" readonly>
                    
                    <label for="grade" staticTotranslate="profile_account_type">Type de compte :</label>
                    <input type="grade" name="grade" id="grade" class="form-control" value="<?php echo $grade; ?>" style="width: 80% !important;" readonly>
                    <label for="firstname" staticTotranslate="profile_firstname">Votre prénom</label>
                    <input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo $user['firstname']; ?>" style="width: 80% !important;" required>
                    <label for="lastname" staticTotranslate="profile_lastname">Votre nom</label>
                    <input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo $user['lastname']; ?>" style="width: 80% !important;" required>
                    <label for="phone" staticTotranslate="profile_phone">Votre numéro de téléphone</label>
                    <div style="width: 80% !important; display: flex;">
                        <select class="form-control" id="extension" name="extension" style="flex-grow: 1;">
                            <option value="+33" staticTotranslate="profile_extension_france">+33 France</option>
                            <option value="+1" staticTotranslate="profile_extension_usa_canada">+1 USA/Canada</option>
                            <option value="+44" staticTotranslate="profile_extension_uk">+44 Royaume-Uni</option>
                            <option value="+49" staticTotranslate="profile_extension_germany">+49 Allemagne</option>
                            <option value="+39" staticTotranslate="profile_extension_italy">+39 Italie</option>
                            <option value="+91" staticTotranslate="profile_extension_india">+91 Inde</option>
                        </select>
                        <input type="text" name="phone" id="phone" class="form-control" value="<?php echo $user['phone_number']; ?>" required style="flex-grow: 3; margin-left: 10px;">
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary" style="margin-top:1em" staticTotranslate="profile_update">Modifier</button>
                </form>
            </center>
        </div>
        <div class="tab-pane fade" id="Security" role="tabpanel" aria-labelledby="Security-tab">
            <center>
                <h2 style="margin-top:1em" staticTotranslate="profile_security_title">Connexion & sécurité</h2>

                <h3 style="margin-top:1em" staticTotranslate="profile_change_password">Changer de mot de passe</h3>
                <form action="includes/updateUser" method="post" class="support-form">
                    <label for="oldPassword" staticTotranslate="profile_old_password">Ancien mot de passe</label>
                    <input type="password" name="oldPassword" id="oldPassword" class="form-control" style="width: 80% !important;" required>
                    <label for="newPassword" staticTotranslate="profile_new_password">Nouveau mot de passe</label>
                    <input type="password" name="newPassword" id="newPassword" class="form-control" style="width: 80% !important;" required>
                    <label for="confirmPassword" staticTotranslate="profile_confirm_password">Confirmer le mot de passe</label>
                    <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" style="width: 80% !important;" required>
                    <button type="submit" name="submit-password" class="btn btn-primary" style="margin-top:1em" staticTotranslate="profile_update">Modifier</button>
                </form>

                <hr>

                <h3 style="margin-top:1em" staticTotranslate="profile_delete_account_title">Supprimer le compte</h3>
                <p style="color:red; width: 80% !important;" staticTotranslate="profile_delete_account_warning">Attention, cette action est irréversible.<br>Suite à la suppression de votre compte, vous perdrez l'ensemble de vos données et ne pourrez plus accéder à votre compte.<br>Votre compte sera supprimé dans un délai de 30 jours après la demande de suppression.</p>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal" style="margin-top:1em" staticTotranslate="profile_delete_account_button">
                    Supprimer le compte
                </button>

                <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteAccountModalLabel" staticTotranslate="profile_delete_account_modal_title">Suppression du compte</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p staticTotranslate="profile_delete_account_modal_text">Êtes-vous sûr de vouloir supprimer votre compte ?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" staticTotranslate="profile_delete_account_modal_cancel">Annuler</button>
                                <a href="includes/deleteUser" class="btn btn-danger" staticTotranslate="profile_delete_account_modal_confirm">Supprimer</a>
                            </div>
                        </div>
                    </div>
                </div>


            </center>
        </div>


        <div class="tab-pane fade" id="Payment" role="tabpanel" aria-labelledby="Payment-tab">
            <center>
                <h2 style="margin-top:1em" staticTotranslate="profile_payment_title">Moyen de paiement</h2>
            </center>
        </div>



        <div class="tab-pane fade" id="Notifications" role="tabpanel" aria-labelledby="Notifications-tab">
            <center>
                <h2 style="margin-top:1em" staticTotranslate="profile_notifications_title">Notifications & préférences</h2>
                <div class="theme-toggle">
                    <button id="theme-toggle-button" staticTotranslate="profile_change_theme">Changer de thème</button>
                </div>
            </center>
        </div>


        <div class="tab-pane fade" id="Tickets" role="tabpanel" aria-labelledby="Tickets-tab">
            <center>
                <h2 style="margin-top:1em" staticTotranslate="profile_tickets_title">Mes tickets</h2>
                <table class="table table-hover" style="color:var(--text-color)!important;">
                    <thead>
                        <tr>
                            <th scope="col" staticTotranslate="profile_ticket_id">ID</th>
                            <th scope="col" staticTotranslate="profile_ticket_subject">Sujet</th>
                            <th scope="col" staticTotranslate="profile_ticket_date">Date</th>
                            <th scope="col" staticTotranslate="profile_ticket_status">Statut</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //Appel API pour récupérer les tickets
                        try {
                            $client = new Client();
                            $response = $client->get('https://pcs-all.online:8000/getTicketsByUserId/' . $idUser);
                            $tickets = json_decode($response->getBody(), true)['tickets'];
                        } catch (Exception $e) {
                            echo '<div class="alert alert-danger" role="alert" staticTotranslate="profile_error_retrieving_tickets">Erreur lors de la récupération des tickets</div>';
                        }
                        foreach ($tickets as $ticket) {
                            echo '<tr>';
                            echo '<th scope="row">' . $ticket['id'] . '</th>';
                            echo '<td>' . $ticket['subject'] . '</td>';
                            $date = new DateTime($ticket['creation_date']);
                            echo '<td>' . $date->format('d/m/y à H:i') . '</td>';
                            echo '<td>' . $ticket['status'] . '</td>';
                            echo '<td><a href="myTicket?id=' . $ticket['id'] . '" class="btn btn-outline-secondary" staticTotranslate="profile_view">Voir</a></td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </center>
        </div>

        <div class="tab-pane fade" id="VIP" role="tabpanel" aria-labelledby="VIP-tab">
        <?php 
        $userToken = $_SESSION['token'];
        try {
        $client = new Client([
            'base_uri' => 'https://pcs-all.online:8000'
        ]);
        $response = $client->get('/usersbytoken/' . $userToken);
        $body = json_decode($response->getBody()->getContents(), true);
        $users = $body["users"];
    } catch (Exception $e) {
        $users = [];
    }
?>

<link href = "/css/VIP.css" rel="stylesheet">
<div class="container mt-5">
    
    <?php 
    if ($users["grade"] == 1){
        echo '<div class="alert alert-primary" role="alert" staticTotranslate="profile_free_plan">Vous êtes actuellement abonné au plan Free</div>';
    }else if ($users["grade"] == 2){
        echo '<div class="alert alert-primary" role="alert" staticTotranslate="profile_bag_packer_plan">Vous êtes actuellement abonné au plan Bag Packer</div>';
    }else if ($users["grade"] == 3){
        echo '<div class="alert alert-primary" role="alert" staticTotranslate="profile_explorator_plan">Vous êtes actuellement abonné au plan Explorator</div>';
    }

    try {
        $date = new DateTime($users["vip_date"]);
        $date->modify('+1 year');
        $date = $date->format('d/m/Y');
    
    } catch (Exception $e) {
        echo 'Erreur : ', $e->getMessage();
    }
    if($users["vip_status"]==2){
        echo '<div class="alert alert-primary" role="alert" staticTotranslate="profile_vip_status_stopped">Votre abonnement a bien été arrêté. Vous pouvez en profiter jusqu\'à '. $date.' </div>';
    }
    
    if (isset($_SESSION["success"])){
        echo '<div class="alert alert-success" role="alert">'.$_SESSION["success"].'</div>';
        unset($_SESSION["success"]);
    } ?>
    <?php if (isset($_SESSION["error"])){
        echo '<div class="alert alert-danger" role="alert">'.$_SESSION["error"].'</div>';
        unset($_SESSION["error"]);
    } ?>
    <div class="table-responsive">
        <table class="table table-bordered table-custom">
            <thead>
                <tr>
                    <th></th>
                    <th>
                        <img src="/assets/img/VIP/free.png" alt="Free" class="icon"><br>
                        <p class="plan-title" staticTotranslate="profile_plan_free">Free</p>
                        <p staticTotranslate="profile_free">Gratuit</p>
                    </th>
                    <th>
                        <img src="/assets/img/VIP/backpacker.png" alt="Bag Packer" class="icon"><br>
                        <p class="plan-title" staticTotranslate="profile_plan_bag_packer">Bag Packer</p>
                        <?php $priceBag = 113;?>
                        <p staticTotranslate="profile_price_bag_packer">9,90€/mois ou 113€/an</p>
                        
                    </th>
                    <th>
                        <img src="/assets/img/VIP/explorateur.png" alt="Explorator" class="icon"><br>
                        <p class="plan-title" staticTotranslate="profile_plan_explorator">Explorator</p>
                        <?php if ($users["grade"]!=3){
                            $priceExplo = 220;?>
                        <p staticTotranslate="profile_price_explorator">19€/mois ou 220€/an</p>
                        <?php  }else if($users["grade"]==3){
                            $priceExplo = 200;?>
                        <p staticTotranslate="profile_price_explorator_renewal">19€/mois ou 200€/an</p>
                        <?php }?> 
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td staticTotranslate="profile_ads">Présence de publicités dans le contenu consulté</td>
                    <td class="check-icon">✔</td>
                    <td class="cross-icon">✘</td>
                    <td class="cross-icon">✘</td>
                </tr>
                <tr>
                    <td staticTotranslate="profile_comments">Commenter, publier des avis</td>
                    <td class="cross-icon">✘</td>
                    <td class="check-icon">✔</td>
                    <td class="check-icon">✔</td>
                </tr>
                <tr>
                    <td staticTotranslate="profile_discount">Réduction permanente de 5% sur les prestations</td>
                    <td class="cross-icon">✘</td>
                    <td class="check-icon">✔</td>
                    <td class="check-icon">✔</td>
                </tr>
                <tr>
                    <td staticTotranslate="profile_free_services">Prestations offertes</td>
                    <td class="cross-icon">✘</td>
                    <td class="check-icon">✔<br staticTotranslate="profile_free_services_bag_packer">1 par an dans la limite d'une prestation d'un montant inférieur à 80€</td>
                    <td class="check-icon">✔<br staticTotranslate="profile_free_services_explorator">1 par semestre, sans limitation du montant</td>
                </tr>
                <tr>
                    <td staticTotranslate="profile_vip_services">Accès prioritaire à certaines prestations et aux prestations VIP</td>
                    <td class="cross-icon">✘</td>
                    <td class="cross-icon">✘</td>
                    <td class="check-icon">✔</td>
                </tr>
                <tr>
                    <td staticTotranslate="profile_renewal_bonus">Bonus renouvellement de l'abonnement</td>
                    <td class="cross-icon">✘</td>
                    <td class="cross-icon">✘</td>
                    <td class="check-icon">✔<br staticTotranslate="profile_renewal_bonus_explorator">Réduction de 10% du montant de l'abonnement en cas de renouvellement, valable uniquement sur le tarif annuel</td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        
                    </td>
                    <td> 
                        <?php if ($users["grade"]==3){
                            }else if ($users["grade"] != 2){?>
                        <form method="POST" action="/VIP/VIPPayment">
                            <input type="hidden" name="plan" value="1">
                            <input type="hidden" name="price" value ="9.90">
                            <button type="submit" class="btn btn-primary" staticTotranslate="profile_choose_bag_packer_monthly">Choisir Bag Packer Mensuel</button>
                        </form>
                        <form method="POST" action="/VIP/VIPPayment">
                            <input type="hidden" name="plan" value="2">
                            <input type="hidden" name="price" value ="<?php echo $priceBag;?>">
                            <button type="submit" class="btn btn-primary" staticTotranslate="profile_choose_bag_packer_annually">Choisir Bag Packer Annuel</button>
                        </form>
                        <?php }else { ?>
                            <form method="POST" action="/VIP/VIPDelete">
                            <button type="submit" class="btn btn-danger" staticTotranslate="profile_cancel_subscription">Supprimer l'abonnement</button>
                        </form>
                        <?php } ?>
                    </td>
                    <td>
                        <?php if ($users["grade"]==2){
                            }else if ($users["grade"] != 3){?>
                        <form method="POST" action="/VIP/VIPPayment">
                            <input type="hidden" name="plan" value="3">
                            <input type="hidden" name="price" value ="19">
                            <button type="submit" class="btn btn-primary" staticTotranslate="profile_choose_explorator_monthly">Choisir Explorator Mensuel</button>
                        </form>
                        <form method="POST" action="/VIP/VIPPayment">
                            <input type="hidden" name="plan" value="4">
                            <input type="hidden" name="price" value ="<?php echo $priceExplo;?>">
                            <button type="submit" class="btn btn-primary" staticTotranslate="profile_choose_explorator_annually">Choisir Explorator Annuel</button>
                        </form>
                        <?php }else{?>
                            <form method="POST" action="/VIP/VIPDelete">
                            <button type="submit" class="btn btn-danger" staticTotranslate="profile_cancel_subscription">Supprimer l'abonnement</button>
                        </form>
                        <?php } ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
        </div>
    </div>
</div>






<?php
include "includes/footer.php";
?>
