<?php
require 'includes/admin_header.php';
require 'includes/fun_admin.php';
//Verifier la connexion
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
}

//si on a un post delete
if (isset($_POST['delete'])) {
    deleteAd($_POST['id'], $_POST['type']);
    //Nettoyer les données
    unset($_POST);
}

//si on a un post reactivate
if (isset($_POST['reactivate'])) {
    reactivateAd($_POST['id'], $_POST['type']);
    //Nettoyer les données
    unset($_POST);
}
//si on a un post validate
if (isset($_POST['validate'])) {
    validateAd($_POST['id'], $_POST['type']);
    //Nettoyer les données
    unset($_POST);
}

//si c'est le choix qui est envoyé en paramètre
if (isset($_GET['choice'])) {
    $choice = $_GET['choice'];
    switch ($choice) {
        case 'housing':
            $ads = getAdsByCategory('housing');
?>
            <div class="admin-content">
                <h1>Annonces de logement (<?= nbAdsByType('housing') ?>)</h1>
            <?php
            break;
        case 'performance':
            $ads = getAdsByCategory('performance');
            ?>
                <div class="admin-content">
                    <h1>Annonces de prestations (<?= nbAdsByType('performance') ?>)</h1>
            <?php
            break;
    }
    //barre de recherche
            ?>
            <form action="" method="post">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Rechercher une annonce" name="search">
                    <button class="btn btn-outline-secondary" type="submit" name="searchButton">Rechercher</button>
                </div>
            </form>
            <?php
            //si on a un post search
            if (isset($_POST['searchButton'])) {
                $ads = searchingBar($_POST['search'], $choice);
            }
            if (empty($ads)) {
                echo "Aucune annonce trouvée";
            } else {

            ?>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col"> Photo </th>
                            <th scope="col">ID</th>
                            <th scope="col">Titre</th>
                            <th scope="col">Note</th>
                            <th scope="col">Prix</th>
                            <th scope="col">Publié par</th>
                            <th scope="col">Date de création</th>
                            <th scope="col">Status </th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($ads as $ad) {
                            $user = getUserById($ad['id_user']);
                        ?>
                            <tr>
                                <td><img src="../assets/ads/<?= $ad['photo'] ?>" alt="photo" width="100"></td>
                                <td><?php echo $ad['id']; ?></td>
                                <td><?php echo $ad['title']; ?></td>
                                <td><?php echo $ad['rate']; ?></td>
                                <td><?php echo $ad['price']; ?></td>
                                <td><?php echo $user['pseudo']; ?></td>
                                <td><?php echo $ad['creation_date']; ?></td>
                                <td><?php echo getAdStatus($ad['id'], $choice); ?></td>
                                <td>
                                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modal<?= $ad['id'] ?>">Voir</button>
                                    <div class="modal fade" id="modal<?= $ad['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel"><?= $ad['title'] ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <img src="../assets/ads/<?= $ad['photo'] ?>" alt="photo" width="100">
                                                    <p>Description : <?php echo $ad['description']; ?></p>
                                                    <p>Prix : <?php echo $ad['price']; ?></p>
                                                    <p>Publié par : <?php echo $user['pseudo']; ?></p>
                                                    <p>Date de création : <?php echo $ad['creation_date']; ?></p>
                                                    <p>Validation PCS : <?php if ($ad['is_validated'] == 1) {
                                                                            echo "Validé";
                                                                        } else {
                                                                            echo "En attente de validation";
                                                                        } ?></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <?php if ($ad['is_deleted'] == 1) { ?>
                                                        <form action="" method="post">
                                                            <input type="hidden" name="id" value="<?= $ad['id'] ?>">
                                                            <input type="hidden" name="type" value="<?= $choice ?>">
                                                            <button type="submit" class="btn btn-outline-success" name="reactivate">Réactiver</button>
                                                        </form>
                                                    <?php }
                                                    if ($ad['is_validated'] == 0) { ?>
                                                        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalValidate<?= $ad['id'] ?>">
                                                            Valider
                                                        </button>
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="modalValidate<?= $ad['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Validation de l'annonce</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body
                                                    ">
                                                                        <p>Êtes-vous sûr de vouloir valider l'annonce <?= $ad['title'] ?> ?</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                                        <form action="" method="post">
                                                                            <input type="hidden" name="id" value="<?= $ad['id'] ?>">
                                                                            <input type="hidden" name="type" value="<?= $choice ?>">
                                                                            <button type="submit" class="btn btn-outline-success" name="validate">Valider</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if ($ad['is_deleted'] == 0) { ?>
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalDelete<?= $ad['id'] ?>">
                                            Supprimer
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="modalDelete<?= $ad['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Suppression de l'annonce</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Êtes-vous sûr de vouloir supprimer l'annonce <?= $ad['title'] ?> ?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                        <form action="" method="post">
                                                            <input type="hidden" name="id" value="<?= $ad['id'] ?>">
                                                            <input type="hidden" name="type" value="<?= $choice ?>">
                                                            <button type="submit" class="btn btn-outline-danger" name="delete">Supprimer</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        </div>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                </div>




        <?php }
            echo "</div>";
        }


        require 'includes/admin_footer.php';
        ?>