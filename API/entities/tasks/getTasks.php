<?php

function getTasks(): array
{
    require_once __DIR__ . "/../../database/connection.php";

    $pdo = getDatabaseConnection();
    $getTasksQuery = $pdo->query("SELECT * FROM tasks;");
    return $getTasksQuery->fetchAll(PDO::FETCH_ASSOC);
}