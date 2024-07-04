<?php 

function getAdsDisponibilitybyID($id, $type) {
    require_once __DIR__ . "/../../database/connection.php";
    $db = connectDB();
    if ($type == 'housing') {
        $req = $db->prepare("SELECT * FROM disponibility WHERE id_housing = :id");
        $req->execute(['id' => $id]);
        return $req->fetchAll(PDO::FETCH_ASSOC);
    } else if ($type == 'performance') {
        $req = $db->prepare("SELECT * FROM disponibility WHERE id_performance = :id");
        $req->execute(['id' => $id]);
        return $req->fetchAll(PDO::FETCH_ASSOC);
    } else {
        return null;
    }                                                                                                                                                      
}
function getAdsDisponibilitybyIDandIdDispo($id, $type, $id_dispo) {
    require_once __DIR__ . "/../../database/connection.php";
    $db = connectDB();
    if ($type == 'housing') {
        $req = $db->prepare("SELECT * FROM disponibility WHERE id_housing = :id AND id = :id_dispo");
        $req->execute(['id' => $id, 'id_dispo' => $id_dispo]);
        return $req->fetchAll(PDO::FETCH_ASSOC);
    } else if ($type == 'performance') {
        $req = $db->prepare("SELECT * FROM disponibility WHERE id_performance = :id AND id = :id_dispo");
        $req->execute(['id' => $id, 'id_dispo' => $id_dispo]);
        return $req->fetchAll(PDO::FETCH_ASSOC);
    } else {
        return null;
    }
}

function addAdsDisponibility($id, $type, $date, $hour_start, $hour_end, $hour_duration) {
    require_once __DIR__ . "/../../database/connection.php";
    $db = connectDB();

    if ($type == 'housing') {
        //Verifier que la date n'existe pas deja
        $req = $db->prepare("SELECT * FROM disponibility WHERE id_housing = :id AND date = :date");
        $req->execute(['id' => $id, 'date' => $date]);
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            delAdsDisponibility($id, $type, $date);
            return null;
        }
        $req = $db->prepare("INSERT INTO disponibility (id_housing, date) VALUES (:id, :date)");
        $req->execute(['id' => $id, 'date' => $date]);
        return $db->lastInsertId();
    } else if ($type == 'performance') {
        //Verifier que la date n'existe pas deja
        $req = $db->prepare("SELECT * FROM disponibility WHERE id_performance = :id AND date = :date");
        $req->execute(['id' => $id, 'date' => $date]);
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            delAdsDisponibility($id, $type, $date);
            return null;
        }
        $start = strtotime($hour_start);
        $end = strtotime($hour_end);
        $interval = $hour_duration * 60 * 60;

        for ($i = $start; $i < $end; $i += $interval) {
            $start_hour = date("Y-m-d H:i:s", $i);
            $end_hour = date("Y-m-d H:i:s", $i + $interval);
            $req = $db->prepare("INSERT INTO disponibility (id_performance, date, hour_start, hour_end, hour_duration, original_dispo) VALUES (:id, :date, :hour_start, :hour_end, :hour_duration, :original_dispo)");
            $req->execute(['id' => $id, 'date' => $date , 'hour_start' =>  $start_hour, 'hour_end' => $end_hour, 'hour_duration' => $hour_duration, 'original_dispo' => 1]);
        }

        return $db->lastInsertId();
    } else {
        return null;
    }
}

function delAdsDisponibility($id, $type, $date) {
    require_once __DIR__ . "/../../database/connection.php";
    $db = connectDB();

    if ($type == 'housing') {
        $req = $db->prepare("DELETE FROM disponibility WHERE id_housing = :id AND date = :date");
        $req->execute(['id' => $id, 'date' => $date]);
    } else if ($type == 'performance') {
        $req = $db->prepare("DELETE FROM disponibility WHERE id_performance = :id AND date = :date");
        $req->execute(['id' => $id, 'date' => $date]);
    } else {
        return null;
    }
}