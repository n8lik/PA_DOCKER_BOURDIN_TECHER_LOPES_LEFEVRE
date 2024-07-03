<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function isbooked($id, $type, $start_date, $end_date)
{
    require_once __DIR__ . "/../../database/connection.php";

    if ($type = "housing") {
        $db = connectDB();
        $req = $db->prepare("UPDATE disponibility SET is_booked = 1 WHERE id_housing = :id AND date >= :start_date AND date <= :end_date");

        $req->execute([
            'id' => $id,
            'start_date' => $start_date,
            'end_date' => $end_date
        ]);
    } else if ($type = "performance") {

       
    }
}


function getBookingById($id)
{
    require_once __DIR__ . "/../../database/connection.php";

    $db = connectDB();

    $req = $db->prepare("SELECT * FROM booking WHERE id = :id");
    $req->execute(['id' => $id]);
    return $req->fetch();
}
function getBookingByDate($id, $firstDay, $lastDay){
    require_once __DIR__ . "/../../database/connection.php";
    require_once __DIR__ . "/../ads/adsInfo.php";

    $db = connectDB();
    $req = $db->prepare("SELECT id FROM housing WHERE id_user = :id ");
    $req->execute(['id' => $id]);
    $housing = $req->fetchAll();
    $req = $db->prepare("SELECT * FROM performances WHERE id_user = :id ");
    $req->execute(['id' => $id]);
    $performances = $req->fetchAll();


    $firstDay = date("Y-m-d H:i:s", strtotime($firstDay));
    $lastDay = date("Y-m-d H:i:s", strtotime($lastDay));
    $bookings = [];
    foreach ($housing as $house) {
        $req = $db->prepare("SELECT * FROM booking WHERE housing_id = :id AND timestamp >= :firstDay AND timestamp <= :lastDay");
        $req->execute([
            'id' => $house['id'],
            'firstDay' => $firstDay,
            'lastDay' => $lastDay
        ]);
        $house = $req->fetchAll();
        array_merge($bookings, $house);
    }

    foreach ($performances as $performance) {
        $req = $db->prepare("SELECT * FROM booking WHERE performance_id = :id AND timestamp >= :firstDay AND timestamp <= :lastDay");
        $req->execute([
            'id' => $performance['id'],
            'firstDay' => $firstDay,
            'lastDay' => $lastDay
        ]);
        $performance = $req->fetchAll();
        array_merge($bookings, $performance);
    }

    return $bookings;
    
}
function addBooking($id, $type, $start_date, $end_date, $amount_people, $price, $userId, $title)
{
    require_once __DIR__ . "/../../database/connection.php";

    $db = connectDB();

    if ($type == "performance") {
        $req = $db->prepare("INSERT INTO booking (performance_id,  start_date, end_date,  price, user_id, title) VALUES (:id, :start_date, :end_date,  :price, :user_id, :title)");
        $req->execute([
            'id' => $id,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'price' => $price,
            'user_id' => $userId,
            'title' => $title
        ]);
        $lastId = $db->lastInsertId();

        $start_date_reformat = date("Y-m-d", strtotime($start_date));
        
        $req = $db->prepare("UPDATE disponibility SET is_booked =:is_booked WHERE id_performance = :id AND date = :date AND hour_start >= :hour_start AND hour_end <= :hour_end");
        $req->execute([
            'is_booked' => 1,
            'id' => $id,
            'date' => $start_date_reformat,
            'hour_start' => $start_date,
            'hour_end' => $end_date
        ]);
        
        return $lastId;
    } else if ($type == "housing") {
        $req = $db->prepare("INSERT INTO booking (housing_id, start_date, end_date, amount_people, price, user_id, title, ) VALUES (:id,  :start_date, :end_date, :amount_people, :price, :user_id, :title, )");
        $req->execute([
            'id' => $id,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'amount_people' => $amount_people,
            'price' => $price,
            'user_id' => $userId,
            'title' => $title
        ]);

        isbooked($id, $type, $start_date, $end_date);

        $lastId = $db->lastInsertId();
        return $lastId;
    }
}


function getBookingByUserId($userId, $type)
{
    require_once __DIR__ . "/../../database/connection.php";
    require_once __DIR__ . "/../ads/adsInfo.php";

    $db = connectDB();

    if ($type == "traveler") {
        $req = $db->prepare("SELECT * FROM booking WHERE user_id = :userId");
        $req->execute(['userId' => $userId]);
        $bookings = $req->fetchAll();

        //Récupération de l'image de l'annonceen fonction de son type (si housing_id ou performance_id) grace a la fonction getAdsImages + addresse grace a la fonction getAdsAddress
        foreach ($bookings as $key => $booking) {
            if ($booking["housing_id"] != null) {

                if (!getAdsImages($booking["housing_id"], "housing")) {
                    $bookings[$key]["image"] = NULL;
                } else {
                    $bookings[$key]["image"] = getAdsImages($booking["housing_id"], "housing")[0];
                    $bookings[$key]["address"] = getAdsAddress($booking["housing_id"], "housing");
                }
            } else if ($booking["performance_id"] != null) {

                if (!getAdsImages($booking["performance_id"], "performance")) {
                    $bookings[$key]["image"] = NULL;
                } else {
                    $bookings[$key]["image"] = getAdsImages($booking["performance_id"], "performance")[0];
                    $bookings[$key]["address"] = getAdsAddress($booking["performance_id"], "performance");
                }
            }
        }


        return $bookings;
    }
}
function addReview($rate, $comment, $id)
{
    require_once __DIR__ . "/../../database/connection.php";

    $db = connectDB();

    $req = $db->prepare("UPDATE booking SET rate = :rate, review = :comment WHERE id = :id");
    $req->execute([
        'rate' => $rate,
        'comment' => $comment,
        'id' => $id
    ]);
    return "ok";
}

function getAllBookingByOwnerId($id, $type)
{
    require_once __DIR__ . "/../../database/connection.php";
    require_once __DIR__ . "/../ads/adsInfo.php";
    if ($type == "housing") {
        $db = connectDB();
        $req = $db->prepare("SELECT * FROM booking b JOIN housing h ON b.housing_id = h.id WHERE h.id_user = :id");
        $req->execute(['id' => $id]);
        $bookings = $req->fetchALL();
        foreach ($bookings as $key => $booking) {
            if (!getAdsImages($booking["housing_id"], "housing")) {
                $bookings[$key]["image"] = NULL;
            } else {
                $bookings[$key]["image"] = getAdsImages($booking["housing_id"], "housing")[0];
                $bookings[$key]["address"] = getAdsAddress($booking["housing_id"], "housing");
            }
        }
    } else if ($type == "performance") {
        $db = connectDB();
        $req = $db->prepare("SELECT * FROM booking b JOIN performances p ON b.performance_id = p.id WHERE p.id_user = :id");
        $req->execute(['id' => $id]);
        $bookings = $req->fetchALL();
        foreach ($bookings as $key => $booking) {
            if (!getAdsImages($booking["performance_id"], "performance")) {
                $bookings[$key]["image"] = NULL;
            } else {
                $bookings[$key]["image"] = getAdsImages($booking["performance_id"], "performance")[0];
                $bookings[$key]["address"] = getAdsAddress($booking["performance_id"], "performance");
            }
        }
    }

    return $bookings;
}
