<?php

require '../vendor/autoload.php';
require '../includes/header.php';
Use GuzzleHttp\Client;

if (!isConnected()){
    $_SESSION['isConnected'] = "Vous devez être connecté pour accéder à cette page";
    header("Location: /");
 
    die();
}
$token = $_SESSION["token"];
$grade = $_SESSION["grade"];
try {
    $client = new Client([
        'base_uri' => 'https://pcs-all.online:8000'
    ]);
    $test = [
        'token' => $token,
        'grade' => $grade
    ];
    $response = $client->get('/files', [
        'json' => $test
    ]);

    $body = json_decode($response->getBody()->getContents(), true);
   
    if (isset($body['success']) && $body['success'] === true) {
        $files = $body['files'];
        
    } else {
        $files = [];
        echo "<div class='alert alert-danger' role='alert'>Pas de fichier trouvé</div>";
    }
} catch (Exception $e) {
    $files = [];
    echo $e->getMessage();
}
?>
<link rel="stylesheet" href="../css/files.css">
<center><h1>Mes Documents</h1></center>
<?php if (isset($_SESSION["success"])){ ?>
    <div class="alert alert-success" role="alert">
        <?php echo $_SESSION["success"]; ?>
    </div>
<?php
unset($_SESSION["success"]);
}
if (isset($_SESSION['error'])){ ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $_SESSION["error"]; ?>
    </div>
<?php
unset($_SESSION["error"]);
}
?>
<div class="file-container">
    <?php foreach ($files as $file): 
        $parts = explode('/', $file);
        $idLogement = $parts[3];
        
        $fileType = $parts[4];
        $fileType = htmlspecialchars($fileType);
        if ($grade == 4){
            $nomlogement = getHousingById($idLogement)["title"];
            if($fileType == 1){
                $fileType = "Document d'identité";
            }
            else if($fileType == 2){
                $fileType = "Bail";
            }
            else if($fileType == 3){
                $fileType = "Contrat de location";
            }
            else if($fileType == 4){
                $fileType = "Diagnostic de performance énergétique";
            }
            else if($fileType == 5){
                $fileType = "Règlement de copropriété";

            }
        }else if($grade == 5){
            
        
            $nomlogement = getPerformanceById($idLogement)[0]["title"];
            if($fileType == 1){
                $fileType = "Document d'identité";
            }
            else if($fileType == 2){
                $fileType = "Licence d'activité";
            }
            else if($fileType == 3){
                $fileType = "Carte professionnelle";
            }
            else if($fileType == 4){
                $fileType = "Facture";
            }
    }
       
        
        $fileName = end($parts);
    ?>
        <div class="file-item">
            <div class="file-name">ID Annonce: <?php echo htmlspecialchars($idLogement); ?> <BR> Nom : <?php echo $nomlogement ;?> <BR><BR> Type de Fichier: <?php echo $fileType; ?></div>
            <center><div class="file-path">Titre : <?php echo htmlspecialchars($fileName); ?></div>
            
                <a href="download.php?file=<?php echo $file;  ?>" class="btn btn-outline-primary">Télécharger <i class="fas fa-download"></i></a>
                <a href="delete.php?file=<?php echo $file; ?>" class="btn btn-outline-danger">Supprimer</a>
            </center>
        </div>
    <?php endforeach; ?>
</div>