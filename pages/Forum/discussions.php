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

//======= check if their is a category and title $_GET variables =========
$categorie = $_GET['categorie'];
$titleGet = $_GET['title'];
if (empty($categorie) || empty($titleGet) || !isset($categorie) || !isset($titleGet)) {
    header("Location: accueil.php");
    exit;
}

// Check if $_GET['categorie'] value exists
$getDiscussionsNames = $pdo->query('SELECT code_categorie FROM DISCUSSION_CATEGORIE;');

$discussionNamesCode = $getDiscussionsNames->fetchAll(PDO::FETCH_ASSOC);
$categorieFound = 0;
foreach ($discussionNamesCode as $name) {
    
    if ($categorie === $name['code_categorie']) {
        $categorieFound = 1;
        break;
    }
}
if($categorieFound !== 1 || !isset($categorieFound)) {
    header("Location: accueil.php");
    exit;
}

//============== get discussion ==============
$query = "SELECT id_discussion, name, op FROM DISCUSSION WHERE categorie = :categorie;";
$request = $pdo->prepare($query);
$request->bindParam(":categorie", $categorie);
$request->execute();
$discussions = $request->fetchAll(PDO::FETCH_ASSOC);

//============== get discussions authors ==============
function get_author($topic, $pdo)
{
    $query = "SELECT username FROM USER WHERE id_user = :id";
    $request = $pdo->prepare($query);
    $request->bindParam(":id", $topic['op']);
    $request->execute();
    $username = $request->fetchAll(PDO::FETCH_ASSOC);
    echo $username[0]['username'];
}

function get_post_count($topic, $pdo)
{
    $query = "SELECT COUNT(id_post) AS count FROM POST WHERE id_discu = :id_discu;";
    $request = $pdo->prepare($query);
    $request->bindParam(":id_discu", $topic['id_discussion']);
    $request->execute();
    $count = $request->fetchAll(PDO::FETCH_ASSOC);
    echo $count[0]['count'];
}

function get_last_post($topic, $pdo, $rootPath)
{
    $query = "SELECT MAX(post_date) AS timestamp FROM POST WHERE id_discu = :id_discu";
    $request = $pdo->prepare($query);
    $request->bindParam(":id_discu", $topic['id_discussion']);
    $request->execute();
    $timestamp = $request->fetchAll(PDO::FETCH_ASSOC);

    //ouput the time
    $timestamp = $timestamp[0]['timestamp'];
    include $rootPath . 'includes/format_time.php';

}

$btnTxt = "+ Nouvelle discussion";
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $rootPath ?>assets/css/pageSpecific/forum_accueil.css">
    <link rel="stylesheet" href="<?php echo $rootPath ?>assets/css/modules/forum_panel.css">
    <link rel="stylesheet" href="<?php echo $rootPath ?>assets/css/modules/new_discu.css">
    <title>
        <?= $DocumentTitle; ?>
    </title>
    <!-- Content that will appear on the bottom of title in search IMPORTANT !!! -->
    <meta name="description" content="">

    <!-- ====== BASIC CSS AND JS FOR NAVBAR, FOOTER, AND style.css ======= -->
    <?php include $rootPath . 'includes/head.php'; ?>

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
            <?php echo htmlspecialchars($_GET['title']) ?>
        </h1>
        <div class="tableAndSidePannel">
            <table class="forum-table">
                <tr>
                    <th>Sujet</th>
                    <th>Auteur</th>
                    <th>Nombre de post</th>
                    <th>Dernier post</th>
                </tr>

                <?php foreach ($discussions as $topic): ?>
                    <!-- HTML content -->
                    <tr onclick="window.location='URL_1';">
                        <td data-url="<?php echo 'posts.php?id=' . $topic["id_discussion"] ?>">
                            <?php echo $topic['name'] ?>
                        </td>
                        <td><?php get_author($topic, $pdo) ?></td>
                        <td><?php get_post_count($topic, $pdo) ?></td>
                        <td><?php get_last_post($topic, $pdo, $rootPath) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <?php include $rootPath . 'includes/forum_panel.php' ?>
            <?php
            include $rootPath . 'includes/new_discussion.php';
            ?>
            <script src="<?php echo $rootPath ?>assets/js/click_table_row.js"></script>
            <script src="<?php echo $rootPath ?>assets/js/forum_new_discu.js"></script>
    </main>

    <!-- ========= FOOTER INCLUDE ================= -->
    <?php
    include $rootPath . 'includes/footer.php';
    ?>

</body>

</html>