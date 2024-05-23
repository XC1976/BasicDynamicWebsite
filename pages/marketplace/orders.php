<?php
session_start();

// Relative path to root "/"
// ========== PLEASE ADD A "/" AT THE END ! ========== 
$rootPath = '../../';
// Name of the document
$DocumentTitle = 'Openreads - Commandes';

// Verify if user is connected if not redirect with error
if (!isset($_SESSION['auth'])) {
    header('Location: ../others/errorPage.php?message=Vous devez être connecter pour accéder aux commandes.');
    exit;
}

// Path to DB
require $rootPath . 'includes/db.php';
// Path to tracking
require $rootPath . 'scripts/log_tracking.php';

// Specific PHP to page
require $rootPath . 'scripts/marketplace/orders.php';
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
    <link rel="stylesheet" href="<?= $rootPath . 'assets/css/pageSpecific/marketplace/orders.css'; ?>">

    <!-- JS for the button tabs -->
    <script src="../../assets/js/marketplace/ongletProfilePic.js" defer></script>

    <!-- JS to cancel or validate an order -->
    <script src="../../assets/js/marketplace/cancelValidateOrder.js" defer></script>
</head>

<body>

    <!-- ========== HEADER NAVBAR INCLUDE ============= -->
    <?php
    include $rootPath . 'includes/headerNavbar.php';
    ?>

    <main>
        <h1>Vos commandes</h1>

        <section>
            <!-- Content of current orders -->
            <div style="display: block; ">
                <?php foreach ($getOrdersStateZero as $order): ?>
                    <!-- Get username of id_seller -->
                    <?php
                    // Get username of seller_user
                    $getSellerUserUsernameRequest = $pdo->prepare('SELECT username FROM USER WHERE id_user = ?;');
                    $getSellerUserUsernameRequest->execute([
                        $order['idSeller']
                    ]);

                    $getSellerUserUsername = $getSellerUserUsernameRequest->fetch(PDO::FETCH_ASSOC);

                    // Calculate total price
                    $totalPrice = $order['quantity'] * $order['bookPrice'];
                    ?>

                    <div class="orders">
                        <div class="navFlexOrders">
                            <h3>Date de la commande : <?= $order['dateOrder']; ?></h3>
                            <h4>Total : $<?= $totalPrice; ?></h4>
                            <p>Commande #<?= $order['ordersID']; ?>, Quantité : <?= $order['quantity']; ?></p>
                        </div>

                        <div class="mainCommandBodyFlex">
                            <div class="mainCommandBodyFlexLeft">
                                <img src="<?= $rootPath . 'assets/img/books/' . $order['bookImg']; ?>" alt="Image produit" />
                                <h2><?= $order['bookName']; ?></h2>
                                <p>Vendu par <a href="../Profil/profile.php?username=<?= $getSellerUserUsername['username']; ?>">@<?= $getSellerUserUsername['username']; ?></a></p>
                            </div>

                            <!-- Vertical flex -->
                            <div class="mainCommandBodyFlexButton">
                                <button class="commandReceived" onclick="validateOrder(event, <?= $order['ordersID']; ?>);">Commande reçue</button>
                                <button class="commmandCancelled" onclick="cancelOrder(event, <?= $order['ordersID']; ?>);">Annuler la commande</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if($rowCount == 0): ?>
                <h2 style="text-align: center; font-size: 27px; margin-top: 200px;">Vous n'avez pas de commandes actuellement !</h2>
            <?php endif; ?>
        </section>
    </main>

    <!-- ========= FOOTER INCLUDE ================= -->
    <?php
    include $rootPath . 'includes/footer.php';
    ?>

</body>

</html>