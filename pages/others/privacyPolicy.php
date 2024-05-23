<?php
session_start();

// Relative path to root "/"
// ========== PLEASE ADD A "/" AT THE END ! ========== 
$rootPath = '../../';
// Name of the document
$DocumentTitle = 'Politique de confidentialité';

// Path to DB
require $rootPath . 'includes/db.php';
// Path to tracking
require $rootPath . 'scripts/log_tracking.php';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $DocumentTitle; ?>
    </title>
    <!-- Content that will appear on the bottom of title in search IMPORTANT !!! -->
    <meta name="description" content="La politique de confidentialité de openreads.">

    <!-- ====== BASIC CSS AND JS FOR NAVBAR, FOOTER, AND style.css ======= -->
    <?php include $rootPath . 'includes/head.php'; ?>

    <!-- CSS specific for privacy policy page -->
    <link rel="stylesheet" href="../../assets/css/pageSpecific/privacyPolicy.css" />

</head>

<body>

    <!-- ========== HEADER NAVBAR INCLUDE ============= -->
    <?php
    include $rootPath . 'includes/headerNavbar.php';
    ?>

    <!-- Bloc de code qui apparaît seulement si une erreur avec le login ou autre chose -->
    <?php include $rootPath . 'includes/errorPopup.php'; ?>

    <main class="mainPrivacyPolicySpecific">
        <h1>Politique de confidentialité</h1>

        <h3>Dernière mise à jour : 2024-03-27</h3>

        <p>Merci d'utiliser notre site web openreads. Nous attachons une grande importance à la
            protection de vos données personnelles et nous nous engageons à respecter votre vie privée. Cette politique
            de confidentialité vous explique comment nous collectons, utilisons et protégeons vos informations lorsque
            vous utilisez notre Site.</p>

        <p>En utilisant le Site, vous consentez à la collecte et à l'utilisation de vos informations personnelles comme
            décrit dans cette politique. Si vous n'acceptez pas les termes de cette politique, veuillez ne pas utiliser
            notre Site.</p>

        <h2>1. Collecte de l'information</h2>

        <p>Nous collectons différentes types d'informations lorsque vous utilisez notre Site, notamment :</p>

        <ul>
            <li>Informations personnelles que vous fournissez volontairement, telles que votre nom, votre adresse
                e-mail, votre adresse postale et votre numéro de téléphone lorsque vous vous inscrivez sur le Site,
                participez à nos forums, envoyez des messages privés, ou effectuez des transactions sur notre
                marketplace.</li>
            <li>Informations automatiquement collectées lorsque vous utilisez le Site, telles que votre adresse IP,
                votre type de navigateur, votre fournisseur de services Internet, les pages que vous consultez sur notre
                Site, et les dates et heures de vos visites.</li>
            <li>Informations sur les transactions, telles que les détails des achats et des ventes effectuées sur notre
                marketplace.</li>
        </ul>
        <h2>2. Utilisation de l'information</h2>

        <p>Nous utilisons les informations que nous collectons pour les finalités suivantes :</p>

        <ul>
            <li>Pour vous fournir les services demandés, tels que le suivi de livres, les forums de discussion, les
                messages privés et le marketplace.</li>
            <li>Pour personnaliser votre expérience sur le Site et vous proposer des contenus et des offres qui
                pourraient vous intéresser.</li>
            <li>Pour traiter vos transactions sur notre marketplace et assurer leur suivi.</li>
            <li>Pour répondre à vos demandes de service à la clientèle et de support.</li>
            <li>Pour détecter, prévenir et résoudre les problèmes techniques ou de sécurité.</li>
            <li>Pour nous conformer à nos obligations légales et réglementaires.</li>
        </ul>
        <h2>3. Partage de l'information</h2>

        <p>Nous ne vendons ni ne louons vos informations personnelles à des tiers. Cependant, nous pouvons partager vos
            informations dans les circonstances suivantes :</p>

        <ul>
            <li>Avec des prestataires de services tiers qui nous aident à exploiter le Site et à fournir les services
                que vous demandez.</li>
            <li>Avec des partenaires commerciaux pour vous proposer des offres spéciales et des promotions.</li>
            <li>En réponse à une demande d'informations d'une autorité compétente si nous pensons de bonne foi que la
                divulgation est nécessaire pour se conformer à une obligation légale, protéger nos droits ou assurer la
                sécurité de nos utilisateurs ou d'autres parties.</li>
        </ul>
        <h2>4. Sécurité de l'information</h2>

        <p>Nous mettons en place des mesures de sécurité techniques, administratives et physiques appropriées pour
            protéger vos informations contre la perte, le vol, l'accès non autorisé, la divulgation, l'altération et la
            destruction.</p>

        <h2>5. Vos droits</h2>

        <p>Vous avez le droit de consulter, de corriger, de mettre à jour ou de supprimer vos informations personnelles
            à tout moment. Vous pouvez également vous opposer au traitement de vos informations pour des motifs
            légitimes. Pour exercer vos droits, veuillez nous contacter à <a href="mailto:contact@openreads.uk">contact@openreads.uk</a>.</p>

        <h2>6. Modifications de la politique</h2>

        <p>Nous nous réservons le droit de modifier cette politique de confidentialité à tout moment. Toute modification
            sera publiée sur cette page avec une indication de la date de la dernière mise à jour. Nous vous
            encourageons à consulter régulièrement cette page pour rester informé de nos pratiques en matière de
            confidentialité.</p>

        <h2>7. Contactez-nous</h2>

        <p>Si vous avez des questions, des préoccupations ou des commentaires concernant cette politique de
            confidentialité, veuillez nous contacter à <a href="mailto:contact@openreads.uk">contact@openreads.uk</a>.</p>

    </main>

    <!-- ========= FOOTER INCLUDE ================= -->
    <?php
    include $rootPath . 'includes/footer.php';
    ?>

</body>

</html>