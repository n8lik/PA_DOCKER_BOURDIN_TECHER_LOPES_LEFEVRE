<?php
/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */
require 'includes/admin_header.php';
require 'includes/fun_admin.php';
require '/var/www/html/vendor/autoload.php';
use GuzzleHttp\Client;
//Verifier la connexion
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

//Si un admin est ajouté
if (isset($_POST['addNewAdmin'])) {
    $result=addNewAdmin($_POST['pseudo'], $_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['pwd'], $_POST['pwdConfirm'], $_POST['grade']);
    //Si le tableau d'erreur est plein, afficher les erreurs dans un alert
    if (!empty($result)) {
        ?>
        <div class="alert alert-danger" role="alert" style="text-align: center;" >
            L'ajout de l'administrateur a échoué
        </div>
    <?php
    }else{
        ?>
        <div class="alert alert-success" role="alert" style="text-align: center;">
            L'administrateur a bien été ajouté
        </div>
        <?php
        //Nettoyer les variables
        unset($_POST);
        unset ($result);
    }
}

if (isset($_POST['annuler'])) {
    //Nettoyer les variables
    unset($_POST);
    unset ($result);

}

//Si un admin est réactivé
if (isset($_POST['reactivateUser'])) {
    reactivateUser($_POST['id']);
    //Nettoyer les variables
    unset($_POST);
}

//Si un admin est validé
if (isset($_POST['validateUser'])) {
    validateUser($_POST['id']);
    //Nettoyer les variables
    unset($_POST);
}

