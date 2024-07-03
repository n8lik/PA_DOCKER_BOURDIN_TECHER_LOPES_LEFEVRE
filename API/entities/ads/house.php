<?php

require_once __DIR__ . "/../../database/connection.php";


function insertHousing($title,$description, $experienceType, $id_user, $propertyAddress, $propertyCity, $propertyZip, $propertyCountry, $fee,$propertyType, $rentalType, $bedroomCount, $guestCapacity, $propertyArea, $price, $contactPhone, $time, $wifi , $parking, $pool, $tele, $oven, $air_conditionning ,$wash_machine, $gym ,$kitchen)
{
    $db = connectDB();

    $queryprepare = $db->prepare("INSERT INTO housing (title, description, id_user, management_type, address, city, postal_code, country, fee, type_house, type_location, amount_room, guest_capacity, property_area, price, contact_phone, contact_time, wifi, parking, pool, tele, oven, air_conditionning, wash_machine, gym, kitchen) VALUES (:title, :description, :id_user, :management_type, :address, :city, :postal_code, :country, :fee, :type_house, :type_location, :amount_room, :guest_capacity, :property_area, :price, :contact_phone, :contact_time, :wifi, :parking, :pool, :tele, :oven, :air_conditionning, :wash_machine, :gym, :kitchen)");
    $queryprepare->execute([
        'title' => $title,
        'description' => $description,
        'id_user' => $id_user,
        'management_type' => $experienceType,
        'address' => $propertyAddress,
        'city' => $propertyCity,
        'postal_code' => $propertyZip,
        'country' => $propertyCountry,
        'fee' => $fee,
        'type_house' => $propertyType,
        'type_location' => $rentalType,
        'amount_room' => $bedroomCount,
        'guest_capacity' => $guestCapacity,
        'property_area' => $propertyArea,
        'price' => $price,
        'contact_phone' => $contactPhone,
        'contact_time' => $time,
        'wifi' => $wifi,
        'parking' => $parking,
        'pool' => $pool,
        'tele' => $tele,
        'oven' => $oven,
        'air_conditionning' => $air_conditionning,
        'wash_machine' => $wash_machine,
        'gym' => $gym,
        'kitchen' => $kitchen
    ]);
    $lastId = $db->lastInsertId();
    
    return $lastId;

}

function getHousingById($id){
    $db = connectDB();
    $req = $db->prepare("SELECT * FROM housing WHERE id = :id");
    $req->execute(['id' => $id]);
    return $req->fetch();
}


function deletehouse($id){
    $id_user = getHousingById($id)['id_user'];

    $db = connectDB();
    $req = $db->prepare("DELETE FROM housing WHERE id = :id");
    $req->execute(['id' => $id]);
    $basePath = 'externalFiles/ads/housing/';
    $extensions = ['jpg', 'png', 'jpeg'];
    for ($compteur = 0; $compteur <= 9; $compteur++) {
        foreach ($extensions as $ext) {
            $filePath = $basePath . $id . '_' . $id_user .'_'. $compteur . '.' . $ext;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }
    return 1;  
}