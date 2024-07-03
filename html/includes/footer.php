
<script>
function changeLanguage(lang) {
    if (getCookie('acceptCookies')) {
        document.cookie = `language=${lang}; path=/; max-age=31536000`; // Store for 1 year
    } else {
        document.getElementById('langForm').submit();
    }
    applyTranslations(lang);
}

function applyTranslations(lang) {
    fetch(`/includes/lang/${lang}.json`)
        .then(response => response.json())
        .then(translations => {
            document.querySelectorAll('[staticToTranslate]').forEach(element => {
                const key = element.getAttribute('staticToTranslate');
                if (translations[key]) {
                    element.textContent = translations[key];
                }
            });
        });
}

function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}

document.addEventListener('DOMContentLoaded', () => {
    const lang = getCookie('language') || 'fr';
    changeLanguage(lang);
});
</script>

</body>
<footer class="footer">
    <div class="footer-content">
        <div class="footer-content-column">
            <h3>Assitance</h3>
            <ul>
                <li><a href="/support?type=chatbot" staticToTranslate="Chatbot">ChatBot</a></li>
                <li><a href="/support?type=ticket" staticToTranslate="footer_ContactUs">Contactez-nous</a></li>
            </ul>
        </div>
        <div class="footer-content-column">
            <h3>PCS</h3>
            <ul>
                <li><a href="/terms.php?id=0" staticToTranslate="footer_WhoAreWe">Qui sommes nous?</a></li>
            </ul>
        </div>
        <div class="footer-content-column">
            <ul>
                <li><a href="https://www.facebook.com/">Facebook</a></li>
                <li><a href="https://www.instagram.com/">Instagram</a></li>
                <li><a href="https://twitter.com/">X - Twitter</a></li>

            </ul>
        </div>
    </div>
    <div class="footer-mentions">
        <a staticToTranslate="footer_Copyright"> © 2024 - PCS Tous droits réservés</a>  
        <a href="/terms.php?id=1" staticToTranslate="footer_LegalNotice">Mentions légales</a>
        <a href="/terms.php?id=2" staticToTranslate="footer_GeneralConditions">Conditions générales</a>
        <a href="/terms.php?id=3" staticToTranslate="footer_IntellectualProperty"> Avis de propriété intellectuelle</a>
    </div>
</footer>
</html>