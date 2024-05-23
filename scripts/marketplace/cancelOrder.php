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

// DELETE Order row + refill stock if validated

// Get quantity and id of the book
$getQuantityOrderRequest = $pdo->prepare('SELECT quantity, id_bookToSell FROM ORDERS WHERE id = ?;');
$getQuantityOrderRequest->execute([
    $_POST['orderID']
]);

$getQuantityOrder = $getQuantityOrderRequest->fetch(PDO::FETCH_ASSOC);

// Calculate new quantity
$getQuantityBookRequest = $pdo->prepare('SELECT quantityItem FROM BookToSell WHERE id_bookToSell = ?;');
$getQuantityBookRequest->execute([
    $getQuantityOrder['id_bookToSell']
]);

$getQuantityBook = $getQuantityBookRequest->fetch(PDO::FETCH_ASSOC);

$newQuantity = $getQuantityBook['quantityItem'] + $getQuantityOrder['quantity'];

// Refill stock

$refillStockRequest = $pdo->prepare('UPDATE BookToSell SET quantityItem = ? WHERE id_bookToSell = ?;');
$refillStockRequest->execute([
    $newQuantity,
    $getQuantityOrder['id_bookToSell']
]);

// Delete order

$updateOrderStatusOneRequest = $pdo->prepare('DELETE FROM ORDERS WHERE id = ?');
$updateOrderStatusOneRequest->execute([
    $_POST['orderID']
]);

echo 'successful';