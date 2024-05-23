<?php
session_start();

$rootPath = '../../';
include $rootPath . 'includes/db.php';

function redirectWithError($message) {
    header('Location: ../../pages/Profil/profile.php?' . 'username=' . $_SESSION['username'] . '&message=' . $message);
    $message = "";
    exit();
}

//checking that user is connected
if (empty($_SESSION['auth']) || !isset($_SESSION['auth'])) {
    redirectWithError("Vous devez être connecté", "");
}

//========verifying the post content ================

//it must contain something
$post_content = $_POST['editPost'];
$idPost = $_POST['id_post'];

if (!isset($post_content) || empty($post_content)) {
    $message = "Erreur : Message vide";
    redirectWithError($message);
}

//it must not be too long
if (strlen($post_content) > 10000) {
    $message = "Erreur : La taille du message est limitée à 10 000 caractères";
    redirectWithError($message);
}

//it must not be too short
if (strlen($post_content) < 11) {
    $message = "Erreur : Le message est trop court";
    redirectWithError($message);
}

// Verify the current posts is from the user
$getCurrentPostUserRequest = $pdo->prepare("SELECT id_user FROM REVIEW_BOOK WHERE id_review = ?");
$getCurrentPostUserRequest->execute([
    $idPost
]);
$getCurrentPostUser = $getCurrentPostUserRequest->fetch(PDO::FETCH_ASSOC);

if(!$getCurrentPostUser) {
    $message = "Erreur : Ce post n'existe pas !";
    redirectWithError($message);
}

// Sanitize
$post_content = htmlspecialchars($post_content);

// Update content of the post
$updatePostContent = $pdo->prepare("UPDATE REVIEW_BOOK SET comment = ? WHERE id_review = ?;");
$updatePostContent->execute([
    $post_content,
    $idPost
]);

header('Location: ../../pages/Profil/profile.php?' . 'username=' . $_SESSION['username']);
exit;