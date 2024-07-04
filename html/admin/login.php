
<?php require '/var/www/html/admin/includes/admin_header.php'; 
session_start(); // Démarrer la session au début

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center mb-4">Se connecter à l'interface administrateur</h1>
                <?php if (isset($_SESSION['errors'])): ?>
                    <div class="alert alert-danger">
                        <?php foreach ($_SESSION['errors'] as $error): ?>
                            <p class="mb-0"><?php echo $error; ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <form action="includes/fun_log" method="POST">
                    <div class="mb-3">
                        <label for="signin-email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="signin-email" name="email" placeholder="Adresse email" required >
                    </div>
                    <div class="mb-3">
                        <label for="signin-password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="signin-password" name="password" placeholder="Mot de passe" required >
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary" name="loginsubmit" value="true">Se connecter</button>
                    </div>
                    <div class="mt-2 text-center">
                        <a href="forgot_password.php">Mot de passe oublié?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
        <?php include '/var/www/html/admin/includes/admin_footer.php'; ?>