//si c'est le choix qui est donné en paramètre :*
if (isset($_GET['choice'])) {
    /*Recuperer le paramètre donné en GET*/
    $id = $_GET['choice'];
    //Switch pour les différents cas
    switch ($id) {
        case 'all':
            $users = getAllUsers(); ?>
            <div class="admin-content">
                <h1> Utilisateurs (<?php echo totalNbUsers();?>)</h1>
            <?php
            break;
        case 'travelers':
            $users = getUsersByGrade("users");
            ?>
            <div class="admin-content">
                <h1> Voyageurs (<?php echo nbUserByGrade(1)+nbUserByGrade(2)+nbUserByGrade(3);?>)</h1>
            <?php
            break;
        case 'landlords':
            $users = getUsersByGrade(4);
            ?>
            <div class="admin-content">
                <h1> Bailleurs (<?php echo nbUserByGrade(4);?>)</h1>
            <?php
            break;
        case 'providers':
            $users = getUsersByGrade(5);
            ?>
            <div class="admin-content">
                <h1> Prestataires (<?php echo nbUserByGrade(5);?>)</h1>
            <?php
            break;
        case 'admins':
            $users = getUsersByGrade(6);
            ?>
            <div class="admin-content">

            <div class="d-flex justify-content-between align-items-center">
                <h1> Administrateurs (<?php echo nbUserByGrade(6);?>)</h1>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddAdmin">
                    +
                </button>
            </div>
                <div class="modal fade" id="modalAddAdmin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Ajouter un administrateur</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body ">
                                <form method="post" action="">
                                    <input type="hidden" name="grade" value="6">
                                    <?php 
                                        if (!empty($result)) {
                                            ?>
                                            <div class="alert alert-danger" role="alert">
                                                <?php
                                                foreach ($result as $error) {
                                                    echo $error . "<br>";
                                                }
                                                unset($result);
                                                ?>
                                            </div>
                                        <?php
                                        }
                                    ?>
                                    <div class="mb-3">
                                        <label for="pseudo" class="form-label">Pseudo</label>
                                        <input type="text" class="form-control" id="pseudo" name="pseudo"  value="<?php if(isset($_POST["pseudo"])){echo $_POST["pseudo"];};?>"   required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="lastname" class="form-label">Nom</label>
                                        <input type="text" class="form-control" id="lastname" name="lastname" value="<?php if(isset($_POST["pseudo"])){echo $_POST["lastname"];};?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">Prénom</label>
                                        <input type="text" class="form-control" id="firstname" name="firstname"  value="<?php if(isset($_POST["pseudo"])){echo $_POST["firstname"];};?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?php if(isset($_POST["pseudo"])){echo $_POST["email"];};?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pwd" class="form-label">Mot de passe</label>
                                        <input type="password" class="form-control" id="pwd" name="pwd" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pwdConfirm" class="form-label">Confirmez le mot de passe</label>
                                        <input type="password" class="form-control" id="pwdConfirm" name="pwdConfirm"  required>
                                    </div>
                                    <div class="alert alert-info" role="alert">
                                        Le mot de passe doit contenir au moins 8 caractères, une majuscule, un chiffre et un caractère spécial
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-primary" name="addNewAdmin" onclick="window.location.href='#';">Ajouter</button>
                                <button type="button" class="btn btn-secondary" onclick="window.location.href='users?choice=admins';">Annuler</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            


            <?php
            break;
        default:

            break;
    }
    ?>
    <form method="get" action="">
        <input type="hidden" name="choice" value="<?php echo $id; ?>">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Rechercher un utilisateur" name="search">
            <button class="btn btn-outline-secondary" type="submit">Rechercher</button>
        </div>
    </form>
        <?php
        if (isset($_GET['search'])) {
            $users = searchingBar($_GET['search'],$id);
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
                                    <button type="button" class="btn btn-outline-primary"data-bs-toggle="modal" data-bs-target="#modalFiles<?php echo $user['id']; ?>">Voir les fichiers</button>
                                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modal<?php echo $user['id']; ?>">
                                        Voir
                                    </button>
                                    
                                    <?php $token = $user["token"];
                                        $grade = $user["grade"];
                                        $files = []; 
                                        try {
                                            $client = new Client([
                                                'base_uri' => 'https://pcs-all.online:8000'
                                            ]);
                                            $test = [
                                                'token' => $token,
                                                'grade' => $grade
                                            ];
                                            $response = $client->get('/files', [
                                                'json' => $test
                                            ]);

                                            $body = json_decode($response->getBody()->getContents(), true);
                                        
                                            if (isset($body['success']) && $body['success'] === true) {
                                                $files = $body['files'];
                                                
                                            } 
                                        } catch (Exception $e) {
                                            $files = [];
                                            echo $e->getMessage();
                                        }?>
                                        
                                    <div class="modal fade" id="modalFiles<?php echo $user['id']; ?>" tabindex="-1" aria-labelledby="modalFilesLabel<?php echo $user['id']; ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalFilesLabel<?php echo $user['id']; ?>">Fichiers de <?php echo $user['pseudo']; ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <?php if ($files) { ?>
                                                        <ul class="list-group">
                                                            <?php foreach ($files as $file) { 
                                                                $parts = explode('/', $file);
                                                                $idLogement = $parts[3];
                                                                $fileType = $parts[4];
                                                                $fileType = htmlspecialchars($fileType);

                                                                if ($grade == 4){
                                                                    $nomlogement = getAdsById($idLogement, "housing")["title"];
                                                                    if($fileType == 1){
                                                                        $fileType = "Document d'identité";
                                                                    }
                                                                    else if($fileType == 2){
                                                                        $fileType = "Bail";
                                                                    }
                                                                    else if($fileType == 3){
                                                                        $fileType = "Contrat de location";
                                                                    }
                                                                    else if($fileType == 4){
                                                                        $fileType = "Diagnostic de performance énergétique";
                                                                    }
                                                                    else if($fileType == 5){
                                                                        $fileType = "Règlement de copropriété";
                        
                                                                    }
                                                                }else{

                                                                $nomlogement = getAdsById($idLogement, "performance")["title"];
                                                                    if($fileType == 1){
                                                                        $fileType = "Document d'identité";
                                                                    }
                                                                    else if($fileType == 2){
                                                                        $fileType = "Licence d'activité";
                                                                    }
                                                                    else if($fileType == 3){
                                                                        $fileType = "Carte professionnelle";
                                                                    }
                                                                    else if($fileType == 4){
                                                                        $fileType = "Facture";
                                                                    }
                                                                    }

                                                                ?>
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                <?php if ($_SESSION["error"]){    ?>
                                                                <div class="alert" role="alert"> <?php echo $_SESSION["error"]; ?> </div>
                                                                <?php
                                                                unset($_SESSION["error"]);
                                                                }
                                                                if ($_SESSION["success"]){    ?>
                                                                <div class="alert" role="alert"> <?php echo $_SESSION["success"]; ?> </div>
                                                                <?php
                                                                unset($_SESSION["success"]);
                                                                }
                                                                ?>

                                                                    <?php echo "Logement n°".$idLogement; 
                                                                        echo " - ".$nomlogement;
                                                                        echo " - ".$fileType;
                                                                    ?>
        


                                                                    <div>
                                                                        <a href="includes/files/download?file=<?php echo $file; ?>&grade=<?php echo $grade;?>&token=<?php echo $token;?>" class="btn btn-success btn-sm">Télécharger</a>
                                                                        <a href="includes/files/deleteFiles.php?file=<?php echo $file; ?>" class="btn btn-danger btn-sm">Supprimer</a>
                                                                    </div>
                                                                </li>
                                                            <?php } ?>
                                                        </ul>
                                                    <?php } else { ?>
                                                        <div class="alert alert-warning" role="alert">Aucun fichier trouvé.</div>
                                                    <?php } ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    
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
                                                            <select class="form-select" id="grade" name="grade" <?php if (getUserStatus($user['id']) == "Supprimé") { ?> disabled <?php } ?>>
                                                                <option value="1">Voyageur</option>
                                                                <option value="2">Voyageur VIP1</option>
                                                                <option value="3">Voyageur VIP2</option>
                                                                <option value="4">Bailleur</option>
                                                                <option value="5">Prestataire</option>
                                                                <option value="6">Administrateur</option>
                                                            </select>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <?php if (getUserStatus($user['id']) != "Supprimé") { ?>
                                                        <button type="submit" form="userForm<?php echo $user['id']; ?>" class="btn btn-info" name="userForm" >Enregistrer les changements</button>
                                                    <?php }else{
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
                                                        <div class="modal fade
                                                        " id="modalValidate<?php echo $user['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                    <div class="modal-body
                                                    ">
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
            </div>
        </div>
   
    <?php } ?>
 </div>
<?php


}




include 'includes/admin_footer.php';
?>