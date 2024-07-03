<?php
$pageTitle = "Vos réservations";
require '../includes/header.php';
require '../vendor/autoload.php';

use GuzzleHttp\Client;

// Si l'utilisateur n'est pas connecté ou n'est pas du grade 1, 2 ou 3, on le redirige vers la page d'accueil

if (!isConnected()){
    $_SESSION['isConnected'] = "Vous devez être connecté pour accéder à cette page";
    header("Location: /");
 
    die();
}
if ($_SESSION["grade"] > 3) {
    $_SESSION['error'] = "Vous devez être un voyageur pour avoir accès à cette page";
    header("Location: /");
    die();
} 
// On récupère les réservations de l'utilisateur
try {
    $client = new Client([
        'base_uri' => 'https://pcs-all.online:8000'
    ]);
    $response = $client->get('/getBookingByTravelerId/' . $_SESSION["userId"]);
    $data = json_decode($response->getBody()->getContents(), true);
    $bookings = $data["bookings"];
} catch (Exception $e) {
    $bookings = [];
}

// Trier les réservations par date de début et mettre celles qui sont passées dans un autre tableau
$bookingsPassed = [];
$bookingsFuture = [];
foreach ($bookings as $booking) {
    if (strtotime($booking["start_date"]) < time()) {
        $bookingsPassed[] = $booking;
    } else {
        $bookingsFuture[] = $booking;
    }
}
// Si le formulaire de commentaire est envoyé
if (isset($_POST["rate"]) && isset($_POST["comment"]) && isset($_POST["id"])) {
    
    try {
        $client = new Client([
            'base_uri' => 'https://pcs-all.online:8000'
        ]);
        $param = [
            "rate" => $_POST["rate"],
            "comment" => $_POST["comment"],
            "id" => $_POST["id"]
        ];

        $response = $client->post('/addReview', [
            'json' => $param
        ]);
        $data = json_decode($response->getBody()->getContents(), true);

        if ($data["success"]==false){
            $_SESSION["error"] = $data["message"];
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    //Unsset le post
    unset($_POST);
}

?>

<div class="container" style="margin-top: 1em;">
    <div class="row">
        <h2>Vos réservations</h2>
    </div>
</div>

<div class="container" style="margin-top: 2em;">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button style="color:black !important" class="nav-link active" id="future-tab" data-bs-toggle="tab" data-bs-target="#future" type="button" role="tab" aria-controls="future" aria-selected="true">Futures</button>
        </li>
        <li class="nav-item" role="presentation">
            <button style="color:black !important" class="nav-link" id="passed-tab" data-bs-toggle="tab" data-bs-target="#passed" type="button" role="tab" aria-controls="passed" aria-selected="false">Passées</button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="future" role="tabpanel" aria-labelledby="future-tab">
            <div class="container" style="margin-top: 2em;">
                <div class="row">
                    <?php if (empty($bookingsFuture)) { ?>
                        <div class="col-12">
                            <h2>Aucune réservation future trouvée</h2>
                        </div>
                    <?php } else { ?>
                        <?php foreach ($bookingsFuture as $booking) { ?>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card" style="width: 100%; margin-bottom: 1em !important;">
                                        <div class="card-body d-flex flex-row align-items-center">
                                            <?php if (isset($booking["image"])){?>
                                            <img src="<?= $booking["image"] ?>" class="img-fluid" alt="Photo de <?= $booking["title"] ?>" style="max-width: 20%; margin-right: 1em;">
                                            <?php } else
                                            {
                                                echo '<img src="x" class="img-fluid" alt="Photo de '.$booking["title"].'" style="max-width: 20%; margin-right: 1em;">';
                                            }?>
                                            <div class="flex-grow-1">
                                                <h5 class="card-title"><strong> <?= $booking["title"] ?></strong></h5>
                                                <p class="card-text">Du
                                                    <?php
                                                    echo date("d/m/Y", strtotime($booking["start_date"]));
                                                    echo " à ";
                                                    $date = new DateTime($booking["start_date"]);
                                                    echo $date->format('H:i');
                                                    echo " au ";
                                                    echo date("d/m/Y", strtotime($booking["end_date"]));
                                                    echo " à ";
                                                    $date = new DateTime($booking["end_date"]);
                                                    echo $date->format('H:i');
                                                    ?>
                                                    <br>
                                                    <br>
                                                    Adresse : <?= $booking["address"] ?>
                                                    <br>
                                                    Prix : <?= $booking["price"] ?>€
                                                    <br>
                                                    Nombre de voyageurs : <?= $booking["amount_people"] ?>
                                                </p>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <a href="#" class="btn btn-primary mb-2">Contacter le propriétaire</a>
                                                <a href="#" class="btn btn-danger mb-2">Annuler la réservation</a>
                                                <?php
                                                if ($booking["housing_id"] != null) {
                                                    echo '<a href="/ads?id=' . $booking["housing_id"] . '&type=housing" class="btn btn-primary">Voir l\'annonce</a>';
                                                } else {
                                                    echo '<a href="/ads?id=' . $booking["performance_id"] . '&type=performance" class="btn btn-primary">Voir l\'annonce</a>';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        <?php }; ?>
                    <?php }; ?>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="passed" role="tabpanel" aria-labelledby="passed-tab">
            <div class="container" style="margin-top: 2em;">
                <div class="row">
                    <?php if (empty($bookingsPassed)) { ?>
                        <div class="col-12">
                            <h2>Aucune réservation passée trouvée</h2>
                        </div>
                    <?php } else { ?>
                        <?php foreach ($bookingsPassed as $booking) { ?>
                            <div class="col-lg-3 col-md-6 col-12">
                                <div class="card" style="width: 18rem; margin-bottom: 1em !important;">
                                    <div class="card-body">
                                        <img src="<?= $booking["image"] ?>" class="card-img-top" alt="Photo de <?= $booking["title"] ?>">
                                        <h5 class="card-title"><?= $booking["title"] ?></h5>
                                        <p class="card-text">Du <?= $booking["start_date"] ?> au <?= $booking["end_date"] ?></p>
                                        <p class="card-text">Prix : <?= $booking["price"] ?>€</p>
                                        <?php if ($booking["review"] == null) { ?>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#commentModal<?= $booking["id"] ?>">Laisser un commentaire</button>
                                            <div class="modal fade" id="commentModal<?= $booking["id"] ?>" tabindex="-1" aria-labelledby="commentModalLabel<?= $booking["id"] ?>" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="commentModalLabel<?= $booking["id"] ?>">Laisser un commentaire</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?php if (isset($_SESSION["error"])) {?>
                                                                <div class="alert" role="alert"> <?php
                                                                echo $_SESSION["error"];
                                                                unset($_SESSION["error"]);
                                                                ?></div><?php
                                                            } ?>
                                                            <form action="" method="post">
                                                                <div class="mb-3">
                                                                    <label for="rate<?= $booking["id"] ?>" class="form-label">Note</label>
                                                                    <input type="number" class="form-control" id="rate<?= $booking["id"] ?>" name="rate" min="1" max="5" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="comment<?= $booking["id"] ?>" class="form-label">Commentaire</label>
                                                                    <textarea class="form-control" id="comment<?= $booking["id"] ?>" name="comment" rows="3" required></textarea>
                                                                </div>
                                                                <input type="hidden" name="id" value="<?= $booking["id"] ?>">
                                                                <button type="submit" class="btn btn-primary">Envoyer</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } 
                                        if ($booking["housing_id"] != null) {
                                                    echo '<a href="/ads?id=' . $booking["housing_id"] . '&type=housing" class="btn btn-primary">Voir l\'annonce</a>';
                                                } else {
                                                    echo '<a href="/ads?id=' . $booking["performance_id"] . '&type=performance" class="btn btn-primary">Voir l\'annonce</a>';
                                                }

                                                $token = $_SESSION["token"];
                                                ?>
                                                <a href="/pdf/generatePDF.php?id=<?= $booking["id"] ?>&user=<?php echo $token;?>" class="btn btn-primary">Télécharger la facture <i class="fas fa-download"></i></a>
                                         </div>       
                                </div>
                            </div>
                        <?php }; ?>
                    <?php }; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require '../includes/footer.php';
?>