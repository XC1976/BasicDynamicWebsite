<?php
session_start();

$rootPath = '../../';
include $rootPath . 'includes/db.php';

$idPost = $_POST['id_post'];

// Get the post user
$getUserIdPostRequest = $pdo->prepare('SELECT id_user FROM POST WHERE id_post = ?');
$getUserIdPostRequest->execute([
    $idPost
]);
$getUserIdPost = $getUserIdPostRequest->fetch(PDO::FETCH_ASSOC);

// No post found
if(!$getUserIdPost) {
    echo 'postNotFound';
    exit;
}

// Verify it belongs to current user
if($getUserIdPost['id_user'] != $_SESSION['id_user']) {
    echo 'postNotBelongsToYou';
    exit;
}

// Delete post by changing column deleted
$deletePostRequest = $pdo->prepare("UPDATE POST SET deleted = 1 WHERE id_post = ?");
$deletePostRequest->execute([
    $idPost
]);

echo 'success';
exit;