<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require '../../includes/functions/functions.php';
require '../../vendor/autoload.php';
if (!isConnected()){
    $_SESSION['isConnected'] = "Vous devez être connecté pour accéder à cette page";
    header("Location: /");
 
    die();
}
if ($_SESSION['grade']!=4){
    $_SESSION["error"] = "Vous n'avez pas les droits pour accéder à cette page";
    header('Location: /');
}
use GuzzleHttp\Client;

$connect = connectDB();
$getType = $_GET["type"];

if(isset($_GET["id"])){
    $id = $_GET["id"];
    $house = getHousingById($id);

}


$id_user = $_SESSION['userId'];


if ($getType == "delete") {
    
    $id = $_GET["id"];
    $client = new Client([
        'base_uri' => 'https://pcs-all.online:8000/',
        'timeout'  => 2.0,
    ]);
    $response = $client->delete('deleteHouse/'. $id);
    
    header('Location: houses.php');
}

if ($getType == "add") {

    if (isset($_POST['submit'])) {
        $title = $_POST['title'];
        $experienceType = $_POST['experienceType'];
        $description = $_POST['description'];
        $propertyAddress = $_POST['propertyAddress'];
        $propertyCity = $_POST['propertyCity'];
        $propertyZip = $_POST['propertyZip'];
        $propertyCountry = $_POST['propertyCountry'];
        if ($_POST['propertyType'] == 'other') {
            $propertyType = $_POST['otherField'];
        } else {
            $propertyType = $_POST['propertyType'];
        }
        $rentalType = $_POST['rentalType'];
        $bedroomCount = $_POST['bedroomCount'];
        $guestCapacity = $_POST['guestCapacity'];
        $propertyArea = $_POST['propertyArea'];
        $price = $_POST['price'];
        $fee = $price * 0.20;
        $contactPhone = $_POST['contactPhone'];
        $timeSlot1 = isset($_POST['timeSlot1']) ? $_POST['timeSlot1'] : $_POST['timeSlot1_hidden'];
        $timeSlot2 = isset($_POST['timeSlot2']) ? $_POST['timeSlot2'] : $_POST['timeSlot2_hidden'];
        $timeSlot3 = isset($_POST['timeSlot3']) ? $_POST['timeSlot3'] : $_POST['timeSlot3_hidden'];
        // si $_post['wifi'] est vide alors $wifi = 0 sinon $wifi = 1
        $wifi = isset($_POST['wifi']) ? 1 : 0;
        $parking = isset($_POST['parking']) ? 1 : 0;
        $pool = isset($_POST['piscine']) ? 1 : 0;
        $tele = isset($_POST['tele']) ? 1 : 0;
        $oven = isset($_POST['four']) ? 1 : 0;
        $wash_machine = isset($_POST['laveLinge']) ? 1 : 0;
        $kitchen = isset($_POST['cuisineEquipee']) ? 1 : 0;
        $air_conditionning = isset($_POST['climatisation']) ? 2 : 1;
        $gym = isset($_POST['salleSport']) ? 2 : 1;



        $_SESSION['data']['title'] = $title;
        $_SESSION['data']['experienceType'] = $experienceType;
        $_SESSION['data']['description'] = $description;
        $_SESSION['data']['propertyAddress'] = $propertyAddress;
        $_SESSION['data']['propertyCity'] = $propertyCity;
        $_SESSION['data']['propertyZip'] = $propertyZip;
        $_SESSION['data']['propertyCountry'] = $propertyCountry;
        $_SESSION['data']['propertyType'] = $propertyType;
        $_SESSION['data']['rentalType'] = $rentalType;
        $_SESSION['data']['bedroomCount'] = $bedroomCount;
        $_SESSION['data']['guestCapacity'] = $guestCapacity;
        $_SESSION['data']['propertyArea'] = $propertyArea;
        $_SESSION['data']['price'] = $price;
        $_SESSION['data']['contactPhone'] = $contactPhone;
        $_SESSION['data']['timeSlot1'] = $timeSlot1;
        $_SESSION['data']['timeSlot2'] = $timeSlot2;
        $_SESSION['data']['timeSlot3'] = $timeSlot3;
        $_SESSION['data']['wifi'] = $wifi;
        $_SESSION['data']['parking'] = $parking;
        $_SESSION['data']['piscine'] = $pool;
        $_SESSION['data']['tele'] = $tele;
        $_SESSION['data']['four'] = $oven;
        $_SESSION['data']['laveLinge'] = $wash_machine;
        $_SESSION['data']['cuisineEquipee'] = $kitchen;
        $_SESSION['data']['climatisation'] = $air_conditionning;
        $_SESSION['data']['salleSport'] = $gym;





        $time = contactTime($timeSlot1, $timeSlot2, $timeSlot3);

        $errorMessage = '';


        if (strlen($title) < 3 || strlen($title) > 50) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">Le titre doit contenir entre 3 et 50 caractères.</div>';
        }

        // Description juste entre 30 et 500 caractères (non pas de regex)
        if (strlen($description) < 30 || strlen($description) > 500) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">La description doit contenir entre 30 et 500 caractères.</div>';
        }

        if (strlen($propertyAddress) < 3 || strlen($propertyAddress) > 50) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">L\'adresse doit contenir entre 3 et 50 caractères.</div>';
        }

        if (strlen($propertyCity) < 3 || strlen($propertyCity) > 50) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">La ville doit contenir entre 3 et 50 caractères.</div>';
        }

        if (!preg_match("/^[0-9]{5}$/", $propertyZip)) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">Le code postal doit contenir 5 chiffres.</div>';
        }

        if (strlen($propertyCountry) < 3 || strlen($propertyCountry) > 50) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">Le pays doit contenir entre 3 et 50 caractères.</div>';
        }

        if (strlen($bedroomCount) < 1 || strlen($bedroomCount) > 2 || !preg_match("/^[0-9]{1,2}$/", $bedroomCount)) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">Le nombre de chambres doit être compris entre 1 et 2 chiffres.</div>';
        }

        if (strlen($guestCapacity) < 1 || strlen($guestCapacity) > 2 || !preg_match("/^[0-9]{1,2}$/", $guestCapacity)) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">La capacité d\'accueil doit être comprise entre 1 et 2 chiffres.</div>';
        }

        if (strlen($propertyArea) < 1 || strlen($propertyArea) > 4 || !preg_match("/^[0-9]{1,4}$/", $propertyArea)) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">La surface doit être comprise entre 1 et 4 chiffres.</div>';
        }

        if (!preg_match("/^[0-9]{1,4}$/", $price)) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">Le prix doit être compris entre 1 et 4 chiffres.</div>';
        }

        if (!preg_match("/^[0-9]{10}$/", $contactPhone)) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">Le numéro de téléphone doit contenir 10 chiffres.</div>';
        }

        if (!isset($_POST['acceptation'])) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">Vous devez accepter les conditions générales d\'utilisation.</div>';
        }
        if ($experienceType == '') {
            $errorMessage .= '<div class="alert alert-danger" role="alert">Vous devez choisir un type de gestion.</div>';
        }
        // si files empty alors erreur
        if (empty($_FILES['file']['name'])) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">Vous devez télécharger au moins une image de votre logement.</div>';
        }

        // vérif si c une image via l'extension (jpg jpeg ou png uniquement)
        $allowed = ['jpg', 'jpeg', 'png'];
        $fileExtension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        if (!in_array($fileExtension, $allowed)) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">Désolé, seuls les fichiers JPG, JPEG et PNG sont autorisés.</div>';
        }
        //si la taille du  fichier est supérieur à 15mo alors erreur
        if ($_FILES['file']['size'] > 15728640) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">Désolé, votre fichier est trop volumineux.</div>';
        }
        if ($errorMessage === '') {
            $client = new Client(['base_uri' => 'https://pcs-all.online:8000']);

            // Préparer les parties multipart pour les champs du formulaire
            $multipart = [
                ['name' => 'title', 'contents' => $title],
            ['name' => 'id_user', 'contents' => $id_user],
            ['name' => 'experienceType', 'contents' => $experienceType],
            ['name' => 'description', 'contents' => $description],
            ['name' => 'propertyAddress', 'contents' => $propertyAddress],
            ['name' => 'propertyCity', 'contents' => $propertyCity],
            ['name' => 'propertyZip', 'contents' => $propertyZip],
            ['name' => 'propertyCountry', 'contents' => $propertyCountry],
            ['name' => 'propertyType', 'contents' => $propertyType],
            ['name' => 'rentalType', 'contents' => $rentalType],
            ['name' => 'bedroomCount', 'contents' => $bedroomCount],
            ['name' => 'guestCapacity', 'contents' => $guestCapacity],
            ['name' => 'propertyArea', 'contents' => $propertyArea],
            ['name' => 'price', 'contents' => $price],
            ['name' => 'fee', 'contents' => $fee],
            ['name' => 'contactPhone', 'contents' => $contactPhone],
            ['name' => 'time', 'contents' => $time],
            ['name' => 'wifi', 'contents' => $wifi],
            ['name' => 'parking', 'contents' => $parking],
            ['name' => 'pool', 'contents' => $pool],
            ['name' => 'tele', 'contents' => $tele],
            ['name' => 'oven', 'contents' => $oven],
            ['name' => 'wash_machine', 'contents' => $wash_machine],
            ['name' => 'kitchen', 'contents' => $kitchen],
            ['name' => 'air_conditionning', 'contents' => $air_conditionning],
            ['name' => 'gym', 'contents' => $gym],
            [
                'name' => 'file',
                'contents' => fopen($_FILES['file']['tmp_name'], 'r'),
                'filename' => $_FILES['file']['name']
            ]
            ];

            try {
                // Envoyer la requête multipart
                $response = $client->post('https://pcs-all.online:8000/addAHouse', [
                    'multipart' => $multipart
                ]);

                $body = json_decode($response->getBody()->getContents(),true);
                if ($body['success'] == true)
                    echo "<script>alert('Votre demande a bien été envoyée, elle sera traitée prochainement.');</script>";
                echo "<script> window.location.href='houses.php';</script>";
            } catch (Exception $e) {
                echo $e->getMessage();
                die();
            }
        } else {
            $_SESSION["errorAdd"] = $errorMessage;
            header("Location: addAHouse.php");
        }
    }
}

