<?php

require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../entities/ads/house.php";
require_once __DIR__ . "/../../entities/files.php";
require_once __DIR__ . "/../../libraries/parameters.php";
file_put_contents('/var/log/apilog/logpost.log', print_r($_POST, true), FILE_APPEND);
file_put_contents('/var/log/apilog/logfile.log', print_r($_FILES, true), FILE_APPEND);


$title = $_POST["title"];
$description = $_POST["description"];
$experienceType = $_POST["experienceType"];
$id_user = $_POST["id_user"];
$propertyAddress = $_POST["propertyAddress"];
$propertyCity = $_POST["propertyCity"];
$propertyZip = $_POST["propertyZip"];
$propertyCountry = $_POST["propertyCountry"];
$fee = $_POST["fee"];
$propertyType = $_POST["propertyType"];
$rentalType = $_POST["rentalType"];
$bedroomCount = $_POST["bedroomCount"];
$guestCapacity = $_POST["guestCapacity"];
$propertyArea = $_POST["propertyArea"];
$price = $_POST["price"];
$contactPhone = $_POST["contactPhone"];
$time = $_POST["time"];
$wifi = $_POST["wifi"];
$parking = $_POST["parking"];
$pool = $_POST["pool"];
$tele = $_POST["tele"];
$oven = $_POST["oven"];
$air_conditionning = $_POST["air_conditionning"];
$wash_machine = $_POST["wash_machine"];
$gym = $_POST["gym"];
$kitchen = $_POST["kitchen"];



$insert = insertHousing($title, $description, $experienceType, $id_user, $propertyAddress, $propertyCity, $propertyZip, $propertyCountry, $fee, $propertyType, $rentalType, $bedroomCount, $guestCapacity, $propertyArea, $price, $contactPhone, $time, $wifi, $parking, $pool, $tele, $oven, $air_conditionning, $wash_machine, $gym, $kitchen);
if (!$insert) {
    echo jsonResponse(
        400,
        [],
        [
            "success" => false,
            "message" => "Erreur lors de l'ajout de la maison"
        ]
    );
    die();
}

$file = $_FILES["file"];
$usertype = "housing";

                        





uploadImageforHouse($usertype, $id_user, $insert, $file);


echo jsonResponse(200, [], [
    "success" => true,
    "message" => $insert
]);
 
