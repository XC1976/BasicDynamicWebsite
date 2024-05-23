<?php
session_start();

$rootPath = '../../';
include $rootPath . 'includes/db.php';

// Verify that the ORDERS = $_POST['orderID'] exists

$verifyOrderIDRequest = $pdo->prepare('SELECT id_user FROM ORDERS WHERE id = ?');
$verifyOrderIDRequest->execute([
    $_POST['orderID']
]);

$rowCount = $verifyOrderIDRequest->rowCount();

if($rowCount != 1) {
    echo 'ItemNotFound';
}

$verifyOrderID = $verifyOrderIDRequest->fetch(PDO::FETCH_ASSOC);

// Reverify that the ORDERS is from the current user (should not happen)

if($verifyOrderID['id_user'] != $_SESSION['id_user']) {
    echo 'ItemNotFromUser';
}

// DELETE Order row if validated

$updateOrderStatusOneRequest = $pdo->prepare('DELETE FROM ORDERS WHERE id = ?');
$updateOrderStatusOneRequest->execute([
    $_POST['orderID']
]);

echo 'successful';