<?php

require 'conf.inc.php';

// fonction connexion base de donnée 
function connectDB()
{
    try {
        $connection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT, DB_USER, DB_PWD);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connection;
    } catch (Exception $e) {
        echo "Erreur SQL " . $e->getMessage();
        exit;
    }
}

// vérification si l'utilisateur est connecté
function isConnected()
{
    if (isset($_SESSION['userId'])) {
        return true;
    } else {
        return false;
    }
}


// fonction de nettoyage des données

function cleanLastname($name)
{
    $name = trim($name);
    $name = strip_tags($name);
    $name = htmlspecialchars($name);
    $name = ucfirst($name);
    return $name;
}

function cleanMail($mail)
{
    $mail = trim($mail);
    $mail = strip_tags($mail);
    $mail = htmlspecialchars($mail);
    $mail = strtolower($mail);
    return $mail;
}
function cleanFirstname($name)
{
    $name = trim($name);
    $name = strip_tags($name);
    $name = htmlspecialchars($name);
    $name = ucfirst($name);
    return $name;
}

// fonction pour calculer les prix 

function price_calcul($type)
{
}

// fonction insertion BDD form location




function updateHousing($id, $title, $type_location, $amountRoom, $experienceType, $guestCapacity, $propertyArea, $contactPhone, $time)
{
    $db = connectDB();
    $queryprepare = $db->prepare("UPDATE housing SET title = :title, type_location = :type_location, amount_room = :amount_room, management_type = :experienceType, guest_capacity = :guestCapacity, property_area = :propertyArea, contact_phone = :contactPhone, contact_time = :time, is_validated = :validated WHERE id = :id");
    $queryprepare->execute(['title' => $title, 'type_location' => $type_location, 'amount_room' => $amountRoom, 'experienceType' => $experienceType, 'guestCapacity' => $guestCapacity, 'propertyArea' => $propertyArea, 'contactPhone' => $contactPhone, 'time' => $time, 'id' => $id, 'validated' => 0]);
}

function contactTime($timeSlot1, $timeSlot2, $timeSlot3)
{
    if ($timeSlot1 == 1 && $timeSlot2 == 0 && $timeSlot3 == 0) {
        return "avant 13h";
    } else if ($timeSlot1 == 0 && $timeSlot2 == 1 && $timeSlot3 == 0) {
        return "entre 13h et 18h";
    } else if ($timeSlot1 == 0 && $timeSlot2 == 0 && $timeSlot3 == 1) {
        return " après 18h";
    } else if ($timeSlot1 == 1 && $timeSlot2 == 1 && $timeSlot3 == 0) {
        return "avant 13h et max 18h";
    } else if ($timeSlot1 == 1 && $timeSlot2 == 0 && $timeSlot3 == 1) {
        return "avant 13h et après 18h";
    } else if ($timeSlot1 == 0 && $timeSlot2 == 1 && $timeSlot3 == 1) {
        return " à partir de 13h et après 18h";
    } else if ($timeSlot1 == 1 && $timeSlot2 == 1 && $timeSlot3 == 1) {
        return "tout le temps";
    }
}

function getUserById($id)
{
    $db = connectDB();
    $req = $db->prepare("SELECT * FROM user WHERE id = ?");
    $req->execute([$id]);
    return $req->fetch();
}

function getHousingByOwner($id)
{
    $db = connectDB();
    $req = $db->prepare("SELECT * FROM housing WHERE id_user = :userId");
    $req->execute(['userId' => $id]);
    return $req->fetchAll();
}
function getHousingById($id)
{
    $db = connectDB();
    $req = $db->prepare("SELECT * FROM housing WHERE id = :id");
    $req->execute(['id' => $id]);
    return $req->fetch();
}

function getCalendarByHousingId($id)
{
    $db = connectDB();
    $req = $db->prepare("SELECT * FROM disponibility WHERE id_housing = :id");
    $req->execute(['id' => $id]);
    return $req->fetchAll();
}


