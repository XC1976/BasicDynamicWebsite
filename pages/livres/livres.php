<?php
session_start();

// Relative path to root "/"
// ========== PLEASE ADD A "/" AT THE END ! ========== 
$rootPath = '../../';
// Name of the document
$DocumentTitle = 'Livres par genre';

// Path to DB
require $rootPath . 'includes/db.php';
// Path to tracking
require $rootPath . 'scripts/log_tracking.php';

//======= check if their is a genre =========
$genre = $_GET['genre'];
if (empty($genre) || (intval($genre) == 0 && $genre != "0")) {
    header("Location: biblioteque.php");
}

//============== get genre ==============
$query = "SELECT name, description FROM GENRE WHERE id_genre = :genre;";
$request = $pdo->prepare($query);
$request->bindParam(":genre", $genre);
$request->execute();
$genre_infos = $request->fetchAll(PDO::FETCH_ASSOC);


// Page number logic
if (isset($_GET['page']) && !empty($_GET['page']) && filter_var($_GET['page'], FILTER_VALIDATE_INT) !== false && $_GET['page'] > 0) {
    $pageNumber = $_GET['page'];
} else {
    $pageNumber = 1;
}

// Calculate the offset for the page number
if ($pageNumber == 1) {
    $pageNumberOffset = 0;
} else {
    $pageNumberOffset = ($pageNumber - 1) * 8;
}


//get books
/*
$query = "SELECT id_book, title_VF, release_date, name as auth_name, lastname as auth_lastname
        FROM BOOK INNER JOIN AUTHOR on author = id_author
        WHERE genre = :genre;";
*/
$query = "SELECT 
            BOOK.id_book, 
            BOOK.title_VF, 
            BOOK.release_date, 
            AUTHOR.name AS auth_name, 
            AUTHOR.lastname AS auth_lastname, 
            AVG(REVIEW_BOOK.rating) AS nb_stars
        FROM 
            BOOK 
        INNER JOIN 
            AUTHOR ON BOOK.author = AUTHOR.id_author
        INNER JOIN 
            REVIEW_BOOK ON BOOK.id_book = REVIEW_BOOK.id_book
        WHERE 
            BOOK.genre = :genre
        GROUP BY 
            BOOK.id_book, 
            BOOK.title_VF, 
            BOOK.release_date, 
            AUTHOR.name, 
            AUTHOR.lastname
            ORDER BY BOOK.release_date DESC LIMIT 8 OFFSET :offset
        ";
$request = $pdo->prepare($query);
$request->bindParam(":genre", $genre);
$request->bindParam(":offset", $pageNumberOffset, PDO::PARAM_INT);
$request->execute();
$livres = $request->fetchAll(PDO::FETCH_ASSOC);

//=====STARS ====
include $rootPath . 'includes/printStarRating.php';
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

    <!-- Pagination JS script (see description inside the file) -->
    <script src="../../assets/js/marketplace/paginationShop.js" defer></script>
    <link rel="stylesheet" href="../../assets/css/pageSpecific/livres.css">

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
        <h1 class="big-title">
            <?php echo $genre_infos[0]['name'] ?>
        </h1>
        <section class="productsBlock">
            <p><?php echo $genre_infos[0]['description'] ?></p>
            <div class="products-container">

                <?php foreach ($livres as $livre): ?>
                    <div class="pro" onclick="window.location.href='livre.php?id=<?= $livre['id_book'] ?>'">
                        <img src="../../assets/img/books/default_bookImg.png" alt="">
                        <div class="description">
                            <h5><?= $livre['title_VF']; ?></h5>
                            <h4><?php echo $livre['auth_name'] . ' ' . $livre['auth_lastname'] ?></h4>
                            <?php printStarRating($livre['nb_stars']) ?>

                        </div>

                    </div>
                <?php endforeach; ?>
            </div>

            <?php if (empty($livres)): ?>
                <h1 class="noProducts">Il n'y a pas encore de livres ici. 😅</h1>
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