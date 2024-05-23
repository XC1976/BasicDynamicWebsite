<?php
session_start();

// Relative path to root "/"
// ========== PLEASE ADD A "/" AT THE END ! ========== 
$rootPath = '../../';
// Name of the document
$DocumentTitle = 'Openreads - Marketplace';

// Verify if user is connected if not redirect with error
if (!isset($_SESSION['auth'])) {
    header('Location: ../others/errorPage.php?message=Vous devez être connecté pour accéder au panier.');
    exit;
}

// Path to DB
require $rootPath . 'includes/db.php';
// Path to tracking
require $rootPath . 'scripts/log_tracking.php';
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
    <link rel="stylesheet" href="../../assets/css/pageSpecific/marketplace/cart.css">

    <!-- ====== BASIC CSS AND JS FOR NAVBAR, FOOTER, AND style.css ======= -->
    <?php include $rootPath . 'includes/head.php'; ?>

    <!-- Specific script to this page -->
    <script src="<?= $rootPath . 'assets/js/marketplace/cart.js'; ?>" defer></script>

</head>

<body>

    <!-- ========== HEADER NAVBAR INCLUDE ============= -->
    <?php
    include $rootPath . 'includes/headerNavbar.php';
    ?>

    <!-- Bloc de code qui apparaît seulement si une erreur avec le login -->
    <?php include $rootPath . 'includes/errorPopup.php'; ?>

    <main>

        <section class="cart">
            <div class="tableCart">
                <div class="tableCart2">

                    <nav>
                        <ul>
                            <li>Supprimer</li>
                            <li>Image</li>
                            <li>Produit</li>
                            <li>Prix</li>
                            <li>Quantité</li>
                            <li>Stock</li>
                        </ul>
                    </nav>

                    <!-- Items inside the cart -->
                    <?php $countTotal = 0; ?>
                    <?php if (!empty($_SESSION['cartItems']) && isset($_SESSION['cartItems'])): ?>
                        <?php foreach ($_SESSION['cartItems'] as $key => $value): ?>

                            <!-- Get informations of the specific item -->
                            <?php
                            $getInfosItemRequest = $pdo->prepare("SELECT book_name, price, main_img_name, quantityItem FROM BookToSell WHERE id_bookToSell = ?");
                            $getInfosItemRequest->execute([
                                $_SESSION['cartItems'][$key]['itemID']
                            ]);

                            $infosItemRequest = $getInfosItemRequest->fetch(PDO::FETCH_ASSOC);

                            $countTotal = $countTotal + $infosItemRequest['price'] * $_SESSION['cartItems'][$key]['itemQuantity'];
                            ?>

                            <div class="cartItem">
                                <div>
                                    <button class="removeButtons">Remove</button>
                                </div>
                                <div>
                                    <img src="<?= $rootPath . 'assets/img/books/' . $infosItemRequest['main_img_name']; ?>"
                                        alt="Image of book" class="productImage" />
                                </div>
                                <h3><?= $infosItemRequest['book_name']; ?></h3>
                                <span class="itemPrice">$<?= $infosItemRequest['price']; ?></span>
                                <div>
                                    <input type="number" value="<?= $_SESSION['cartItems'][$key]['itemQuantity']; ?>"
                                        class="itemQuantity" min="1" max="<?= $infosItemRequest['quantityItem']; ?>"
                                        data-max-stock-value="<?= $infosItemRequest['quantityItem']; ?>" />
                                </div>

                                <div>
                                    <span><?= $infosItemRequest['quantityItem']; ?> en stock</span>
                                </div>

                                <input type="hidden" value="<?= $_SESSION['cartItems'][$key]['itemID']; ?>"
                                    class="itemIDSession" />
                                <input type="hidden" value="<?= $infosItemRequest['quantityItem']; ?>"
                                    class="idBookToSellInput" />
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <section class="checkout">
                <div class="subtotal">
                    <h3>Cart Totals</h3>
                    <table>
                        <tr>
                            <td>Sous-total du panier</td>
                            <td class="totalPrice">$ <?= $countTotal; ?></td>
                        </tr>
                        <tr>
                            <td>Expédition</td>
                            <td class="shippingPrice">$ 5</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Total</td>
                            <td style="font-weight: bold;" class="totalCheckout">$
                                <?= $countTotal == 0 ? '0' : $countTotal + 5;
                                ; ?>
                            </td>
                        </tr>
                    </table>

                    <?php if ($countTotal == 0): ?>
                        <div id="buttonContainer">
                            <button onclick="noitem()" style="background-color: #EA5455;">Panier vide !</button>
                        </div>
                    <?php else: ?>
                        <div id="buttonContainer">
                            <button onclick="checkout(event)" id="checkoutButton">Passer à la caisse</button>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </section>
    </main>

    <!-- ========= FOOTER INCLUDE ================= -->
    <?php
    include $rootPath . 'includes/footer.php';
    ?>

</body>

</html>