function searchingBar($search, $choice)
{
    $db = connectDB();
    switch ($choice) {
        case "all":
            $req = $db->prepare("SELECT * FROM user WHERE pseudo LIKE ? OR firstname LIKE ? OR lastname LIKE ? OR email LIKE ?");
            $req->execute(["%" . $search . "%", "%" . $search . "%", "%" . $search . "%", "%" . $search . "%"]);
            return $req->fetchAll();
        case "travelers":
            $req = $db->prepare("SELECT * FROM user WHERE (grade = 1 OR grade = 2 OR grade = 3) AND (pseudo LIKE ? OR firstname LIKE ? OR lastname LIKE ? OR email LIKE ?)");
            $req->execute(["%" . $search . "%", "%" . $search . "%", "%" . $search . "%", "%" . $search . "%"]);
            return $req->fetchAll();
        case "landlords":
            $req = $db->prepare("SELECT * FROM user WHERE grade = 4 AND (pseudo LIKE ? OR firstname LIKE ? OR lastname LIKE ? OR email LIKE ?)");
            $req->execute(["%" . $search . "%", "%" . $search . "%", "%" . $search . "%", "%" . $search . "%"]);
            return $req->fetchAll();
        case "providers":
            $req = $db->prepare("SELECT * FROM user WHERE grade = 5 AND (pseudo LIKE ? OR firstname LIKE ? OR lastname LIKE ? OR email LIKE ?)");
            $req->execute(["%" . $search . "%", "%" . $search . "%", "%" . $search . "%", "%" . $search . "%"]);
            return $req->fetchAll();
        case "housing":
            $req = $db->prepare("SELECT * FROM housing WHERE title LIKE ? OR city LIKE ? OR type_house LIKE ? or price LIKE ? or creation_date LIKE ?");
            $req->execute(["%" . $search . "%", "%" . $search . "%", "%" . $search . "%", "%" . $search . "%", "%" . $search . "%"]);
            return $req->fetchAll();
        case "performances":
            $req = $db->prepare("SELECT * FROM performances WHERE title LIKE ? OR place LIKE ? OR performance_type LIKE ? or price LIKE ?");
            $req->execute(["%" . $search . "%", "%" . $search . "%", "%" . $search . "%", "%" . $search . "%"]);
            return $req->fetchAll();
    }
}

function deleteHousingById($id)
{
    $db = connectDB();
    $req = $db->prepare("DELETE FROM housing WHERE id = :id");
    $req->execute(['id' => $id]);
}

/*#########################Prestataire#########################*/

function insertPerformance($title, $description, $performance_type, $address_appointment, $city_appointment, $zip_appointment, $country_appointment, $price, $price_type, $userId, $fee, $place, $radius)
{
    $connexion = connectDB();
    $queryprepared = $connexion->prepare('INSERT INTO performances (title, description, performance_type, address_appointment, city_appointment, zip_appointment, country_appointment, price, price_type, id_user, fee, place, radius) VALUES (:title, :description, :performance_type, :address_appointment, :city_appointment, :zip_appointment, :country_appointment, :price, :price_type, :user_id, :fee, :place, :radius)');

    $queryprepared->execute([
        ':title' => $title,
        ':description' => $description,
        ':performance_type' => $performance_type,
        ':address_appointment' => $address_appointment,
        ':city_appointment' => $city_appointment,
        ':zip_appointment' => $zip_appointment,
        ':country_appointment' => $country_appointment,
        ':price' => $price,
        ':price_type' => $price_type,
        ':user_id' => $userId,
        ':fee' => $fee,
        ':place' => $place,
        ':radius' => $radius
    ]);
}

function updatePerformance($id, $title, $description, $address_appointment, $city_appointment, $zip_appointment, $country_appointment, $price, $price_type, $fee, $place, $radius)
{
    $connexion = connectDB();
    $queryprepared = $connexion->prepare('UPDATE performances SET title = :title, description = :description, address_appointment = :address_appointment, city_appointment = :city_appointment, zip_appointment = :zip_appointment, country_appointment = :country_appointment, price = :price, price_type = :price_type, fee = :fee, place = :place, radius = :radius, is_validated = :validated  WHERE id = :id');

    $queryprepared->execute([
        ':title' => $title,
        ':description' => $description,
        ':address_appointment' => $address_appointment,
        ':city_appointment' => $city_appointment,
        ':zip_appointment' => $zip_appointment,
        ':country_appointment' => $country_appointment,
        ':price' => $price,
        ':price_type' => $price_type,
        ':fee' => $fee,
        ':place' => $place,
        ':radius' => $radius,
        ':id' => $id,
        ':validated' => 0
    ]);
}
function getCalendarByPerformanceId($id)
{
    $db = connectDB();
    $req = $db->prepare("SELECT * FROM disponibility WHERE id_performance = :id");
    $req->execute(['id' => $id]);
    return $req->fetchAll();
}

