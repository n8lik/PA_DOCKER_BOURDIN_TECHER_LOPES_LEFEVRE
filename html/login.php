<?php
$pageTitle = "Connexion";
require 'includes/header.php';
session_start();

?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="text-center mb-4" staticTotranslate="login_title">Se connecter</h1>
            <form action="includes/login" method="POST">
                <div class="mb-3">
                    <?php
                    // Si une erreur existe, on l'affiche 
                    if (isset($_SESSION['ERRORS']['nouser'])) {
                    ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $_SESSION['ERRORS']['nouser']; ?>
                        </div>
                    <?php
                        unset($_SESSION['ERRORS']['nouser']);
                    }

                    if (isset($_SESSION['ERRORS']['emptyfields'])) {
                    ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $_SESSION['ERRORS']['emptyfields']; ?>
                        </div>
                    <?php
                        unset($_SESSION['ERRORS']['emptyfields']);
                    }
                    if (isset($_SESSION['ERRORS']['captcha'])) {
                    ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $_SESSION['ERRORS']['captcha']; ?>
                        </div>
                    <?php
                        unset($_SESSION['ERRORS']['captcha']);
                    }
                    if (isset($_SESSION['passwordOk'])) {
                    ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $_SESSION['passwordOk']; ?>
                        </div>
                    <?php
                        unset($_SESSION['passwordOk']);
                    }
                    if (isset($_SESSION['passwordError'])) {
                    ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $_SESSION['passwordError']; ?>
                        </div>
                    <?php
                        unset($_SESSION['passwordError']);
                    }
                    if (isset($_SESSION['SUCCESS']['password'])) {
                    ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $_SESSION['SUCCESS']['password']; ?>
                        </div>
                    <?php
                        unset($_SESSION['SUCCESS']['password']);
                    }
                    if (isset($_SESSION['pwd'])) {
                    ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $_SESSION['pwd']; ?>
                        </div>
                    <?php
                        unset($_SESSION['pwd']);
                    }

                    ?>

                    <label for="signin-email" class="form-label" staticTotranslate="login_email_label">Email</label>
                    <input type="email" class="form-control" id="signin-email" name="email" placeholder="Adresse email" required>

                </div>
                <div class="mb-3 position-relative">
                    <label for="signin-password" class="form-label" staticTotranslate="login_password_label">Mot de passe</label>
                    <input type="password" class="form-control" id="signin-password" name="password" placeholder="Mot de passe" required>
                    <i class="toggle-password bi bi-eye-slash position-absolute" style="top: 38px; right: 10px; cursor: pointer;"></i>
                </div>
                <center>
                    <div class="g-recaptcha" data-sitekey="6Ldj_NopAAAAAPFMUGV9t6pDP3nJnqh-VuqpkTwg"></div>
                </center>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary" name="loginsubmit" staticTotranslate="login">Se connecter</button>
                </div>
                <div class="mt-3 text-center">
                    <span staticTotranslate="login_no_account">Pas de compte ?</span> <a href="register.php" staticTotranslate="login_sign_up_here_link">PCS</a>.
                </div>
                <div class="mt-3 text-center">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal" staticTotranslate="login_forgot_password">Mot de passe oublié ?</a>
                </div>
            </form>
            <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="forgotPasswordModalLabel" staticTotranslate="login_forgot_password_title">Récupération de mot de passe</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="includes/forgotPassword" method="POST">
                                <div staticTotranslate="login_forgot_password_text">
                                    Entrez votre adresse email pour recevoir un lien de réinitialisation de mot de passe.
                                </div>
                                <br>
                                <div class="mb-3">
                                    <label for="forgot-email" class="form-label" staticTotranslate="login_forgot_password_email_label">Email</label>
                                    <input type="email" class="form-control" id="forgot-email" name="email" placeholder="Adresse email" required>
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary" name="forgotpasswordsubmit" staticTotranslate="send">Envoyer</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.2/font/bootstrap-icons.min.css">
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.querySelector('.toggle-password');
        const passwordField = document.querySelector('#signin-password');

        togglePassword.addEventListener('click', function() {
            // Toggle the type attribute
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);

            // Toggle the icon
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    });
</script>

<?php include 'includes/footer.php'; ?>
