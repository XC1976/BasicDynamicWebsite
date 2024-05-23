<?php
session_start();

// Relative path to root "/"
// ========== PLEASE ADD A "/" AT THE END ! ========== 
$rootPath = '../../';
// Name of the document
$DocumentTitle = 'Livre';

// Path to DB
require $rootPath . 'includes/db.php';
// Path to tracking
require $rootPath . 'scripts/log_tracking.php';

//======= check if their is a genre =========
$id = $_GET['id'];

//==== current page link
$page_link = $_SERVER['PHP_SELF'] . '?id=' . $_GET['id'];

// Verify the $_GET['id'] is valid
if (empty($_GET['id']) && !isset($_GET['id'])) {
    header('Location: ../others/errorPage.php?message=Vous nous ne pouvez pas accéder à la page ainsi !');
    exit;
}

$verifyIDValidityRequest = $pdo->prepare("SELECT id_book FROM BOOK WHERE id_book = ?;");
$verifyIDValidityRequest->execute([
    $_GET['id']
]);
$verifyIDValidityRowCount = $verifyIDValidityRequest->rowCount();

if ($verifyIDValidityRowCount == 0) {
    header('Location: ../others/errorPage.php?message=Ce livre n\'existe pas !');
    exit;
}


//get books
$query = "SELECT
            title_VF,
            synopsis,
            DATE_FORMAT(release_date, '%d/%m/%Y') AS release_date,
            cover_img,
            lang, GENRE.name,
            AUTHOR.name as auth_name,
            AUTHOR.lastname as auth_lastname,
            AVG(rating) AS nb_stars
        FROM
            BOOK
        JOIN
            GENRE ON genre = id_genre
        JOIN
            AUTHOR ON author = id_author
        JOIN
            REVIEW_BOOK ON BOOK.id_book = REVIEW_BOOK.id_book 
        WHERE
            REVIEW_BOOK.id_book = :id
        AND
            rating IS NOT NULL;";

$request = $pdo->prepare($query);
$request->bindParam(":id", $id);
$request->execute();
$book = $request->fetchAll(PDO::FETCH_ASSOC);

$stars = $book[0]['nb_stars'];

//get reviews
$query = "SELECT id_review, comment, rating, DATE_FORMAT(time_stamp, '%d/%m/%Y %H:%i') AS date, respond_to, USER.id_user, USER.name, USER.lastname, profile_pic, username
        FROM REVIEW_BOOK JOIN USER ON REVIEW_BOOK.id_user = USER.id_user
        WHERE id_book = :id AND REVIEW_BOOK.deleted != 1;
        ";

$request = $pdo->prepare($query);
$request->bindParam(":id", $id);
$request->execute();
$posts = $request->fetchAll(PDO::FETCH_ASSOC);

include $rootPath . 'includes/printStarRating.php';

/*
input : array of post, id of a post,  identation level
output : nothing
*/
function display_post($posts, $id, $indent)
{
    foreach ($posts as $post) {
        if ($post['id_review'] == $id) {
            include '../../includes/post.php';
        }
    }
}
/*
input : array of post, id of a post
output : array of all the posts that are in response to the input post
*/
function search_resp($posts, $id)
{
    $answers = array();
    foreach ($posts as $post) {
        if ($post['respond_to'] == $id) {
            $answers[] = $post;
        }
    }
    return $answers;
}

