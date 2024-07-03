<?php
function deleteTask(int $id): bool
{
    require_once __DIR__ . "/../../database/connection.php";
    //On récupère la connexion à la base de données
    $pdo = getDatabaseConnection();

    //On teste si la task existe dans la base de données
    $getTaskQuery = $pdo->prepare("SELECT * FROM tasks WHERE id = :id");
    $getTaskQuery->execute([
        "id" => $id
    ]);
    $task = $getTaskQuery->fetch(PDO::FETCH_ASSOC);
    if (!$task) {
        return false;
    }
    //Si la task existe on la supprime et on renvoie true
    $deleteTaskQuery = $pdo->prepare("DELETE FROM tasks WHERE id = :id");
    $deleteTaskQuery->execute([
        "id" => $id
    ]);
    return true;
}
