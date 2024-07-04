<?php
//upload le fichier recu
var_dump($_FILES);
var_dump($_POST);
if (!isset($_POST['lang']) || !isset($_POST['translations'])) {
    die('Veuillez entrer une langue et des traductions.');
}

$lang = $_POST['lang'];
$translations = json_decode($_POST['translations'], true);

//dans le dossier locales, on crée un fichier json avec les traductions
file_put_contents("locales/$lang.json", json_encode($translations, JSON_PRETTY_PRINT));

echo 'Traductions enregistrées avec succès !';

