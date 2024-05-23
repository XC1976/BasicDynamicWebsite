<?php
session_start();

// Relative path to root "/"
// ========== PLEASE ADD A "/" AT THE END ! ========== 
$rootPath = '../../';
// Name of the document
$DocumentTitle = '';

// Path to DB
require $rootPath . 'includes/db.php';
// Path to tracking
require $rootPath . 'scripts/log_tracking.php';

//user must be connected
if (!isset($_SESSION['id_user']) || empty($_SESSION['id_user'])) {
    header('Location: ' . $rootPath . 'index.php?show-login=true');
}
$id_user = $_SESSION['id_user'];




?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= $rootPath . 'assets/css/pageSpecific/messagerie.css'?>">
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
        <section class="users">        
        <button class="new-discu-btn" id="btnbtn" onclick="new_mp()">Nouvelle discussion</button>
        <div id="usrArea">

            
        </div>
        </section>
        <section class="messages">
            <div class="msgarea" id="msgarea">
                <!-- messages are fetched using js -->
            </div>
            <div class="txtbox">
                <input type="text" id="msgContent" placeholder="Ecrivez un message" class="txt">
                <button id="sendMsgBtn" class="send-btn" onclick="sendMsg()">Envoyer</button>
            </div>
        </section>
        <!--==================== new mp ====================-->
        <div class="search" id="searchUsr">
           <form action="" class="search__form">
              <div class="searchbar">
              <input type="search" placeholder="Rechercher un utilisateur" class="search__input" id="search_inputUsr"
                 oninput="searchUser()">
              <i class="ri-search-line search__icon"></i>
              </div>
              <div id="resultsUser" class="results">
              </div>
           </form>
           <i class="ri-close-line search__close" id="search-closeUsr"></i>
        </div>
        <script src="<?= $rootPath . "assets/js/messagerie.js" ?>"></script>
    </main>

    <!-- ========= FOOTER INCLUDE ================= -->
    <?php
    include $rootPath . 'includes/footer.php';
    ?>

</body>

</html>