function getPerformanceById($id)
{
    $conn = connectDB();
    $req = $conn->prepare("SELECT * FROM performances WHERE id = :id");
    $req->execute(['id' => $id]);
    return $req->fetchAll();
}


function getPerformanceByOwner($id)
{
    $conn = connectDB();
    $req = $conn->prepare("SELECT * FROM performances WHERE id_user = :id");
    $req->execute(['id' => $id]);
    return $req->fetchAll();
}


function deletePerformance($id)
{
    $db = connectDB();
    $req = $db->prepare("DELETE FROM performances WHERE id = :id");
    $req->execute(['id' => $id]);
}

####################MIKE#########################
function getPerformanceByIdUser($id)
{
    $conn = connectDB();
    $req = $conn->prepare("SELECT * FROM prestations WHERE id_user = :id");
    $req->execute(['id' => $id]);
    return $req->fetchAll();
}
function getPerformanceByIdUserAndIdPerf($id_user, $id_perf)
{
    $conn = connectDB();
    $req = $conn->prepare("SELECT * FROM prestations WHERE id_user = :id_user AND id = :id_perf");
    $req->execute(['id_user' => $id_user, 'id_perf' => $id_perf]);
    return $req->fetch();
}
function deletePerformanceById($id)
{
    $db = connectDB();
    $req = $db->prepare("DELETE FROM prestations WHERE id = :id");
    $req->execute(['id' => $id]);
}
function getRdvByIdNotFini($id)
{
    $conn = connectDB();
    $req = $conn->prepare("SELECT * FROM rendez_vous WHERE prestation_id = :id AND status <> 'fini'");
    $req->execute(['id' => $id]);
    return $req->fetchAll();

}

function accepterPrestation($id)
{
    $conn = connectDB();
    $req = $conn->prepare("UPDATE rendez_vous SET status = 'en cours' WHERE id_rdv = :id");
    $req->execute(['id' => $id]);
    $conn = null;
}
function refuserPrestation($id)
{
    $conn = connectDB();
    $req = $conn->prepare("UPDATE rendez_vous SET status = 'refuse' WHERE id_rdv = :id");
    $req->execute(['id' => $id]);
    $conn = null;
}
function finirPrestation($id)
{
    $conn = connectDB();
    $req = $conn->prepare("UPDATE rendez_vous SET status = 'fini' WHERE id_rdv = :id");
    $req->execute(['id' => $id]);
    $conn = null;
}
function getRdvByIdClientNotFini($id)
{

    $conn = connectDB();

    $req = $conn->prepare("SELECT * FROM rendez_vous WHERE client_id = :id AND status <> 'fini'");
    $req->execute(['id' => $id]);
    return $req->fetchAll();

}
function getRdvByIdClientFini($id)
{

    $conn = connectDB();

    $req = $conn->prepare("SELECT * FROM rendez_vous WHERE client_id = :id AND status = 'fini'");
    $req->execute(['id' => $id]);
    return $req->fetchAll();

}
function getRdvByIdClientNotFiniAndEnCours($id)
{

    $conn = connectDB();

    $req = $conn->prepare("SELECT * FROM rendez_vous WHERE client_id = :id AND (status = 'en cours' OR status = 'demande')");
    $req->execute(['id' => $id]);
    return $req->fetchAll();

}
function selectAppointmentHisto()
{
    $conn = connectDB();
    $id_user = $_SESSION['userId'];

    $sql = "SELECT * FROM rendez_vous WHERE client_id = :id_user AND status = 'fini' ORDER BY date_rdv DESC, heure_fin_rdv DESC";

    $req = $conn->prepare($sql);
    $req->execute(['id_user' => $id_user]);
    return $req->fetchAll();

}
function listPerformance()
{
    $conn = connectDB();
    $req = $conn->prepare("SELECT * FROM prestations");
    $req->execute();
    return $req->fetchAll();

}


########################Angélique - Tickets ############################
function getTicketsByUserId($id)
{
    $conn = connectDB();
    $req = $conn->prepare("SELECT * FROM ticket WHERE id_user = :id AND type = 0");
    $req->execute(['id' => $id]);
    return $req->fetchAll();
}

