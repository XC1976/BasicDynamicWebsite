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

// Verify that $_GET['id'] is set
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: ' . $rootPath . 'pages/others/errorPage.php?message=Cette discussion n\'existe pas !');
    exit;
}

// ======= Verify if $_GET['id'] is valid
$getAllIdDiscussionQuery = $pdo->query("SELECT id_discussion FROM DISCUSSION");

$allDiscussionsID = $getAllIdDiscussionQuery->fetchAll(PDO::FETCH_ASSOC);

foreach ($allDiscussionsID as $id) {
    if ($id['id_discussion'] == $_GET['id']) {
        $idExists = 1;
        break;
    }
}

if ($idExists !== 1 || !isset($idExists)) {
    header('Location: ' . $rootPath . 'pages/others/errorPage.php?message=Cette discussion n\'existe pas !');
    exit;
}

//======= check if their is a topic (topic = discussion theme) =========
$id_discu = $_GET['id'];
if (
    !array_key_exists('id', $_GET) ||
    empty($_GET['id'])
) {
    header("Location: accueil.php");
} else {
    $id_discu = $_GET['id'];
    $id_discu = htmlspecialchars($id_discu);
}

//============== get post ==============

$query = "SELECT POST.id_post, POST.content, POST.post_date, POST.id_user, USER.name, USER.lastname, USER.username, USER.profile_pic
        FROM POST INNER JOIN USER
        ON POST.id_user = USER.id_user
        WHERE POST.id_discu = :id_discu AND POST.deleted != 1
        ORDER BY POST.post_date ASC;
        ";

$request = $pdo->prepare($query);
$request->bindParam(":id_discu", $id_discu);
$request->execute();
$posts = $request->fetchAll(PDO::FETCH_ASSOC);

//=======get title ===========
$query = "SELECT name FROM DISCUSSION WHERE id_discussion = :id_discu";

$request = $pdo->prepare($query);
$request->bindParam(":id_discu", $id_discu);
$request->execute();
$title = $request->fetchAll(PDO::FETCH_ASSOC);

//testcode
//var_dump($_SESSION);

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/pageSpecific/forum_posts.css">
    <link rel="stylesheet" href="<?= $rootPath ?>assets/css/modules/forum_panel.css">
    <title>
        <?= $DocumentTitle; ?>
    </title>
    <!-- Content that will appear on the bottom of title in search IMPORTANT !!! -->
    <meta name="description" content="">

    <!-- ====== BASIC CSS AND JS FOR NAVBAR, FOOTER, AND style.css ======= -->
    <?php include $rootPath . 'includes/head.php'; ?>


    <!-- Script specific to page -->
    <script src="<?php echo $rootPath ?>assets/js/forum_new_post.js" defer></script>

</head>

<body>

    <!-- ========== HEADER NAVBAR INCLUDE ============= -->
    <?php
    include $rootPath . 'includes/headerNavbar.php';
    ?>

    <!-- Bloc de code qui apparaît seulement si une erreur avec le new_post -->
    <?php include $rootPath . 'includes/errorPopup.php'; ?>

    <main>
        <h1 class="big-title">
            <?php echo $title[0]['name'] ?>
        </h1>
        <div class="postAndSidePannel">
            <div class="posts-container">
                <?php foreach ($posts as $post): ?>
                    <div class="post">
                        <a href="<?= $rootPath . 'pages/Profil/profile.php?username=' . $post['username']; ?>"
                            class="avatar">
                            <div>
                                <img src="<?= $rootPath . 'assets/img/profilPic/' . $post['profile_pic'] ?>"
                                    alt="User Avatar">
                                <div class="user-info">
                                    <div class="full-name"><?php echo $post['lastname'] ?></div>
                                    <div class="username"><?php echo '@' . $post['username'] ?></div>
                                </div>
                            </div>
                        </a>
                        <div class="content">
                            <div class="message"><?php echo $post['content'] ?></div>
                            <div class="time">
                                <?php $timestamp = $post['post_date'];
                                include $rootPath . 'includes/format_time.php'; ?>
                            </div>
                            <div class="actions">
                                <button id="<?php echo $post['id_post'] ?>" class="like-btn2" onclick="like_click(this)">
                                    <img src="<?= $rootPath . 'assets/img/profilPage/like.png'; ?>" alt="Aimer"
                                        class="likeImg" />
                                </button>
                                <span class="like-counter" id="<?php echo 'counter' . $post['id_post'] ?>">
                                    <?php
                                    $id_post = $post['id_post'];
                                    include $rootPath . 'scripts/like_nb.php';
                                    ?>
                                </span>
                            </div>
                            <?php if (isset($_SESSION['id_user'])) :?>
                            <?php if ($post['id_user'] == $_SESSION['id_user']): ?>
                                <div>
                                <button onclick="deletePost(event, <?= $post['id_post']; ?>)" class="deletePostButton">Supprimer post</button>
                                    <button onclick="showTextArea(event)" class="editPostButton">Edit post</button>
                                    <form action="<?= $rootPath . 'scripts/posts/editPost.php'?>" method="post" class="editPost">
                                        <textarea name="editPost"></textarea>
                                        <input type="submit" name="submit" value="Modifier post" class="modifPost">
                                        <input type="hidden" name="id_post" value="<?= $post['id_post']; ?>">
                                        <input type="hidden" name="previous_page" value="<?php echo $page_link ?>">
                                        <input type="hidden" name="id_discu" value=<?php echo $id_discu ?>>
                                    </form>
                                </div>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php include $rootPath . 'includes/forum_panel.php' ?>
        </div>

        <!--==================== new_post ON CLICK ====================-->
        <div class="new_post" id="new_post">
            <form action="<?= $rootPath . 'scripts/new_post.php'; ?>" class="new_post__form" method="POST">
                <h2 class="new_post__title">Nouveau message</h2>
                <p id="message">
                    <?php if (array_key_exists('message', $_GET))
                        echo htmlspecialchars($_GET['message']); ?>
                </p>
                <textarea placeholder="Écrivez votre message" id="new_post_text" class="new_post__input"
                    name="new_post_text"></textarea>

                <button type="submit" class="new_post__button" name="validate">Poster mon message</button>
                <input type="hidden" name="previous_page" value="<?php echo $page_link ?>">
                <input type="hidden" name="id_discu" value=<?php echo $id_discu ?>>
            </form>

            <i class="ri-close-line new_post__close" id="new_post-close"></i>
        </div>

    </main>


    <!-- ========= FOOTER INCLUDE ================= -->
    <?php
    include $rootPath . 'includes/footer.php';
    ?>
</body>

</html>