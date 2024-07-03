<?php


require "../includes/header.php";
if (!isConnected()){
    $_SESSION['isConnected'] = "Vous devez être connecté pour accéder à cette page";
    header("Location: /");
 
    die();
}
$id = $_GET["id"];
$userId = $_SESSION['userId'];
$user = getUserById($userId);
$house = getHousingById($id);

if (!isConnected()) {
    header('Location: ../login.php');
}
if ($_SESSION['grade'] != 4) {
    header('Location: /');
}
if ($house['id_user'] != $userId) {
    header("Location: logements/houses.php");
}


?>

<div class="container border-form mt-5">
    <form method="post" action="logements/action?type=addFiles&id=<?= $id ?>&usertype=landlord" enctype="multipart/form-data">


        <?php if (!empty($_SESSION['errorFile'])) {

            echo $_SESSION['errorFile'];
        }
        $_SESSION['errorFile'] = ''; ?>
        <div class="alert alert-primary" role="alert">
            Veuillez ajouter le bail, le contrat de location, le diagnostic de performance énergétique et le règlement de copropriété de votre logement.
        </div>
        <div>
            <div class="form-group">
                <label for="type">Type de document</label>
                <select class="form-select" id="type" name="type">
                    <option value="1">Document d'identité</option>
                    <option value="2">Bail</option>
                    <option value="3">Contrat de location</option>
                    <option value="4">Diagnostic de performance énergétique</option>
                    <option value="5">Règlement de copropriété</option>
                </select>
            </div>
            <div>
                <label for="image">Ajoute tes documents</label><br>
                <input type="file" id="file" name="file"><br><br>
            </div>
            <input type="submit" value="Publier" name="submit">


        </div>
    </form>
</div>

<?php
require "../includes/footer.php";
?>