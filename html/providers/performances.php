<link href="../css/bailleur.css" rel="stylesheet">

<?php 
require "../includes/header.php";

$userId = $_SESSION['userId'];
$user = getUserById($userId);
$performance = getPerformanceByOwner($userId);
$choice = "performances";
$type = "P";

if (!isConnected()){
    $_SESSION['isConnected'] = "Vous devez être connecté pour accéder à cette page";
    header("Location: /");
 
    die();
}
if ($_SESSION['grade']!=5){
    header('Location: /');
}

?>

<div class="bailleur-content">
    <div class="d-flex justify-content-center align-items-center">

        <h1 style="padding-right: 1em;">Mes prestations</h1>
        <a href="addAPerformance.php" class="btn btn-primary">+</a>


    </div>
    <form action="" method="post">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Rechercher une annonce" name="search">
            <button class="btn btn-outline-secondary" type="submit" name="searchButton">Rechercher</button>
        </div>
    </form>
    <?php
    if (isset($_POST['searchButton'])) {
        $performance = searchingBar($_POST['search'], $choice);

    }
    if (empty($performance)) {
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
            <?php foreach ($performance as $key => $value) {
                $performanceId = $value['id'];
                $performanceTitle = $value['title'];
                $performanceCity = $value['city_appointment'];
                $performanceType = $value['performance_type'];
                $performancePrice = $value['price'];
                $performanceRate = $value['rate'];
                $performanceStatus = $value['is_validated'];


            ?>
                <tr>
                    <td><?= $performanceTitle ?></td>
                    <td><?= $performanceCity ?></td>
                    <td><?= $performanceType ?></td>
                    <td><?= $performancePrice ?></td>
                    <td><?= $performanceRate ?></td>

                    <td><?php if ($performanceStatus == 0) {
                            echo "En attente de validation";
                        } else {
                            echo "Validé";
                        } ?></td>

                    <td><a href="/ads?id=<?= $performanceId ?>&type=performance" class="btn btn-primary">Voir</a></td>
                    <td><a href="filesAdd?id=<?= $performanceId ?>" class="btn btn-info">Ajouter</a></td>
                    <td>
                        <?php if ($performanceStatus==1){?>
                        <a href="modifyAPerformance?id=<?=$performanceId?>" class="btn btn-warning">Modifier</a>
                        <?php } ?>
                        <a href="action?id=<?= $performanceId ?>&type=delete" class="btn btn-danger">Supprimer</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>

    </table>
</div>

<?php

require "../includes/footer.php"; ?>