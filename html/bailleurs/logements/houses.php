<link href="../../css/bailleur.css" rel="stylesheet">

<?php require "../../includes/header.php";

if (!isConnected()){
    $_SESSION['isConnected'] = "Vous devez être connecté pour accéder à cette page";
    header("Location: /");
 
    die();
}
if ($_SESSION['grade'] != 4){
    $_SESSION["error"] = "Vous n'avez pas les droits pour accéder à cette page";
    header('Location: /');
}
$userId = $_SESSION['userId'];
$user = getUserById($userId);


$house = getHousingByOwner($userId);
$choice = "housing";


?>

<div class="bailleur-content">
    <div class="d-flex justify-content-center align-items-center">

        <h1 style="padding-right: 1em;">Mes logements</h1>
        <a href="addAHouse.php" class="btn btn-primary">+</a>


    </div>
    <form action="" method="post">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Rechercher une annonce" name="search">
            <button class="btn btn-outline-secondary" type="submit" name="searchButton">Rechercher</button>
        </div>
    </form>
    <?php
    if (isset($_POST['searchButton'])) {
        $house = searchingBar($_POST['search'], $choice);
    }
    if (empty($house)) {
        echo "Aucune annonce trouvée";
    }
    ?>
    <table class="table">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Ville</th>
                <th>Type</th>
                <th>Prix</th>
                <th>Note</th>
                <th>Status</th>
                <th>Voir l'annonce</th>
                <th>Ajouter des documents</th>
                <th>Actions</th>


            </tr>
        </thead>
        <tbody>
            <?php foreach ($house as $key => $value) {
                $houseId = $value['id'];
                $houseTitle = $value['title'];
                $houseCity = $value['city'];
                $houseType = $value['type_house'];
                $housePrice = $value['price'];
                $houseRate = $value['rate'];
                $houseStatus = $value['is_validated'];


            ?>
                <tr>
                    <td><?= $houseTitle ?></td>
                    <td><?= $houseCity ?></td>
                    <td><?= $houseType ?></td>
                    <td><?= $housePrice ?></td>
                    <td><?= $houseRate ?></td>
                    <td><?php if ($houseStatus == 0) {
                            echo "En attente de validation";
                        } else {
                            echo "Validé";
                        } ?></td>
                    <td><center><a href="/ads.php?id=<?= $houseId ?>&type=housing" class="btn btn-outline-secondary">Voir</a></center></td>
                    <td>
                        <a href="../filesAdd.php?id=<?= $houseId ?>" class="btn btn-outline-success">Ajout de Document</a>
                    </td>
                    <td>
                    <?php if ($houseStatus==1){?>
                        <a href="modifyAHouse.php?id=<?= $houseId ?>" class="btn btn-outline-info">modify</a>
                       <?php } ?>
                       
                        <a href="action.php?id=<?= $houseId ?>&type=delete" class="btn btn-outline-danger">Supprimer</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>

    </table>
</div>

<?php

require "../../includes/footer.php"; ?>