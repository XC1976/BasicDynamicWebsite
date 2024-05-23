<!-- Verify if the user is banned -->
<?php if(isset($_SESSION['auth']) && !empty($_SESSION['auth'])) {
    $isUserBannedAllRequest = $pdo->prepare('SELECT is_banned FROM USER WHERE id_user = ?;');
    $isUserBannedAllRequest->execute([
        $_SESSION['id_user']
    ]);
    $isUserBannedAll = $isUserBannedAllRequest->fetch(PDO::FETCH_ASSOC);
    if($isUserBannedAll['is_banned'] == 1) {
        unset($_SESSION['admin']);
        header('Location: ' . $rootPath . 'scripts/deconnexion.php');
        exit;
    } 
} ?> 
<!--=============== BASIC COMPONENTS ===============-->

<!-- basic components, header, footer... -->
<link rel="stylesheet" href="<?= $rootPath . 'assets/css/general/style.css'; ?>" />

<!--=============== Navbar JS ===============-->
<script src="<?= $rootPath . 'assets/js/headerNavbar.js'; ?>" defer></script>

<!--=============== JS to remember logins ============== -->
<script src="<?= $rootPath . 'assets/js/rememberMe.js';?>" defer></script>

<!-- Fontawesome Link for Icons -->
<script src="https://kit.fontawesome.com/2b30deba9f.js" crossorigin="anonymous"></script>

<!-- Script for closing popup windows -->
<script src="<?= $rootPath . 'assets/js/closeErrorPopup.js';?>" defer></script>

<!--=============== REMIXICONS ===============-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css">

<link rel="icon" type="image/x-icon" href="<?= $rootPath . 'assets/img/favicon.ico';?>" />