<?php session_start();
require '../includes/db.php';
if(isset($_SESSION['auth']) && !empty($_SESSION['auth'])) {
    $isUserBannedAllRequest = $pdo->prepare('SELECT admin FROM USER WHERE id_user = ?;');
    $isUserBannedAllRequest->execute([
        $_SESSION['id_user']
    ]);
    $isUserBannedAll = $isUserBannedAllRequest->fetch(PDO::FETCH_ASSOC);
    if($isUserBannedAll['admin'] != 1) {
        unset($_SESSION['admin']);
        header('Location: ../../../scripts/deconnexion.php');
        exit;
    } 
}
?>
