<?php
session_start();

$rootPath = '../../';
include $rootPath . 'includes/db.php';

if(empty($_SESSION['auth']) && !isset($_SESSION['auth'])) {
    header('Location: ' . $rootPath . 'index.php');
    exit;
}

$deleteUserPPRequest = $pdo->prepare('UPDATE USER SET profile_pic = ? WHERE id_user = ?;');
$deleteUserPPRequest->execute([
    'default.jpg',
    $_SESSION['id_user']
]);

$_SESSION['profile_pic'] = 'default.jpg';