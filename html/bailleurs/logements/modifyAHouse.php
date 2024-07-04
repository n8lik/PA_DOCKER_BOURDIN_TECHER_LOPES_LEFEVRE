<link href="../../css/bailleur.css" rel="stylesheet">
<?php
require '../../includes/header.php';
$id = $_GET['id'];
$userId = $_SESSION['userId'];
$house = getHousingById($id);
$experienceType = $house['management_type'];
$title = $house['title'];
$type_location = $house['type_location'];
$amount_room = $house['amount_room'];
$guest_capacity = $house['guest_capacity'];
$property_area = $house['property_area'];
$contact_phone = $house['contact_phone'];
$price = $house['price'];
$contact_time = $house['contact_time'];


if (!isConnected()){
    $_SESSION['isConnected'] = "Vous devez être connecté pour accéder à cette page";
    header("Location: /");
 
    die();
}
if ($_SESSION['grade']!=4){
    $_SESSION["error"] = "Vous n'avez pas les droits pour accéder à cette page";
    header('Location: /');
}
if ($house['id_user'] != $userId) {
    header("Location: houses.php");
}
?>

<div class="container border-form mt-5">
    <center>
        <h2 class="mb-4 ">Je modifie les informations de mon logement !</h2>
    </center>
    <?php if ($_SESSION["errorModify"] != '') { ?>
        <div><?php echo $_SESSION["errorModify"]; ?></div>
    <?php };
    $_SESSION['errorModify']=''; ?>
    <form method="POST" action="action?type=update&id=<?= $id ?>">
        <div>
            <label for="title">Titre de l'annonce</label>
            <input type="text" name="title" id="title" class="form-control" value="<?php echo $title;  ?>" style="width: 80% !important; ">
            
            <label for="management_type">Type d'expérience :</label>
            <select name="management_type" id="management_type" class="form-control" value="<?php echo $experienceType ?>" style="width: 80% !important; " required>
                <option value="Gestion de A à Z">Gestion de A à Z</option>
                <option value="Yield Management">Yield Management</option>
                <option value="Autre">Autre</option>
            </select>
            <label for="amount_room">Nombre de chambre</label>
            <input type="number" name="amount_room" id="amount_room" class="form-control" value="<?php echo $amount_room; ?>" style="width: 80% !important; " required>
            <label for="type_location">type de location </label>
            <select name="type_location" id="type_location" class="form-control" value="<?php echo $type_location; ?>" style="width: 80% !important; " required>
                <option value="Maison">Maison</option>
                <option value="Appartement">Appartement</option>
                <option value="Villa">Villa</option>
                <option value="Chambre d'hôtes">Chambre d'hôtes</option>
                <option value="Gîte">Gîte</option>
                <option value="otherLocation">Autre</option>
                <input type="text" id="otherField" name="otherField" class="form-control" style="display:none;" placeholder="Précisez le type de bien">
            </select>
            <label for="guest_capacity">Capacité d'accueil</label>
            <input type="number" name="guest_capacity" id="guest_capacity" class="form-control" value="<?php echo $guest_capacity; ?>" style="width: 80% !important; " required>
            <label for="property_area">Surface</label>
            <input type="number" name="property_area" id="property_area" class="form-control" value="<?php echo $property_area; ?>" style="width: 80% !important; " required>
            <label for="price">Prix</label>
            <input type="number" name="price" id="price" class="form-control" value="<?php echo $price; ?>" style="width: 80% !important; " required>
            <label for="contact_phone">Numéro de téléphone</label>
            <input type="number" name="contact_phone" id="contact_phone" class="form-control" value="<?php echo $contact_phone; ?>" style="width: 80% !important; " required>
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

        </div>

        <button type="submit" name="submit" class="btn btn-primary">Modifier</button>
    </form>
</div>
<?php
include '../../includes/footer.php';
?>