<?php
require '../../includes/header.php';

$userId = $_SESSION['userId'];
$user = getUserById($userId);
if (!isConnected()){
    $_SESSION['isConnected'] = "Vous devez être connecté pour accéder à cette page";
    header("Location: /");
 
    die();
}
if ($_SESSION['grade']!=4){
    $_SESSION["error"] = "Vous n'avez pas les droits pour accéder à cette page";
    header('Location: /');
}
if ($user["is_validated"]==0){
    echo "<div class='container mt-5'><center><div class='alert'>Votre compte n'est pas encore validé par un administrateur, vous ne pouvez pas ajouter de logement pour le moment.</h2></div></center></div>";
}else{
$type = 'add';
?>


<link href="../../css/bailleur.css" rel="stylesheet">


<div class="container border-form mt-5">
    <center>
        <h2 class="mb-4 ">Je propose mon logement !</h2>
    </center>
    <?php if ($_SESSION["errorAdd"] != '') { ?>
        <div><?php echo $_SESSION["errorAdd"]; ?></div>
    <?php };
    $_SESSION["errorAdd"] = ''; ?>
    <form method="POST" action="action?type=<?= $type ?>" enctype="multipart/form-data">

        <div class="form-group">
            <label for="Title">Titre</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Titre de l'annonce" value="<?php if (isset($_SESSION['data']["title"])) {
                                                                                                                        echo $_SESSION['data']["title"];
                                                                                                                    } ?>" required>
            <div class="form-group">
                <label for="Description">Description</label>
                <textarea class="form-control" id="description" name="description" placeholder="Description entre 30 et 500 caractères de votre annonce" rows="3" oninput="updateCounter()" required><?php if (isset($_SESSION['data']["description"])) {
                                                                                                                                                                                                            echo $_SESSION['data']["description"];
                                                                                                                                                                                                        } ?></textarea>
                <p>Caractères : <span id="charCount">0</span> /500</p>
            </div>

        </div>
        <div class="form-group">
            <label for="experienceType">Quel type d'expérience souhaitez-vous ?</label>
            <select class="form-control" id="experienceType" name="experienceType" required>
                <option value="" disabled selected>Sélectionnez une expérience</option>

                <option>Gestion de A à Z</option>
                <option>Yield Management</option>
                <option>Autre</option>
            </select>
        </div>

        <label for="propertyAddress">Adresse complète de votre propriété en location courte durée</label>
        <div class="form-row">


            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="propertyAddress" name="propertyAddress" placeholder="Adresse" value="<?php if (isset($_SESSION['data']["propertyAddress"])) {
                                                                                                                                        echo $_SESSION['data']["propertyAddress"];
                                                                                                                                    } ?>" required>
            </div>

            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="propertyCity" name="propertyCity" placeholder="Ville" value="<?php if (isset($_SESSION['data']["propertyCity"])) {
                                                                                                                                echo $_SESSION['data']["propertyCity"];
                                                                                                                            } ?>" required>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="propertyZip" name="propertyZip" placeholder="Code postal" value="<?php if (isset($_SESSION['data']["propertyZip"])) {
                                                                                                                                    echo $_SESSION['data']["propertyZip"];
                                                                                                                                } ?>" required>
            </div>
        </div>



        <div class="form-group">
            <select class="form-control" id="propertyCountry" name="propertyCountry" placeholder="Pays" required>

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
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="propertyType">Type de bien</label>
                <select class="form-control" name="propertyType" id="propertyType" required>
                    <option value="Maison">Maison</option>
                    <option value="Appartement">Appartement</option>
                    <option value="Villa">Villa</option>
                    <option value="Chambre d'hôtes">Chambre d'hôtes</option>
                    <option value="Gîte">Gîte</option>
                    <option value="otherType">Autre</option>
                    <input type="text" id="otherField" name="otherField" class="form-control" style="display:none;" placeholder="Précisez le type de bien">

                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="rentalType">Type de location</label>
                <select class="form-control" name="rentalType" id="rentalType" required>
                    <option>Logement complet</option>
                    <option>Chambre privée</option>
                    <option>Chambre partagée</option>
                    <option value="otherLocation">Autre</option>
                    <input type="text" id="otherFieldL" name="otherFieldL" class="form-control" style="display:none;" placeholder="Précisez le type de location">

                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="bedroomCount">Nombre de chambres</label>
                <input type="number" class="form-control" name="bedroomCount" id="bedroomCount" value="<?php if (isset($_SESSION['data']["bedroomCount"])) {
                                                                                                            echo $_SESSION['data']["bedroomCount"];
                                                                                                        } ?>" required>
            </div>
            <div class="form-group col-md-6">
                <label for="guestCapacity">Capacité d'accueil</label>
                <input type="number" class="form-control" name="guestCapacity" id="guestCapacity" value="<?php if (isset($_SESSION['data']["guestCapacity"])) {
                                                                                                                echo $_SESSION['data']["guestCapacity"];
                                                                                                            } ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label for="propertyArea">Surface en m²</label>
            <input type="number" class="form-control" name="propertyArea" id="propertyArea" value="<?php if (isset($_SESSION['data']["propertyArea"])) {
                                                                                                        echo $_SESSION['data']["propertyArea"];
                                                                                                    } ?>" required>
        </div>
        <div class="form-group">
            <label for="price">Prix à la nuit (en €)</label>
            <input type="number" class="form-control" id="price" name="price" value="<?php if (isset($_SESSION['data']["price"])) {
                                                                                            echo $_SESSION['data']["price"];
                                                                                        }; ?>" required>
        </div>

        <div class="form-group">
            <label for="contactPhone">Téléphone</label>
            <input type="tel" class="form-control" id="contactPhone" name="contactPhone" value="<?php if (isset($_SESSION['data']["contactPhone"])) {
                                                                                                    echo $_SESSION['data']["contactPhone"];
                                                                                                } ?>" required>
        </div>

        <div class="form-check-inline">
            <label for="contact_time">Me contacter (si rien n'est coché vous êtes succeptible d'être appelé n'importe quand) :</label>

            <input class="form-check-input" type="checkbox" value="1" name="timeSlot1" id="timeSlot1">
            <input type="hidden" name="timeSlot1_hidden" value="0">
            <label class="form-check-label" for="timeSlot1">Avant 13h00</label>
        </div>
        <div class="form-check-inline">
            <input class="form-check-input" type="checkbox" value="1" name="timeSlot2" id="timeSlot2">
            <input type="hidden" name="timeSlot2_hidden" value="0">
            <label class="form-check-label" for="timeSlot2">13h00 - 18h00</label>
        </div>
        <div class="form-check-inline">
            <input class="form-check-input" type="checkbox" value="1" name="timeSlot3" id="timeSlot3">
            <input type="hidden" name="timeSlot3_hidden" value="0">
            <label class="form-check-label" for="timeSlot3">Après 18h00</label>
        </div>
        <Br><Br>
        <div>
            <div class="form-group">
                <label for="file">Image du logement</label><Br>
                <input type="file" id="file" name="file"><br>
            </div>


        </div>
        <div class="form-group">
            <label for="moreOptions">Plus d'options</label>
            <div id="moreOptions">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" name="wifi" id="wifi">
                    <label class="form-check-label" for="wifi">WiFi</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" name="piscine" id="piscine">
                    <label class="form-check-label" for="piscine">Piscine</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" name="tele" id="tele">
                    <label class="form-check-label" for="tele">Télé</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" name="four" id="four">
                    <label class="form-check-label" for="four">Four</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" name="cuisineEquipee" id="cuisineEquipee">
                    <label class="form-check-label" for="cuisineEquipee">Cuisine équipée</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" name="laveLinge" id="laveLinge">
                    <label class="form-check-label" for="laveLinge">Lave-linge</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" name="parking" id="parking">
                    <label class="form-check-label" for="parking">Parking</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" name="climatisation" id="climatisation">
                    <label class="form-check-label" for="climatisation">Climatisation</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" name="cheminee" id="cheminee">
                    <label class="form-check-label" for="cheminee">Cheminée</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" name="detecteurFumee" id="detecteurFumee">
                    <label class="form-check-label" for="detecteurFumee">Détecteur de fumée</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" name="salleSport" id="salleSport">
                    <label class="form-check-label" for="salleSport">Salle de sport</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <input type="checkbox" name="acceptation" id="acceptation" required>
            <label for="acceptation">J'accepte la déclaration de confidentialité et les conditions générales d'utilisation</label>
        </div>


        <button type="submit" class="btn btn-primary" name="submit">Envoyer</button>
    </form>
</div>
<?php

unset($_SESSION['data']);
?> 
<script>
    function showOtherField($id, $id_showed) {

        var userInput = document.getElementById($id_showed);
        userInput.style.display = selectBox.value == $id ? 'block' : 'none';
    }


    selectBox.addEventListener('change', function() {
        showOtherField('otherType', 'otherField');
    });
    selectBox.addEventListener('change', function() {
        showOtherField('otherLocation', 'otherFieldL');
    });

    function updateCounter() {
        const textarea = document.getElementById('description');
        const charCount = document.getElementById('charCount');
        charCount.textContent = textarea.value.length;
    }
</script>
</script>
<?php

}

include '../../includes/footer.php';
