<?php
session_start();

// Relative path to root "/"
// ========== PLEASE ADD A "/" AT THE END ! ========== 
$rootPath = '../../';
// Name of the document
$DocumentTitle = 'Openreads - Ajouter un produit';

// Verify if user is connected
if(!isset($_SESSION['auth'])) {
    header('Location: ../others/errorPage.php?message=Vous devez être connecté pour accéder à cette page !');
}

// Verify if the $_POST['id'] is present and an integer
if(!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: ../others/errorPage.php?message=Il faut une ID');
    exit;
}

// Path to DB
require $rootPath . 'includes/db.php';
// Path to tracking
require $rootPath . 'scripts/log_tracking.php';

// Select information of current book
$currentBookInfosRequest = $pdo->prepare('SELECT book_name, price, description, quantityItem, main_img_name, seller_user FROM BookToSell WHERE id_bookToSell = ?;');
$currentBookInfosRequest->execute([
    $_GET['id']
]);

$currentBookInfos = $currentBookInfosRequest->fetch(PDO::FETCH_ASSOC);
$rowCountCurrentBooksInfos = $currentBookInfosRequest->rowCount();

// Verify if book exists
if($rowCountCurrentBooksInfos == 0) {
    header('Location: ../others/errorPage.php?message=Ce livre n\'existe pas !');
    exit;
}

// Verify the book is from the current user
if($currentBookInfos['seller_user'] != $_SESSION['id_user']) {
    header('Location: ../others/errorPage.php?message=Ce livre ne vous appartient pas !');
    exit;
}
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
    <link rel="stylesheet" href="<?= $rootPath . 'assets/css/pageSpecific/marketplace/addProduct.css'?>" />

</head>

<body>

    <!-- ========== HEADER NAVBAR INCLUDE ============= -->
    <?php
    include $rootPath . 'includes/headerNavbar.php';
    ?>

    <!-- Bloc de code qui apparaît seulement si une erreur avec le login -->
    <?php include $rootPath . 'includes/errorPopup.php'; ?>

    <main>

    <h1>Ajouter un produit à vendre</h1>

        <form action="<?= $rootPath . 'scripts/marketplace/editProductVerify.php'?>" method="post" enctype="multipart/form-data" autocomplete="off">
            <label>Nom du livre : </label>
            <input type="text" name="nom" placeholder="Nom du livre" value="<?= $currentBookInfos['book_name']; ?>"required>
            <label>Prix du livre : </label>
            <input type="number" name="price" placeholder="Prix" step="0.01" min="0" value="<?= $currentBookInfos['price']; ?>" required>
            <label>Description du livre : </label>
            <textarea name="description" placeholder="Description du livre" required><?= $currentBookInfos['description']; ?></textarea>
            <label>Quantité : </label>
            <input type="number" name="quantity" placeholder="Quantité" value="<?= $currentBookInfos['quantityItem']; ?>" min="1" required>
            <label>Image (max 1MO, si vide, l'image ne sera pas changée) : </label>
            <input type="file" name="image">
            <input type="hidden" name="currentBookID" value="<?= $_GET['id']; ?>">
            <input type="submit" value="Modifier" class="submit">
        </form>

    </main>

    <!-- ========= FOOTER INCLUDE ================= -->
    <?php
    include $rootPath . 'includes/footer.php';
    ?>

</body>

</html>
