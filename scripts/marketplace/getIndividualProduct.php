<!-- Get individual product for the product.php page marketplace -->
<?php
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: ' . $rootPath . 'pages/others/errorPage.php?message=Cette article n\'existe pas.');
    exit;
}

// Get article informations depending on the $_GET['id'] variable
$getArticleInfo = $pdo->prepare("SELECT id_bookToSell, price, book_name, description, main_img_name, quantityItem, seller_user FROM BookToSell WHERE id_BookToSell = ?");
$getArticleInfo->execute([
    $_GET['id']
]);

$ArticleInfos = $getArticleInfo->fetch(PDO::FETCH_ASSOC);

// Verify that the article exist, if not, redirect to the error page with error message
if ($getArticleInfo->rowCount() === 0) {
    header('Location: ' . $rootPath . 'pages/others/errorPage.php?message=Cette article n\'existe pas.');
    exit;
}

// Verify if the item is already in cart to disable the add to cart button
if (isset($_SESSION['cartItems']) || !empty($_SESSION['cartItems']) || is_array($_SESSION['cartItems'])) {

    foreach ($_SESSION['cartItems'] as $itemArray) {
        // Compare if the product ID is already in the session
        if($itemArray['itemID'] == $ArticleInfos['id_bookToSell']) {
            $alreadyInCart = 1;
        }
    }
}

// SELECT username of seller_user

$getSellerUserUsernameRequest = $pdo->prepare('SELECT username FROM USER WHERE id_user = ?');
$getSellerUserUsernameRequest->execute([
    $ArticleInfos['seller_user']
]);

$getSellerUserUsername = $getSellerUserUsernameRequest->fetch(PDO::FETCH_ASSOC);