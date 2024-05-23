<?php
//this page is accessed by a user that clicked on the button in the mail "reset_passwd.html"
//it triggers the set_new_pw.php script
session_start();

// Relative path to root "/"
// ========== PLEASE ADD A "/" AT THE END ! ========== 
$rootPath = '../../';
// Name of the document
$DocumentTitle = 'Nouveau mot de passe';

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
    <link rel="stylesheet" href="../../assets/css/pageSpecific/forgot-pw.css">

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
        <h1 class="big-title">Nouveau mot de passe</h1>
        <form method="POST" action="../../scripts/set_new_pw.php">
            <div class="form">
                <input type="password" name="password01" placeholder="Nouveau mot de passe">
                <input type="password" name="password02" placeholder="Réinsérez le mot de passe">
                <input type="submit" value="Définir comme mot de passe" name="validate" class="validate">
                <input type="hidden" value="<?php if (isset($_GET['id'])) {echo $_GET['id'];}?>" name="id">
                <input type="hidden" value="<?php if (isset($_GET['token'])) {echo $_GET['token'];}?>" name="token">
            </div>
        </form>
    </main>

    <!-- ========= FOOTER INCLUDE ================= -->
    <?php
    include $rootPath . 'includes/footer.php';
    ?>

</body>

</html>