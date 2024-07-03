<?php

function getAdsImages($id, $type)
{
    $images = [];
    $dir = __DIR__ . "/../../externalFiles/ads/" . $type;
    $files = scandir($dir);
    foreach ($files as $file) {
        $parts= explode("_", $file);
        if ($parts[0] == $id) {
            $images[] = "https://pcs-all.online:8000/externalFiles/ads/" . $type . "/" . $file;
        }
    }
    return $images;
}

function getAdsInfo ($id, $type)
{
    require_once __DIR__ . "/../../database/connection.php";
    $db = connectDB();

    if ($type == 'housing') {
        $req = $db->prepare("SELECT * FROM housing WHERE id = :id");
        $req->execute(['id' => $id]);
        return $req->fetch(PDO::FETCH_ASSOC);
    } else if ($type == 'performance') {
        $req = $db->prepare("SELECT * FROM performances WHERE id = :id");
        $req->execute(['id' => $id]);
        return $req->fetch(PDO::FETCH_ASSOC);
    } else {
        return null;
    }
}

function getAdsAddress($id, $type)
{
    require_once __DIR__ . "/../../database/connection.php";
    $db = connectDB();

    if ($type == 'housing') {
        $req = $db->prepare("SELECT * FROM housing WHERE id = :id");
        $req->execute(['id' => $id]);
        $housing = $req->fetch();
        return $housing["address"] . " " . $housing["city"] . " " . $housing["postal_code"];
    } else if ($type == 'performance') {
        $req = $db->prepare("SELECT * FROM performances WHERE id = :id");
        $req->execute(['id' => $id]);
        $performance = $req->fetch();
        return $performance["address_appointment"] . " " . $performance["city_appointment"] . " " . $performance["zip_code_appointment"];
    } else {
        return null;
    }
}


function getAdsAverageRate($id, $type)
{
    require_once __DIR__ . "/../../database/connection.php";
    $db = connectDB();

    if ($type == 'housing') {

        $req = $db->prepare("SELECT AVG(rate) as average FROM booking WHERE housing_id = :id");
        $req->execute(['id' => $id]);
       
       
        return round($req->fetch()["average"], 2);
    } else if ($type == 'performance') {
        $req = $db->prepare("SELECT AVG(rate) as average FROM booking WHERE performance_id = :id");
        $req->execute(['id' => $id]);
        return round($req->fetch()["average"], 2);
    } else {
        return null;
    }
}

function getAdsComments($id, $type)
{
    require_once __DIR__ . "/../../database/connection.php";
    $db = connectDB();
    //récupérer les commentaires (review dans booking) et le pseudo dans user correspondant à l'user_id dans booking grace a une jointure, et où review not null
    if ($type == 'housing') {
        $req = $db->prepare("SELECT review, pseudo, user_id FROM booking INNER JOIN user ON booking.user_id = user.id WHERE housing_id = :id AND review IS NOT NULL");
        $req->execute(['id' => $id]);
        return $req->fetchAll();
    } else if ($type == 'performance') {
        $req = $db->prepare("SELECT review, pseudo, user_id FROM booking INNER JOIN user ON booking.user_id = user.id WHERE performance_id = :id AND review IS NOT NULL");
        $req->execute(['id' => $id]);
        return $req->fetchAll();
    } else {
        return null;
    }
}

function getAllAdsByOwnerId($id){
    require_once __DIR__ . "/../../database/connection.php";
    $db = connectDB();
    
    //Récupérer les annonces de logements
    $req = $db->prepare("SELECT * FROM housing WHERE id_user = :id");
    $req->execute(['id' => $id]);
    $housings = $req->fetchAll(PDO::FETCH_ASSOC);
    //Récupérer les images et les ajouter à chaque annonce de logement
    foreach ($housings as &$housing) { //Référence pour modifier directement la valeur dans le tableau
        $housing["images"] = getAdsImages($housing["id"], "housing");
        $housing["tmp"] = "housing";
    }
    unset($housing);
    
    //Récupérer les annonces de performances
    $req = $db->prepare("SELECT * FROM performances WHERE id_user = :id");
    $req->execute(['id' => $id]);
    $performances = $req->fetchAll(PDO::FETCH_ASSOC);
    
    //Récupérer les images et les ajouter à chaque annonce de performance
    foreach ($performances as &$performance) { 
        $performance["images"] = getAdsImages($performance["id"], "performance");
        $performance["tmp"] = "performance";
    }
    unset($performance);
    
    return array_merge($housings, $performances);
}

?>
