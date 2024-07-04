<?php 

require_once __DIR__ . "/../../database/connection.php";
function deleteUser($id){
    $conn=connectDB();
    //is_deleted à 1 pour une suppression logique
    $sql = "UPDATE user SET is_deleted = 1, delete_date = NOW() WHERE id = ?";
    $req = $conn->prepare($sql);
    $req->execute([$id]);
}