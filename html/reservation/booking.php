<?php


$pageTitle = "Réservation";
require '../includes/header.php';
require '../vendor/autoload.php';
session_start();

use GuzzleHttp\Client;

if (!isConnected()) {
    $_SESSION['isConnected'] = "Vous devez être connecté pour accéder à cette page";
    header("Location: /");

    die();
}
if (!isset($_GET["id"]) || !isset($_GET["type"])) {
    header("Location: /");
    die();
}



$id = $_GET["id"];
$type = $_GET["type"];

$client = new Client(['base_uri' => 'https://pcs-all.online:8000']);
$response = $client->get($type == 'housing' ? '/housingDisponibility/' . $id : '/performanceDisponibility/' . $id);
$disponibility = json_decode($response->getBody()->getContents(), true)['disponibility'];

$response = $client->get($type == 'housing' ? '/housingAdsImages/' . $id : '/performanceAdsImages/' . $id);
$images = json_decode($response->getBody()->getContents(), true)['images'];

$response = $client->get($type == 'housing' ? '/getHousingAdsInfo/' . $id : '/getPerformanceAdsInfo/' . $id);
$ad = json_decode($response->getBody()->getContents(), true)['adsInfo'];

$response = $client->get('/usersbytoken/' . $_SESSION['token']);
$user = json_decode($response->getBody()->getContents(), true)['users'];
if ($type == 'performance') {
    if (($user['grade'] == 2 && $ad['price']<80 ) || $user['grade'] == 3) {
        if ($user["free_perf"]==0) {
            $message =  '<div class="alert alert-success" role="alert">Vous avez une réservation gratuite, elle sera déduite de la facture finale.</div>';
            $ad['price'] = 0;
            if ($user['grade'] == 2) {
                $_SESSION["free_perf_end_date"] = date("Y-m-d H:i:s", strtotime($user["free_perf_end_date"] . " + 1 year"));
            } else {
                $_SESSION["free_perf_end_date"] = date("Y-m-d H:i:s", strtotime($user["free_perf_end_date"] . " + 3 month"));
            }
        } else if ($user["free_perf"] == 1 && $user["free_perf_end_date"] < date("Y-m-d H:i:s")) {
            $ad['price'] = 0;
            $message = '<div class="alert alert-success" role="alert">Vous avez une réservation gratuite, elle sera déduite de la facture finale.</div>';
        } else {
            $ad['price'] =  $ad['price'] * 0.95;
        }
    }
}
?>
<div class="terms-container">
    <div class="container" style="margin-top: 1em;">
        <div class="row">
            <center>
                <h1><strong>Réservation</strong></h1>
                <hr>
            </center>
        </div>
        <?php
        

        if (isset($message)) {
            echo $message;
        }

        if (isset($_SESSION["booking"])) {
            if ($_SESSION["booking"] == 0) {
        ?>
                <div class="alert alert-success" role="alert">
                    Votre réservation a été effectuée avec succès. Vous recevrez votre facture par mail sous peu.
                </div>
            <?php
                unset($_SESSION["booking"]);
            } else {
            ?>
                <div class="alert alert-danger" role="alert">
                    Une erreur est survenue lors de la réservation.
                </div>
            <?php
                unset($_SESSION["booking"]);
            }
        }
        if (isset($_SESSION["Erreur"])) {
            foreach ($_SESSION["Erreur"] as $erreur) {
                echo '<div class="alert alert-danger" role="alert">' . $erreur . '</div>';
            }
            unset($_SESSION["Erreur"]);
        }
        if (!isset($disponibility)) {
            echo '<div class="alert alert-danger" role="alert">Aucune disponibilité n\'est renseignée pour cette annonce.</div>';
        } else {
            ?>
            <div class="row" style="height: 40vh;">
                <div class="col-8" style="height: 100%;">
                    <div class="row" style="height: 100%;">
                        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" style="height: 100%;">
                            <div class="carousel-inner" style="height: 100%;">
                                <?php
                                if (isset($images)) {
                                    for ($i = 0; $i < count($images); $i++) {
                                        $image = $images[$i];
                                        echo '<div class="carousel-item' . ($i == 0 ? ' active' : '') . '" style="height: 100%;">';
                                        echo '<img src="' . $image . '" class="d-block w-100" alt="Image ' . $i . '" style="height: 100%; object-fit: cover;">';
                                        echo '</div>';
                                    }
                                }
                                ?>
                            </div>
                            <a class="carousel-control-prev" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </a>
                            <a class="carousel-control-next" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-4" style="height: 100%;">
                    <div id='calendar' style="height: 100%;"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-8">
                    <br>
                    <h2><?php echo $ad['title']; ?></h2>
                    <?php if ($type == 'housing') { ?>
                        <p> L'adresse exacte vous sera communiquée après la réservation.</p>
                    <?php } else {
                        // on passes $ad['radius'] à 2 chiffres derrière la virgule 
                        $ad['radius'] = number_format($ad['radius'], 2, ',', ' ');
                    ?>
                        <p>Lieu d'action <?php echo $ad['city_appointment']; ?>, <?php echo $ad['country_appointment']; ?> dans un rayon de : <?php echo $ad['radius']; ?> km</p>
                    <?php } ?>
                </div>
                <div class="col-4" style="text-align: right;">
                    <?php if ($type == 'housing') { ?>

                        <p> Selectionnez les dates de votre séjour</p>
                        <p><?php echo $ad['price']; ?> €/nuit</p>

                    <?php } else { ?>
                        <p>Selectionnez la date de votre événement</p>
                        <p><?php echo $ad['price'] . "€/" . $ad["price_type"]; ?></p>
                    <?php } ?>
                </div>
                <hr>
                <div class="row">
                    <?php if ($type == 'housing') { ?>
                        <div class="col-8">
                            <?php echo $ad['guest_capacity']; ?> personnes - <?php echo $ad['property_area']; ?> m² - <?php echo $ad['amount_room']; ?> chambres
                            <br>
                            <p><strong>Description:</strong> <?php echo $ad['description']; ?></p>
                        </div>
                        <div class="col-4">
                            <p>Date de début: <strong id="start-date"></strong>
                                <br>
                                Date de fin: <strong id="end-date"></strong>
                                <br>
                                Total: <strong id="total-price"></strong>
                            </p>
                            <!-- Formulaire de paiement -->
                            <form id="payment-form" method="POST" action="payment">
                                <label for="amount_people">Nombre de personnes</label>
                                <input type="hidden" name="id" value="<?php echo $id; ?>" required>
                                <input type="hidden" name="type" value="<?php echo $type; ?>">
                                <input type="number" name="amount_people">

                                <input type="hidden" id="s-date" name="s-date" value="">
                                <input type="hidden" id="e-date" name="e-date" value="">
                                <input type="hidden" id="price" name="price" value="">
                                <input type="hidden" name="title" value="<?php echo $ad['title'] ?>">
                                <div id="card-element"></div>

                                <div id="card-errors" role="alert"></div>
                                <button id="submit">Payer</button>
                            </form>
                        </div>
                    <?php } else if ($type == 'performance') { ?>
                        <div class="col-8">
                            <?php echo "prix : " . $ad['price'] . "€/" . $ad['price_type']; ?>
                            <br>
                            <p><strong>Description:</strong> <?php echo $ad['description']; ?></p>
                        </div>
                        <div class="col-4">
                            <p>Date de la réservation: <strong id="start-date"></strong>
                                <br>

                            <p>Heure de début: <strong id="hour_start_display"></strong>
                                <br>
                                Heure de fin: <strong id="hour_end_display"></strong>
                                <br>

                                Total: <strong id="total-price"></strong>
                            </p>

                            <div class="modal fade" id="addAvailabilityModal" tabindex="-1" aria-labelledby="addAvailabilityModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addAvailabilityModalLabel">Affichage des disponibilités</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <div> Durée de la prestation : <p id="hour-duration"></p>
                                            </div>
                                            <?php if ($ad['price_type'] == 'heure') { ?>
                                                <div> Le prix est en heure <p id="heure-container"></p>
                                                </div>
                                            <?php } else if ($ad['price_type'] == 'km') {

                                            ?><div> Nombre de KM à parcourir : <p id="km-container"></p>
                                                </div><?php } else if ($ad['price_type'] == 'm²') { ?>
                                                <div> Nombre de m² à nettoyer : <p id="m2-container"></p>
                                                </div>
                                            <?php } else if ($ad['price_type'] == 'prestation') { ?>
                                                <div> Prix de la prestation : <p id="prestation-container"></p>
                                                </div>
                                            <?php } else if ($ad['price_type'] == 'mur') { ?>
                                                <div> Nombre de murs à peindre : <p id="mur-container"></p>
                                                </div>
                                            <?php } ?>




                                            <div>Heure de début de disponibilité : <p id="hour-start"></p>
                                            </div>
                                            <div>Heure de fin de disponibilité : <p id="hour-end"></p>
                                            </div>
                                            <button type="button" class="btn btn-primary" id="submit-button">Valider la réservation</button>
                                            <form id="disponibilityForm" method="POST" action="">
                                                <input type="hidden" name="hour_start" id="hour_start" value="">
                                                <input type="hidden" name="hour_end" id="hour_end" value="">
                                                <input type="hidden" name="hour_duration" id="hour_duration" value="">

                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Formulaire de paiement -->
                            <form id="payment-form" method="POST" action="payment?id=<?php echo $id; ?>&type=<?php echo $type; ?>">
                                <input type="hidden" name="id" value="<?php echo $id; ?>" required>
                                <input type="hidden" name="type" value="<?php echo $type; ?>">
                                <input type="hidden" id="hour_start_input" name="hour_start" value="">
                                <input type="hidden" id="hour_end_input" name="hour_end" value="">
                                <input type="hidden" id="hour_duration_input" name="hour_duration" value="">

                                <input type="hidden" id="km" name="km" value="">
                                <input type="hidden" id="m2" name="m2" value="">
                                <input type="hidden" id="heure" name="heure" value="">
                                <input type="hidden" id="mur" name="mur" value="">
                                <input type="hidden" id="prestation" name="prestation" value="">

                                <input type="hidden" id="s-date" name="s-date" value="">
                                <input type="hidden" id="price" name="price" value="">
                                <input type="hidden" name="title" value="<?php echo $ad['title'] ?>">
                                <div id="card-element"></div>

                                <div id="card-errors" role="alert"></div>
                                <button id="submit">Payer</button>
                            </form>
                        </div>
                <?php }
                } ?>
                </div>
            </div>
    </div>
