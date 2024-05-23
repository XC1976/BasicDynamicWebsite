<?php
session_start();

$rootPath = '../../';
include $rootPath . 'includes/db.php';

$idOfDeletedUser = $_POST['userID'];

$deleteFollowRequest = $pdo->prepare('DELETE FROM Follows WHERE following_user = ? AND followed_user = ?');
$deleteFollowRequest->execute([
    $_SESSION['id_user'],
    $idOfDeletedUser
]);

echo 'successful';
exit;