<?php
//ce fichier est un include sous l'appel du header.
//Afficher la page de demande de cookies sous forme de modale
?>

<!-- Modal -->
<div class="modal fade" id="cookieModal" tabindex="-1" aria-labelledby="cookieModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="cookieModalLabel">Cookies</h5>
                <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Ce site utilise des cookies pour vous offrir une meilleure expérience utilisateur. En poursuivant votre navigation sur ce site, vous acceptez l'utilisation de cookies.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Refuser</button>
                <button type="button" class="btn btn-primary" id="acceptCookies">Accepter</button>
            </div>
        </div>
    </div>
</div>

<script>
    // On récupère le bouton d'acceptation des cookies
    const acceptCookiesButton = document.getElementById('acceptCookies');

    // On récupère la modale
    const cookieModal = new bootstrap.Modal(document.getElementById('cookieModal'));

    // On vérifie si le cookie a déjà été accepté
    if (!document.cookie.split(';').some((item) => item.trim().startsWith('acceptCookies='))) {
        // Si le cookie n'a pas été accepté, on affiche la modale
        cookieModal.show();
    }

    // On ajoute un écouteur d'événement sur le bouton d'acceptation des cookies
    acceptCookiesButton.addEventListener('click', () => {
        // On crée un cookie d'acceptation des cookies valable 1 an
        document.cookie = 'acceptCookies=true; max-age=' + 60 * 60 * 24 * 365;
        // On ferme la modale
        cookieModal.hide();
    });
</script>
