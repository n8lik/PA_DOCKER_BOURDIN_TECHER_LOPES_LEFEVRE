<?php
require 'includes/admin_header.php';
require 'includes/fun_admin.php';
//Afficher les erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//Verifier la connexion
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
}

if (!isset($_GET['choice'])) {
    header('Location: index.php');
} else {
    $choice = $_GET['choice'];
}


switch ($choice) {
    case 'chatbot':
        //Vérifier si le formulaire d'ajout a été soumis
        if (isset($_POST['addMessage'])) {
            $rep=addChatbotMessage($_POST['keyword'], $_POST['response']);
            if($rep){
                echo '<div class="alert alert-danger" role="alert"> Le mot clé "'.$_POST['keyword'].'" existe déjà</div>';
            }else{
                echo '<div class="alert alert-success" role="alert"> Message ajouté avec succès</div>';
            }
            unset($_POST['addMessage']);
            unset($_POST['keyword']);
            unset($_POST['response']);
        }
        //Vérifier si le formulaire de modification a été soumis
        if (isset($_POST['editMessage'])) {
            editChatbotMessage($_POST['id'], $_POST['keyword'], $_POST['response']);
            unset($_POST['editMessage']);
            unset($_POST['id']);
            unset($_POST['keyword']);
            unset($_POST['response']);
        }
        //Vérifier si le formulaire de suppression a été soumis
        if (isset($_POST['deleteMessage'])) {
            deleteChatbotMessage($_POST['id']);
            unset($_POST['deleteMessage']);
            unset($_POST['id']);
            echo '<div class="alert alert-success" role="alert"> Message supprimé avec succès</div>';
        }

        //Vérifier si une recherche a été effectuée
        if (isset($_POST['search'])) {
            $messages = searchChatbotMessages($_POST['search']);
            echo '<div class="alert alert-success" role="alert"> Résultat de la recherche: '.$_POST['search'].'</div>';
            unset($_POST['search']);
        } else {
            $messages = getChatbotMessages();
        }
?>
        <div class="admin-content-line">
            <div class="stat-block">
                <h4>Messages du chatbot</h4>
                <form action="" method="POST">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Rechercher un mot clé" name="search" aria-label="Rechercher un mot clé" aria-describedby="button-addon2">
                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Rechercher</button>
                    </div>
                </form>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMessage">Ajouter un message</button>
                <div class="modal fade" id="addMessage" tabindex="-1" aria-labelledby="addMessageLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addMessageLabel">Ajouter un message</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="" method="POST">
                                <div class="modal-body">
                                <div class="mb-3">
                                    <label for="keyword" class="form-label">Mot clé</label>
                                    <input type="text" class="form-control" id="keyword" name="keyword">
                                </div>
                                <div class="mb-3">
                                    <label for="response" class="form-label">Réponse</label>
                                    <textarea class="form-control" id="response" name="response" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-primary" name="addMessage">Ajouter</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <hr>
                <?php 
                if ($messages == null) {
                    echo '<div class="alert alert-danger" role="alert"> Aucun message trouvé</div>';
                }else{
                    ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Mot clé</th>
                                <th scope="col" width = "70%">Réponse</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($messages as $message) : ?>
                                <tr>
                                    <td><?php echo $message['keyword']; ?></td>
                                    <td><?php echo $message['chatbotresponse']; ?></td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editMessage<?php echo $message['id']; ?>">Modifier</button>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteMessage<?php echo $message['id']; ?>">Supprimer</button>
                                    </td>
                                </tr>
                                <!-- Modal de modification -->
                                <div class="modal fade" id="editMessage<?php echo $message['id']; ?>" tabindex="-1" aria-labelledby="editMessage<?php echo $message['id']; ?>Label" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editMessage<?php echo $message['id']; ?>Label">Modifier le message</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="" method="POST">
                                                <div class="modal-body">
                                                    <input type="hidden" name="id" value="<?php echo $message['id']; ?>">
                                                    <div class="mb-3">
                                                        <label for="keyword" class="form-label">Mot clé</label>
                                                        <input type="text" class="form-control" id="keyword" name="keyword" value="<?php echo $message['keyword']; ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="response" class="form-label">Réponse</label>
                                                        <textarea class="form-control" id="response" name="response" rows="3"><?php echo $message['chatbotresponse']; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                    <button type="submit" class="btn btn-primary" name="editMessage">Enregistrer</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal de suppression -->
                                <div class="modal fade" id="deleteMessage<?php echo $message['id']; ?>" tabindex="-1" aria-labelledby="deleteMessage<?php echo $message['id']; ?>Label" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteMessage<?php echo $message['id']; ?>Label">Supprimer le message</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="" method="POST">
                                                <div class="modal-body">
                                                    <input type="hidden" name="id" value="<?php echo $message['id']; ?>">
                                                    <p>Voulez-vous vraiment supprimer le message ?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                    <button type="submit" class="btn btn-danger" name="deleteMessage">Supprimer</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php } ?>
            </div>
        </div>
<?php
        break;

    default:
        header('Location: index.php');
        break;
}


require 'includes/admin_footer.php';
?>