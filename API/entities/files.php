<?php

function uploadFile($type, $id_user, $id_ads, $file,$filetype)
{
    $compteur = 0;

    $originalFileName = $file["name"];

    $uploadOk = 1;
    if (isset($id_ads)) {
        $target_dir = "externalFiles/" . $type . "/" . $id_user . "/" . $id_ads . "/" . $filetype . "/";
        // Vérifier que le répertoire cible existe, sinon le créer
        if (!is_dir($target_dir)) {
            $test = mkdir($target_dir, 0777, true);
        }

        // Obtenir l'extension du fichier
        $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);

        // Générer un nouveau nom de fichier
        while (file_exists($target_dir . $compteur . "." . $extension)) {
            $compteur++;
            if ($compteur > 5) {
                $reponse = "Il ya trop de fichiers dans cette catégorie ";
                return $reponse;
                
            }
        }
        $newFileName = $compteur  . "." . $extension;
        $target_file = $target_dir . $newFileName;
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $reponse = "Erreur de téléchargement du fichier : " . $file['error'];
            return $reponse;;
        }
    } else {
        $target_dir = "externalFiles/" . $type . "/";

        // Vérifier que le répertoire cible existe, sinon le créer
        if (!is_dir($target_dir)) {
            $test = mkdir($target_dir, 0777, true);
        }

        // Obtenir l'extension du fichier
        $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);

        // supprimer le fichier de nom $id_user

        $files = glob($target_dir . $id_user . ".*");
        
        unlink($files[0]);
        
        $newFileName = $id_user . "." . $extension;
        $target_file = $target_dir . $newFileName;
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $reponse = "Erreur de téléchargement du fichier : " . $file['error'];
            return $reponse;;
        }
    }




    // Déplacer le fichier uploadé
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        $reponse = "Le fichier " . htmlspecialchars(basename($file["name"])) . " a été téléchargé.";
    } else {
        $reponse =  "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
    }
    return $reponse;
}

function uploadImageforHouse($type, $id_user, $id_ads, $file)
{
    $compteur = 0;

    $originalFileName = $file["name"];

    $uploadOk = 1;
    if (isset($id_ads)) {
        $target_dir = "externalFiles/ads/" . $type . "/";
        // Vérifier que le répertoire cible existe, sinon le créer
        if (!is_dir($target_dir)) {
            $test = mkdir($target_dir, 0777, true);
        }

        // Obtenir l'extension du fichier
        $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);

        // Générer un nouveau nom de fichier
        while (file_exists($target_dir . $id_ads ."_". $id_user ."_". $compteur. "." . $extension)) {
            $compteur++;
        }
        $newFileName =  $id_ads ."_". $id_user ."_". $compteur   . "." . $extension;
        $target_file = $target_dir . $newFileName;
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $reponse = "Erreur de téléchargement du fichier : " . $file['error'];
            return $reponse;;
        }
    } 



    // Déplacer le fichier uploadé
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        $reponse = "Le fichier " . htmlspecialchars(basename($file["name"])) . " a été téléchargé.";
    } else {
        $reponse =  "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
    }
    return $reponse;
}
function getAllFilesByUserId($id, $type) {
    $basePath = 'externalFiles/';
    $userPath = '';
    if ($type === 'landlord') {
        $userPath = "landlord/{$id}";
    } elseif ($type === 'provider') {
        $userPath = "providers/{$id}";
    }
    $userDirectory = $basePath . $userPath;
    $filesData = [];

    // Fonction récursive pour scanner les fichiers et répertoires
    function scanDirectory($directory, &$filesData) {
        $items = glob($directory . '/*');
        foreach ($items as $item) {
            if (is_file($item)) {
                $filesData[] = $item;
            } elseif (is_dir($item)) {
                scanDirectory($item, $filesData); // Appel récursif pour les sous-répertoires
            }
        }
    }

    scanDirectory($userDirectory, $filesData);

    return $filesData;
}

function deleteFile($fileName)
{
    
    if (file_exists($fileName)) {
        unlink($fileName);
        
    }
    
}
function downloadFile($id, $type, $fileName)
{
    $basePath = 'externalFiles/';
    $userPath = '';
    if ($type === 'landlord') {
        $userPath = "landlord/{$id}/";
    } elseif ($type === 'provider') {
     
        $userPath = "providers/{$id}/";
    }
    $filePath = $basePath . $userPath . $fileName;
    if (file_exists($filePath)) {
        $headers = [];

   
        $headers = [
            'Cache-Control: must-revalidate, pre-check=0, post-check=0, max-age=0',
            'Content-Tranfer-Encoding: none',
            'Content-Length: ' . filesize($filePath),
            'Content-MD5: ' . base64_encode(md5_file($filePath)),
            'Content-Type: application/pdf; name="' . $fileName . '"',
            'Content-Disposition: attachment; filename="' . $fileName . '"',
            'Expires: ' . gmdate(DATE_RFC1123, filemtime($filePath)),
            'Last-Modified: ' . gmdate(DATE_RFC1123, filemtime($filePath)),
            'Date: ' . gmdate(DATE_RFC1123, filemtime($filePath)),
            'Pragma: public'
        ];
        readfile($filePath);
       
        
        return $headers;

    } else {
        return json_encode(["success" => false, "error" => "File not found"]);
        
    }
}