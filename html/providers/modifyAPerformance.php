<link href="../css/bailleur.css" rel="stylesheet">
<link href="../css/map.css" rel="stylesheet">

<?php
require '../includes/header.php';
$id = $_GET['id'];
$userId = $_SESSION['userId'];
$performance = getPerformanceById($id);
$performance_type = $performance[0]["performance_type"];
$title = $performance[0]["title"];
$description = $performance[0]["description"];
$address_appointment = $performance[0]["address_appointment"];
$city_appointment = $performance[0]["city_appointment"];
$zip_appointment = $performance[0]["zip_appointment"];
$country_appointment = $performance[0]["country_appointment"];
$price = $performance[0]["price"];
$price_type = $performance[0]["price_type"];
$place = $performance[0]["place"];
$radius = $performance[0]["radius"];
$fee = $price * 0.20;
if (!isConnected()){
    $_SESSION['isConnected'] = "Vous devez être connecté pour accéder à cette page";
    header("Location: /");
 
    die();
}
if ($_SESSION['grade']!=5){
    header('Location: /');
}
if ($performance[0]['id_user'] != $userId) {
    header("Location: performances.php");
}
?>


<div class="container border-form mt-5">
    <center>
        <h2 class="mb-4 ">Je propose mon service !</h2>
    </center>
    <?php if ($_SESSION["errorUpdateP"] != '') { ?>
        <div><?php
                echo $_SESSION["errorUpdateP"]; ?></div>
    <?php };
    $_SESSION['errorUpdateP'] = ''; ?>
    <form method="POST" action="action?type=update">

        <div class="form-group">
            <label for="Title">Titre</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Titre de l'annonce" value="<?php echo $title; ?>" required>


        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Description de l'annonce" value="" required><?php echo $description; ?></textarea>
        </div>


        <label for="place-input">Lieu d'action</label>

        <?php include 'map.php'; ?>


        <br>

        <label for="propertyAddress">Adresse de facturation</label>
        <div class="form-row">


            <div class="form-group col-md-3">
                <input type="text" class="form-control" id="address_appointment" name="address_appointment" placeholder="Adresse" value="<?php echo $address_appointment; ?>" required>
            </div>

            <div class="form-group col-md-3">
                <input type="text" class="form-control" id="city_appointment" name="city_appointment" placeholder="Ville" value="<?php echo $city_appointment; ?>" required>
            </div>
            <div class="form-group col-md-3">
                <input type="text" class="form-control" id="zip_appointment" name="zip_appointment" placeholder="Code postal" value="<?php echo $zip_appointment; ?>" required>
            </div>
            <div class="form-group col-md-3">
                <select class="form-control" id="country_appointment" name="country_appointment" required>
                    <option value="<?php $country_appointment; ?>" selected><?php echo $country_appointment; ?></option>
                    <option value="France">France</option>
                    <option value="Belgique">Belgique</option>
                    <option value="Suisse">Suisse</option>
                    <option value="Luxembourg">Luxembourg</option>
                    <option value="Allemagne">Allemagne</option>
                    <option value="Royaume-Uni">Royaume-Uni</option>
                    <option value="Espagne">Espagne</option>
                    <option value="Italie">Italie</option>
                    <option value="Pays-Bas">Pays-Bas</option>
                    <option value="Portugal">Portugal</option>
                    <option value="Autriche">Autriche</option>
                    <option value="Suède">Suède</option>
                    <option value="Danemark">Danemark</option>
                    <option value="Finlande">Finlande</option>
                    <option value="Norvège">Norvège</option>
                    <option value="Grèce">Grèce</option>
                    <option value="Irlande">Irlande</option>
                    <option value="Pologne">Pologne</option>
                    <option value="République tchèque">République tchèque</option>
                    <option value="Slovaquie">Slovaquie</option>
                    <option value="Hongrie">Hongrie</option>
                    <option value="Roumanie">Roumanie</option>
                    <option value="Bulgarie">Bulgarie</option>
                    <option value="Croatie">Croatie</option>
                    <option value="Slovénie">Slovénie</option>
                    <option value="Estonie">Estonie</option>
                    <option value="Lettonie">Lettonie</option>
                    <option value="Lituanie">Lituanie</option>
                    <option value="Malte">Malte</option>
                    <option value="Chypre">Chypre</option>
                </select>
            </div>
        </div>

        <div class="form-groupe">
            <label for="price" class="form-label">Prix</label>
            <input type="number" class="form-control" id="price" name="price" placeholder="Prix" value="<?php echo $price; ?>" required>
            <label for="price_type">Prix par</label>
            <select class="form-control" id="price_type" name="price_type" required>
                <option value="" disabled selected>Sélectionnez une unité</option>

                <?php
                if ($performance_type == "taxi") {
                    if ($price_type == "km") {
                        echo '<option value="km" selected>km</option>';
                        echo '<option value="heure">heure</option>';
                    } else {
                        echo '<option value="km">km</option>';
                        echo '<option value="heure" selected>heure</option>';
                    }
                } elseif ($performance_type == "ménage") {
                    if ($price_type == "m²") {
                        echo '<option value="m²" selected>m²</option>';
                        echo '<option value="heure">heure</option>';
                    } else {
                        echo '<option value="m²">m²</option>';
                        echo '<option value="heure" selected>heure</option>';
                    }
                } elseif ($performance_type == "plomberie") {
                    if ($price_type == "prestation") {
                        echo '<option value="prestation" selected>prestation</option>';
                        echo '<option value="heure">heure</option>';
                    } else {
                        echo '<option value="prestation">prestation</option>';
                        echo '<option value="heure" selected>heure</option>';
                    }
                } elseif ($performance_type == "menuisier") {
                    if ($price_type == "prestation") {
                        echo '<option value="prestation" selected>prestation</option>';
                        echo '<option value="heure">heure</option>';
                    } else {
                        echo '<option value="prestation">prestation</option>';
                        echo '<option value="heure" selected>heure</option>';
                    }
                } elseif ($performance_type == "entretien") {
                    if ($price_type == "prestation") {
                        echo '<option value="prestation" selected>prestation</option>';
                        echo '<option value="heure">heure</option>';
                    } else {
                        echo '<option value="prestation">prestation</option>';
                        echo '<option value="heure" selected>heure</option>';
                    }
                } elseif ($performance_type == "paysagiste") {
                    if ($price_type == "prestation") {
                        echo '<option value="prestation" selected>prestation</option>';
                        echo '<option value="heure">heure</option>';
                    } else {
                        echo '<option value="prestation">prestation</option>';
                        echo '<option value="heure" selected>heure</option>';
                    }
                } elseif ($performance_type == "electricien") {
                    if ($price_type == "prestation") {
                        echo '<option value="prestation" selected>prestation</option>';
                        echo '<option value="heure">heure</option>';
                    } else {
                        echo '<option value="prestation">prestation</option>';
                        echo '<option value="heure" selected>heure</option>';
                    }
                } elseif ($performance_type == "peintre") {
                    if ($price_type == "prestation") {
                        echo '<option value="prestation" selected>prestation</option>';
                        echo '<option value="mur">mur</option>';
                        echo '<option value="heure">heure</option>';
                    } else {
                        echo '<option value="prestation">prestation</option>';
                        echo '<option value="mur" selected>mur</option>';
                        echo '<option value="heure">heure</option>';
                    }
                } elseif ($performance_type == "chauffagiste") {
                    if ($price_type == "prestation") {
                        echo '<option value="prestation" selected>prestation</option>';
                        echo '<option value="heure">heure</option>';
                    } else {
                        echo '<option value="prestation">prestation</option>';
                        echo '<option value="heure" selected>heure</option>';
                    }
                }
                ?>







            </select>
        </div>


        <div class="form-group">
            <input type="checkbox" name="acceptation" id="acceptation" required>
            <label for="acceptation">J'accepte la déclaration de confidentialité et les conditions générales d'utilisation</label>
        </div>


        <button type="submit" class="btn btn-primary" name="submit">Envoyer</button>


    </form>
</div>

<?php



include '../includes/footer.php';
