<?php
require 'includes/admin_header.php';
require 'includes/fun_admin.php';
//Verifier la connexion
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
}

//Si y'a un POST qui est envoyé (par rapport au formulaire)
if (isset($_POST['userForm'])) {
    updateUser($_POST['id'], $_POST['pseudo'], $_POST['lastname'], $_POST['firstname'], $_POST['email'], $_POST['grade']);
    //Nettoyer les variables
    unset($_POST);
}
    

//gerer la suppression d'un utilisateur
if (isset($_POST['deleteUser'])) {
    deleteUser($_POST['id']);
    //Nettoyer les variables
    unset($_POST);
}
//Si un admin est validé
if (isset($_POST['validateUser'])) {
    validateUser($_POST['id']);
    //Nettoyer les variables
    unset($_POST);
}

//si on a un post delete
if (isset($_POST['delete'])) {
    deleteAd($_POST['id'], $_POST['type']);
    //Nettoyer les données
    unset($_POST);
}

//si on a un post validate
if (isset($_POST['validate'])) {
    validateAd($_POST['id'], $_POST['type']);
    //Nettoyer les données
    unset($_POST);
}

//switch case pour les choix
if (isset($_GET['choice'])) {
    $choice = $_GET['choice'];
    switch ($choice) {
        case 'vlandlords':
            $users = getPendingUsersByGrade(4);
?>
            <div class="admin-content">
                <h1>Bailleurs (<?= count($users); ?>)</h1>
            <?php
            break;
        case 'vproviders':
            $users = getPendingUsersByGrade(5);
            ?>
                <div class="admin-content">
                    <h1>Prestataires (<?= count($users); ?>)</h1>
                <?php
                break;
            case 'vhousing':
                $ads = getPendingAdsByType('housing');
                ?>
                    <div class="admin-content">
                        <h1>Annonces de logement (<?= count($ads); ?>)</h1>
                    <?php
                    break;
                case 'vperformance':
                    $ads = getPendingAdsByType('performance');
                    ?>
                        <div class="admin-content">
                            <h1>Annonces de prestations (<?= count($ads); ?>)</h1>
                        <?php
                        break;
                    case 'vevolution':
                        $ads = getPendingEvolutionPrice('evolution');
                        ?>
                            <div class="admin-content">
                                <h1>Evolution tarifaire (<?= nbAdsByType('evolution') ?>)</h1>
                            <?php
                            break;
                    }
                    if (isset($users)) { ?>
                            <form method="get" action="">
                                <input type="hidden" name="choice" value="<?php echo $choice; ?>">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Rechercher un utilisateur" name="search">
                                    <button class="btn btn-outline-secondary" type="submit">Rechercher</button>
                                </div>
                            </form>
                            <?php
                            if (isset($_GET['search'])) {
                                $users = searchingBar($_GET['search'], $choice);
                            }

                            if (empty($users)) {
                                echo "Aucun utilisateur trouvé";
                            } else {
                            ?>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Pseudo</th>
                                            <th>Nom</th>
                                            <th>Prénom</th>
                                            <th>Email</th>
                                            <th>Grade</th>
                                            <th>Statut</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($users as $user) {
                                        ?>
                                            <tr>
                                                <td><?php echo $user['id']; ?></td>
                                                <td><?php echo $user['pseudo']; ?></td>
                                                <td><?php echo $user['lastname']; ?></td>
                                                <td><?php echo $user['firstname']; ?></td>
                                                <td><?php echo $user['email']; ?></td>
                                                <td><?php echo getGrade($user['grade']); ?></td>
                                                <td><?php echo getUserStatus($user['id']); ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modal<?php echo $user['id']; ?>"> Voir </button>
                                                    <div class="modal fade" id="modal<?php echo $user['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Informations de <?php echo $user['pseudo']; ?></h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form id="userForm<?php echo $user['id']; ?>" method="post" action="">
                                                                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                                                        <div class="mb-3">
                                                                            <label for="pseudo" class="form-label">Pseudo</label>
                                                                            <input type="text" class="form-control" id="pseudo" name="pseudo" value="<?php echo $user['pseudo']; ?>" <?php if (getUserStatus($user['id']) == "Supprimé") { ?> disabled <?php } ?>>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="lastname" class="form-label">Nom</label>
                                                                            <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $user['lastname']; ?>" <?php if (getUserStatus($user['id']) == "Supprimé") { ?> disabled <?php } ?>>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="firstname" class="form-label">Prénom</label>
                                                                            <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $user['firstname']; ?>" <?php if (getUserStatus($user['id']) == "Supprimé") { ?> disabled <?php } ?>>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="email" class="form-label">Email</label>
                                                                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" <?php if (getUserStatus($user['id']) == "Supprimé") { ?> disabled <?php } ?>>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="grade" class="form-label">Grade</label>
                                                                            <select class="form-select" id="grade" name="grade" <?php if (getUserStatus($user['id']) == "Supprimé") { echo 'disabled'; } ?>>
                                                                                <option value="1" <?php echo (getGrade($user['grade']) == 'Voyageur') ? 'selected' : ''; ?>>Voyageur</option>
                                                                                <option value="2" <?php echo (getGrade($user['grade']) == 'Voyageur VIP1') ? 'selected' : ''; ?>>Voyageur VIP1</option>
                                                                                <option value="3" <?php echo (getGrade($user['grade']) == 'Voyageur VIP2') ? 'selected' : ''; ?>>Voyageur VIP2</option>
                                                                                <option value="4" <?php echo (getGrade($user['grade']) == 'Bailleur') ? 'selected' : ''; ?>>Bailleur</option>
                                                                                <option value="5" <?php echo (getGrade($user['grade']) == 'Prestataire') ? 'selected' : ''; ?>>Prestataire</option>
                                                                                <option value="6" <?php echo (getGrade($user['grade']) == 'Administrateur') ? 'selected' : ''; ?>>Administrateur</option>
                                                                            </select>

                                                                        </div>
                                                                    </form>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <?php if (getUserStatus($user['id']) != "Supprimé") { ?>
                                                                        <button type="submit" form="userForm<?php echo $user['id']; ?>" class="btn btn-info" name="userForm">Enregistrer les changements</button>
                                                                    <?php } else {
                                                                    ?>
                                                                        <form method="post" action="">
                                                                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                                                            <button type="submit" class="btn btn-outline-success" name="reactivateUser">Réactiver</button>
                                                                        </form>
                                                                    <?php } ?>
                                                                    <?php if (getUserStatus($user['id']) == "En attente de validation") { ?>
                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalValidate<?php echo $user['id']; ?>">
                                                                            Valider
                                                                        </button>
                                                                        <div class="modal fade" id="modalValidate<?php echo $user['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                            <div class="modal-dialog modal-dialog-centered">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title" id="exampleModalLabel">Valider <?php echo $user['pseudo']; ?></h5>
                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                    </div>
                                                                                    <div class="modal-body
                                                                    ">
                                                                                        <p>Êtes-vous sûr de vouloir valider <?php echo $user['pseudo']; ?> ?</p>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                                                        <form method="post" action="">
                                                                                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                                                                            <button type="submit" class="btn btn-success" name="validateUser">Valider</button>
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
                                                    <?php if (getUserStatus($user['id']) != "Supprimé") { ?>
                                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalDelete<?php echo $user['id']; ?>">
                                                            Supprimer
                                                        </button>
                                                        <div class="modal fade" id="modalDelete<?php echo $user['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Supprimer <?php echo $user['pseudo']; ?></h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Êtes-vous sûr de vouloir supprimer <?php echo $user['pseudo']; ?> ?</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                                        <form method="post" action="">
                                                                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                                                            <button type="submit" class="btn btn-danger" name="deleteUser">Supprimer</button>
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
                    <?php
                }
                            }elseif(isset($ads)){
                    ?>
                    <form method="get" action="">
                        <input type="hidden" name="choice" value="<?php echo $choice; ?>">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Rechercher une annonce" name="search">
                            <button class="btn btn-outline-secondary" type="submit">Rechercher</button>
                        </div>
                    </form>
                    <?php
                    if (isset($_GET['search'])) {
                        $ads = searchingBar($_GET['search'], $choice);
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
                                <td><img src="img/ads/<?php echo $ad['id']; ?>.jpg" alt="photo" style="width: 100px;"></td>
                                <td><?php echo $ad['id']; ?></td>
                                <td><?php echo $ad['title']; ?></td>
                                <td><?php echo $ad['rate']; ?></td>
                                <td><?php echo $ad['price']; ?></td>
                                <td><?php echo $user['pseudo']; ?></td>
                                <td><?php echo $ad['creation_date']; ?></td>
                                <td>En attente de validation</td>
                                <td>
                                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modal<?php echo $ad['id']; ?>"> Voir </button>
                                    <div class="modal fade">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Informations de <?php echo $ad['title']; ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="adForm<?php echo $ad['id']; ?>" method="post" action="">
                                                        <input type="hidden" name="id" value="<?php echo $ad['id']; ?>">
                                                        <div class="mb-3">
                                                            <label for="title" class="form-label">Titre</label>
                                                            <input type="text" class="form-control" id="title" name="title" value="<?php echo $ad['title']; ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="note" class="form-label">Note</label>
                                                            <input type="text" class="form-control" id="note" name="note" value="<?php echo $ad['note']; ?>" >
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="price" class="form-label">Prix</label>
                                                            <input type="text" class="form-control" id="price" name="price" value="<?php echo $ad['price']; ?>">
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalValidate<?php echo $ad['id']; ?>">
                                                            Valider
                                                        </button>
                                                        <div class="modal fade">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Valider <?php echo $ad['title']; ?></h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Êtes-vous sûr de vouloir valider <?php echo $ad['title']; ?> ?</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                                        <form method="post" action="">
                                                                            <input type="hidden" name="id" value="<?php echo $ad['id']; ?>">
                                                                            <button type="submit" class="btn btn-success" name="validateAd">Valider</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalDelete<?php echo $ad['id']; ?>">
                                            Supprimer
                                        </button>
                                        <div class="modal fade
                                        ">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Supprimer <?php echo $ad['title']; ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body
                                        ">
                                                        <p>Êtes-vous sûr de vouloir supprimer <?php echo $ad['title']; ?> ?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                        <form method="post" action="">
                                                            <input type="hidden" name="id" value="<?php echo $ad['id']; ?>">
                                                            <button type="submit" class="btn btn-danger" name="deleteAd">Supprimer</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <?php
            }
        }
        ?>
        </div>
        <?php
}
        require 'includes/admin_footer.php';
        ?>