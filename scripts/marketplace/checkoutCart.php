<?php
session_start();

$rootPath = '../../';
include $rootPath . 'includes/db.php';

$newStringQuantities = $_POST['new_string_quantities'];

// Verify a string of new quantities are valid with regex
$pattern = '/^\d+(?:_\d+)*$/';

if (!preg_match($pattern, $newStringQuantities)) {
    // String format is not valid
    echo 'newQuantitiesInvalid';
    exit;
}

$newStringQuantities = explode("_", $newStringQuantities);

foreach ($_SESSION['cartItems'] as $key => $item) {
    $_SESSION['cartItems'][$key]["itemQuantity"] = $newStringQuantities[$key];
}

// Get all id of ORDERS of the user to verify later if we should add quantity or a new order
$getIDOrdersRequest = $pdo->query("SELECT id_bookToSell FROM ORDERS");
$getIDOrders = $getIDOrdersRequest->fetchAll(PDO::FETCH_ASSOC);

$idOrders = array_column($getIDOrders, 'id_bookToSell');

foreach ($_SESSION['cartItems'] as $key => $item) {
    // Id of the specific item
    $itemID = $_SESSION['cartItems'][$key]["itemID"];
    // Quantity of the specific item
    $itemQuantity = $_SESSION['cartItems'][$key]["itemQuantity"];

    $getItemInformationsRequest = $pdo->prepare("SELECT id_bookToSell, quantityItem, seller_user FROM BookToSell WHERE id_bookToSell = ?;");
    $getItemInformationsRequest->execute([$itemID]);

    // Verify if the announced item ID exists
    if (!$getItemInformationsRequest->rowCount() > 0) {
        echo "ItemNotFound";
        exit;
    }

    // Fetch the row
    $getItemInformations = $getItemInformationsRequest->fetch(PDO::FETCH_ASSOC);

    // Verify the announced wanted quantity aren actually inferior to the total stock
    $remainingQuantity = $getItemInformations['quantityItem'] - $itemQuantity;

    // Change the value of quantityItem in table, if the condition doesn't meet it means there is more items ordered than stock
    if ($remainingQuantity >= 0) {
        // Update the quantity by substracting the quantity of the orders which is inferior to the old value
        $changeQuantityItemValue = $pdo->prepare("UPDATE BookToSell SET quantityItem = ? WHERE id_bookToSell = ?");
        $changeQuantityItemValue->execute([
            $remainingQuantity,
            $getItemInformations['id_bookToSell']
        ]);
    } else {
        echo "NotEnoughStock";
        exit;
    }

    // Add to quantity if the user already has an order with the same item
    if (in_array($getItemInformations['id_bookToSell'], $idOrders)) {

        // Get current quantity of orders
        $getOrderCurrentQuantityRequest = $pdo->prepare("SELECT quantity FROM ORDERS WHERE id_bookToSell = ?");
        $getOrderCurrentQuantityRequest->execute([$getItemInformations['id_bookToSell']]);

        $getOrderCurrentQuantity = $getOrderCurrentQuantityRequest->fetch();

        // Calculate new quantity

        $newQuantityAdd = $getOrderCurrentQuantity['quantity'] + $itemQuantity;

        $addQuantityOrder = $pdo->prepare("UPDATE ORDERS SET quantity = ? WHERE id_bookToSell = ?");
        $addQuantityOrder->execute([
            $newQuantityAdd,
            $getItemInformations['id_bookToSell']
        ]);
    }
    // If it doesn't already exists, add a new row in ORDERS
    else {
        // Insert current products into order
        $insertProductInOrder = $pdo->prepare("INSERT INTO ORDERS(dateOrder, quantity, id_user, id_bookToSell, id_seller) 
      VALUES(DATE_FORMAT(CURRENT_TIMESTAMP, '%Y-%m-%d %H:%i:%s'), ?, ?, ?, ?);");

        $insertProductInOrder->execute([
            $itemQuantity,
            $_SESSION['id_user'],
            $getItemInformations['id_bookToSell'],
            $getItemInformations['seller_user']
        ]);
    }
}
unset($_SESSION['cartItems']);
echo 'success';
