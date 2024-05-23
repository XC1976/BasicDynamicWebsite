<?php
session_start();

$rootPath = '../../';
include $rootPath . 'includes/db.php';

$idPost = $_POST['id_post'];

// Get the post user
$getUserIdPostRequest = $pdo->prepare('SELECT id_user FROM REVIEW_BOOK WHERE id_review = ?');
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
$deletePostRequest = $pdo->prepare("UPDATE REVIEW_BOOK SET deleted = 1 WHERE id_review = ?");
$deletePostRequest->execute([
    $idPost
]);

echo 'success';
exit;