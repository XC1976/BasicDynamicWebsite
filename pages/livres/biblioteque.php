<?php
session_start();

// Relative path to root "/"
// ========== PLEASE ADD A "/" AT THE END ! ========== 
$rootPath = '../../';
// Name of the document
$DocumentTitle = 'Livres par genres';

// Path to DB
require $rootPath . 'includes/db.php';
// Path to tracking
require $rootPath . 'scripts/log_tracking.php';

//============== get categories ==============
// == accueil ==

//number of books per genre
$sql = "SELECT COUNT(id_book) AS sum, id_genre, name, GENRE.description, GENRE.name
        FROM BOOK INNER JOIN GENRE ON genre = id_genre
        GROUP BY GENRE.name
        ORDER BY id_genre;
        ";
$query = $pdo->query($sql);
$genres = $query->fetchAll(PDO::FETCH_ASSOC);


//=== getting the last 5 reviews

$query="SELECT
            comment,
            DATE_FORMAT(time_stamp, '%d/%m/%Y %H:%i') AS post_date,
            id_book,
            USER.username
        FROM
            REVIEW_BOOK
        INNER JOIN
            USER ON REVIEW_BOOK.id_user = USER.id_user
        ORDER BY
            time_stamp DESC LIMIT 5;
            ";
$request = $pdo->prepare($query);
$request->execute();
$posts = $request->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/pageSpecific/forum_accueil.css">
    <link rel="stylesheet" href="../../assets/css/modules/forum_panel.css">
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
    <h1 class="big-title">Bibliotèque</h1>
    <div class="tableAndSidePannel">
        <table class="forum-table">
            <tr>
                <th>Genres littéraires</th>
                <th>Description</th>
                <th>Nombre de livres</th>
            </tr>
            
            <?php foreach ($genres as $genre): ?>
                <!-- HTML content -->
                <tr onclick="window.location='URL_1';">
                    <td data-url=<?php echo $rootPath . 'pages/livres/livres.php?genre=' . $genre['id_genre']?>>
                        <?php echo $genre["name"]?>
                    </td>
                    <td><?php echo $genre['description']; ?></td>
                    <td><?php echo $genre['sum']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <!-- SIDE PANNEL -->
        <div class="panel">
            <h3>Dernières critiques</h3>
            <?php foreach ($posts as $post): ?>
                <div class="panel-post" id="panel-post" url="<?php echo $rootPath . 'pages/livres/livre.php?id=' . $post['id_book'] ?>">
                    <div class="username"><?php echo '@' . $post['username']?></div>
                    <div class="content">
                        <p class="panel_message"><?php echo $post['comment']?></p>
                        <div class="time">
                            <?= $timestamp = $post['post_date']?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
            
        <script>
            //make message clickable
            const posts = document.querySelectorAll('.panel-post');
                posts.forEach(function(post) {
                post.addEventListener('click', function() {
                    window.location = this.getAttribute('url');
                });
            });
            const last_post = document.querySelectorAll(".panel_message");
        
            //cut off the long messages
            last_post.forEach(function(msg) {
                if (msg.textContent.length > 150) {
                    msg.textContent = msg.textContent.substring(0, 150) + ' ...';
                }
            });
        
        
        </script>

        <script src="<?php echo $rootPath?>assets/js/click_table_row.js"></script>
    </main>

    <!-- ========= FOOTER INCLUDE ================= -->
    <?php
    include $rootPath . 'includes/footer.php';
    ?>

</body>

</html>