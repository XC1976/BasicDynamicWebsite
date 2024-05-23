<?php
session_start();

// Relative path to root "/"
// ========== PLEASE ADD A "/" AT THE END ! ========== 
$rootPath = '../../';

// Path to DB
require $rootPath . 'includes/db.php';
// Path to tracking
require $rootPath . 'scripts/log_tracking.php';

// Script specific to page
require '../../scripts/profilPic_script.php';

//==== current page link
$page_link = $_SERVER['PHP_SELF'] . '?id=' . $_GET['id'];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil de @<?= $userUsername; ?></title>

    <!-- ===== CSS code specific to the page ====== -->
    <link rel="stylesheet" href="../../assets/css/pageSpecific/profil.css">

    <!-- ====== BASIC CSS AND JS FOR NAVBAR, FOOTER, AND style.css ======= -->
    <?php include $rootPath . 'includes/head.php'; ?>

    <script src="<?= $rootPath . 'assets/js/marketplace/ongletProfilePic.js'; ?>" defer></script>
    <script src="<?= $rootPath . 'assets/js/forum_new_post.js'; ?>" defer></script>

    <!-- Script specific to page -->
    <script src="<?= $rootPath . 'assets/js/profilPage/followUnfollow.js' ?>" defer></script>

</head>

<body>
    <!-- ========== HEADER NAVBAR INCLUDE ============= -->
    <?php
    include $rootPath . 'includes/headerNavbar.php';
    ?>

    <!--==================== CHANGE USERNAME ====================-->
    <div class="login" id="usernameReset">
        <form action="<?= $rootPath . 'scripts/profilPage/resetUsername.php'; ?>" class="login__form" method="POST">
            <h2 class="login__title">Modifier informations utilisateur</h2>

            <div class="login__group">
                <div>
                    <label for="email" class="login__label">Pseudo</label>
                    <input type="text" placeholder="Écrivez votre nouveau pseudo" class="login__input" name="username"
                        required>
                </div>
                <div>
                    <label for="email" class="login__label">Email</label>
                    <input type="email" placeholder="Écrivez votre nouvel email" class="login__input" name="email"
                        required>
                </div>
                <div>
                    <label for="email" class="login__label">Nom</label>
                    <input type="text" placeholder="Écrivez votre nouveau nom" class="login__input" name="lastName"
                        required>
                </div>
                <div>
                    <label for="email" class="login__label">Prénom</label>
                    <input type="text" placeholder="Écrivez votre nouveau prénom" class="login__input" name="firstName"
                        required>
                </div>
                <div>
                    <label for="email" class="login__label">Biographie</label>
                    <input type="text" placeholder="Écrivez votre nouvelle biographie" class="login__input" name="bio"
                        required>
                </div>
            </div>

            <div>
                <button type="submit" class="login__button" name="validate">Modifier</button>
            </div>

            <a href="<?= $rootPath . 'backOffice/users.php' ?>" class="nav__link">Admin</a>

        </form>

        <i class="ri-close-line login__close" id="username-close"></i>
    </div>

    <main class="MainSpecificProfile">

        <!-- Bloc de code qui apparaît seulement si une erreur avec le login -->
        <?php include $rootPath . 'includes/errorPopup.php'; ?>

        <div class="mainContainer">
            <div class="leftPart">
                <img src="<?= $userProfilPic; ?>" alt="Profile Pic" id="userProfilPic" />

                <?php if (isset($_SESSION['auth']) || !empty($_SESSION['auth'])): ?>
                    <?php if ($_SESSION['username'] == $_GET['username']): ?>
                        <button onclick="appearDissapear(event)" class="editPPButton">Modifier photo de profile</button>
                    <?php endif; ?>
                <?php endif; ?>

                <form action="../../scripts/profilPage/modifyProfilPicture.php" class="changePPForm" method="post"
                    enctype="multipart/form-data" id="editPPForm">
                    <label>Image (max 1MO): </label>
                    <input type="file" name="image" required>
                    <input type="submit" value="Modifier" class="submit">
                    <button onclick="deletePP(event)" class="editPPButton">Supprimer photo de profile</button>
                </form>

                <h2>
                    <?= '@' . $userUsername; ?>
                </h2>

                <ul>
                    <li>
                        <!-- Verify if number of followers < 1 to append or not an s -->
                        <?php
                        if ($numberOfFollowers <= 1) {
                            echo '<li id="followers">' . $numberOfFollowers . ' follower</li>';
                        } else {
                            echo '<li id="followers">' . htmlspecialchars(formatNombre($numberOfFollowers), ENT_QUOTES, 'UTF-8') . ' ' . (formatNombre($numberOfFollowers) == 1 ? 'follower' : 'followers') . '</li>';
                        }
                        ?>
                    </li>
                    <li>
                        <!-- Verify if number of followed < 1 to append or not an s -->
                        <?php
                        if ($numberOfPeopleFollowed <= 1) {
                            echo '<li id="suivies">' . $numberOfPeopleFollowed . ' suivi</p>';
                        } else {
                            echo '<li id="suivies">' . htmlspecialchars(formatNombre($numberOfPeopleFollowed), ENT_QUOTES, 'UTF-8') . ' ' . (formatNombre($numberOfPeopleFollowed) == 1 ? 'suivi' : 'suivis') . '</li>';
                        }
                        ?>
                    </li>
                </ul>

                <div class="bio">
                    <p>
                        <?= $usernameBio; ?>
                    </p>
                </div>
                <!-- If its own user profile, show the buttons -->
                <?php if (isset($_SESSION['auth']) || !empty($_SESSION['auth'])): ?>
                    <?php if ($_SESSION['username'] == $_GET['username']): ?>
                        <button id="username-btn" class="changeInfos">Changer vos informations</button>
                        <a href="pdfGeneration.php" target="_blank" class="generatePDF">Données utilisateur en PDF</a>
                        <a href="../Inscription/forgot-pw.php">Changer votre mot de passe</a>

                        <?php if (isset($_SESSION['admin'])): ?>
                            <?php if ($_SESSION['username'] == $_GET['username']): ?>
                                <div>
                                    <a href="<?= $rootPath . 'backOffice/users.php' ?>" style="text-decoration: underline;">Admin</a>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <div class="rightPart">
                <nav>
                    <button onclick="openTab(0)" class="btn active">Posts forum</button>
                    <button onclick="openTab(1)" class="btn">Bibliothèques</button>
                    <button onclick="openTab(2)" class="btn">Avis livres</button>
                    <button onclick="openTab(3)" class="btn">Challenges</button>

                    <!-- Verify if the follow button has to be shown -->
                    <?php if (isset($_SESSION['auth'])): ?>
                        <!-- Verify if user is connected -->
                        <?php if ($userID == $_SESSION['id_user']): ?>
                            <!-- Verify if it's the same user -->
                            <button onclick="openTab(4)" class="btn">Suivis</button>
                            <button onclick="openTab(5)" class="btn">Followers</button>
                        <?php endif; ?>

                    <?php endif; ?>
                </nav>

                <nav>
                    <!-- Verify if the follow button has to be shown -->
                    <?php if (isset($_SESSION['auth'])): ?>
                        <!-- Verify if user is connected -->
                        <?php if ($userID != $_SESSION['id_user']): ?>
                            <!-- Verify if it's the same user -->
                            <button class="<?= count($followRow) === 0 ? 'followButton' : 'unfollowButton'; ?> shrinkButton"
                                onclick="follow_user(this)">
                                <!-- Content of the button -->
                                <?= count($followRow) === 0 ? 'Follow +' : 'Unfollow -'; ?>
                            </button>
                        <?php endif; ?>

                        <input type="hidden" id="sessionID" value="<?= $_SESSION['id_user'] ?>" />
                        <input type="hidden" id="sessionID" value="<?= $_SESSION['id_user'] ?>" />

                    <?php endif; ?>

                    <!-- Almost the same but for blocked button -->

                    <?php if (isset($_SESSION['auth'])): ?>

                        <?php if ($userID != $_SESSION['id_user']): ?>

                            <button onclick="blockUser(this)"
                                class="<?= count($blockRow) === 0 ? 'blockButton' : 'unblockButton'; ?> shrinkButton">
                                <!-- Content of the button -->
                                <?= count($blockRow) === 0 ? 'Block' : 'Unblock'; ?>
                            </button>

                        <?php endif; ?>

                    <?php endif; ?>

                    <input type="hidden" id="blockedID" value="<?= $userID; ?>" />
                </nav>

                <!-- Content that will appear or disappear -->
                <section>

                    <!-- Content of post forums -->
                    <div class="tab singleReviewContainer" style="display: block;">

                        <?php foreach ($currentUserPosts as $post): ?>

                            <!-- Récupère le nombre de likes pour le post -->
                            <?php
                            $getNumberOfLikeForPostRequest = $pdo->prepare("SELECT COUNT(?) AS numberLikes FROM LIKE_POST WHERE id_post = ? ;");
                            $getNumberOfLikeForPostRequest->execute([
                                "id_like",
                                $post['id_post']
                            ]);

                            $postNumberOfLikes = $getNumberOfLikeForPostRequest->fetch(PDO::FETCH_ASSOC);
                            ?>

                            <!-- Récupère le titre de la discussion qui contient le post -->
                            <?php
                            $getDiscussionTitleRequest = $pdo->prepare("SELECT name FROM DISCUSSION WHERE id_discussion = ?");
                            $getDiscussionTitleRequest->execute([
                                $post['id_discu']
                            ]);

                            $postDiscussionTitle = $getDiscussionTitleRequest->fetch(PDO::FETCH_ASSOC);

                            // Récupère la catégorie dans laquelle a été postée le poste
                            $getDiscussionCategorieRequest = $pdo->prepare("SELECT DISCUSSION_CATEGORIE.name AS name 
                            FROM DISCUSSION_CATEGORIE INNER JOIN DISCUSSION ON DISCUSSION.categorie = DISCUSSION_CATEGORIE.code_categorie 
                            WHERE id_discussion = ?;");

                            $getDiscussionCategorieRequest->execute([
                                $post['id_discu']
                            ]);

                            $categorieDiscussionTitle = $getDiscussionCategorieRequest->fetch(PDO::FETCH_ASSOC);
                            ?>

                            <div class="singleReviewStyle">
                                <h4 class="postLink">
                                    <a href="<?= $rootPath . 'pages/Forum/posts.php?id=' . $post['id_discu']; ?>">
                                        Poste : "<?= $postDiscussionTitle['name']; ?>" dans la catégorie :
                                        <?= $categorieDiscussionTitle['name']; ?>
                                    </a>
                                </h4>
                                <p><?= $post['content']; ?></p>
                                <p class="timestampReview"><?= $post['post_date']; ?></p>
                                <div class="likeFlexbox">
                                    <button class="AimerBlock" id="<?= $post['id_post']; ?>" onclick="like_click(this)">
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
                                <?php if (isset($_SESSION['auth']) || !empty($_SESSION['auth'])): ?>
                                    <?php if ($_SESSION['username'] == $_GET['username']): ?>
                                        <div>
                                            <button onclick="deletePost(event, <?= $post['id_post']; ?>)"
                                                class="deletePostButton">Supprimer post</button>
                                            <button onclick="showTextArea(event)" class="editPostButton">Edit post</button>
                                            <form action="<?= $rootPath . 'scripts/profilPage/editPostPP.php' ?>" method="post"
                                                class="editPost">
                                                <textarea name="editPost"></textarea>
                                                <input type="submit" name="submit" value="Modifier post" class="modifPost">
                                                <input type="hidden" name="id_post" value="<?= $post['id_post']; ?>">
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>

                        <!-- Show message if no posts is found -->
                        <?php if ($currentUserPostsRow == 0): ?>
                            <h2>Vous n'avez jamais posté ! <br><a href="../Forum/accueil.php">Commencer dès maintenant
                                    !</a></h2>
                        <?php endif; ?>
                    </div>

                    <div class="tab singleReviewContainer">
                        <div class="allLibraries">

                            <!-- Add library only if own profile-->
                            <?php if (isset($_SESSION['auth']) || !empty($_SESSION['auth'])): ?>
                                <?php if ($_SESSION['username'] == $_GET['username']): ?>
                                    <div class="individualLibrary addLibs"
                                        onclick="window.location.href='../library/addLib.php';">
                                        <div class="libraryOverlay"></div>
                                        <p>Ajouter une librarie +</p>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <!-- List all libraries -->
                            <?php foreach ($getLibraries as $lib): ?>
                                <a href="<?= $rootPath . 'pages/library/lib.php?id=' . $lib['id_lib']; ?>">
                                    <div class="individualLibrary"
                                        style="background-image: url(<?= $rootPath . 'assets/img/libraries/' . $lib['library_img'] ?>);">
                                        <div class="libraryOverlay"></div>
                                        <p><?= $lib['name']; ?></p>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="tab singleReviewContainer">
                        <!-- Content of reviews book -->
                        <?php foreach ($ReviewsBook as $key => $value): ?>
                            <span class="reviewBookIndividual">
                                <div class="reviewBody">
                                    <a href="../livres/livre.php?id=<?= $ReviewsBook[$key]['idBook']; ?>">
                                        <h2>
                                            <?php if ($ReviewsBook[$key]['respond_to'] == NULL): ?>
                                                Critique du livre : <?= $ReviewsBook[$key]['bookName']; ?>
                                            <?php else: ?>
                                                <?php
                                                // Get information about the responded review
                                                $getInformationsAnswerRequest = $pdo->prepare("SELECT USER.username AS username FROM 
                                                REVIEW_BOOK JOIN USER ON REVIEW_BOOK.id_user = USER.id_user 
                                                WHERE REVIEW_BOOK.id_review = ?;");
                                                $getInformationsAnswerRequest->execute([
                                                    $ReviewsBook[$key]['respond_to'],
                                                ]);

                                                $getInformationsAnswer = $getInformationsAnswerRequest->fetch(PDO::FETCH_ASSOC);
                                                ?>

                                                <p>Réponse à "@<?= $getInformationsAnswer['username']; ?>" sur le livre :
                                                    <?= $ReviewsBook[$key]['bookName']; ?>
                                                </p>
                                            <?php endif; ?>
                                        </h2>
                                        <div>
                                            <?php for ($i = 0; $i < 5; ++$i) {
                                                if ($ReviewsBook[$key]['rating'] > $i) {
                                                    echo '<i class="fas fa-star"></i>';
                                                } else {
                                                    echo '<i class="far fa-star"></i>';
                                                }
                                            }
                                            ?>
                                        </div>
                                        <p><?= $ReviewsBook[$key]['comment']; ?></p>
                                        <span><?= $ReviewsBook[$key]['time_stamp']; ?></span>
                                    </a>
                                    <?php if (isset($_SESSION['auth'])): ?>
                                        <!-- Verify if user is connected -->
                                        <?php if ($userID == $_SESSION['id_user']): ?>
                                            <div style="margin-top: 10px;">
                                                <button onclick="deletePost2(event, <?= $ReviewsBook[$key]['id_review']; ?>)"
                                                    class="deletePostButton">Supprimer
                                                    post</button>
                                                <button onclick="showTextArea(event)" class="editPostButton">Edit post</button>
                                                <form action="<?= $rootPath . 'scripts/posts/editReviewBookPP.php' ?>" method="post"
                                                    class="editPost">
                                                    <textarea name="editPost"></textarea>
                                                    <input type="submit" name="submit" value="Modifier post" class="modifPost">
                                                    <input type="hidden" name="id_post"
                                                        value="<?= $ReviewsBook[$key]['id_review']; ?>">
                                                </form>
                                            </div>
                                        <?php endif; ?>

                                    <?php endif; ?>

                                </div>
                            </span>
                        <?php endforeach; ?>

                        <!-- Show message if no posts is found -->
                        <?php if ($reviewsBookRowCount == 0): ?>
                            <h2>Vous n'avez jamais posté ! <br><a href="../livres/biblioteque.php">Commencez dès maintenant
                                    !</a></h2>
                        <?php endif; ?>
                    </div>

                    <div class="tab singleReviewContainer">
                        <?php foreach ($getUsersChallenge as $challenge): ?>
                            <div class="individualChallenge">
                                <h2><?= $challenge['name']; ?></h2>
                                <p>Début : <?= $challenge['date_start']; ?></p>
                                <p>Fin : <?= $challenge['date_end']; ?></p>
                                <p>Objectif : <?= $challenge['goal_books']; ?> livres</p>
                                <button
                                    onclick="supprimerChallenge(event, <?= $challenge['id_challenge']; ?>)">Supprimer</button>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if (isset($_SESSION['auth']) || !empty($_SESSION['auth'])): ?>
                        <?php if ($_SESSION['username'] == $_GET['username']): ?>
                            <div class="tab singleReviewContainer">
                                <div class="suiviSection">
                                    <!-- SELECT all people we follow -->
                                    <?php
                                    $getPeopleThatWeFollowRequest = $pdo->prepare('SELECT USER.username AS username, USER.profile_pic AS profilePic, USER.id_user AS idUser FROM Follows 
                            INNER JOIN USER ON Follows.followed_user = USER.id_user WHERE Follows.following_user = ?;');
                                    $getPeopleThatWeFollowRequest->execute([
                                        $_SESSION['id_user']
                                    ]);

                                    $getPeopleThatWeFollow = $getPeopleThatWeFollowRequest->fetchAll(PDO::FETCH_ASSOC);
                                    ?>
                                    <!-- Bloc de suivi -->
                                    <?php foreach ($getPeopleThatWeFollow as $value): ?>
                                        <?php
                                        $currentFile = $_SERVER['PHP_SELF'];
                                        $newUsername = 'example_username';
                                        $relativePath = '../..' . $currentFile . '?username=' . $value['username'];
                                        ?>
                                        <div class="individualPeople">
                                            <div>
                                                <img src="<?= $rootPath . 'assets/img/profilPic/' . $value['profilePic']; ?>"
                                                    alt="Profil pic" />
                                            </div>
                                            <h2>@<?= $value['username']; ?></h2>
                                            <div>
                                                <button onclick="deleteFollowUser(event, <?= $value['idUser']; ?>)">Unfollow
                                                    -</button>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                        <?php endif; ?>
                    <?php endif; ?>


                    <?php if (isset($_SESSION['auth']) || !empty($_SESSION['auth'])): ?>
                        <?php if ($_SESSION['username'] == $_GET['username']): ?>
                            <div class="tab singleReviewContainer">
                                <div class="suiviSection">
                                    <!-- Select all people who follow us -->
                                    <?php
                                    $getPeopleWhoFollowsUsRequest = $pdo->prepare('SELECT USER.username AS username, USER.profile_pic AS profilePic, USER.id_user AS idUser 
                            FROM Follows INNER JOIN USER ON Follows.following_user = USER.id_user WHERE Follows.followed_user = ?;
                            ');

                                    $getPeopleWhoFollowsUsRequest->execute([
                                        $_SESSION['id_user']
                                    ]);
                                    $getPeopleWhoFollowsUs = $getPeopleWhoFollowsUsRequest->fetchAll(PDO::FETCH_ASSOC);
                                    ?>

                                    <!-- Bloc de suivi -->
                                    <?php foreach ($getPeopleWhoFollowsUs as $value): ?>
                                        <?php
                                        $currentFile = $_SERVER['PHP_SELF'];
                                        $newUsername = 'example_username';
                                        $relativePath = '../..' . $currentFile . '?username=' . $value['username'];
                                        ?>
                                        <div class="individualPeople">
                                            <div>
                                                <img src="<?= $rootPath . 'assets/img/profilPic/' . $value['profilePic']; ?>"
                                                    alt="Profil pic" />
                                            </div>
                                            <h2>@<?= $value['username']; ?></h2>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                </section>
            </div>
        </div>
    </main>

    <!-- ========= FOOTER INCLUDE ================= -->
    <?php
    include $rootPath . 'includes/footer.php';
    ?>

</body>

</html>