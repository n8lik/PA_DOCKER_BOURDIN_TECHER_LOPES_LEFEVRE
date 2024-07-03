<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

 $pageTitle="Catalogue";
require 'includes/header.php';
require 'vendor/autoload.php';

use GuzzleHttp\Client;

if (isset($_GET['choice'])) {
    $choice = $_GET['choice'];
    switch ($choice) {
        case 'housing':
            if (isset($_POST['destination'])) {
                $destination = $_POST['destination'];
                $arrivalDate = $_POST['arrivalDate'];
                $departureDate = $_POST['departureDate'];
                $travelers = $_POST['travelers'];
                //Requete API en POST pour récupérer le catalogue
                $client = new Client([
                    'base_uri' => 'https://pcs-all.online:8000'
                ]);
                $response = $client->post('/getHousingCatalogBySearch', [
                    'json' => [
                        'destination' => $destination,
                        'arrivalDate' => $arrivalDate,
                        'departureDate' => $departureDate,
                        'travelers' => $travelers
                    ]
                ]);
                $tmp_content = json_decode($response->getBody()->getContents(), true)['catalog'];
                unset($_POST);
            } else {
                $client = new Client();
                $response = $client->request('GET', 'https://pcs-all.online:8000/getAllCatalogByChoice/' . $choice);
                $tmp_content = json_decode($response->getBody(), true)['catalog'];
            }
            $content=[];
            foreach ($tmp_content as $key => $item) {
                //Requete API pour récupérer les disponibilités
                $client = new Client([
                    'base_uri' => 'https://pcs-all.online:8000'
                ]);
                $response = $client->get('/housingDisponibility/' . $item['id']);
                $disponibility = json_decode($response->getBody()->getContents(), true)['disponibility'];
                if (!empty($disponibility)) {
                    //Ajouter la note moyenne
                    try{
                        $client=new Client();
                        $response=$client->post('https://pcs-all.online:8000/getAverageRate',[
                            'json'=>[
                                'id'=>$item['id'],
                                'type'=>'housing'
                            ]
                        ]);
                        $averageRate=json_decode($response->getBody()->getContents(),true)['average'];
                    }catch (Exception $e){
                        echo $e->getMessage();
                        die();
                    }

                    if ($averageRate==null){
                        $averageRate="Pas de note disponible";
                    }
                    $item['averageRate']=$averageRate;
                    $content[] = $item;
                }
            }
?>
            <link rel="stylesheet" href="css/catalog.css">
            <div class="container" style="margin-top: 1em;">
                <div class="row">
                    <h2> Où souhaitez-vous séjourner ?</h2>
                </div>
                <div class="row" style=" background-color: #34656D;border-radius:1em; padding:0.5em;">
                    <div class="col-12">
                        <form class="d-flex" action="catalog?choice=housing" method="POST">
                            <input name="destination" id="destinationInput" class="form-control me-2" type="text" placeholder="Destination" aria-label="Search">
                            <input name="arrivalDate" class="form-control me-2" type="date" placeholder="Date d'arrivée" aria-label="Search">
                            <input name="departureDate" class="form-control me-2" type="date" placeholder="Date de départ" aria-label="Search">
                            <input name="travelers" class="form-control me-2" type="number" placeholder="Nombre de voyageurs" aria-label="Search" min="1" max="10">
                            <button class="btn btn-outline-light" type="submit">Rechercher</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php
            if (isset($destination) && !empty($destination)) {
                echo '<center><div class="container" style="margin-top: 2em;">';
                echo '<div class="row">';
                echo '<div class="col-12">';
                echo '<h2> Résultats pour ' . $destination . '</h2>';
                echo '</div>';
                echo '</div>';
                echo '</div></center>';
            }

            break;
        case 'performance':
            if (isset($_POST['type'])) {
                $activity = $_POST['type'];
                $date = $_POST['date'];
                //Requete API en POST pour récupérer le catalogue
                $client = new Client([
                    'base_uri' => 'https://pcs-all.online:8000'
                ]);
                $response = $client->post('/getPerformanceCatalogBySearch', [
                    'json' => [
                        'activity' => $activity,
                        'date' => $date
                    ]
                ]);
                $tmp_content = json_decode($response->getBody()->getContents(), true)['catalog'];
                unset($_POST);
            } else {
                $client = new Client();
                $response = $client->request('GET', 'https://pcs-all.online:8000/getAllCatalogByChoice/' . $choice);
                $tmp_content = json_decode($response->getBody(), true)['catalog'];
            }
            $content=[];
            foreach ($tmp_content as $key => $item) {
                //Requete API pour récupérer les disponibilités
                $client = new Client([
                    'base_uri' => 'https://pcs-all.online:8000'
                ]);
                $response = $client->get('/performanceDisponibility/' . $item['id']);
                $disponibility = json_decode($response->getBody()->getContents(), true)['disponibility'];
                if (!empty($disponibility)) {
                    //Ajouter la note moyenne
                    try{
                        $client=new Client();
                        $response=$client->post('https://pcs-all.online:8000/getAverageRate',[
                            'json'=>[
                                'id'=>$item['id'],
                                'type'=>'performance'
                            ]
                        ]);
                        $averageRate=json_decode($response->getBody()->getContents(),true)['average'];
                    }catch (Exception $e){
                        echo $e->getMessage();
                        die();
                    }
                    if ($averageRate==null){
                        $averageRate="Pas de note disponible";
                    }
                    $item['averageRate']=$averageRate;
                    $content[] = $item;
                }
            }

            ?>
            <div class="container" style="margin-top: 1em;">
                <div class="row">
                    <h2> Quelle activité souhaitez-vous découvrir ?</h2>
                </div>
                <div class="row" style=" background-color: #34656D;border-radius:1em; padding:0.5em;">
                    <div class="col-12">
                        <form class="d-flex">
                            <input name="activity" class="form-control me-2" type="text" placeholder="Activité" aria-label="Search" required>
                            <input name="date" class="form-control me-2" type="date" placeholder="Date" aria-label="Search">
                            <button class="btn btn-outline-light" type="submit">Rechercher</button>
                        </form>
                    </div>
                </div>
            </div>
<?php
            break;
        default:
            header('Location: /index.php');
            break;
    }
    if (isset($content) && !empty($content)) {
        echo '<center>';
        echo '<div class="container" style="margin: 2em;">';
        //Affichage du contenu sous forme de mosaique
        echo '<div class="row">';
        foreach ($content as $item) {
            //Requete API pour récupérer l'image
            try {
                $client = new Client([
                    'base_uri' => 'https://pcs-all.online:8000'
                ]);
                if ($choice == 'housing') {
                    $response = $client->get('/housingAdsImages/' . $item['id']);
                } else {
                    $response = $client->get('/performanceAdsImages/' . $item['id']);
                }
                $image = json_decode($response->getBody()->getContents(), true)['images'][0];
            } catch (Exception $e) {
                echo $e->getMessage();
                die();
            }
            echo '<div class="col-lg-3 col-md-6 col-12">';
            echo '<div class="card" style="width: 18rem; margin-bottom :1em !important;">
            <img img src="' . $image . '" class="card-img-top" alt="image de ' . $item['title'] . '">
            <div class="card-body" >
                <h5 class="card-title">' . $item['title'] . '</h5>
                <p class="card-text">Note moyenne : ' . $item['averageRate'] . '/5</p>
                <a href="/ads.php?id=' . $item['id'] . '&type=' . $choice . '" class="btn btn-primary">Voir plus</a>
            </div>
                </div>';
            echo '</div>';
        }

        echo '</div>';
        echo '</div>';
        echo '</center>';
    } else {
        echo '<center>';
        echo '<div class="container" style="margin: 2em;">';
        echo '<div class="row">';
        echo '<div class="col-12">';
        echo '<h2> Aucun résultat trouvé</h2>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</center>';
    }
} else {
    header('Location: /index.php');
}
include 'includes/footer.php';
?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBfTvwEttd84Lx7xTxVqNk85d6z3CaDYrE&libraries=places&callback=initAutocomplete" async defer></script>
<script>
    function initAutocomplete() {
        var input = document.getElementById('destinationInput');
        var options = {
            //Limites aux villes
            types: ['(cities)'],
        };
        new google.maps.places.Autocomplete(input, options);
    }
</script>