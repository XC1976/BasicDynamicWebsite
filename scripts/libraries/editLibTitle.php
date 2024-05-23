<?php
session_start();

$rootPath = '../../';
include $rootPath . 'includes/db.php';

$previousPage = $_POST['previous_page'];
$libID = $_POST['libID'];
function returnErrorMsg($previousPage, $message)
{
    header('Location: ../..' . $_POST['previous_page'] . '&message=' . $message);
    $message = '';
    exit;
}

$newTitle = $_POST['newTitle'];
$newTitle = htmlspecialchars($newTitle);

// Verify it's not too long

// Check if $newTitle is set and not empty
if (!isset($newTitle) && empty($newTitle)) {
    // $newTitle is not set or empty
    $message = 'Le titre est vide !';
    returnErrorMsg($previousPage, $message);
}

// Check the length of $newTitle
$titleLength = strlen($newTitle);

if ($titleLength < 1 || $titleLength > 15) {
    // Title length is not within the specified range
    $message = 'Le titre doit être entre 1 et 15 caractères !';
    returnErrorMsg($previousPage, $message);
}

// Verify the user own the lib
$verifyUserOwnLibRequest = $pdo->prepare("SELECT id_user FROM LIB WHERE id_lib = ?");
$verifyUserOwnLibRequest->execute([
    $libID
]);
$verifyUserOwnLib = $verifyUserOwnLibRequest->fetch(PDO::FETCH_ASSOC);

// Verify if library exists
if(!$verifyUserOwnLib) {
    $message = 'Cette librarie n\'est pas trouvable ! ';
    returnErrorMsg($previousPage, $message);
}

// Verify if user own the library
if($verifyUserOwnLib['id_user'] != $_SESSION['id_user']) {
    $message = 'Cette librarie ne vous appartient pas !';
    returnErrorMsg($previousPage, $message);
}

$renameLibraryRequest = $pdo->prepare("UPDATE LIB SET name = ? WHERE id_lib = ?;");
$renameLibraryRequest->execute([
    $newTitle,
    $libID
]);

$message = 'Librarie renommée avec succès !';
returnErrorMsg($previousPage, $message);