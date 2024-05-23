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

// Get current challenge list
$verifyChallengeDuplicatesRequest = $pdo->prepare("SELECT enCours FROM CHALLENGE WHERE id_user = ?;");
$verifyChallengeDuplicatesRequest->execute([
    $_SESSION['id_user']
]);
$verifyChallengeDuplicates = $verifyChallengeDuplicatesRequest->fetch(PDO::FETCH_ASSOC);

$getCurrentChallengeListRequest = $pdo->prepare("SELECT CHALLENGELIST.name AS challengeName, CHALLENGELIST.date_end, CHALLENGELIST.goal_books, CHALLENGELIST.id
FROM CHALLENGELIST 
LEFT JOIN CHALLENGE ON CHALLENGELIST.id = CHALLENGE.enCours AND CHALLENGE.id_user = ?
WHERE CHALLENGE.id_challenge IS NULL;
;");
$getCurrentChallengeListRequest->execute([
    $_SESSION['id_user']
]);

$getCurrentChallengeList = $getCurrentChallengeListRequest->fetchAll(PDO::FETCH_ASSOC);


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
    <link rel="stylesheet" href="../../assets/css/pageSpecific/challenge/challengeList.css" />

    <!-- script specific to page -->
    <script src="../../assets/js/challenge/addChallenge.js" defer></script>

</head>

<body>

    <!-- ========== HEADER NAVBAR INCLUDE ============= -->
    <?php
    include $rootPath . 'includes/headerNavbar.php';
    ?>

    <main>
        <!-- Bloc de code qui apparaît seulement si une erreur avec le login -->
        <?php include $rootPath . 'includes/errorPopup.php'; ?>

        <h1>Challenges</h1>

        <!-- List all challenges -->
        <?php foreach ($getCurrentChallengeList as $challenge): ?>
            <div class="individualChallenge">
                <div>
                    <h2><?= $challenge['challengeName']; ?></h2>
                    <p>Deadline : <?= $challenge['date_end']; ?></p>
                    <span>Nombres de livres : <?= $challenge['goal_books']; ?></span>
                </div>
                <?php if (isset($_SESSION['auth']) && !empty($_SESSION['auth'])): ?>
                    <div>
                        <button onclick="addChallenge(event, <?= $challenge['id']; ?>)">Ajouter challenge</button>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

    </main>

    <!-- ========= FOOTER INCLUDE ================= -->
    <?php
    include $rootPath . 'includes/footer.php';
    ?>

    <pre>
        <?php var_dump($verifyChallengeDuplicates); ?>
    </pre>

</body>

</html>