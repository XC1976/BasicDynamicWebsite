<?php
session_start();

// Relative path to root "/"
// ========== PLEASE ADD A "/" AT THE END ! ========== 
$rootPath = '';
// Name of the document
$DocumentTitle = 'OpenReads Accueil';

// Path to DB
require $rootPath . 'includes/db.php';
// Path to log tracking
require $rootPath . 'scripts/log_tracking.php';

//==== livres ============
$query = "SELECT 
            BOOK.id_book, 
            BOOK.title_VF, 
            BOOK.release_date, 
            AUTHOR.name AS auth_name, 
            AUTHOR.lastname AS auth_lastname, 
            AVG(rating) AS nb_stars
         FROM 
            BOOK 
         INNER JOIN 
            AUTHOR ON BOOK.author = AUTHOR.id_author
         INNER JOIN 
            REVIEW_BOOK ON BOOK.id_book = REVIEW_BOOK.id_book
         WHERE
            rating IS NOT NULL
         GROUP BY 
            BOOK.id_book, 
            BOOK.title_VF, 
            BOOK.release_date, 
            AUTHOR.name, 
            auth_lastname
         ORDER BY 
            nb_stars DESC
         LIMIT
            5;
        ";
$request = $pdo->prepare($query);

$request->execute();
$livres = $request->fetchAll(PDO::FETCH_ASSOC);


//==== forum ============
$query = "SELECT
            POST.content,
            POST.post_date,
            POST.id_discu,
            USER.username,
            USER.profile_pic,
            DISCUSSION.name
         FROM 
            POST
         INNER JOIN
            USER ON POST.id_user = USER.id_user
         INNER JOIN 
            DISCUSSION ON id_discussion = id_discu
         ORDER BY 
            POST.post_date DESC LIMIT 4;
        ";
       
$request = $pdo->prepare($query);
$request->execute();
$posts = $request->fetchAll(PDO::FETCH_ASSOC);


//==== reviews ========
$query= "SELECT
            comment,
            DATE_FORMAT(time_stamp, '%d/%m/%Y %H:%i') AS post_date,
            BOOK.id_book,
            rating,
            profile_pic,
            username,
            BOOK.title_VF as title
         FROM
            REVIEW_BOOK
         INNER JOIN
            USER ON REVIEW_BOOK.id_user = USER.id_user
         INNER JOIN
            BOOK ON REVIEW_BOOK.id_book = BOOK.id_book
         WHERE
            REVIEW_BOOK.respond_to IS NULL
         ORDER BY
            time_stamp DESC LIMIT 5;
            ";
$request = $pdo->prepare($query);
$request->execute();
$reviews = $request->fetchAll(PDO::FETCH_ASSOC);


//=====STARS ====
include $rootPath . 'includes/printStarRating.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />

   <!-- Description of the page -->
   <meta name="description" content="Découvrez des milliers de livres passionnants, partagez vos avis, 
   créez votre bibliothèque virtuelle et trouvez de nouvelles lectures captivantes sur notre plateforme de recommandations de livres. 
   Rejoignez une communauté de lecteurs passionnés et explorez un monde de littérature en ligne." />

   <!-- ====== BASIC CSS AND JS FOR NAVBAR, FOOTER, AND style.css ======= -->
   <?php include $rootPath . 'includes/head.php'; ?>

   <!-- Caroussel CSS -->
   <link rel="stylesheet" href="assets/css/modules/carrousel.css" />

   <!-- Carrousel JS -->
   <script src="assets/js/carrousel.js" defer></script>

   <!-- Page specific CSS -->
   <link rel="stylesheet" href="assets/css/pageSpecific/accueil_php.css" />

   <title>
      <?= $DocumentTitle; ?>
   </title>
</head>

<body>

   <!-- HEADER INCLUDE -->
   <?php
   include $rootPath . 'includes/headerNavbar.php';
   ?>

   <main>
      <!-- Discussions -->

      <!-- Bloc de code qui apparaît seulement si une erreur avec le login -->
      <?php include $rootPath . 'includes/errorPopup.php'; ?>

      <!-- Code du carrousel -->

      <h2 class="h2Style">Livres les mieux notés</h2>
      <section class="cardSection">
         <div class="wrapper">
            <i id="left" class="fa-solid fa-angle-left"></i>
            <ul class="carousel">
               <?php foreach ($livres as $livre): ?>
                  <li class="card" onclick="window.location.href='pages/livres/livre.php?id=<?= $livre['id_book'] ?>'">
                     <div class="img">
                        <img src="../../assets/img/books/default_bookImg.png" alt="img" draggable="false">
                     </div>

                     <h2  class="bookTitle"><?= $livre['title_VF']; ?></h2>
                     <span><?php echo  $livre['auth_name'] . ' ' . $livre['auth_lastname']?></span>
                     
                  </li>
               <?php endforeach; ?>
            </ul>
            <i id="right" class="fa-solid fa-angle-right"></i>
         </div>
      </section>

      <!-- Code des discussions -->

      <section class="forum">
         <h2 class="h2Style">Derniers messages du forum</h2>
         <div class="forumFlexbox">
            <?php foreach ($posts as $post): ?>
               <a href="<?php echo 'pages/Forum/posts.php?id=' . $post['id_discu'] ?>">
                  <div class="comment">
                     <div class="commentHeader">
                        <img src=<?php echo "assets/img/profilPic/" . $post['profile_pic']?> alt="pp" />
                        <h3><?php echo '@' . $post['username']?></h3>
                        <p><?php $timestamp = $post['post_date'];
                       include $rootPath . 'includes/format_time.php'; ?></p>
                     </div>
                     <hr>
                     <div id="postContent" class="commentContent">
                        <h4><?php echo $post['name']?></h4>
                        <p><?php echo $post['content']?></p>
                     </div>
                  </div>
               </a>
            <?php endforeach; ?>
      </section>

      <h2 class="h2Style">Dernières critiques</h2>
      <section class="criticNotes">
         <?php foreach ($reviews as $review): ?>
            <a href="<?php echo 'pages/livres/livre.php?id=' . $review['id_book'] ?>">
               <div class="comment2">
                  <h4 class="book_title_review"><?= $review['title']?></h4>
                  <div class="commentHeader2">
                     <img src=<?php echo "assets/img/profilPic/" . $review['profile_pic']?> alt="pp" />
                     <h3><?php echo '@' . $review['username']?></h3>
                     <p><?php echo $review['post_date']?></p>
                  </div>
                  <div class="commentContent2">
                     <?php printStarRating($review['rating']) ?>
                     <p><?= $review['comment'] ?>
                     </p>
                  </div>
               </div>
            </a>
         <?php endforeach; ?>
      </section>
      <script>
      //cut off the long messages
      title = document.querySelectorAll('.bookTitle');
      title.forEach(function(h2) {
         if (h2.innerHTML.length > 26) {
            h2.textContent = h2.textContent.substring(0, 26) + ' ...';
         }
      });
      </script>
   </main>

   <!-- FOOTER INCLUDE -->
   <?php
   include $rootPath . 'includes/footer.php';
   ?>
</body>

</html>