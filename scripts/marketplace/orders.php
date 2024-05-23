<?php

$rootPath = '../../';
include $rootPath . 'includes/db.php';

// Get ORDERS in state 0 (normal) of the current user
$getOrdersStateZeroRequest = $pdo->prepare('SELECT BookToSell.book_name AS bookName, ORDERS.dateOrder AS dateOrder, ORDERS.id_seller AS idSeller, 
BookToSell.main_img_name AS bookImg, ORDERS.quantity AS quantity, ORDERS.id AS ordersID, BookToSell.price AS bookPrice
FROM ORDERS INNER JOIN BookToSell ON ORDERS.id_bookToSell = BookToSell.id_bookToSell WHERE ORDERS.id_user = ? AND ORDERS.state = 0;
');
$getOrdersStateZeroRequest->execute([
    $_SESSION['id_user']
]);

$getOrdersStateZero = $getOrdersStateZeroRequest->fetchAll(PDO::FETCH_ASSOC);
$rowCount = $getOrdersStateZeroRequest->rowCount();