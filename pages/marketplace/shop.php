<?php
session_start();

// Relative path to root "/"
// ========== PLEASE ADD A "/" AT THE END ! ========== 
$rootPath = '../../';
// Name of the document
$DocumentTitle = 'Openreads - Marketplace';

// Path to DB
require $rootPath . 'includes/db.php';
// Path to tracking
require $rootPath . 'scripts/log_tracking.php';

// Included scripts
require ($rootPath . 'scripts/marketplace/getProductsShop.php');
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

    <!-- CSS specific to page -->
    <link rel="stylesheet" href="../../assets/css/pageSpecific/marketplace/marketplaceIndex.css" />
    <link rel="stylesheet" href="../../assets/css/pageSpecific/marketplace/shop.css">

    <!-- ====== BASIC CSS AND JS FOR NAVBAR, FOOTER, AND style.css ======= -->
    <?php include $rootPath . 'includes/head.php'; ?>

    <!-- JS file specific to page -->
    <script src="../../assets/js/marketplace/shop.js" defer></script>

</head>

<body>

    <!-- ========== HEADER NAVBAR INCLUDE ============= -->
    <?php
    include $rootPath . 'includes/headerNavbar.php';
    ?>

    <!-- Bloc de code qui apparaît seulement si une erreur avec le login -->
    <?php include $rootPath . 'includes/errorPopup.php'; ?>

    <main>

        <section class="productsBlock">
            <div class="productHeader">
                <div class="productHeaderTitle">
                    <h2>Derniers articles</h2>
                    <p>Découvrez les derniers livres mis en vente par la communauté !</p>
                </div>
                <div class="productHeaderButton">
                    <?php if (isset($_SESSION['auth'])): ?>
                        <a href="addProduct.php">Ajouter un article +</a>
                    <?php else: ?>
                        <a onclick="triggerLoggingScreen()">Ajouter un article +</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="products-container">

                <?php foreach ($itemsOfPageInfos as $key => $row): ?>
                    <div class="pro" onclick="window.location.href='product.php?id=<?= $row['id_bookToSell']; ?>'">
                        <img src="<?= $rootPath . 'assets/img/books/' . $itemsOfPageInfos[$key]['main_img_name']; ?>"
                            alt="">
                        <div class="description">
                            <h5><?= $itemsOfPageInfos[$key]['book_name']; ?></h5>
                            <div class="star">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <h4><?= $itemsOfPageInfos[$key]['price'] . '$'; ?></h4>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if ($getItemsOfPage->rowCount() == 0): ?>
                <h1 class="noProducts">Il n'y a pas de produits ici. 😅</h1>
            <?php endif; ?>

            <section class="pagination">

                <!-- Verify conditions to see if previous buttons should be added -->

                <!-- Previous page -->
                <?php if ($pageNumber > 1): ?>
                    <a onclick="addGetParameter('page', '<?= $pageNumber - 1; ?>')">
                        <img src="<?= $rootPath . 'assets/img/marketplace/left-arrow.png'; ?>" alt="Previous"
                            class="paginationImg"></a>
                    </a>
                <?php endif; ?>

                <!-- First page -->
                <?php if ($pageNumber > 2): ?>
                    <a onclick="addGetParameter('page', '1')">1</a>
                <?php endif; ?>

                <!-- Previous page number -->
                <?php if ($pageNumber > 1): ?>
                    <a onclick="addGetParameter('page', '<?= $pageNumber - 1; ?>')"><?= $pageNumber - 1; ?></a>
                <?php endif; ?>

                <!-- Current page pageNumber -->
                <a href="#" style="color: #240A34;"><?= $pageNumber; ?></a>

                <!-- Next page number -->
                <a onclick="addGetParameter('page', '<?= $pageNumber + 1; ?>')"><?= $pageNumber + 1; ?></a>

                <!-- Next arrow, does the same as current page number -->
                <a class="paginationImg" onclick="addGetParameter('page', '<?= $pageNumber + 1; ?>')">
                    <img src="<?= $rootPath . 'assets/img/marketplace/right-arrow.png'; ?>" alt="Next"></a>
            </section>

    </main>

    <!-- ========= FOOTER INCLUDE ================= -->
    <?php
    include $rootPath . 'includes/footer.php';
    ?>

</body>

</html>