<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="/assets/logos/darkLogo.png" type="image/x-icon">
	<title>
		<?php
		if (isset($pageTitle)) {
			echo "PCS - $pageTitle";
		} else {
			echo "PCS";
		}
		?>
	</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.css' rel='stylesheet' />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
	<script src="/includes/theme.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.js'></script>
	<link rel="stylesheet" href="/css/variables.css">
	<link rel="stylesheet" href="/css/base.css">
</head>

<body class="body">
	<header class="header">
		<nav class="navbar navbar-expand-lg navbar-dark bg-body-tertiary">
			<div class="container-fluid">
				<a class="navbar-brand" href="/">
					<img src="/assets/logos/darkLogo.png" alt="Logo" height="60">
				</a>
				<div class="collapse navbar-collapse" id="navbarText">
					<ul class="navbar-nav me-auto mb-2 mb-lg-0">
						<?php if (isset($_SESSION['grade']) && $_SESSION['grade'] == '1') { ?>
							<li class="nav-item">
								<a class="nav-link active" aria-current="page" href="/catalog?choice=housing" staticTotranslate="header_housing">Logements</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="/catalog?choice=performance" staticTotranslate="header_performance">Prestations</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="/travelers/catalogBookings" staticTotranslate="header_my_reservations">Mes réservations</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="/travelers/favorites" staticTotranslate="header_favorites">Coups de cœur</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#" staticTotranslate="header_vip_subscription">Souscription VIP</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="/privateMessage/privateMessage" staticTotranslate="header_messaging">Messagerie</a>
							</li>
						<?php } elseif (isset($_SESSION['grade']) && $_SESSION['grade'] == '4') { ?>
							<li class="nav-item">
								<a class="nav-link" href="/bailleurs/logements/houses" staticTotranslate="header_my_houses">Mes logements</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="/bailleurs/logements/booking?id=<?php echo $_SESSION["userId"]; ?>" staticTotranslate="header_booking_history">Historique des réservations</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#" staticTotranslate="header_my_fees">Mes frais</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="/files/files" staticTotranslate="header_my_documents">Mes documents</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="/privateMessage/privateMessage" staticTotranslate="header_messaging">Messagerie</a>
							</li>
						<?php } else if (isset($_SESSION['grade']) && $_SESSION['grade'] == '5') { ?>
							<a class="nav-link" href="/providers/performances" staticTotranslate="header_my_performances">Mes prestations</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="/providers/booking?id=<?php echo $_SESSION["userId"]; ?>" staticTotranslate="header_performance_history">Historique des prestations</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#" staticTotranslate="header_invoices">Factures</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="/files/files" staticTotranslate="header_my_documents">Mes documents</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="/privateMessage/privateMessage" staticTotranslate="header_messaging">Messagerie</a>
							</li>
						<?php } else { ?>
							<li class="nav-item">
								<a class="nav-link active" aria-current="page" href="/catalog?choice=housing" staticTotranslate="header_housing">Logements</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="/catalog?choice=performance" staticTotranslate="header_performance">Prestations</a>
							</li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</nav>

		<nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary">
			<div class="justify-content-end">
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<form method="POST" id="langForm" action="">
					<select name="lang" id="lang" onchange="changeLanguage(this.value)">
						<?php
						$lang_dir = '/var/www/html/includes/lang';
						$langs = array_diff(scandir($lang_dir), array('.', '..'));
						foreach ($langs as $file) {
							if (pathinfo($file, PATHINFO_EXTENSION) == 'json') {
								$lang = pathinfo($file, PATHINFO_FILENAME);
								$selected = (isset($_COOKIE['language']) && $_COOKIE['language'] == $lang) || (isset($_SESSION['language']) && $_SESSION['language'] == $lang) ? 'selected' : '';
								echo "<option value='$lang' $selected>$lang</option>";
							}
						}
						?>
					</select>
				</form>
				<?php if (isset($_SESSION['grade'])) { ?>
					<span class="navbar-text">
						<a href="/profile" class="btn btn-primary"><img src="/assets/img/login.png" height="20px"></a>
					</span>
					<span class="navbar-text">
						<a href="/logout.php" class="btn btn-primary"><img src="/assets/img/logout.png" height="20px"></a>
					</span>
				<?php } else { ?>
					<span class="navbar-text">
						<a href="/login.php" class="btn btn-primary"><img src="/assets/img/login.png" height="20px"></a>
					</span>
				<?php } ?>
			</div>
		</nav>
	</header>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<?php
	require '/var/www/html/includes/functions/functions.php';
	?>

	<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['lang'])) {
		$lang = $_POST['lang'];
		if (isset($_COOKIE['acceptCookies']) && $_COOKIE['acceptCookies']) {
			setcookie('language', $lang, time() + (365 * 24 * 60 * 60), '/'); // 1 year
		} else {
			$_SESSION['language'] = $lang;
		}
		header("Location: " . $_SERVER['PHP_SELF']);
		exit();
	}

	$lang = isset($_COOKIE['language']) ? $_COOKIE['language'] : (isset($_SESSION['language']) ? $_SESSION['language'] : 'fr');
	echo "<script>document.addEventListener('DOMContentLoaded', () => { changeLanguage('$lang'); });</script>";
	?>
