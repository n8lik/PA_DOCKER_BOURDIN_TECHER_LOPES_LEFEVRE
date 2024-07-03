<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;

$id_user = $_GET['id_user'] ?? null;

if (!$id_user) {
    die('ID utilisateur manquant.');
}

//Récupérer les infos user
try {
    $client = new Client([
        'base_uri' => 'https://pcs-all.online:8000'
    ]);
    $response = $client->get('/users/' . $id_user);
    $body = json_decode($response->getBody()->getContents(), true);
    $user = $body['users'];
} catch (Exception $e) {
    echo 'Erreur: ' . $e->getMessage();
    die();
}

//Récupérer la photo de profil de l'utilisateur
try {
    $response = $client->get('/getPpById/' . $id_user);
    $body = json_decode($response->getBody()->getContents(), true);
    $pp = $body['users'][0];
} catch (Exception $e) {
    echo 'Erreur: ' . $e->getMessage();
    die();
}
//Récupérer le grade de l'utilisateur
switch ($user["grade"]) {
    case "1":
        $grade = "Simple voyageur";
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
        $grade = "Administrateur";
        break;
}

//récupérer les annonces de l'utilisateur si c'est un grade 4 ou 5 (bailleur ou prestataire)
if ($user["grade"] == 4 || $user["grade"] == 5) {
    try {
        $response = $client->get('/getAllAdsByOwnerId/' . $id_user);
        $body = json_decode($response->getBody()->getContents(), true);
        $ads = $body['ads'];
    } catch (Exception $e) {
        echo 'Erreur: ' . $e->getMessage();
        die();
    }
}


?>

<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel"><?php echo "Profil de <b>" . $user['pseudo'] . "</b>"; ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <div class="profile-image">
                            <img src="<?php echo $pp; ?>" class="rounded-circle" alt="Photo de profil" width="70%">
                        </div>
                        <h6><?php $user['pseudo']; ?></h6>
                    </div>
                    <div class="col-md-8">
                        <ul class="list-unstyled">
                            <li>🎖️ Grade: <?php echo $grade; ?></li>
                            <?php
                            if ($user['is_validated'] == 1) {
                                echo '<li>✅ Compte validé</li>';
                            } else {
                                echo '<li>❌ Compte non validé</li>';
                            }
                            ?>
                            <li>📅 Membre depuis <?php
                                                    $date = new DateTime($user['creation_date']);
                                                    echo $date->format('Y');
                                                    ?></li>
                            <li>📍 <?php echo $user['city']; ?></li>
                        </ul>
                    </div>
                </div>
                <?php
                if ($user['grade'] == 4 || $user['grade'] == 5) {
                    echo '<br>';
                    echo '<h5>Annonces de l\'utilisateur</h5>';
                    echo "<hr>";
                    echo '<div class="row">';
                    if (count($ads) == 0) {
                        echo '<p>Cet utilisateur n\'a pas encore publié d\'annonce.</p>';
                    } else {
                        foreach ($ads as $ad) {
                            echo '<div class="col-md-6">';
                            echo '<div class="card mb-3">';
                            echo '<a href="ads.php?id=' . $ad['id'] . '&type=' . $ad['tmp'] . '" style="text-decoration: none; color: black;">';
                            echo '<img src="' . $ad['images'][0] . '" class="card-img-top" alt="Image de l\'annonce">';
                            echo '<div class="card-body">';
                            echo '<h5 class="card-title">' . $ad['title'] . '</h5>';
                            if ($ad['amount_people']) {
                                echo '<p class="card-text">👥 ' . $ad['amount_people'] . ' personnes</p>';
                            } else {
                                echo '<p class="card-text">👥 ' . $ad['guest_capacity'] . ' personnes</p>';
                            }
                            echo '</div>';
                            echo '</a>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                    echo '</div>';
                }
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>