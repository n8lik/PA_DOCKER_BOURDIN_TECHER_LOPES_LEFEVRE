<?php
require 'settings.php';


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