</div>
<?php

require '../includes/footer.php';
?>
<script src="https://js.stripe.com/v3/"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.js'></script>
<script>
    // Récupérer les disponibilités et créer les événements pour FullCalendar
    let disponibility = <?php echo json_encode($disponibility); ?>;

    let events = [];
    let availableDates = new Set();
    let hour = new Set();
    //hour start et end en format Y-M-D H:i:s



    function isDateBetween(start, end) {
        let available = new Set();
        for (let d = new Date(start); d <= new Date(end); d.setDate(d.getDate() + 1)) {
            if (availableDates.has(d.toISOString().split('T')[0])) {
                console.log('day: ' + d.toISOString().split('T')[0]);
                available.add(1);
            } else {
                available.add(0);

            }

        }

        if (available.has(0)) {
            file = 0;
        } else {
            file = 1;
        }
        return file;
    }
    type = "<?php echo $type; ?>";
    if (type == 'housing') {
        // Ajoutez des événements pour toutes les dates de disponibilité

        for (let i = 0; i < disponibility.length; i++) {
            let date = disponibility[i]['date'];
            let isBooked = disponibility[i]['is_booked'];

            if (isBooked == 0) {
                availableDates.add(date);

            }

            events.push({
                start: date,
                display: 'background',
                backgroundColor: isBooked == 1 ? 'lightgray' : 'green'
            });
        }

        let calendarEl = document.getElementById('calendar');
        let calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: '100%',
            events: events,
            selectable: true,
            select: function(info) {
                let startDate = info.startStr;
                let endDate = info.endStr;
                let date = new Date(endDate);
                date.setDate(date.getDate() - 1);
                endDate = date.toISOString().split('T')[0];
                console.log(endDate);
                //si il n'y a qu'un jour de séléctionné, on indique une erreur
                if (startDate == endDate) {
                    alert("Veuillez sélectionner au moins deux jours.");
                    return;
                }

                if (isDateBetween(startDate, endDate) == 0) {
                    alert("Veuillez sélectionner uniquement les dates disponibles.");
                    return;
                }
                if (availableDates.has(startDate) && availableDates.has(endDate)) {
                    document.getElementById('start-date').textContent = startDate;
                    document.getElementById('end-date').textContent = endDate;

                    let totalPrice = calculateTotalPrice(startDate, endDate, <?php echo $ad['price']; ?>);
                    document.getElementById('total-price').textContent = totalPrice + " €";
                    document.getElementById('price').value = totalPrice;

                    document.getElementById('s-date').value = startDate;
                    document.getElementById('e-date').value = endDate;



                } else {
                    alert("Veuillez sélectionner uniquement les dates disponibles.");
                }
            },
            dayCellDidMount: function(info) {
                if (availableDates.has(info.dateStr)) {
                    info.el.style.backgroundColor = 'green';
                } else {
                    info.el.style.backgroundColor = 'lightgray';
                }
            }
        });

        calendar.render();

        function calculateTotalPrice(startDate, endDate, pricePerNight) {
            let start = new Date(startDate);
            let end = new Date(endDate);
            let nights = (end - start) / (1000 * 60 * 60 * 24);
            return nights * pricePerNight;
        }
    } else {
        function submitForm(hourStart, hourEnd, hourDuration) {
            document.getElementById('hour_start_input').value = hourStart;
            document.getElementById('hour_end_input').value = hourEnd;
            document.getElementById('hour_duration_input').value = hourDuration;
            $('#addAvailabilityModal').modal('hide');
        }

        function getLastHourEnd(disponibilities, date) {
            // Filtrer les disponibilités pour la date donnée et celles qui ne sont pas réservées
            let filteredDisponibilities = disponibilities.filter(d => d.date === date && d.is_booked == 0);

            // Utiliser reduce pour trouver la dernière heure de fin
            let lastHourEnd = filteredDisponibilities.reduce((latest, current) => {
                return (new Date(current.hour_end) > new Date(latest.hour_end)) ? current : latest;
            }, filteredDisponibilities[0]).hour_end;

            return lastHourEnd;
        }
        hour = new Set();
        for (let i = 0; i < disponibility.length; i++) {
            let date = disponibility[i]['date'];
            let isBooked = disponibility[i]['is_booked'];
            if (isBooked == 0) {
                availableDates.add(date);


            }
            events.push({
                start: date,
                display: 'background',
                backgroundColor: isBooked == 1 ? 'lightgray' : 'green'
            });
        }
        let calendarEl = document.getElementById('calendar');
        let calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: '100%',
            events: events,
            selectable: true,
            dateClick: function(info) {
                let date = info.dateStr;

                let availability = disponibility.find(d => d.date === date);
                if (availability) {

                    $('#addAvailabilityModal').modal('show');
                    if (availableDates.has(date)) {
                        document.getElementById('start-date').textContent = date;
                        document.getElementById('s-date').value = date;

                        let hour_duration = availability.hour_duration;
                        let hour_start = availability.hour_start.split(' ')[1].split(':').slice(0, 2).join(':');
                        let hour_end = getLastHourEnd(disponibility, date).split(' ')[1].split(':').slice(0, 2).join(':');

                        document.getElementById('hour-start').textContent = hour_start;
                        document.getElementById('hour-end').textContent = hour_end;
                        document.getElementById('hour-duration').textContent = hour_duration;


                        let hourStart = document.createElement('input');

                        hourStart.setAttribute('type', 'time');
                        hourStart.setAttribute('id', 'hour-start-value');
                        hourStart.setAttribute('class', 'form-control');
                        hourStart.setAttribute('placeholder', 'Heure de début');
                        document.getElementById('hour-start').appendChild(hourStart);

                        let hourEnd = document.createElement('input');

                        hourEnd.setAttribute('type', 'time');
                        hourEnd.setAttribute('id', 'hour-end-value');
                        hourEnd.setAttribute('class', 'form-control');
                        hourEnd.setAttribute('placeholder', 'Heure de fin');
                        document.getElementById('hour-end').appendChild(hourEnd);

                        let price_type = <?php echo json_encode($ad['price_type']); ?>;

                        function createInputField(id, placeholder, containerId, readonly) {
                            let inputField = document.createElement('input');
                            inputField.setAttribute('type', 'number');
                            inputField.setAttribute('id', id);
                            if (readonly) {
                                inputField.setAttribute('readonly', 'true');
                            }
                            inputField.setAttribute('class', 'form-control');
                            inputField.setAttribute('placeholder', placeholder);
                            document.getElementById(containerId).appendChild(inputField);
                        }

                        if (price_type == 'km') {
                            createInputField('km', 'Type de prix de la prestation', 'km-container', false);
                        } else if (price_type == 'm²') {
                            createInputField('m2', 'Type de prix de la prestation', 'm2-container', false);
                        } else if (price_type == 'heure') {
                            createInputField('heure', 'Type de prix de la prestation', 'heure-container', true);
                        } else if (price_type == 'mur') {
                            createInputField('mur', 'Type de prix de la prestation', 'mur-container', false);
                        } else if (price_type == 'prestation') {
                            createInputField('prestation', 'Type de prix de la prestation', 'prestation-container', true);
                        }





                        document.getElementById('submit-button').addEventListener('click', function() {
                            let hourStart = document.getElementById('hour-start-value').value;
                            let hourEnd = document.getElementById('hour-end-value').value;
                            let hourDuration = document.getElementById('hour-duration').textContent;


                            if (hourStart && hourEnd) {
                                submitForm(hourStart, hourEnd, hourDuration);
                                document.getElementById('hour_start_display').textContent = hourStart;
                                document.getElementById('hour_end_display').textContent = hourEnd;

                                let price = <?php echo $ad['price']; ?>;
                                let totalPrice = 0;
                                let km = 0;
                                let m2 = 0;
                                let mur = 0;
                                let prestation = 0;

                                console.log(price_type);
                                if (price_type == 'km') {
                                    km = document.getElementById('km').value;
                                    totalPrice = calculateTotalPrice(hourStart, hourEnd, hourDuration, price_type, km, 0, 0, 0)
                                } else if (price_type == 'm²') {
                                    m2 = document.getElementById('m2').value;
                                    totalPrice = calculateTotalPrice(hourStart, hourEnd, hourDuration, price_type, 0, m2, 0, 0);
                                } else if (price_type == 'heure') {
                                    totalPrice = calculateTotalPrice(hourStart, hourEnd, hourDuration, price_type, 0, 0, 0, 0);
                                    if (hourEnd < hourStart) {
                                        alert("L'heure de fin doit être supérieure à l'heure de début");
                                        return;
                                    } else if (hourEnd == hourStart) {
                                        alert("L'heure de fin doit être différente de l'heure de début");
                                        return;
                                    } else if (hourEnd - hourStart < hourDuration) {
                                        alert("La durée de la prestation doit être supérieure ou égale à la durée de la prestation");
                                        return;
                                    } else if (hourStart < availability.hour_start.split(' ')[1].split(':').slice(0, 2).join(':') || hourEnd > availability.hour_end.split(' ')[1].split(':').slice(0, 2).join(':')) {
                                        alert("Veuillez sélectionner une heure de début et une heure de fin dans les disponibilités.");
                                        return;
                                    }
                                } else if (price_type == 'mur') {
                                    mur = document.getElementById('mur').value;
                                    totalPrice = calculateTotalPrice(hourStart, hourEnd, hourDuration, price_type, 0, 0, mur, 0);
                                } else if (price_type == 'prestation') {
                                    prestation = document.getElementById('prestation').value;
                                    totalPrice = calculateTotalPrice(hourStart, hourEnd, hourDuration, price_type, 0, 0, 0, prestation);
                                }
                                console.log(km);
                                console.log(totalPrice);

                                document.getElementById('total-price').textContent = totalPrice + " €";
                                document.getElementById('price').value = totalPrice;
                            } else {
                                alert("Veuillez sélectionner une heure de début et une heure de fin.");
                            }


                        });

                    } else {
                        alert("Veuillez sélectionner uniquement les dates disponibles.");
                    }
                }
            },


            dayCellDidMount: function(info) {
                if (availableDates.has(info.dateStr)) {
                    info.el.style.backgroundColor = 'green';
                } else {
                    info.el.style.backgroundColor = 'lightgray';
                }
            }
        });

        function calculateTotalPrice(hourStart, hourEnd, hourDuration, priceType, km, m2, mur, prestation) {

            let hours = (new Date('1970-01-01T' + hourEnd) - new Date('1970-01-01T' + hourStart)); // en ms
            hours = hours / 1000 / 60 / 60; // en heures
            let price = <?php echo $ad['price']; ?>;

            if (priceType == 'heure') {
                return hours * price * hourDuration;
            } else if (priceType == 'km') {
                return km * price;
            } else if (priceType == 'm²') {
                return m2 * price;
            } else if (priceType == 'mur') {
                return mur * price;
            } else if (priceType == 'prestation') {
                return price * (hours / hourDuration);
            }
        }
        calendar.render();


    }




    // Gestion des flèches du carousel
    $('.carousel-control-prev').click(function() {
        $('#carouselExampleControls').carousel('prev');
    });

    $('.carousel-control-next').click(function() {
        $('#carouselExampleControls').carousel('next');
    });
</script>