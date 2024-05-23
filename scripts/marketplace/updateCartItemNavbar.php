<?php
session_start();

$rootPath = '../../';
include $rootPath . 'includes/db.php';

$numberOfCartItems = 0;
if(isset($_SESSION['cartItems']) && !empty($_SESSION['cartItems'])) {

   foreach($_SESSION['cartItems'] as $item) {
      $numberOfCartItems++;
   } 
}

echo $numberOfCartItems;