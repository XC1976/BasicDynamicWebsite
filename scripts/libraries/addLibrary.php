<?php
session_start();

$rootPath = '../../';
include $rootPath . 'includes/db.php';

// Verify POST validity
if(!isset($_POST['nom']) || empty($_POST['nom'])) {
    header('Location: ../../pages/others/errorPage.php?message=Vous ne pouvez pas accéder à cette page ainsi !');
    exit;
}

$nameLibrary = $_POST['nom'];

if(strlen($nameLibrary) < 5 || strlen($nameLibrary) > 20) {
    header('Location: ../../pages/library/addLib.php?message=Doit être entre 5 et 20 caractères !');
    exit;
}

// verify if it already exists
$verifyIfDuplicateNameRequest = $pdo->prepare("SELECT id_lib FROM LIB WHERE name = ?;");
$verifyIfDuplicateNameRequest->execute([
    $nameLibrary
]);
$verifyIfDuplicateName = $verifyIfDuplicateNameRequest->fetch(PDO::FETCH_ASSOC);

if($verifyIfDuplicateName > 0) {
    header('Location: ../../pages/library/addLib.php?message=Cette librarie existe déjà !');
    exit;
}

// Sanitize
$nameLibrary = htmlspecialchars($nameLibrary);

// Create LIB
$createLibRequest = $pdo->prepare("INSERT INTO LIB(name, id_user) VALUES(?, ?);");
$createLibRequest->execute([
    $nameLibrary,
    $_SESSION['id_user']
]);

header('Location: ../../pages/library/addLib.php?message=Librarie rajouté avec succès !');
exit;