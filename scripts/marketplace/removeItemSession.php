<?php
session_start();

$rootPath = '../../';
include $rootPath . 'includes/db.php';

$currentItemID = $_POST['current_item_id'];

$found = 0;

// Verify if the SESSION exists and is not empty
if(isset($_SESSION['cartItems']) && !empty($_SESSION['cartItems'])) {

    // Verify that the value we are trying to remove is in the array
    foreach($_SESSION['cartItems'] as $key => $item) {
       if($item['itemID'] == $currentItemID) {
            $found = 1;
            unset($_SESSION['cartItems'][$key]);
       }
    } 
 }

 echo $found;