<?php
session_start();

$rootPath = '../../';
include $rootPath . 'includes/db.php';

function errorMsgRedirect($message, $previous_link) {
    header('Location: ../..' . $previous_link . '&message2=' . $message);
    $message = '';
    exit;
}

$previous_link = $_POST['previous_link'];

// Verify variables are not empty
if(!isset($_POST['choices']) || empty($_POST['choices']) ||
!isset($_POST['bookID']) || empty($_POST['bookID'])) {
    $message = 'Il manque des champs !';
    errorMsgRedirect($message, $previous_link);
}

$libID = $_POST['choices'];
$bookID = $_POST['bookID'];

// Verify use own the library
$verifyUserOwnsLibraryRequest = $pdo->prepare("SELECT id_user FROM LIB WHERE id_lib = ?;");
$verifyUserOwnsLibraryRequest->execute([
    $libID
]);
$verifyUserOwnsLibrary = $verifyUserOwnsLibraryRequest->fetch(PDO::FETCH_ASSOC);

// Libraries does not exists
if(!$verifyUserOwnsLibrary) {
    $message = 'Librarie introuvable !';
    errorMsgRedirect($message, $previous_link);
}

// Librairie n'appartient pas au user
if($verifyUserOwnsLibrary['id_user'] != $_SESSION['id_user']) {
    $message = 'Vous ne posséder pas cette librarie';
    errorMsgRedirect($message, $previous_link);
}

// Verify books exists
$verifyBookExistsRequest = $pdo->prepare("SELECT id_book FROM BOOK WHERE id_book = ?;");
$verifyBookExistsRequest->execute([
    $bookID
]);
$verifyBookExists = $verifyBookExistsRequest->fetch();

if(!$verifyBookExists) {
    $message = 'Ce livre n\'existe pas !';
    errorMsgRedirect($message, $previous_link);
}

// Verify book is not already in library
$verifyIfDuplicateRequest = $pdo->prepare("SELECT id_book FROM EST_DANS_LIB WHERE id_book = ? AND id_lib = ?;");
$verifyIfDuplicateRequest->execute([
    $bookID,
    $libID
]);
$verifyIfDuplicate = $verifyIfDuplicateRequest->fetch(PDO::FETCH_ASSOC);

if($verifyIfDuplicate) {
    $message = 'Ce livre est déjà dans votre librarie !';
    errorMsgRedirect($message, $previous_link);
}

// Get the current date and time in YYYY-MM-DD HH:MM:SS format
$currentDateTime = date('Y-m-d H:i:s');

// Add book to chosen library
$insertBookIntoLibRequest = $pdo->prepare("INSERT INTO EST_DANS_LIB(id_book, id_lib, date_ajout) VALUES(?, ?, ?);");
$insertBookIntoLibRequest->execute([
    $bookID,
    $libID,
    $currentDateTime
]);

$message = 'Livre rajouté avec succès !';
errorMsgRedirect($message, $previous_link);