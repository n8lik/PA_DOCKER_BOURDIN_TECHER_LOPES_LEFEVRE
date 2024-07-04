<?php

function getPpByUserID($id)
{
    $images = [];
    $dir = __DIR__ . "/../../externalFiles/pp/";
    $files = scandir($dir);
    foreach ($files as $file) {
        if (strpos($file, $id) !== false) {
            $images[] = "api/externalFiles/pp/" . $file;
        }
    }
    //si pas d'image, on mets la photo de profil de base defautl.jpg
    if (count($images) == 0) {
        $images[] = "api/externalFiles/pp/default.jpg";
    }
    return $images;
}
?>