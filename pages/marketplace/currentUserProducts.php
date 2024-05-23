<?php
session_start();

// Relative path to root "/"
// ========== PLEASE ADD A "/" AT THE END ! ========== 
$rootPath = '../../';
// Name of the document
$DocumentTitle = 'Openreads - Vos produits';

// Path to DB
require $rootPath . 'includes/db.php';
// Path to tracking
require $rootPath . 'scripts/log_tracking.php';

// Verify if user connected
if (!isset($_SESSION['auth'])) {
    header('Location: ../others/errorPage.php?message=Vous n\'êtes pas connecté !');
    exit;
}

// Get current user all of its own orders
$getCurrentUserOrdersRequest = $pdo->prepare('SELECT id_bookToSell, book_name, price, description, date_published, quantityItem, main_img_name FROM BookToSell WHERE seller_user = ?;');
$getCurrentUserOrdersRequest->execute([
    $_SESSION['id_user']
]);

$getCurrentUserOrders = $getCurrentUserOrdersRequest->fetchAll(PDO::FETCH_ASSOC);
$rowCount = $getCurrentUserOrdersRequest->rowCount();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $DocumentTitle; ?>
    </title>
    <!-- Content that will appear on the bottom of title in search IMPORTANT !!! -->
    <meta name="description" content="">

    <!-- ====== BASIC CSS AND JS FOR NAVBAR, FOOTER, AND style.css ======= -->
    <?php include $rootPath . 'includes/head.php'; ?>

    <!-- CSS specific to page -->
    <link rel="stylesheet" href="<?= $rootPath . 'assets/css/pageSpecific/marketplace/currentUserProducts.css' ?>" />

    <!-- JS specific to page -->
    <script src="<?= $rootPath . 'assets/js/marketplace/deleteOwnProduct.js'?>" defer></script>

</head>

<body>

    <!-- ========== HEADER NAVBAR INCLUDE ============= -->
    <?php
    include $rootPath . 'includes/headerNavbar.php';
    ?>

    <!-- Bloc de code qui apparaît seulement si une erreur avec le login -->
    <?php include $rootPath . 'includes/errorPopup.php'; ?>

    <main>
        <div class="mainHead">
            <h1>Vos produits</h1>
            <a href="addProduct.php">Ajouter un produit +</a>
        </div>

        <section class="products">
            <?php foreach ($getCurrentUserOrders as $value): ?>
                <div class="individualProduct">
                    <div class="individualProductHeader">
                        <h2>Nom : <?= $value['book_name'];?></h2>
                        <span>Date published : <?= $value['date_published'];?></span>
                    </div>

                    <div class="individualProductBody">
                        <div class="image">
                            <img src="<?= $rootPath . 'assets/img/books/' . $value['main_img_name']; ?>" alt="Image livre" />
                        </div>
                        <div class="individualProductBody2">
                            <span>Quantité : <?= $value['quantityItem'];?></span>
                            <h3>Description : </h3>
                            <p><?= $value['description'];?></p>
                            <button onclick="deleteProduct(event, <?= $value['id_bookToSell'];?>)">Supprimer produit</button>
                            <a href="<?= $rootPath . 'pages/marketplace/product.php?id=' . $value['id_bookToSell']; ?>">Lien vers le produit</a>
                            <a href="<?= $rootPath . 'pages/marketplace/editProduct.php?id=' . $value['id_bookToSell']; ?>">Editer le produit</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if($rowCount == 0): ?>
                <h2 style="text-align: center; margin-top: 200px;">Vous n'avez pas publié de produits !</h2>
            <?php endif; ?>
        </section>
    </main>

    <!-- ========= FOOTER INCLUDE ================= -->
    <?php
    include $rootPath . 'includes/footer.php';
    ?>

</body>

</html>