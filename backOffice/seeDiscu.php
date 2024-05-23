<?php include 'scripts/php/init.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include('scripts/php/genHeaderLinks.php'); ?>

    <!-- SPECIFIC CSS  -->
    <link rel="stylesheet" href="../assets/css/pageSpecific/seeDiscu.css">

    <!--  JS  -->
    <script src="scripts/js/Discussion.js"></script>

    <link rel = "stylesheet" href = "../assets/css/general/components/popupDelete.css">

    <title>Posts de la discussion</title>
</head>

<body>
<?php  
    include('../includes/navbar_back.php');
    include('../includes/db.php');  
    include('../includes/popupDelete.php');  

    if (!isset($_GET['id_discu']) || empty($_GET['id_discu'])) { 
        header('location: seeDiscussions.php?message=Identifiant de discussion invalide.');
        exit; 
    }

    $q = 'SELECT id_post, content, POST.id_user as id_user, username, id_discu, DATE_FORMAT(post_date, \'%d/%m/%Y %H:%i:%s\') AS post_date
    FROM POST
    JOIN USER ON POST.id_user = USER.id_user
    WHERE id_discu = :id AND POST.content IS NOT NULL
    ORDER BY post_date;';


    $req = $pdo->prepare($q);
    $req->execute(['id' => $_GET['id_discu']]);
    $posts = $req->fetchAll(PDO::FETCH_ASSOC);

    if(empty($posts)) {
       echo '<div id = "empty">
       <p>Aucun post trouvé sur cette discussion.</p>
       
       </div>';
    } else {
    $firstPost = $posts[0];
    ?>
        <main>

        <div id = "conv"> 

            <div id = "firstPost">
                <div class = "replyBlock">
                    <div class = "reply">
                        <h2 class = "username"><a href = "editUser.php?id_user=<?php echo $firstPost['id_user']; ?>">@<?php echo $firstPost['username']; ?></a></h2>
                        <p class = "text"><?php echo $firstPost['content']; ?></p>
                    </div>
                    <p class = "date"><?php echo $firstPost['post_date']; ?></p>
                </div>
            </div>

            <div id = "replies">
                <?php for ($i = 1; $i < count($posts); $i++): ?>
                <div class="replyBlock">
                    <div class="reply">
                        <h2 class="username"><a href = "editUser.php?id_user=<?php echo $posts[$i]['id_user']; ?>">@<?php echo $posts[$i]['username']; ?></a></h2>
                        <p class="text"><?php echo $posts[$i]['content']; ?></p>
                    </div>
                    <p class = "date"><?php echo $posts[$i]['post_date']; ?></p>
                    <button class="btn" onclick="togglePopup(<?php echo $posts[$i]['id_post']; ?>)">supprimer</button>
                </div>
                <?php endfor; ?>
            </div>

        </div>

        <?php 
    }

    ?>
    </main>



    
</body>
</html>