function getTicketStatus($nb)
{
    switch ($nb) {
        case "0":
            return "En attente";
           
        case "1":
            return "En cours";
            
        case "2":
            return "Résolu";
            
    }
}

function getTicketSubject($sub)
{
    switch ($sub) {
        case "1":
            return "Problème de connexion";
            
        case "2":
            return "Problème de paiement";
            
        case "3":
            return "Problème de réservation";
            
        case "4":
            return "Autre";
            
    }
}

function getTicketById($id)
{
    $conn = connectDB();
    $req = $conn->prepare("SELECT * FROM ticket WHERE id = :id");
    $req->execute(['id' => $id]);
    return $req->fetch();
}

function getTicketAnswers($id)
{
    $conn = connectDB();
    $req = $conn->prepare("SELECT * FROM ticket WHERE answer_id = :id");
    $req->execute(['id' => $id]);
    return $req->fetchAll();
}

/*#########################Catalogue#########################*/
function getCatalogByType($choice, $type)
{
    $db = connectDB();
    switch ($choice) {
        case 'housing':
            if ($type == 'all') {
                $req = $db->prepare("SELECT * FROM housing WHERE is_validated = 1");
                $req->execute();
                return $req->fetchAll();
            } else {
                $req = $db->prepare("SELECT * FROM housing WHERE type_house = :type AND is_validated = 1");
                $req->execute(['type' => $type]);
                return $req->fetchAll();
            }
        case 'performance':
            if ($type == 'all') {
                $req = $db->prepare("SELECT * FROM performances WHERE is_validated = 1");
                $req->execute();
                return $req->fetchAll();
            } else {
                $req = $db->prepare("SELECT * FROM performances WHERE performance_type = :type AND is_validated = 1");
                $req->execute(['type' => $type]);
                return $req->fetchAll();
            }
    }
}

function getHousingCatalogBySearch($destination, $arrivalDate, $departureDate, $travelers)
{
    $destination = explode(",", $destination);
    $destination = $destination[0];
    $db = connectDB();
    $req = $db->prepare("SELECT * FROM housing WHERE city = :destination AND is_validated = 1");
    $req->execute(['destination' => $destination]);
    return $req->fetchAll();
}

function getImagesByTypeAndId($type, $id)
{
    $images = [];
    $dir = "/var/www/html/externalFiles/ads/" . $type . "/";
    $files = scandir($dir);
    foreach ($files as $file) {
        if (strpos($file, $id) !== false) {
            $images[] = "/externalFiles/ads/" . $type . "/" . $file;
        }
    }
    return $images;
}

/*#########################Like#########################*/
function addLike($id, $type, $userId)
{
    $db = connectDB();
    if ($type == 'housing') {
        $req = $db->prepare("INSERT INTO likes (id_housing, id_user) VALUES (:id, :userId)");
        $req->execute(['id' => $id, 'userId' => $userId]);
    } else if ($type == 'performance') {
        $req = $db->prepare("INSERT INTO likes (id_performance, id_user) VALUES (:id, :userId)");
        $req->execute(['id' => $id, 'userId' => $userId]);
    }
}

function removeLike($id, $type, $userId)
{
    $db = connectDB();
    if ($type == 'housing') {
        $req = $db->prepare("DELETE FROM likes WHERE id_housing = :id AND id_user = :userId");
        $req->execute(['id' => $id, 'userId' => $userId]);
    } else if ($type == 'performance') {
        $req = $db->prepare("DELETE FROM likes WHERE id_performance = :id AND id_user = :userId");
        $req->execute(['id' => $id, 'userId' => $userId]);
    }
}

function isLiked($id, $type, $userId)
{
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
    $db = connectDB();
    $req = $db->prepare("SELECT * FROM likes WHERE id_user = :userId");
    $req->execute(['userId' => $userId]);
    return $req->fetchAll();
}

function getPpByUserID($id)
{
    $dir = "/var/www/html/externalFiles/pp/";
    $files = scandir($dir);
    foreach ($files as $file) {
        if (strpos($file, $id) !== false) {
            return "/externalFiles/pp/" . $file;
        }
    }
    return "/externalFiles/pp/default.jpg";
}
