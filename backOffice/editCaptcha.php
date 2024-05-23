<?php include 'scripts/php/init.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include('scripts/php/genHeaderLinks.php'); ?>

    <!-- SPECIFIC CSS  -->
    <link rel="stylesheet" href="../assets/css/pageSpecific/editCaptcha.css">

    <!-- ACTION CHANGE JS  -->
    <script src="scripts/js/changeAction.js"></script>

    <title>edit Captcha</title>
</head>
<body>
    <?php  
        include('../includes/navbar_back.php');
        include('../includes/db.php');   
    ?>

    <main>
        <?php  
            // Si dans l'URL il n'y a pas un id valide 
            if (!isset($_GET['id_captcha']) || !is_numeric($_GET['id_captcha'])) { 
                header('location: captcha.php?message=Identifiant invalide.');
                exit;
            } else {
                // On selectionne les éléments que nous voulons display
                $q = 'SELECT id_captcha, questions, goodAnswer FROM CAPTCHA WHERE id_captcha = :id';
                $req = $pdo->prepare($q);
                $req->execute(['id' => $_GET['id_captcha']]);
                $captcha = $req->fetch(PDO::FETCH_ASSOC);

                // Dans le cas où nous n'avons pas pu trouver le captcha dans la db
                if (!$captcha) { 
                    header('location: captcha.php?message=Utilisateur introuvable.');
                    exit;
                } else { 
                    include('scripts/php/message.php');
        ?>

        <div class="form">
            <div class="center-box">
                <div class="title-container">
                    <h1>MODIFIER CAPTCHA</h1>
                </div>
                <div class="form-container"> 
                    <!-- l'action est vide car le formulaire est envoyé à 2 endroits différents en fonction de s'il s'agit d'une suppression ou d'un enregistrement -->
                    <form method="post" action="" id="Form" enctype="multipart/form-data">
                        <div class="inputRow">
                            <label for="inputQuestion">Modifier la question</label>
                            <input type="text" name="question" placeholder="question" class="input-zone" id="inputQuestion" value="<?php echo $captcha['questions']; ?>">
                        </div>
                        <div class="inputRow">
                            <label for="inputReponse">Modifier la réponse</label>
                            <input type="text" name="reponse" placeholder="reponse" class="input-zone" id="inputReponse" value="<?php echo $captcha['goodAnswer']; ?>">
                        </div>
                        <!-- id caché pour permettre au script d'action de faire les requêtes sql en fonction des id -->
                        <input type="hidden" name="captchaId" value="<?= $captcha['id_captcha'] ?>">

                        <!-- changeAction est une fonction JS qui change l'action du form on click-->
                        <button class="btn" id="submit-btn" onclick="changeAction('scripts/php/verificationEditCaptcha.php')" type="submit">Enregistrer</button>
                        <button class="btn" id="delete-btn" onclick="changeAction('scripts/php/deleteCaptcha.php')" type="submit">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
        <?php 
                }
            }
        ?> 
    </main>
</body>
</html>
