<?php
session_start();

// Relative path to root "/"
// ========== PLEASE ADD A "/" AT THE END ! ========== 
$rootPath = '../../';
// Name of the document
$DocumentTitle = 'Inscriptions';

// Path to DB
require $rootPath . 'includes/db.php';
// Path to tracking
require $rootPath . 'scripts/log_tracking.php';

/*
    Select a random captcha question
*/
$randomCaptchaQuestionRequest = $pdo->prepare('SELECT id_captcha, questions, goodAnswer FROM CAPTCHA order by RAND() LIMIT 1');
$randomCaptchaQuestionRequest->execute();

// Store these information
$randomCaptchaQuestion = $randomCaptchaQuestionRequest->fetch(PDO::FETCH_ASSOC);

// Store informations in Session
$_SESSION['id_captcha'] = $randomCaptchaQuestion['id_captcha'];
$_SESSION['questions'] = $randomCaptchaQuestion['questions'];
$_SESSION['goodAnswer'] = $randomCaptchaQuestion['goodAnswer'];

?>
<!DOCTYPE html>

<head>
    <title>
        <?= $DocumentTitle; ?>
    </title>
    <meta charset="UTF-8">
    <meta title="Connection">
    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- ====== BASIC CSS AND JS FOR NAVBAR, FOOTER, AND style.css ======= -->
    <?php include $rootPath . 'includes/head.php'; ?>

    <!-- Page specific CSS -->
    <link rel="stylesheet" href="../../assets/css/pageSpecific/inscriptionSpecific.css">
</head>

<body">

    <!-- ========== HEADER NAVBAR INCLUDE ============= -->
    <?php
    include $rootPath . 'includes/headerNavbar.php';
    ?>

    <main class="mainSpecific">

        <!-- Code qui apparaît que pour afficher une erreur si problème -->
        <?php if (isset ($_GET['message']) && !empty ($_GET['message'])): ?>
            <div class="errorMsg">
                <p>
                    <?= $_GET['message'] ?>
                </p>
                <form action="../../scripts/errorMsgDeletion.php?currentPagePath=<?= $rootPath . 'pages/Inscription/inscription.php'; ?>"
                    method="POST">
                    <button type="submit" name="validate"><img src="<?= $rootPath . 'assets/img/closeButton.png'; ?>"
                            alt="Close popup button"></button>
                </form>
            </div>
        <?php endif; ?>

        <form method="POST" action="../../scripts/inscription_verify.php">
            <div class="container">
                <div class="name">
                    <input type="text" name="name" placeholder="Prénom" value="<?php if (isset($_SESSION['name'])) { echo htmlspecialchars($_SESSION['name']);}?>">
                    <input type="text" name="lastname" placeholder="Nom" value="<?php if (isset($_SESSION['lastname']))  { echo htmlspecialchars($_SESSION['lastname']);}?>">
                </div>

                <div class="userTypeChoice">
                    <div class="user">
                        <input type="radio" id="user" name="status" value="utilisateur" checked />
                        <label for="utilisateur">Utilisateur</label>
                    </div>
                    <div class="author">
                        <input type="radio" id="author" name="status" value="auteur" />
                        <label for="author">Auteur</label>
                    </div>
                    <input type="text" placeholder="Nom d'utilisateur" name="username" value="<?php if (isset($_SESSION['username']))  { echo htmlspecialchars($_SESSION['username']);}?>" class="inputFlex">
                </div>

                <input type="email" name="email" placeholder="Email" value="<?php if (isset($_SESSION['email'])){ echo htmlspecialchars($_SESSION['email']);}?>">
                <input type="password" name="password" placeholder="Mot de passe" >
                <input type="date" name="birthdate" placeholder="Date de naissance" value="<?php if (isset($_SESSION['birthdate'])) { echo htmlspecialchars($_SESSION['birthdate']);}?>">

                <div class="captchaDiv">
                    <h2>Captcha</h2>
                    <h3>
                        <?= $randomCaptchaQuestion['questions']; ?>
                    </h3>
                    <label>Réponse :</label>
                    <input type="text" name="answerCaptcha">
                </div>

                <input type="submit" value="S'inscrire" name="validate" class="validate">
            </div>
        </form>


        <!-- ========= FOOTER INCLUDE ================= -->
        <?php
    include $rootPath . 'includes/footer.php';
    ?>

    </main>

    </body>