/*
input : array of post, id of a post, identation level
output : nothing
description : recursive function that takes a post that isn't a response to any other post
                print original post            
                find all the post in response, print them
*/
function response_tree($posts, $id, $indent)
{
    display_post($posts, $id, $indent);
    $responses = search_resp($posts, $id);

    if (empty($responses)) {
        return;
    }
    foreach ($responses as $post) {
        response_tree($posts, $post['id_review'], $indent + 1);
    }
}
if (isset($_SESSION['id_user'])){
    // Get libraries of current user
    if (isset($_SESSION['auth'])) {
        $getUsersLibrariesInfosRequest = $pdo->prepare("SELECT id_lib, name FROM LIB WHERE id_user = ?;");
        $getUsersLibrariesInfosRequest->execute([
            $_SESSION['id_user']
        ]);
        $getUsersLibrariesInfos = $getUsersLibrariesInfosRequest->fetchAll(PDO::FETCH_ASSOC);

        $verifyIfDuplicatesRequest = $pdo->prepare("SELECT LIB.name, LIB.id_lib FROM LIB JOIN EST_DANS_LIB ON LIB.id_lib = EST_DANS_LIB.id_lib 
        WHERE LIB.id_user = ? AND EST_DANS_LIB.id_book = ?");
        $verifyIfDuplicatesRequest->execute([
            $_SESSION['id_user'],
            $_GET['id']
        ]);
        $verifyIfDuplicates = $verifyIfDuplicatesRequest->fetchAll(PDO::FETCH_ASSOC);
    }

    // see if it's completed
    $getCurrentValueRequest = $pdo->prepare("SELECT id_book FROM BOOKCOMPLETE WHERE id_book = ? AND id_user = ?;");
    $getCurrentValueRequest->execute([
        $_GET['id'],
        $_SESSION['id_user']
    ]);
    $getCurrentValue = $getCurrentValueRequest->fetch(PDO::FETCH_ASSOC);
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

    <!-- CSS specific to page -->
    <link rel="stylesheet" href="../../assets/css/pageSpecific/livre.css" />

    <!-- ====== BASIC CSS AND JS FOR NAVBAR, FOOTER, AND style.css ======= -->
    <?php include $rootPath . 'includes/head.php'; ?>

    <!-- Script specific to page -->
    <script src=<?php echo $rootPath . 'assets/js/review_book.js' ?> defer></script>

</head>

<body>

    <!-- ========== HEADER NAVBAR INCLUDE ============= -->
    <?php
    include $rootPath . 'includes/headerNavbar.php';
    ?>

    <!-- Bloc de code qui apparaît seulement si une erreur avec le login -->
    <?php include $rootPath . 'includes/errorPopup.php'; ?>

    <!-- Bloc de code qui apparaît seulement si une erreur avec le login -->
    <?php include $rootPath . 'includes/errorPopup.php'; ?>

    <main>
        <section class="prodetails">
            <div class="single-pro-image">
                <img src="<?php echo $rootPath . 'assets/img/books/' . $book[0]['cover_img']; ?>" width="100% "
                    id="MainImage" alt="Main image" />
            </div>

            <div class="single-pro-details">
                <h5 class="genre"><?= $book[0]['name'] ?></h5>
                <hr>
                <h2 class="big-title">
                    <?= $book[0]['title_VF'] . ' - ' . $book[0]['auth_name'] . ' ' . $book[0]['auth_lastname'] ?>
                </h2>
                <h5 class="date"><?php echo 'Paru le ' . $book[0]['release_date']; ?></h5>
                <?php printStarRating($stars) ?>

                <?php if (isset($_SESSION['auth']) && !empty($_SESSION['auth'])): ?>
                    <?php if ($getUsersLibrariesInfos): ?>
                        <div class="formProduct">
                            <form action="../../scripts/libraries/addBookToLib.php" method="post" class="AddToLibrary">
                                <label for="choices">Vos bibliothèques : </label>
                                <select name="choices">
                                    <?php foreach ($getUsersLibrariesInfos as $lib): ?>
                                        <option value="<?= $lib['id_lib']; ?>"><?= $lib['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" class="submitAddLibrary">Ajouter +</button>
                                <input type="hidden" name="bookID" value="<?= $_GET['id']; ?>">
                                <input type="hidden" name="previous_link" value="<?= $page_link; ?>">
                            </form>
                            <?php if ($verifyIfDuplicates): ?>
                                <p>Ce livre est déjà dans les libraries suivantes :
                                    <?php foreach ($verifyIfDuplicates as $lib): ?>
                                        <a href="<?= $rootPath . 'pages/library/lib.php?id=' . $lib['id_lib']; ?>"><span
                                                style="font-weight: 600; text-decoration: underline;"><?= $lib['name']; ?></span></a> ;
                                    <?php endforeach; ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <p>Vous n'avez pas de librairie : <a href="../library/addLib.php">Ajouter en !</a></p>
                    <?php endif; ?>

                <?php endif; ?>

                <?php if(isset($_SESSION['auth']) || !empty($_SESSION['auth'])): ?>
                    <?php if($getCurrentValue): ?>
                        <button class="buttonCompleted" onclick="switchFinished(event, <?= $_GET['id']; ?>)" style="margin-top: 20px;">Complétée</button>
                    <?php else: ?>
                        <button class="buttonNotCompleted" onclick="switchFinished(event, <?= $_GET['id']; ?>)" style="margin-top: 20px;">Pas complétée</button>
                    <?php endif; ?>
                <?php endif; ?>

                <div class="synopsis">
                    <h3>Synopsis</h3>
                    <span><?= $book[0]['synopsis'] ?></span>
                </div>
            </div>
        </section>
        <section class="review">
            <div class="reviews-header">
                <h2 class="big-title">Critiques</h2>
                <div class="formProduct">
                    <button id="review-btn" onclick="show_popup(this)">Ajouter une critique</button>
                </div>
            </div>
            <div class="posts-container">
                <?php
                foreach ($posts as $post) {
                    if ($post['respond_to'] == NULL) {
                        response_tree($posts, $post['id_review'], 0);
                    }
                }
                ?>
            </div>
        </section>

        <!--==================== review ON CLICK ====================-->
        <div class="review_form" id="review_form">
            <form action="<?= $rootPath . 'scripts/new_review.php'; ?>" class="review__form" method="POST">
                <p id="message" class="warning">
                    <?php if (array_key_exists('message', $_GET))
                        echo htmlspecialchars($_GET['message']); ?>
                </p>
                <h2 class="review__title" id="review__title">Ecrire une critique</h2>
                <div id="ratingAndTitle">
                    <label>Ma note :</label>
                    <div class="rating">
                        <input type="hidden" name="rating" id="rating" value="5">
                        <i class="fas fa-star" data-rating="1"></i>
                        <i class="fas fa-star" data-rating="2"></i>
                        <i class="fas fa-star" data-rating="3"></i>
                        <i class="fas fa-star" data-rating="4"></i>
                        <i class="fas fa-star" data-rating="5"></i>
                    </div>
                </div>
                <textarea placeholder="Écrivez votre critique" id="review_text" class="review__input"
                    name="review_text"></textarea>

                <button type="submit" class="review__button" id="review__button" name="validate">Poster ma
                    critique</button>
                <input type="hidden" name="previous_page" value="<?php echo $page_link ?>">
                <input type="hidden" name="id_book" value="<?php echo $id; ?>">
                <input type="hidden" name="respond_to" id="respond_to" value="">
            </form>

            <i class="ri-close-line review__close" id="review-close"></i>
        </div>
    </main>

    <!-- ========= FOOTER INCLUDE ================= -->
    <?php
    include $rootPath . 'includes/footer.php';
    ?>

</body>

</html>