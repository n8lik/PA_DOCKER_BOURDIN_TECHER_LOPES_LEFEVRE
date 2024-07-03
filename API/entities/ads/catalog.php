<?php

function getAllCatalogByChoice($type)
{
    require_once __DIR__ . "/../../database/connection.php";
    $db = connectDB();
    switch ($type) {
        case 'housing':
            $req = $db->prepare("SELECT * FROM housing WHERE is_validated = 1");
            $req->execute();
            return $req->fetchAll();
            break;
        case 'performance':
            $req = $db->prepare("SELECT * FROM performances WHERE is_validated = 1");
            $req->execute();
            return $req->fetchAll();
            break;
    }
}


function getHousingCatalogByType($type)
{
    require_once __DIR__ . "/../../database/connection.php";
    $db = connectDB();
    $req = $db->prepare("SELECT * FROM housing WHERE is_validated = 1 AND type = :type");
    $req->execute(['type' => $type]);
    return $req->fetchAll();
}

function getPerformanceCatalogByType($type)
{
    require_once __DIR__ . "/../../database/connection.php";
    $db = connectDB();
    $req = $db->prepare("SELECT * FROM performances WHERE is_validated = 1 AND type = :type");
    $req->execute(['type' => $type]);
    return $req->fetchAll();
}
function getHousingCatalogBySearch($destination, $arrivalDate, $departureDate, $travelers)
{
    require_once __DIR__ . "/../../database/connection.php";
    $response = getAllCatalogByChoice('housing');
    // Filtrer par destination
    if ($destination != null) {
        $destination = explode(",", $destination);
        $destination = $destination[0];
        $tmp_response = [];
        foreach ($response as $key => $value) {
            if (strpos($value['city'], $destination) !== false || strpos($value['country'], $destination) !== false) {
                array_push($tmp_response, $value);
            }
        }
        $response = $tmp_response;
    }

    // Filtrer par nombre de voyageurs
    if ($travelers != null) {
        $tmp_response = [];
        foreach ($response as $key => $value) {
            if ($value['guest_capacity'] >= $travelers) {
                array_push($tmp_response, $value);
            }
        }
        $response = $tmp_response;
    }

    // Filtrer par disponibilité
    if ($arrivalDate != null && $departureDate != null) {
        $tmp_response = [];
        $db = connectDB();
        foreach ($response as $key => $value) {
            $req = $db->prepare("SELECT * FROM disponibility WHERE id_housing = :id AND date >= :arrivalDate AND is_booked = 0 AND date <= :departureDate");
            $req->execute(['id' => $value['id'], 'arrivalDate' => $arrivalDate, 'departureDate' => $departureDate]);
            $result = $req->fetchAll();
            if (count($result) > 0) {
                array_push($tmp_response, $value);
            }
        }
        $response = $tmp_response;
    }

    return $response;
}


function getPerformanceCatalogBySearch($date, $type)
{
    require_once __DIR__ . "/../../database/connection.php";
    $response = getAllCatalogByChoice('performance');

    // Filtrer par type
    if ($type != null) {
        $tmp_response = [];
        foreach ($response as $key => $value) {
            if ($value['performance_type'] == $type || $value['title']==$type) {
                array_push($tmp_response, $value);
            }
        }
        $response = $tmp_response;
    }
    if ($date != null) {
        $tmp_response = [];
        $db = connectDB();
        foreach ($response as $key => $value) {
            $req = $db->prepare("SELECT * FROM disponibility WHERE id_performance = :id AND date = :date AND is_booked = 0");
            $req->execute(['id' => $value['id'], 'date' => $date]);
            $result = $req->fetchAll();
            if (count($result) > 0) {
                array_push($tmp_response, $value);
            }
        }
        $response = $tmp_response;
    }
    return $response;
}


######Favorites####

function addLike($id, $type, $userId)
{
    require_once __DIR__ . "/../../database/connection.php";
    $db = connectDB();
    if ($type == 'housing') {
        $req = $db->prepare("INSERT INTO likes (id_housing, id_user) VALUES (:id, :userId)");
        $req->execute(['id' => $id, 'userId' => $userId]);
        return "ok";
    } else if ($type == 'performance') {
        $req = $db->prepare("INSERT INTO likes (id_performance, id_user) VALUES (:id, :userId)");
        $req->execute(['id' => $id, 'userId' => $userId]);
        return "ok";
    }
}

function removeLike($id, $type, $userId)
{
    require_once __DIR__ . "/../../database/connection.php";
    $db = connectDB();
    if ($type == 'housing') {
        $req = $db->prepare("DELETE FROM likes WHERE id_housing = :id AND id_user = :userId");
        $req->execute(['id' => $id, 'userId' => $userId]);
        return "ok";
    } else if ($type == 'performance') {
        $req = $db->prepare("DELETE FROM likes WHERE id_performance = :id AND id_user = :userId");
        $req->execute(['id' => $id, 'userId' => $userId]);
        return "ok";
    }
}

function isLiked($id, $type, $userId)
{
    require_once __DIR__ . "/../../database/connection.php";
    $db = connectDB();
    if ($type == 'housing') {
        $req = $db->prepare("SELECT * FROM likes WHERE id_housing = :id AND id_user = :userId");
        $req->execute(['id' => $id, 'userId' => $userId]);
        return $req->fetch();
    } else if ($type == 'performance') {
        $req = $db->prepare("SELECT * FROM likes WHERE id_performance = :id AND id_user = :userId");
        $req->execute(['id' => $id, 'userId' => $userId]);
        return $req->fetch();
    }
}

function getLikesByUserId($userId)
{
    require_once __DIR__ . "/../../database/connection.php";
    $db = connectDB();
    $req = $db->prepare("SELECT * FROM likes WHERE id_user = :userId");
    $req->execute(['userId' => $userId]);
    return $req->fetchAll();
}
