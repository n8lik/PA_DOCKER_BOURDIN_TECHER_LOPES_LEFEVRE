<?php

function getTicketsByUserId($id)
{
    require_once __DIR__ . "/../database/connection.php";
    $conn = connectDB();
    $req = $conn->prepare("SELECT * FROM ticket WHERE id_user = :id AND type = 0");
    $req->execute(['id' => $id]);
    $tickets = $req->fetchAll();
    foreach ($tickets as $key => $ticket) {
        $tickets[$key]["subject"] = getSubjectById($ticket["subject"]);
        $tickets[$key]["status"] = getStatusById($ticket["status"]);
    }
    return $tickets;
}

function getTicketById($id)
{
    require_once __DIR__ . "/../database/connection.php";
    $conn = connectDB();
    $req = $conn->prepare("SELECT * FROM ticket WHERE id = :id");
    $req->execute(['id' => $id]);
    $ticket=$req->fetch();
    
    $ticket["subject"]=getSubjectById($ticket["subject"]);
    $ticket["status"]=getStatusById($ticket["status"]);
    return $ticket;
}

function getSubjectById($id)
{
    switch ($id) {
        case "1":
            return "Probleme de connexion";
        case "2":
            return "Probleme de paiement";
        case "3":
            return "Probleme de fonctionnalité";
        case "4":
            return "Probleme de compte";
    }
}

function getStatusById($id)
{
    switch ($id) {
        case "0":
            return "En attente";
        case "1":
            return "En cours";
        case "2":
            return "Resolu";
    }
}

function getTicketAnswers($id)
{
    require_once __DIR__ . "/../database/connection.php";
    $conn = connectDB();
    $req = $conn->prepare("SELECT * FROM ticket WHERE answer_id = :id");
    $req->execute(['id' => $id]);
    return $req->fetchAll();
}

function addTicket($userId, $subject, $message)
{
    require_once __DIR__ . "/../database/connection.php";
    $db = connectDB();
    $req = $db->prepare("INSERT INTO ticket (id_user,type,subject,content) VALUES (:id_user,:type,:subject,:content)");
    $req->execute(['id_user' => $userId, 'type' => 0, 'subject' => $subject, 'content' => $message]);
    return "ok";
}

function addTicketAnswer($userId, $ticketId, $message)
{
    require_once __DIR__ . "/../database/connection.php";
    $db = connectDB();
        $req = $db->prepare("INSERT INTO ticket(id_user,type,subject,content,status,answer_id) VALUES (:id_user,1,:subject,:content,0,:answer_id)");
    $req->execute(['id_user' => $userId, 'subject' => 10, 'content' => $message, 'answer_id' => $ticketId]);
    return "ok";
}

    
function changeStatusTicket($ticketId, $status)
{
    require_once __DIR__ . "/../database/connection.php";
    $db = connectDB();
    $req = $db->prepare("UPDATE ticket SET status = :status WHERE id = :id");
    $req->execute(['status' => $status, 'id' => $ticketId]);
    return "ok";
}

function getTicketsByStatus($status)
{
    require_once __DIR__ . "/../database/connection.php";
    $conn = connectDB();
    if ($status == "new") {
        $status = 0;
    } else if ($status == "assigned") {
        $status = 1;
    } else if ($status == "closed") {
        $status = 2;
    }else if ($status == "all") {
        $req = $conn->prepare("SELECT * FROM ticket WHERE answer_id IS NULL");
        $req->execute();
        return $req->fetchAll();
    }else{
        return "error";
    }

    $req = $conn->prepare("SELECT * FROM ticket WHERE status = :status AND answer_id IS NULL");
    $req->execute(['status' => $status]);
    $res = $req->fetchAll();

    foreach ($res as $key => $ticket) {
        $res[$key]["subject"] = getSubjectById($ticket["subject"]);
        $res[$key]["status"] = getStatusById($ticket["status"]);
    }

    return $res;
    
}

function getAssignedTicketsByUserId($userId)
{
    require_once __DIR__ . "/../database/connection.php";
    $conn = connectDB();
    $req = $conn->prepare("SELECT * FROM ticket WHERE tech_id = :id AND status = 1 AND answer_id IS NULL");
    $req->execute(['id' => $userId]);
    return $req->fetchAll();
}


#######################Chatbot#######################
function getChatbotAnswer($message)
{
    require_once __DIR__ . "/../database/connection.php";
    //selectionner tous les mots clés et réponses de la table chatbot
    $conn = connectDB();
    $req = $conn->prepare("SELECT * FROM chatbot");
    $req->execute();
    $chatbot = $req->fetchAll();

    foreach ($chatbot as $key => $value) {
        if (strpos($message, $value["keyword"]) !== false) {
            return $value["chatbotresponse"];
        }
    }
    return "Je n'ai pas compris votre demande";
}