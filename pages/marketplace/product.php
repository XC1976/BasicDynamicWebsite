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

// PHP specific to page
require ($rootPath . 'scripts/marketplace/getIndividualProduct.php');
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
    <link rel="stylesheet" href="../../assets/css/pageSpecific/marketplace/product.css" />

    <!-- ====== BASIC CSS AND JS FOR NAVBAR, FOOTER, AND style.css ======= -->
    <?php include $rootPath . 'includes/head.php'; ?>

    <!-- JS specific to page -->

    <script src="<?= $rootPath . 'assets/js/marketplace/productMarketplace.js'; ?>" defer></script>

</head>

<body>

    <!-- ========== HEADER NAVBAR INCLUDE ============= -->
    <?php
    include $rootPath . 'includes/headerNavbar.php';
    ?>

    <!-- Bloc de code qui apparaît seulement si une erreur avec le login -->
    <?php include $rootPath . 'includes/errorPopup.php'; ?>

    <main>

        <section class="prodetails">
            <div class="single-pro-image">
                <img src="<?= $rootPath . 'assets/img/books/' . $ArticleInfos['main_img_name']; ?>" width="100% "
                    id="MainImage" alt="Main image" />

                <div class="small-img-group">
                    <div class="small-img-col">
                        <img src="<?= $rootPath . 'assets/img/books/' . $ArticleInfos['main_img_name']; ?>" width="100%"
                            class="small-img" alt="Small image" />
                    </div>
                    <div class="small-img-col">
                        <img src="<?= $rootPath . 'assets/img/books/' . $ArticleInfos['main_img_name']; ?>" width="100%"
                            class="small-img" alt="Small image" />
                    </div>
                    <div class="small-img-col">
                        <img src="<?= $rootPath . 'assets/img/books/' . $ArticleInfos['main_img_name']; ?>" width="100%"
                            class="small-img" alt="Small image" />
                    </div>
                    <div class="small-img-col">
                        <img src="<?= $rootPath . 'assets/img/books/' . $ArticleInfos['main_img_name']; ?>" width="100%"
                            class="small-img" alt="Small image" />
                    </div>
                </div>
            </div>

            <div class="single-pro-details">
                <h6>Books</h6>
                <h4><?= $ArticleInfos['book_name']; ?></h4>
                <h2>$<?= $ArticleInfos['price']; ?></h2>

                <div class="formProduct">
                    <input type="number" id="quantityProduct" value="1" onchange="quantityChanged(event)" min="1" max="<?= $ArticleInfos['quantityItem']; ?>" />
                    <?php if (isset($_SESSION['auth'])): ?>
                        <button onclick="addtoCart(event)" class="addToCartButton">
                            <!-- Dynamic content of the button depending if the article is arleady in cart -->
                            <?php if (isset($alreadyInCart) && $alreadyInCart == 1): ?>
                                Déjà dans le panier
                            <?php else: ?>
                                Ajouter au panier
                            <?php endif; ?>
                        </button>
                    <?php else: ?>
                        <button onclick="triggerLoginScreen()" class="addToCartButton" id="buttonTriggerLogin">
                            Ajouter au panier
                        </button>
                    <?php endif; ?>
                </div>
                <h3><?= $ArticleInfos['quantityItem']; ?> en stock vendu par <a href="../Profil/profile.php?username=<?= $getSellerUserUsername['username']; ?>">@<?= $getSellerUserUsername['username']; ?></a></h3>
                <h4>Détails du produit</h4>
                <span><?= $ArticleInfos['description'] ?></span>
            </div>

            <input type="hidden" value="<?= $ArticleInfos['id_bookToSell']; ?>" id="addToCartJS" type="number" min="1"
                max="<?= $ArticleInfos['quantityItem']; ?>" />

            <input type="hidden" value="<?= $ArticleInfos['quantityItem']; ?>" id="idBookToSellInput" />
        </section>
    </main>

    <!-- ========= FOOTER INCLUDE ================= -->
    <?php
    include $rootPath . 'includes/footer.php';
    ?>

</body>

</html>