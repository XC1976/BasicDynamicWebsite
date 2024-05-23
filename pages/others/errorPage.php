<?php
/* 
    Error handling page in case showing the errors directly on the page (e.g. Popup) is not possible
    =====> The error in $_GET['message']; will be shown on the page !
*/

// Relative path to root "/"
// ========== PLEASE ADD A "/" AT THE END ! ========== 
$rootPath = '../../';

include $rootPath . 'scripts/log_tracking.php';
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
    <?php include $rootPath . 'includes/head.php'; ?>
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
    include $rootPath . 'includes/headerNavbar.php';
    ?>

    <main class="mainErrorSpecific">
        <img src="../../assets/img/brokenWebsiteRobot.png" alt="Broken Robot" />
        <h1><?= $_GET['message'];?></h1>
    </main>

    <!-- ========= FOOTER INCLUDE ================= -->
    <?php
    include $rootPath . 'includes/footer.php';
    ?>
</body>

</html>