<?php require 'includes/header.php';
//on vérifie que le paramètre id est bien un entier
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    if ($id ==1) {
        //SI le paramètre id vaut 1 on affiche la rubrique mentions légales
        ?>
        <div class="terms-container">
            <div class="terms-content">
            <h1>Mentions légales</h1>
            <p>Conformément aux dispositions des articles 6-III et 19 de la loi pour la Confiance dans l'Économie Numérique, nous vous informons que :</p>
            <p>Ce site web est édité par NextGen InfraDev, société SAS au capital de 1M€, immatriculée au Registre du Commerce et des Sociétés sous le numéro 1010101001, dont le siège social est situé à 242 Rue du Faubourg Saint-Antoine, Paris.</p>
            <p>Les directeurs de la publication sont ASFEZ Mike, LEFEVRE Kyllian & LOPES Angélique .</p>
    
            <h2>Cookies</h2>
            <p>Ce site web utilise des cookies pour améliorer votre expérience de navigation. Vous pouvez consulter notre politique de cookies pour plus d'informations sur l'utilisation des cookies sur ce site.</p>
            <h2>Liens vers des sites tiers</h2>
            <p>Ce site web peut contenir des liens vers des sites web tiers. PCS n'a aucun contrôle sur le contenu ou les pratiques de confidentialité de ces sites tiers, et décline toute responsabilité quant à leur contenu ou leurs pratiques.</p>
            <h2>Responsabilité</h2>
            <p>PCS s'efforce de fournir des informations précises et à jour sur ce site web, mais ne peut garantir l'exactitude, l'exhaustivité ou la pertinence de ces informations. En conséquence, PCS décline toute responsabilité pour toute inexactitude, omission ou erreur dans les informations fournies sur ce site web.</p>
            <h2>Loi applicable et juridiction compétente</h2>
            <p>Les présentes mentions légales sont régies par la loi française. En cas de litige relatif à l'interprétation, la validité et/ou l'exécution des présentes mentions légales, les tribunaux français seront seuls compétents pour en connaître.</p>

            </div>
        </div>


        <?php
    }else if ($id == 2) {
        //SI le paramètre id vaut 2 on affiche la rubrique conditions générales
        ?>
        <div class="terms-container">
            <div class="terms-content">
                <h1>Conditions générales d'utilisation</h1>
                <p><strong>Dernière mise à jour :</strong> 23/04/2024</p>
                <p>Veuillez lire attentivement ces conditions générales d'utilisation avant d'utiliser le site web PCS exploité par Paris Caretaker Services.</p>
                <p>Votre accès et votre utilisation du Service sont conditionnés à votre acceptation et votre conformité avec ces Conditions. Ces Conditions s'appliquent à tous les visiteurs, utilisateurs et autres personnes qui accèdent ou utilisent le Service.</p>
                <p>En accédant ou en utilisant le Service, vous acceptez d'être lié par ces Conditions. Si vous n'êtes pas d'accord avec une partie quelconque des conditions, alors vous ne pouvez pas accéder au Service.</p>
                <h2>Comptes</h2>
                <p>Lorsque vous créez un compte auprès de nous, vous devez nous fournir des informations exactes, complètes et à jour en tout temps. La négligence de le faire constitue une violation des Conditions, ce qui peut entraîner la résiliation immédiate de votre compte sur notre Service.</p>
                <p>Vous êtes responsable de la protection du mot de passe que vous utilisez pour accéder au Service et de toute activité ou action qui se produit sous votre mot de passe. Vous acceptez de ne pas divulguer votre mot de passe à des tiers. Vous devez nous avertir immédiatement dès que vous avez connaissance de toute violation de la sécurité ou de toute utilisation non autorisée de votre compte.</p>
                <h2>Liens vers d'autres sites web</h2>
                <p>Notre Service peut contenir des liens vers des sites web ou des services tiers qui ne sont pas détenus ou contrôlés par PCS.</p>
                <p>PCS n'a aucun contrôle sur, et n'assume aucune responsabilité pour le contenu, les politiques de confidentialité ou les pratiques des sites web ou services tiers. Vous reconnaissez et acceptez en outre que PCS ne sera pas responsable, directement ou indirectement, de tout dommage ou perte causé ou prétendument causé par ou en relation avec l'utilisation ou la confiance accordée à de tels contenus, biens ou services disponibles sur ou via de tels sites web ou services.</p>
                <p>Nous vous conseillons vivement de lire les conditions générales et les politiques de confidentialité de tout site web ou service tiers que vous visitez.</p>
                <h2>Résiliation</h2>
                <p>Nous pouvons résilier ou suspendre votre compte immédiatement, sans préavis ni responsabilité, pour quelque raison que ce soit, y compris sans limitation si vous violez les Conditions.</p>
                <h2>Dispositions générales</h2>
                <p>Le non-exercice ou le retard de notre part dans l'exercice de tout droit ou recours prévu par les présentes Conditions ne constitue pas une renonciation à ce droit ou recours. Si une disposition de ces Conditions est jugée invalide ou inapplicable par un tribunal, les parties conviennent néanmoins que le tribunal devrait s'efforcer de donner effet aux intentions des parties telles qu'exprimées dans la disposition, et les autres dispositions de ces Conditions resteront en vigueur.</p>
                <p>Ces Conditions constituent l'intégralité de l'accord entre nous concernant notre Service, et remplacent et remplacent tous les accords antérieurs que nous pourrions avoir entre nous concernant le Service.</p>
                <h2>Changements</h2>
                <p>Nous nous réservons le droit, à notre seule discrétion, de modifier ou de remplacer ces Conditions à tout moment. Si une révision est importante, nous essaierons de fournir un préavis d'au moins 30 jours avant que les nouvelles conditions ne prennent effet. Ce qui constitue un changement important sera déterminé à notre seule discrétion.</p>
                <p>En continuant d'accéder ou d'utiliser notre Service après que ces révisions soient entrées en vigueur, vous acceptez d'être lié par les conditions révisées. Si vous n'acceptez pas les nouvelles conditions, veuillez cesser d'utiliser le Service.</p>
                <h2>Nous contacter</h2>
                <p>Si vous avez des questions sur ces Conditions, veuillez nous contacter.</p>
            </div>
        </div>
        
        <?php
    }else if ($id == 3) {
        //SI le paramètre id vaut 3 on affiche la rubrique de propriété intellectuelle
        ?>
        <div class="terms-container">
            <div class="terms-content">
            <h1>Propriété intellectuelle</h1>
            <p>Le contenu de ce site web, incluant mais ne se limitant pas aux textes, graphiques, logos, images, vidéos, sons, données, codes sources et bases de données, ainsi que l'ensemble des éléments le composant, tels que sa structure, son arborescence, son ergonomie, son design et son organisation, sont la propriété exclusive de PCS ou de ses partenaires.</p>
            <p>Ces éléments sont protégés par les lois françaises et internationales sur la propriété intellectuelle, notamment par les dispositions du Code de la propriété intellectuelle, ainsi que par les conventions internationales en vigueur relatives aux droits d'auteur et aux droits voisins.</p>
            <p>Toute reproduction, représentation, modification, adaptation, distribution, transmission ou exploitation, totale ou partielle, de ce site web ou de son contenu, par quelque moyen que ce soit, sans l'autorisation préalable et écrite de PCS, est strictement interdite et constitue une contrefaçon sanctionnée par les articles L.335-2 et suivants du Code de la propriété intellectuelle, et pouvant engager la responsabilité civile et/ou pénale de son auteur.</p>
            <p>Les marques, logos et autres signes distinctifs présents sur ce site web sont des marques déposées de PCS ou de ses partenaires. Toute reproduction, imitation ou usage, total ou partiel, de ces marques sans autorisation expresse et préalable est strictement interdit et susceptible de constituer une contrefaçon engageant la responsabilité civile et/ou pénale de son auteur.</p>
            <p>PCS se réserve le droit d'engager des poursuites judiciaires à l'encontre de toute personne ou entité qui ne respecterait pas les droits de propriété intellectuelle précités.</p>
    
            </div>
        </div>
    <?php
    }else{
        //SI le paramètre id ne correspond à aucune rubrique on affiche un message d'erreur
        ?>
        <div style="text-align: center;  margin: auto; ">
            <h2>Erreur 404</h2>
            <p>La page demandée n'existe pas</p>
        </div>
        <?php
    }
}else{
    //SI le paramètre id n'est pas présent on affiche un message d'erreur
    ?>
    <div style="text-align: center;  margin: auto; ">
        <h2>Erreur 404</h2>
        <p>La page demandée n'existe pas</p>
    </div>
    <?php
}
include 'includes/footer.php';
?>
