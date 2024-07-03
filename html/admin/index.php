<?php
require 'includes/admin_header.php';
require 'includes/fun_admin.php';
//Si pas connecté, redirection vers la page de connexion
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
}
?>

<div class="admin-content">
    <h1>Dashboard</h1>
    <div class="admin-content-line">
        <!--Stat 1: User number -->
        <div class="stat-block">
            <h4><?php echo totalNbUsers(); ?></h4>
            <a href="users?choice=all"><h4>Utilisateurs</h4></a>
        </div>
        <!--Stat 2: Adds number-->
        <div class="stat-block">
            <h4><?php echo nbAds(); ?></h4>
            <h4>Annonces</h4>
        </div>
        <!--Stat 3: Pending number-->
        <div class="stat-block">
            <h4><?php echo nbAllPendingUsers()+ nbAllPendingAds(); ?></h4>
            <h4>Validation PCS en attente</h4>
        </div>
    
        <!--Stat 4:Admin number-->
        <div class="stat-block">
            <h4><?php echo nbUserByGrade(6); ?></h4>
            <a href="users?choice=admins"><h4>Administrateurs</h4></a>
        </div>
        <!--Stat 5: Graphique nombre de noveaux inscrits par mois-->
        <div class="stat-block">
            <h4>Nouveaux inscrits par mois</h4>
            <div class="chart">
                <canvas id="myChart3"></canvas>
            </div>
        </div>
    </div>
    <div class="admin-content-line">
        <!--Stat 1: Nombre d'utilisateurs par grade sous forme de diagramme-->
        <div class="stat-block">
            <h4>Utilisateurs par grade</h4>
            <div class="chart">
                <canvas id="myChart"  class="stats-canvas"></canvas>
            </div>
        </div>
        <!--Stat 2: Nombre de voyageur par grade sous forme de diagramme-->
        <div class="stat-block">
            <h4>Voyageurs par grade</h4>
            <div class="chart">
                <canvas id="myChart2" class="stats-canvas"></canvas>
            </div>
        </div>

        <!--Stat 3: Nombre d'annonces par catégorie sous forme de diagramme-->
        <div class="stat-block">
            <h4>Annonces par catégorie</h4>
            <div class="chart">
                <canvas id="myChart4" class="stats-canvas"></canvas>
            </div>
        </div>

        <!--Stat 4 : Nombre de prestations par type-->
        <div class="stat-block">
            <h4>Prestations par catégorie</h4>
            <div class="chart">
                <canvas id="myChart5" class="stats-canvas"></canvas>
            </div>
        </div>

    </div>
</div>

<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Voyageurs (<?php echo nbUserByGrade(1) + nbUserByGrade(2) + nbUserByGrade(3); ?>)', 'Bailleurs (<?php echo nbUserByGrade(4); ?>)', 'Prestataires (<?php echo nbUserByGrade(5); ?>)'],
            datasets: [{
                label: 'Nombre d\'utilisateurs par grade',
                data: [<?php $tot=nbUserByGrade(1)+nbUserByGrade(2)+nbUserByGrade(3); echo $tot; ?>, <?php echo nbUserByGrade(4); ?>, <?php echo nbUserByGrade(5); ?>],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var ctx2 = document.getElementById('myChart2').getContext('2d');
    var myChart2 = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ['Voyageurs simples (<?php echo nbUserByGrade(1); ?>)', 'Voyageurs VIP1 (<?php echo nbUserByGrade(2); ?>)', 'Voyageurs VIP2 (<?php echo nbUserByGrade(3); ?>)'],
            datasets: [{
                label: 'Nombre de voyageurs par grade',
                data: [<?php echo nbUserByGrade(1); ?>, <?php echo nbUserByGrade(2); ?>, <?php echo nbUserByGrade(3); ?>],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var ctx3 = document.getElementById('myChart3').getContext('2d');
    var myChart3 = new Chart(ctx3, {
        type: 'line',
        data: {
            labels: ['Janvier (<?php echo getNewUsersByMonth(1); ?>)', 'Février (<?php echo getNewUsersByMonth(2); ?>)', 'Mars (<?php echo getNewUsersByMonth(3); ?>)', 'Avril (<?php echo getNewUsersByMonth(4); ?>)', 'Mai (<?php echo getNewUsersByMonth(5); ?>)', 'Juin (<?php echo getNewUsersByMonth(6); ?>)', 'Juillet (<?php echo getNewUsersByMonth(7); ?>)', 'Août (<?php echo getNewUsersByMonth(8); ?>)', 'Septembre (<?php echo getNewUsersByMonth(9); ?>)', 'Octobre (<?php echo getNewUsersByMonth(10); ?>)', 'Novembre (<?php echo getNewUsersByMonth(11); ?>)', 'Décembre (<?php echo getNewUsersByMonth(12); ?>)'],
            datasets: [{
                label: 'Nouveaux utilisateurs par mois',
                data: [
                    <?php echo getNewUsersByMonth(1); ?>,
                    <?php echo getNewUsersByMonth(2); ?>,
                    <?php echo getNewUsersByMonth(3); ?>,
                    <?php echo getNewUsersByMonth(4); ?>,
                    <?php echo getNewUsersByMonth(5); ?>,
                    <?php echo getNewUsersByMonth(6); ?>,
                    <?php echo getNewUsersByMonth(7); ?>,
                    <?php echo getNewUsersByMonth(8); ?>,
                    <?php echo getNewUsersByMonth(9); ?>,
                    <?php echo getNewUsersByMonth(10); ?>,
                    <?php echo getNewUsersByMonth(11); ?>,
                    <?php echo getNewUsersByMonth(12); ?>
                ],
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    
    var ctx4 = document.getElementById('myChart4').getContext('2d');
    var myChart4 = new Chart(ctx4, {
        type: 'pie',
        data: {
            labels: ['Logement (<?php echo nbAdsByType("housing"); ?>)', 'Prestation (<?php echo nbAdsByType("performance"); ?>)'],
            datasets: [{
                label: 'Nombre d\'annonces par catégorie',
                data: [<?php echo nbAdsByType("housing"); ?>, <?php echo nbAdsByType("performance"); ?>],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var ctx5 = document.getElementById('myChart5').getContext('2d');
    var myChart5 = new Chart(ctx5, {
        type: 'pie',
        data: {
            labels: ['Ménage <?php echo nbPerformancesByCategory("1"); ?>', 'Transport <?php echo nbPerformancesByCategory("2"); ?>', 'Loisirs <?php echo nbPerformancesByCategory("3"); ?>', 'Autres <?php echo nbPerformancesByCategory("4"); ?>'],
            datasets: [{
                label: 'Nombre de prestations par catégorie',
                data: [ <?php echo nbPerformancesByCategory("1"); ?>, <?php echo nbPerformancesByCategory("2"); ?>, <?php echo nbPerformancesByCategory("3"); ?>, <?php echo nbPerformancesByCategory("4"); ?>],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

</script>

<?php
include 'includes/admin_footer.php';
?>
