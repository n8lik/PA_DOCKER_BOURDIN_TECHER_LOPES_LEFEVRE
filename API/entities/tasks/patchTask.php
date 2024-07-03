<?php

function patchTask (int $task, string $description): bool
{
    require_once __DIR__ . "/../../database/connection.php";

    $pdo = getDatabaseConnection();
    //On teste si la task existe dans la base de données
    $getTaskQuery = $pdo->prepare("SELECT * FROM tasks WHERE id = :id");
    $getTaskQuery->execute([
        "id" => $task
    ]);
    $task = $getTaskQuery->fetch(PDO::FETCH_ASSOC);
    if (!$task) {
        return false;
    }

    //Si la task existe on la modifie et on renvoie true
    $patchTaskQuery = $pdo->prepare("UPDATE tasks SET description = :description WHERE id = :id");
    $patchTaskQuery->execute([
        "id" => $task,
        "description" => $description
    ]);
    return true;
}