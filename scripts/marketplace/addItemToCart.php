<?php
session_start();

$rootPath = '../../';
include $rootPath . 'includes/db.php';

// Id of element
$itemID = $_POST['item_id'];
// Quantity of element
$itemQuantity = $_POST['item_quantity'];

// Verify if the session has to created
if(!isset($_SESSION['cartItems']) || empty($_SESSION['cartItems']) || !is_array($_SESSION['cartItems'])) {
    $_SESSION['cartItems'] = [];
}

// Verify if the item is already in cart 
foreach ($_SESSION['cartItems'] as $itemArray) {
    // Compare if the product ID is already in the session
    if($itemArray['itemID'] == $itemID) {
        echo 'unsuccessful';
        exit;
    }
}
$_SESSION['cartItems'][] = [
    'itemID'=> $itemID,
    'itemQuantity' => $itemQuantity
];

echo 'successful';