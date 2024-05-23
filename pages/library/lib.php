<?php
session_start();

// Relative path to root "/"
// ========== PLEASE ADD A "/" AT THE END ! ========== 
$rootPath = '../../';
// Name of the document
$DocumentTitle = '';

// Path to DB
require $rootPath . 'includes/db.php';
// Path to tracking
require $rootPath . 'scripts/log_tracking.php';

$verifyIfIDLibExistsRequest = $pdo->prepare("SELECT id_lib, id_user, public FROM LIB WHERE id_lib = ?;");
$verifyIfIDLibExistsRequest->execute([
    $_GET['id']
]);
$verifyIfIDLibExists = $verifyIfIDLibExistsRequest->fetch();
if (!$verifyIfIDLibExists) {
    header('Location: ../others/errorPage.php?message=Librairie introuvable !');
    exit;
}
// Different between public and private
if ($verifyIfIDLibExists['public'] == 0) {

    if ($verifyIfIDLibExists['id_user'] != $_SESSION['id_user']) {
        header('Location: ../others/errorPage.php?message=Cette librairie est privée !');
        exit;
    }
}

// get Books Of Library
$idLibrary = $_GET['id'];

// Get current libName
$getCurrentLibNameRequest = $pdo->prepare("SELECT name, public FROM LIB WHERE id_lib = ?;");
$getCurrentLibNameRequest->execute([
    $idLibrary
]);
$getCurrentLibName = $getCurrentLibNameRequest->fetch(PDO::FETCH_ASSOC);

$getBooksOfLibraryRequest = $pdo->prepare("SELECT BOOK.id_book, BOOK.title_VF, BOOK.synopsis, BOOK.release_date, BOOK.cover_img, BOOK.genre, BOOK.author, AUTHOR.name AS authorName, AUTHOR.lastname AS authorlastName
FROM LIB JOIN EST_DANS_LIB ON EST_DANS_LIB.id_lib = LIB.id_lib JOIN BOOK ON EST_DANS_LIB.id_book = BOOK.id_book JOIN AUTHOR ON AUTHOR.id_author = BOOK.author WHERE LIB.id_lib = ?;");
$getBooksOfLibraryRequest->execute([
    $idLibrary
]);

$getBooksOfLibrary = $getBooksOfLibraryRequest->fetchAll(PDO::FETCH_ASSOC);
//==== current page link
$page_link = $_SERVER['PHP_SELF'] . '?id=' . $_GET['id'];
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
    <link rel="stylesheet" href="../../assets/css/pageSpecific/libraries/lib.css" />

    <!-- JS specific to page -->
    <script src="../../assets/js/library/switchPublicPrivate.js" defer></script>

</head>

<body>

    <!-- ========== HEADER NAVBAR INCLUDE ============= -->
    <?php
    include $rootPath . 'includes/headerNavbar.php';
    ?>

    <main>

        <!-- Bloc de code qui apparaît seulement si une erreur avec le login -->
        <?php include $rootPath . 'includes/errorPopup.php'; ?>

        <h1><?= $getCurrentLibName['name']; ?></h1>
        <?php if ($verifyIfIDLibExists['id_user'] == $_SESSION['id_user']): ?>
            <div class="interactionLib">
                <div>
                    <form action="../../scripts/libraries/editLibTitle.php" method="post">
                        <label>Renommer librarie :</label>
                        <input type="text" name="newTitle" class="textInputRename">
                        <input type="submit" name="submit" value="Renommer" class="buttonBlue">
                        <input type="hidden" name="previous_page" value="<?= $page_link; ?>">
                        <input type="hidden" name="libID" value="<?= $idLibrary; ?>">
                    </form>
                </div>

                <div>
                    <form action="<?= $rootPath . 'scripts/libraries/modifyLibPP.php' ?>" method="post"
                        enctype="multipart/form-data" autocomplete="off">
                        <label>Image de la librarie (max 1MO): </label>
                        <input type="file" name="image" required>
                        <input type="submit" value="Modifier" class="submit buttonBlue">
                        <input type="hidden" name="previous_page" value="<?= $page_link; ?>" />
                        <input type="hidden" name="libID" value="<?= $idLibrary; ?>">
                    </form>
                </div>

                <div>
                    <?php if ($getCurrentLibName['public'] == 1): ?>
                        <button class="libPublic" onclick="switchPublicPrivate(event, <?= $_GET['id']; ?>)">Publique</button>
                    <?php else: ?>
                        <button class="libPrivate" onclick="switchPublicPrivate(event, <?= $_GET['id']; ?>)">Privée</button>
                    <?php endif; ?>
                </div>

                <div>
                    <button class="removeLib" onclick="removeLib(event, <?= $_GET['id']; ?>)">Supprimer librarie</button>
                </div>
            </div>
        <?php endif; ?>

        <section class="books">
            <?php foreach ($getBooksOfLibrary as $book): ?>
                <div class="topContainer">
                    <div>
                        <a href="<?= '../livres/livre.php?id=' . $book['id_book']; ?>">
                            <h2><?= $book['title_VF']; ?></h2>
                            <p><?= $book['authorName']; ?> <?= $book['authorlastName']; ?></p>
                        </a>
                    </div>

                    <?php if ($verifyIfIDLibExists['id_user'] == $_SESSION['id_user']): ?>
                        <button
                            onclick="removeBookLibrary(event, <?= $book['id_book']; ?>, <?= $_GET['id']; ?>)">Supprimer</button>
                        <input type="hidden" id="pageLinkC" value="<?= $page_link; ?>">
                    <?php endif; ?>

                </div>
            <?php endforeach; ?>
        </section>
    </main>

    <!-- ========= FOOTER INCLUDE ================= -->
    <?php
    include $rootPath . 'includes/footer.php';
    ?>

</body>

</html>