if ($getType == 'update') {
    $id = $_GET["id"];
    if (isset($_POST['submit'])) {
        $title = $_POST['title'];

        $experienceType = $_POST['management_type'];
        $title = $_POST['title'];
        $typeLocation = $_POST['type_location'];
        $amountRoom = $_POST['amount_room'];
        $guestCapacity = $_POST['guest_capacity'];
        $propertyArea = $_POST['property_area'];
        $contactPhone =  $_POST['contact_phone'];
        $price = $_POST['price'];
        $timeSlot1 = isset($_POST['timeSlot1']) ? $_POST['timeSlot1'] : $_POST['timeSlot1_hidden'];
        $timeSlot2 = isset($_POST['timeSlot2']) ? $_POST['timeSlot2'] : $_POST['timeSlot2_hidden'];
        $timeSlot3 = isset($_POST['timeSlot3']) ? $_POST['timeSlot3'] : $_POST['timeSlot3_hidden'];

        $time = contactTime($timeSlot1, $timeSlot2, $timeSlot3);

        $errorMessage = '';


        // vérification que le formulaire est rempli avec de bonnes informations (regex)
        if (!preg_match("/^[a-zA-Z0-9 ]{3,50}$/", $title)) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">Le titre doit contenir entre 3 et 50 caractères.</div>';
        }

        if (!preg_match("/^[0-9]{1,2}$/", $ammuntRoom)) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">Le nombre de chambres doit être compris entre 1 et 2 chiffres.</div>';
        }
        if (!preg_match("/^[0-9]{1,2}$/", $guestCapacity)) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">La capacité d\'accueil doit être comprise entre 1 et 2 chiffres.</div>';
        }
        if (!preg_match("/^[0-9]{1,4}$/", $propertyArea)) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">La surface doit être comprise entre 1 et 4 chiffres.</div>';
        }
        // regex prix compris entre 0.00 et 9999.99 
        if (!preg_match('/^(\d{1,4}(\.\d{1,2})?|9999(\.00)?)$/', $price)) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">Le prix doit être compris entre 1 et 4 chiffres.</div>';
        }
        if (!preg_match("/^[0-9]{10}$/", $contactPhone)) {
            $errorMessage .= '<div class="alert alert-danger" role="alert">Le numéro de téléphone doit contenir 10 chiffres.</div>';
        }

        if ($experienceType == '') {
            $errorMessage .= '<div class="alert alert-danger" role="alert">Vous devez choisir un type de gestion.</div>';
        }


        if ($errorMessage === '') { // Si aucune erreur n'est présente, exécuter la fonction d'insertion
            updateHousing($id, $title, $type_location, $amountRoom, $experienceType, $guestCapacity, $propertyArea, $contactPhone, $time);
            echo "<script>alert('Votre demande a bien été envoyée, elle sera traitée prochainement.');</script>";
            echo "<script> window.location.href='houses.php';</script>";
        } else {
            $_SESSION["errorModify"] = $errorMessage;

            header("Location: modifyAHouse.php?id=" . $id);
        }
    }
}

