<?php
session_start();

$rootPath = '../../';
include $rootPath . 'includes/db.php';

// Verify it's not empty
if (!isset($_POST['libID']) || empty($_POST['libID'])) {
    echo 'libraryLacksID';
    exit;
}

$idLib = $_POST['libID'];

// Verify the user owns the library and library exists
$verifyUserOwnsLibRequest = $pdo->prepare("SELECT id_user, public FROM LIB WHERE id_lib = ?;");
$verifyUserOwnsLibRequest->execute([
    $idLib
]);
$verifyUserOwnsLib = $verifyUserOwnsLibRequest->fetch(PDO::FETCH_ASSOC);

// La librarie n'existe pas
if (!$verifyUserOwnsLib) {
    echo 'libraryDoesNotExist';
    exit;
}

// L'utilisateur ne possède pas la librarie
if ($verifyUserOwnsLib['id_user'] != $_SESSION['id_user']) {
    echo 'libraryNotOwned';
    exit;
}

// Switch between public and private
if ($verifyUserOwnsLib['public'] == 0) {
    $switchToPublicRequest = $pdo->prepare("UPDATE LIB SET public = 1 WHERE id_lib = ?;");
    $switchToPublicRequest->execute([
        $idLib
    ]);
    echo 'switchToPublic';
    exit;
} else {
    $switchToPrivateRequest = $pdo->prepare("UPDATE LIB SET public = 0 WHERE id_lib = ?;");
    $switchToPrivateRequest->execute([
        $idLib
    ]);
    echo 'switchToPrivate';
    exit;
}