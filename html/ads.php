<link rel="stylesheet" href="css/ads.css">
<?php
require 'includes/header.php';
require 'vendor/autoload.php';

use GuzzleHttp\Client;

$userId = $_SESSION['userId'];
$id = $_GET['id'];
$type = $_GET['type'];

try {
    $client = new Client(['base_uri' => 'https://pcs-all.online:8000']);
    if ($type == 'housing') {
        $response = $client->get('/getHousingAdsInfo/' . $id);
    } else {
        $response = $client->get('/getPerformanceAdsInfo/' . $id);
    }
    $content = json_decode($response->getBody()->getContents(), true)['adsInfo'];
} catch (Exception $e) {
    echo $e->getMessage();
    die();
}

// Ajouter les disponibilités
if (isset($_POST['new_disponibility']) && !empty($_POST['new_disponibility'])) {
    $disponibility = json_decode($_POST['new_disponibility'], true);
    foreach ($disponibility as $date) {
        if ($type == 'performance'){
        $hour_duration = $_POST['hour_duration'];
        //arrondir 2 chiffres après la virgule
        $hour_duration = round($hour_duration, 2);
        $hour_start = $_POST['hour_start'];
        $hour_end = $_POST['hour_end'];

        if ($hour_end < $hour_start) {
            $temp = $hour_start;
            $hour_start = $hour_end;
            $hour_end = $temp;
        }
        }
        try {
            $client = new Client(['base_uri' => 'https://pcs-all.online:8000']);
            $test = [
                'id' => $id,
                'type' => $type,
                'date' => $date,
                'hour_start' => $hour_start,
                'hour_end' => $hour_end,
                'hour_duration' => $hour_duration
            ];

            $response = $client->post('/addAdsDisponibility', ['json' => $test]);

            $body = json_decode($response->getBody()->getContents(), true);
            if ($body == false) {
                $_SESSION['error'] = "Erreur lors de l'ajout des disponibilités";
            } else {
                $_SESSION['success'] = "Disponibilités ajoutées avec succès";
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            die();
        }
    }
    unset($_POST['new_disponibility']);
}

// Récupérer les disponibilités
$client = new Client(['base_uri' => 'https://pcs-all.online:8000']);
if ($type == 'housing') {
    $response = $client->get('/housingDisponibility/' . $id);
} else {
    $response = $client->get('/performanceDisponibility/' . $id);
}
$disponibility = json_decode($response->getBody()->getContents(), true);

if ($disponibility['success'] == false && ($_SESSION['grade'] != 4 || $_SESSION['grade'] != 5) && $_SESSION['userId'] != $content['id_user']) {
    $_SESSION['error'] = "Désolé, vous n'êtes pas autorisé à voir les disponibilités de cette annonce.";
    header('Location:/');
    exit();
}

// Display success and error messages
function displayMessage($type, $sessionKey)
{
    if (isset($_SESSION[$sessionKey])) {
        echo '<div class="alert alert-' . $type . '" role="alert" style="text-align:center !important">' . $_SESSION[$sessionKey] . '</div>';
        unset($_SESSION[$sessionKey]);
    }
}

displayMessage('success', 'success');
displayMessage('danger', 'error');
displayMessage('success', 'likeSuccess');
displayMessage('danger', 'likeError');

// Récupérer la note moyenne
try {
    $client = new Client();
    $response = $client->post('https://pcs-all.online:8000/getAverageRate', [
        'json' => ['id' => $id, 'type' => $type]
    ]);
    $averageRate = json_decode($response->getBody()->getContents(), true)['average'];
} catch (Exception $e) {
    echo $e->getMessage();
    die();
}

// Récupérer les commentaires
try {
    $client = new Client();
    $response = $client->post('https://pcs-all.online:8000/getComments', [
        'json' => ['id' => $id, 'type' => $type]
    ]);

    $comments = json_decode($response->getBody()->getContents(), true);
    if ($comments['success'] == true) {
        $comments = $comments['comments'];
    } else {
        $comments = null;
    }
} catch (Exception $e) {
    echo $e->getMessage();
    die();
}
?>

<div class="container" style="margin-top: 2em; background-color:#FFFDF6; padding: 1em;">
    <div class="row">
        <div class="col-md-6">
            <div id="carrouselIndividualAds" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    try {
                        $client = new Client(['base_uri' => 'https://pcs-all.online:8000']);
                        if ($type == 'housing') {
                            $response = $client->get('/housingAdsImages/' . $id);
                        } else {
                            $response = $client->get('/performanceAdsImages/' . $id);
                        }
                        $data = json_decode($response->getBody()->getContents(), true);
                    } catch (Exception $e) {
                        echo $e->getMessage();
                        die();
                    }

                    if ($data['success']) {
                        $images = $data['images'];
                        $active = true;
                        foreach ($images as $image) {
                            echo '<div class="carousel-item';
                            if ($active) {
                                echo ' active';
                                $active = false;
                            }
                            echo '">';
                            echo '<img src="' . $image . '" class="d-block w-100" style="border-radius:1em;" alt="image de ' . htmlspecialchars($content['title'], ENT_QUOTES, 'UTF-8') . '">';
                            echo '</div>';
                        }
                    } else {
                        echo "<p>Pas d'images</p>";
                    }
                    ?>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carrouselIndividualAds" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carrouselIndividualAds" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <hr>
            <div class="ads-description">
                <h3>Description</h3>
                <p><?php echo $content['description']; ?></p>
            </div>
        </div>
        <div class="col-md-6">
            <h2><?php echo $content['title']; ?></h2>
            <div class="ads-localisation">
                <?php
                if ($type == 'housing') {
                    echo $content['type_location'] . ' à ' . $content['city'] . ', ' . $content['country'];
                } else {
                    echo $content['performance_type'] . ' à ' . $content['city_appointment'] . ', ' . $content['country_appointment'];
                }
                ?>
            </div>
            <div class="ads-price">
                <?php
                if ($type == 'housing') {
                    echo $content['type_house'] . ' - ' . $content['guest_capacity'] . ' voyageurs - ' . $content['amount_room'] . ' chambres';
                }
                ?>
            </div>
            <hr>
            <?php
            $client = new Client(['base_uri' => 'https://pcs-all.online:8000']);
            $response = $client->get('/users/' . $content['id_user']);
            $body = json_decode($response->getBody()->getContents(), true);
            ?>
            <p>Publié par : <b>
                    <a href="#" class="open-user-modal" data-id="<?php echo $content['id_user']; ?>" data-type="<?php echo $type; ?>">
                        <?php echo htmlspecialchars($body['users']['pseudo'], ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                </b></p>
            <div id="user-modal-container"></div>

            <div>
                <?php if (isset($comments)) { ?>
                    <div id="carrouselComments" class="carousel slide carrouselComments" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php
                            $active = true;
                            foreach ($comments as $comment) {
                                echo '<div class="carousel-item';
                                if ($active) {
                                    echo ' active';
                                    $active = false;
                                }
                                echo '">';
                                echo '<div class="comment-box">';
                                echo '<p>Publié par : <b><a href="#" class="open-user-modal" data-id="' . $comment['user_id'] . '" data-type="' . $type . '">' . $comment['pseudo'] . '</a></b></p>';
                                echo '<p>' . $comment['review'] . '</p>';
                                echo '</div>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carrouselComments" data-bs-slide="prev">
                            <span class="fa fa-chevron-left" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carrouselComments" data-bs-slide="next">
                            <span class="fa fa-chevron-right" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                <?php } ?>
            </div>
            <br>
            <div class="ads-price">
                Prix <?php echo $type == 'housing' ? 'par nuit' : ''; ?>: <b><?php echo $content['price']; ?> €</b>
            </div>
            <br>
            <?php if (($_SESSION['grade'] == 4 && $type == 'housing' || $_SESSION['grade'] == 5 && $type == 'performance') && $_SESSION['userId'] == $content['id_user']) { ?>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAvailabilityModal">
                    Modifier les disponibilités
                </button>
                <div class="modal fade" id="addAvailabilityModal" tabindex="-1" aria-labelledby="addAvailabilityModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addAvailabilityModalLabel">Affichage des disponibilités</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div id="calendar"></div>
                                <button type="button" class="btn btn-secondary mt-3" onclick="submitForm()">Confirmer les modifications</button>
                                <form id="disponibilityForm" method="POST" action="">
                                    <input type="hidden" name="new_disponibility" id="newDisponibility" value="">
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
                
            <?php } else { ?>
                <div class="row">
                    <div class="col-md-12 button-container">
                        <form action="/reservation/booking" method="POST" class="d-flex w-100">
                            <input type="hidden" name="id" value="<?php echo $content['id']; ?>">
                            <input type="hidden" name="type" value="<?php echo $type; ?>">
                            <a href="https://pcs-all.online/reservation/booking?id=<?php echo $content['id']; ?>&type=<?php echo $type; ?>" class="btn btn-primary w-50 me-1">Réserver</a>
                            <a href="/privateMessage/addConversation?id=<?php echo $content['id']; ?>&type=<?php echo $type; ?>" class="btn btn-secondary w-50">Contacter le propriétaire</a>
                        </form>
                    </div>
                </div>
            <?php } ?>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <?php if (isset($_SESSION['userId']) && $_SESSION['grade'] != 4 && $_SESSION['grade'] != 5) {
                        $client = new Client(['base_uri' => 'https://pcs-all.online:8000']);
                        $response = $client->post('/isLiked', [
                            'json' => [
                                'id' => $content['id'],
                                'type' => $type,
                                'userId' => $_SESSION['userId']
                            ]
                        ]);
                        $body = json_decode($response->getBody()->getContents(), true)['favorites'];
                        if ($body != null) { ?>
                            <form action="/includes/like" method="POST">
                                <input type="hidden" name="action" value="removeLike">
                                <input type="hidden" name="id" value="<?php echo $content['id']; ?>">
                                <input type="hidden" name="type" value="<?php echo $type; ?>">
                                <button type="submit" class="btn btn-outline-secondary"> ♡ Retirer des favoris</button>
                            </form>
                        <?php } else { ?>
                            <form action="/includes/like" method="POST">
                                <input type="hidden" name="action" value="addLike">
                                <input type="hidden" name="id" value="<?php echo $content['id']; ?>">
                                <input type="hidden" name="type" value="<?php echo $type; ?>">
                                <button type="submit" class="btn btn-outline-secondary"> ♡ Ajouter aux favoris</button>
                            </form>
                    <?php }
                    } ?>
                </div>
                <div class="col-md-6">
                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="popover" data-bs-html="true" data-bs-content='
        <div class="d-flex flex-column">
            <a href="https://twitter.com/intent/tweet?url=https://pcs-all.online/ads.php?id=<?php echo $content['id']; ?>&type=<?php echo $type; ?>" target="_blank" class="btn btn-secondary mb-2">Twitter</a>
            <a href="https://www.linkedin.com/shareArticle?url=https://pcs-all.online/ads.php?id=<?php echo $content['id']; ?>&type=<?php echo $type; ?>" target="_blank" class="btn btn-secondary mb-2">LinkedIn</a>
            <a href="mailto:?subject=Regardez cette annonce&body=https://pcs-all.online/ads.php?id=<?php echo $content['id']; ?>&type=<?php echo $type; ?>" class="btn btn-secondary">Email</a>
        </div>'>
                        Partager
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.css">

    
<script>
    var newDisponibility = [];
    var hour_start;
    var hour_end;
    var hour_duration;
    var calendar; 

    function submitForm() {
        document.getElementById('newDisponibility').value = JSON.stringify(newDisponibility);
        
        
       
        console.log (document.getElementById('hour_start').value + ' ' + document.getElementById('hour_end').value + ' ' + document.getElementById('hour_duration').value);
        document.getElementById('disponibilityForm').submit();
    }

    document.addEventListener('DOMContentLoaded', function() {
        var disponibility = <?php echo json_encode($disponibility['disponibility'] ?? []); ?>;
        console.log('Disponibility:', disponibility); // Vérifier le contenu

        var events = [];
        var type = '<?php echo $type; ?>';
        if (disponibility && Array.isArray(disponibility)) {
            disponibility.forEach(element => {
                if (element.is_booked == 1) {
                    events.push({
                        start: element.date,
                        end: element.date,
                        display: 'background',
                        classNames: ['booked-date']
                    });
                } else {
                    events.push({
                        start: element.date,
                        end: element.date,
                        display: 'background',
                        classNames: ['available-date']
                    });
                }
            });
        } else {
            console.error('Disponibility is not an array or is undefined.');
        }

        var calendarEl = document.getElementById('calendar');
        if (calendarEl) {
            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: events,
                dayCellClassNames: function(date) {
                    return ['date-text'];
                },
                dateClick: function(info) {
                    var index = newDisponibility.indexOf(info.dateStr);
                    if (index === -1) {
                        if (type == 'performance') {
                            var hour_start = prompt('Heure de début (format 24h):');
                            var hour_end = prompt('Heure de fin (format 24h):');
                            var hour_duration = prompt('Durée de la performance (en minutes):');
                            if (hour_start && hour_end && hour_duration) {
                                // push la date d'aujourd'hui et les heures de début en datetime de fin datetime et hour_duration en int
                                newDisponibility.push(info.dateStr);
                                info.dayEl.classList.add('selected-date');
                                //hour_start en format Y/m/d H:i:s
                                hour_start = info.dateStr + ' ' + hour_start + ':00'+':00';
                                //hour_end en format Y/m/d H:i:s
                                hour_end = info.dateStr + ' ' + hour_end + ':00'+':00';
                                //hour_duration en heure 
                                hour_duration = parseInt(hour_duration) / 60;

                                document.getElementById('hour_start').value = hour_start;
                                document.getElementById('hour_end').value = hour_end;
                                document.getElementById('hour_duration').value = hour_duration;

                                

                              


                                
                            }
                        } else {
                            newDisponibility.push(info.dateStr);
                            info.dayEl.classList.add('selected-date');
                        }
                    } else {
                        newDisponibility.splice(index, 1);
                        info.dayEl.classList.remove('selected-date');
                    }
                }
            });
        } else {
            console.error('Calendar element not found.');
        }
    });

    // Écoutez l'événement 'shown.bs.modal' pour redimensionner le calendrier lorsque la modale est complètement affichée
    $('#addAvailabilityModal').on('shown.bs.modal', function() {
        if (calendar) {
            calendar.render();
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.open-user-modal').forEach(function(element) {
            element.addEventListener('click', function(event) {
                event.preventDefault();
                var userId = this.getAttribute('data-id');
                var type = this.getAttribute('data-type');
                var modalContainer = document.getElementById('user-modal-container');

                // Charger le contenu de la modale
                fetch('modaleUser.php?id_user=' + userId + '&type=' + type)
                    .then(response => response.text())
                    .then(data => {
                        modalContainer.innerHTML = data;
                        var userModal = new bootstrap.Modal(document.getElementById('userModal'));
                        userModal.show();
                    })
                    .catch(error => console.error('Erreur:', error));
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });
    });
</script>