<?php
session_start();

// Relative path to root "/"
// ========== PLEASE ADD A "/" AT THE END ! ========== 
$rootPath = '../../';
// Name of the document
$DocumentTitle = 'document';

// Path to DB
require $rootPath . 'includes/db.php';
// Path to tracking
require $rootPath . 'scripts/log_tracking.php';


//============== get categories ==============
// == accueil ==
$query = $pdo->query("SELECT code_categorie, name FROM DISCUSSION_CATEGORIE WHERE parent_categorie = 'Accueil';");
$accueil = $query->fetchAll(PDO::FETCH_ASSOC);

// == Lecture == 
$query = $pdo->query("SELECT code_categorie, name FROM DISCUSSION_CATEGORIE WHERE parent_categorie = 'Lecture';");
$lecture = $query->fetchAll(PDO::FETCH_ASSOC);

// == Communauté == 
$query = $pdo->query("SELECT code_categorie, name FROM DISCUSSION_CATEGORIE WHERE parent_categorie = 'Communauté';");
$commu = $query->fetchAll(PDO::FETCH_ASSOC);

// == récupérer le nombre de discussion
function get_count($categorie, $pdo) {
    $query = "SELECT COUNT(id_discussion) AS disc FROM DISCUSSION WHERE categorie = :categorie;";
    $request = $pdo->prepare($query);
    $request->bindParam(":categorie", $categorie['code_categorie']);
    $request->execute();
    $count = $request->fetchAll(PDO::FETCH_ASSOC);
    echo $count[0]['disc'];
}
// == récupérer la date de dernier post
function get_last_post($categorie, $pdo, $rootPath) {

    $query = "SELECT MAX(POST.post_date) AS timestamp, DISCUSSION.categorie FROM POST 
              INNER JOIN DISCUSSION ON POST.id_discu = DISCUSSION.id_discussion 
              WHERE DISCUSSION.categorie = :categorie;";
    $request = $pdo->prepare($query);
    $request->bindParam(":categorie", $categorie['code_categorie']);
    $request->execute();
    $timestamp = $request->fetchAll(PDO::FETCH_ASSOC);
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
    <link rel="stylesheet" href="<?php echo $rootPath?>assets/css/modules/new_discu.css">
    <link rel="stylesheet" href="<?php echo $rootPath?>assets/css/modules/forum_panel.css">
    <link rel="stylesheet" href="../../assets/css/pageSpecific/forum_accueil.css">
    
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
        <h1 class="big-title">Forum de la communauté</h1>
        <div class="tableAndSidePannel">
            <table class="forum-table">
                <tr class="notClickable">
                    <th>Accueil</th>
                    <th>Discussions</th>
                    <th>Dernier post</th>
                </tr>
                
                <?php foreach ($accueil as $categorie): ?>
                    <!-- HTML content -->
                    <tr onclick="window.location='URL_1';">

                        <td data-url=<?php echo 'discussions.php?categorie=' . $categorie['code_categorie'] . '&title=' . $categorie["name"]?>>
                            <?php echo $categorie["name"]?>
                        </td>
                        <td><?php get_count($categorie, $pdo); ?></td>
                        <td><?php get_last_post($categorie, $pdo, $rootPath); ?></td>
                    </tr>
                <?php endforeach; ?>

                <tr class="notClickable">
                    <th>Lecture</th>
                    <th>Discussions</th>
                    <th>Dernier post</th>
                </tr>
                
                <?php foreach ($lecture as $categorie): ?>
                    <!-- HTML content -->
                    <tr onclick="window.location='URL_1';">
                        <td data-url=<?php echo 'discussions.php?categorie=' . $categorie['code_categorie'] . '&title=' . $categorie["name"]?>>
                            <?php echo $categorie["name"]?>
                        </td>
                        <td><?php get_count($categorie, $pdo); ?></td>
                        <td><?php get_last_post($categorie, $pdo, $rootPath); ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr class="notClickable">
                    <th>Communauté</th>
                    <th>Discussions</th>
                    <th>Dernier post</th>
                </tr>
                
                <?php foreach ($commu as $categorie): ?>
                    <!-- HTML content -->
                    <tr onclick="window.location='URL_1';">
                        <td data-url=<?php echo 'discussions.php?categorie=' . $categorie['code_categorie'] . '&title=' . $categorie["name"]?>>
                            <?php echo $categorie["name"]?>
                        </td>
                        <td><?php get_count($categorie, $pdo); ?></td>
                        <td><?php get_last_post($categorie, $pdo, $rootPath); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <?php include $rootPath . 'includes/forum_panel.php'?>
        <?php
            include $rootPath . 'includes/new_discussion.php';
        ?>
        <script src="<?php echo $rootPath?>assets/js/click_table_row.js"></script>
        <script src="<?php echo $rootPath?>assets/js/forum_new_discu.js"></script>
    </main>

    <!-- ========= FOOTER INCLUDE ================= -->
    <?php
    include $rootPath . 'includes/footer.php';
    ?>

</body>

</html>