if ($getType == "addFiles") {
    $id = $_GET["id"];
    $type = $_GET["usertype"];
    $user = getUserById($id_user);
    $housing = getHousingById($id);
    $filetype= $_POST['type'];

    if (isset($_POST['submit'])) {
            $client = new Client(['base_uri' => 'https://pcs-all.online:8000']);

            // Préparer les parties multipart pour les champs du formulaire
            $multipart = [
                ['name' => 'userId', 'contents' => $id_user],
                ['name' => 'adsId', 'contents' => $id],
                ['name' => 'type', 'contents' => $type],
                ['name' => 'filetype' , 'contents' => $filetype],
                [
                    'name' => 'file',
                    'contents' => fopen($_FILES['file']['tmp_name'], 'r'),
                    'filename' => $_FILES['file']['name']
                ] 
             
            ];

            try {
                // Envoyer la requête multipart
                $response = $client->post('https://pcs-all.online:8000/addAFile', [
                    'multipart' => $multipart
                ]);
        
                $body = json_decode($response->getBody()->getContents(), true);
                
                if ($body['success'] == true){
                    echo "<script>alert('Votre demande a bien été envoyée, elle sera traitée prochainement (vous pouvez retrouver vos fichiers dans la rubrique Mes Documents.');</script>";
                echo "<script> window.location.href='houses.php';</script>";
            }
            else{
                $errors = '<div class="alert alert-danger" role="alert">'.$body["message"].'</div>';
                $_SESSION['errorFile'] = $errors;
                header("Location: ../filesAdd.php?id=" . $id);}
            } catch (Exception $e) {
                echo $e->getMessage();
                die();
            }
        
    }
}
    
