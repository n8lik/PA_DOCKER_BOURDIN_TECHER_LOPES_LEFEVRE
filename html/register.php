<?php require 'includes/header.php'; ?>
<link rel="stylesheet" href="css/register.css">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4" staticTotranslate="register_create_account">Créer un compte</h2>
                    <?php if (isset($_SESSION['listOfErrors'])) : ?>
                        <div class="alert alert-danger" role="alert">
                            <ul>
                                <?php foreach ($_SESSION['listOfErrors'] as $error) : ?>
                                    <li><?php echo htmlspecialchars($error); ?></li>
                                <?php endforeach; ?>
                                <?php unset($_SESSION['listOfErrors']); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="includes/user_add" method="POST" class="needs-validation">
                        <input type="hidden" value="add" name="action">

                        <div class="card mb-4">
                            <div class="card-header" staticTotranslate="register_role">Rôle</div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="grade" class="form-label" staticTotranslate="register_i_am">Je suis :</label>
                                    <select class="form-control" id="grade" name="grade" required>
                                        <option value="" staticTotranslate="register_select_role">Sélectionnez votre rôle</option>
                                        <option value="1" staticTotranslate="register_client">Client</option>
                                        <option value="5" staticTotranslate="register_provider">Prestataire</option>
                                        <option value="4" staticTotranslate="register_owner">Propriétaire</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header" staticTotranslate="register_identity">Identité</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="username" class="form-label" staticTotranslate="register_username">Pseudonyme</label>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Votre pseudonyme" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label" staticTotranslate="register_email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Votre email" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="firstname" class="form-label" staticTotranslate="register_firstname">Prénom</label>
                                        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Votre prénom" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="lastname" class="form-label" staticTotranslate="register_lastname">Nom</label>
                                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Votre nom" required>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header" staticTotranslate="register_contact_information">Informations de Contact</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label for="extension" class="form-label" staticTotranslate="register_extension">Extension</label>
                                        <select class="form-control" id="extension1" name="extension">
                                            <option value="+33" staticTotranslate="register_extension_france">+33 France</option>
                                            <option value="+1" staticTotranslate="register_extension_usa_canada">+1 USA/Canada</option>
                                            <option value="+44" staticTotranslate="register_extension_uk">+44 Royaume-Uni</option>
                                            <option value="+49" staticTotranslate="register_extension_germany">+49 Allemagne</option>
                                            <option value="+39" staticTotranslate="register_extension_italy">+39 Italie</option>
                                            <option value="+91" staticTotranslate="register_extension_india">+91 Inde</option>
                                        </select>
                                    </div>
                                    <div class="col-md-9 mb-3">
                                        <label for="phone_number" class="form-label" staticTotranslate="register_phone_number">Téléphone</label>
                                        <input type="tel" class="form-control" id="phone_number" name="phone_number" placeholder="Votre numéro de téléphone" required>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header" staticTotranslate="register_address">Adresse</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8 mb-3">
                                        <label for="address" class="form-label" staticTotranslate="register_address_label">Adresse</label>
                                        <input type="text" class="form-control" id="address" name="address" placeholder="Votre adresse">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="postal_code" class="form-label" staticTotranslate="register_postal_code">Code Postal</label>
                                        <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Votre code postal">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="city" class="form-label" staticTotranslate="register_city">Ville</label>
                                        <input type="text" class="form-control" id="city" name="city" placeholder="Votre ville">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="country" class="form-label" staticTotranslate="register_country">Pays</label>
                                        <select class="form-control" id="country" name="country" required>
                                            <option value="" staticTotranslate="register_select_country">Sélectionnez votre pays</option>
                                            <option value="FR" staticTotranslate="register_france">France</option>
                                            <option value="US" staticTotranslate="register_usa">États-Unis</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header" staticTotranslate="register_security">Sécurité</div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="password" class="form-label" staticTotranslate="register_password">Mot de passe</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" required>
                                </div>
                                <div class="mb-3">
                                    <label for="passwordConfirm" class="form-label" staticTotranslate="register_confirm_password">Confirmez le mot de passe</label>
                                    <input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm" placeholder="Confirmez le mot de passe" required>
                                </div>
                            </div>
                        </div>

                        <center>
                            <div class="g-recaptcha" data-sitekey="6Ldj_NopAAAAAPFMUGV9t6pDP3nJnqh-VuqpkTwg"></div>
                        </center>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="consentCheckbox2" name="consent" value="1" required>
                            <a href="terms.php?id=1" target="_blank"><label class="form-check-label" for="consentCheckbox" staticTotranslate="register_consent">Je consens à la politique d'utilisation des données de Paris CareTaker Services</label></a>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" name="submit" staticTotranslate="register_submit">S'inscrire</button>
                        <div class="text-center mt-3">
                            <a href="forgot_password.php" class="text-decoration-none" staticTotranslate="register_forgot_password">Mot de passe oublié?</a><br>
                            <a href="login.php" class="text-decoration-none" staticTotranslate="register_already_have_account">Vous avez déjà un compte ? Connectez-vous !</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
