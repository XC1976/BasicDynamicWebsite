<?php
/* 
    Error handling page in case showing the errors directly on the page (e.g. Popup) is not possible
    =====> The error in $_GET['message']; will be shown on the page !
*/

// Relative path to /includes/headerNavbar.php
$headerNavbarPHPPath = '../../includes/headerNavbar.php';
// Relative path to /includes/footer.php
$footerPHPPath = '../../includes/footer.php';
// Relative path to /includes/head.php
$headPHPPath = '../../includes/head.php';
// Relative path to /assets/js/headerNavbar.js
$headerNavbarJSPath = '../../assets/js/headerNavbar.js';
// Relative path to /assets/css/general/style.css
$styleCSSPath = '../../assets/css/general/style.css';
// Relative path to /assets/img/logo.png
$logoPath = '../../assets/img/logo.png';
// Relative path to /index.php
$indexPHPPath = '../../index.php';
// Relative path to /pages/Inscription/inscription.php
$inscriptionPHPPath = '../../pages/Inscription/inscription.php';
// Relative path to /scripts/connection_verify.php
$connectionPHPPath = '../../scripts/connection_verify.php';
// Relative path to /assets/img/closeButton.png
$closeButtonPNGPath = '../../assets/img/closeButton.png';
// Relative path to /scripts/log_tracking.php
$logTrackingPath = '../../scripts/log_tracking.php';
// Relative path to /pages/privacyPolicy.php
$privacyPolicyPath = 'privacyPolicy.php';

require $logTrackingPath;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $_GET['message']; ?>
    </title>

    <!-- ====== BASIC CSS AND JS FOR NAVBAR, FOOTER, AND style.css ======= -->
    <?php include $headPHPPath; ?>
    <style>
        .mainErrorSpecific {
            margin-top: 110px;
            padding: 0 10vw;
            display: flex;
            align-items: center;
            justify-content: space-around;
        }
        .mainErrorSpecific img {
            max-width: 700px;
        }
        footer {
            margin-top: 30px;
        }
        @media screen and (max-width: 890px) {
            .mainErrorSpecific {
                flex-direction: column;
            }
            .mainErrorSpecific img {
                width: 95vw;
            }
            .mainErrorSpecific h1 {
                font-size: 20px;
                margin-top: 50px;
            }
        }
    </style>
</head>

<body>
    <!-- ========== HEADER NAVBAR INCLUDE ============= -->
    <?php
    include ($headerNavbarPHPPath);
    ?>

    <main class="mainErrorSpecific">
        <img src="../../assets/img/brokenWebsiteRobot.png" alt="Broken Robot" />
        <h1><?= $_GET['message'];?></h1>
    </main>

    <!-- ========= FOOTER INCLUDE ================= -->
    <?php
    include ($footerPHPPath);
    ?>
</body>

</html>