<?php
session_start();

$rootPath = '../../';
include $rootPath . 'includes/db.php';

// Verify if $_POST are set
if (
    !isset($_POST['bookID']) || empty($_POST['bookID']) ||
    !isset($_POST['libID']) || empty($_POST['libID'])
) {
    header('Location: ../../pages/others/errorPage.php?message=Vous ne pouvez pas accéder à cette page ainsi !');
    exit;
}

$bookID = $_POST['bookID'];
$libID = $_POST['libID'];

// verify if book exists
$verifyIfBoosExistsRequest = $pdo->prepare("SELECT id_book FROM BOOK WHERE id_book = ?;");
$verifyIfBoosExistsRequest->execute([
    $bookID
]);
$verifyIfBoosExists = $verifyIfBoosExistsRequest->fetch(PDO::FETCH_ASSOC);

// No book found
if (!$verifyIfBoosExists) {
    echo 'bookNotFound';
    exit;
}

// Verify if LIB exists
$verifyIfLibExistsRequest = $pdo->prepare("SELECT id_lib FROM LIB WHERE id_lib = ?;");
$verifyIfLibExistsRequest->execute([
    $libID
]);
$verifyIfLibExists = $verifyIfLibExistsRequest->fetch(PDO::FETCH_ASSOC);

// Lib does not exists
if (!$verifyIfLibExists) {
    echo 'libNotFound';
    exit;
}

// Verify the book is inside the library
$verifyIfBookInsideLibraryRequest = $pdo->prepare("SELECT id_book FROM EST_DANS_LIB WHERE id_book = ? AND id_lib = ?;");
$verifyIfBookInsideLibraryRequest->execute([
    $bookID,
    $libID
]);
$verifyIfBookInsideLibrary = $verifyIfBookInsideLibraryRequest->fetch(PDO::FETCH_ASSOC);

// Books is not in library
if (!$verifyIfBookInsideLibrary) {
    echo 'bookNotInLibrary';
    exit;
}

// Verify book is owned by user
$verifyIfOwnLibraryRequest = $pdo->prepare("SELECT id_user FROM LIB WHERE id_lib = ?;");
$verifyIfOwnLibraryRequest->execute([
    $libID
]);
$verifyIfOwnLibrary = $verifyIfOwnLibraryRequest->fetch(PDO::FETCH_ASSOC);

if($verifyIfOwnLibrary['id_user'] != $_SESSION['id_user']) {
    echo 'notOwnBook';
    exit;
}


// Remove book from library
$removeBookFromLibraryRequest = $pdo->prepare("DELETE FROM EST_DANS_LIB WHERE id_book = ? AND id_lib = ?;");
$removeBookFromLibraryRequest->execute([
    $bookID,
    $libID
]);

echo 'success';
exit;