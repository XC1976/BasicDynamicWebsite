<?php
session_start();

// Relative path to root "/"
// ========== PLEASE ADD A "/" AT THE END ! ========== 
$rootPath = '/';
// Name of the document
$DocumentTitle = '';

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
    <meta name="description" content="">

    <!-- ====== BASIC CSS AND JS FOR NAVBAR, FOOTER, AND style.css ======= -->
    <?php include $rootPath . 'includes/head.php'; ?>

</head>

<body>

    <!-- ========== HEADER NAVBAR INCLUDE ============= -->
    <?php
    include $rootPath . 'includes/headerNavbar.php';
    ?>

    <!-- Bloc de code qui apparaît seulement si une erreur avec le login -->
    <?php include $rootPath . 'includes/errorPopup.php'; ?>

    <main>

    </main>

    <!-- ========= FOOTER INCLUDE ================= -->
    <?php
    include $rootPath . 'includes/footer.php';
    ?>

</body>

</html>