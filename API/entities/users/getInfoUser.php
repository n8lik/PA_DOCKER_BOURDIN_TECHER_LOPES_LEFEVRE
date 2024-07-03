<?php

function getPpByUserID($id)
{
    $images = [];
    $dir = __DIR__ . "/../../externalFiles/pp/";
    $files = scandir($dir);
    foreach ($files as $file) {
        if (strpos($file, $id) !== false) {
            $images[] = "https://pcs-all.online:8000/externalFiles/pp/" . $file;
        }
    }
    //si pas d'image, on mets la photo de profil de base defautl.jpg
    if (count($images) == 0) {
        $images[] = "https://pcs-all.online:8000/externalFiles/pp/default.jpg";
    }
    return $images;
}
?>