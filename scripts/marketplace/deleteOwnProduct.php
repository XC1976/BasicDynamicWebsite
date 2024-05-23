<?php
session_start();

$rootPath = '../../';
include $rootPath . 'includes/db.php';

// Verify if the user owns the product
$verifyUserOwnRequest = $pdo->prepare('SELECT seller_user FROM BookToSell WHERE id_bookToSell = ?');
$verifyUserOwnRequest->execute([
    $_POST['orderID']
]);

$verifyUserOwn = $verifyUserOwnRequest->fetch(PDO::FETCH_ASSOC);

if($verifyUserOwn['seller_user'] != $_SESSION['id_user']) {
    echo 'notOwnedProduct';
    exit;
}

// Delete product

$deleteProductRequest = $pdo->prepare('DELETE FROM BookToSell WHERE id_bookToSell = ?');
$deleteProductRequest->execute([
    $_POST['orderID']
]);

echo 'deletionSuccessful';
exit;