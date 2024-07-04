<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PCS Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/charts.css/dist/charts.min.css">

    <link rel="stylesheet" href="..\..\css\base.css">
    <link rel="stylesheet" href="includes\admin.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body class="body bg-light">
    <?php session_start(); ?>
    <header class="header">
        <nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" <?php if (isset($_SESSION['admin'])) : ?> href="index.php" <?php endif; ?>>
                    <img src="../assets/logos/darkLogo.png" alt="Logo" height="70">
                </a>
                <?php if (isset($_SESSION['admin'])) : ?>
                    <div class="collapse navbar-collapse" id="navbarText">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    En attente de validation
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark">
                                    <li><a class="dropdown-item" href="validation?choice=vlandlords">Bailleurs</a></li>
                                    <li><a class="dropdown-item" href="validation?choice=vproviders">Prestataires</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li><a class="dropdown-item" href="validation?choice=vhousing">Logements</a></li>
                                    <li><a class="dropdown-item" href="validation?choice=vperformance">Prestations</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="validation?choice=vevolution">Evolution tarifaire</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Gestion annonces
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark">
                                    <li><a class="dropdown-item" href="ads?choice=housing">Logements</a></li>
                                    <li><a class="dropdown-item" href="ads?choice=performance">Prestations</a></li>
                                </ul>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Gestion utilisateurs
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark">
                                    <li><a class="dropdown-item" href="users?choice=travelers">Voyageurs</a></li>
                                    <li><a class="dropdown-item" href="users?choice=landlords">Bailleurs</a></li>
                                    <li><a class="dropdown-item" href="users?choice=providers">Prestataires</a></li>
                                    <li><a class="dropdown-item" href="users?choice=admins">Administrateurs</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="users?choice=all">Voir tout</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Support
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark">
                                    <li><a class="dropdown-item" href="support?choice=chatbot">Chatbot</a></li>
                                    <li><a class="dropdown-item" href="support?choice=tickets">Tickets</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                <?php endif; ?>

            </div>
        </nav>
        <?php if (isset($_SESSION['admin'])) : ?>
            <nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary">
                <div class="justify-content-end">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <span class="navbar-text">
                        <form action="includes/fun_log" method="POST">
                            <button type="submit" class="btn btn-primary" name="logout" value="true"><img src="..\assets\img\logout.png" height="20px"></button>
                        </form>
                    </span>
                </div>
            </nav>
        <?php endif; ?>
    </header>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>