<?php
session_start();

$rootPath = '../../';
include $rootPath . 'includes/db.php';


// Verify if $_POST are set
if(!isset($_POST['libID']) || empty($_POST['libID'])) {
    header('Location: ../../pages/others/errorPage.php?message=Vous ne pouvez pas accéder à cette page ainsi !');
    exit;
}

$libID = $_POST['libID'];

// Verify if lib exists
$verifyIfLibExistsRequest = $pdo->prepare("SELECT id_lib, id_user FROM LIB WHERE id_lib = ?;");
$verifyIfLibExistsRequest->execute([
    $libID
]);
$verifyIfLibExists = $verifyIfLibExistsRequest->fetch(PDO::FETCH_ASSOC);

if(!$verifyIfLibExists) {
    echo 'libNotFound';
    exit;
}

// Verify if user owns the lib
if($verifyIfLibExists['id_user'] != $_SESSION['id_user']) {
    echo 'notOwnLib';
    exit;
}

// Remove lib
$removeLibRequest = $pdo->prepare("DELETE FROM LIB WHERE id_lib = ?;");
$removeLibRequest->execute([
    $libID
]);

echo 'success'; 
exit;