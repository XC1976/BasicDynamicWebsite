<?php 
include 'scripts/php/init.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('scripts/php/genHeaderLinks.php'); ?>
    <!-- SPECIFIC CSS  -->
    <link rel="stylesheet" href="../assets/css/pageSpecific/addCaptcha.css">
    <title>add Captcha</title>
</head>
<body>
    <?php  
        include('../includes/navbar_back.php');
        include('../includes/db.php');   
    ?>
    <main>
        <?php include('scripts/php/message.php'); ?>
        <div class="form">
            <div class="center-box">
                <div class="title-container">
                    <h1>NOUVEAU CAPTCHA</h1>
                </div>
                <div class="form-container">
                    <form method="post" action="scripts/php/verificationAddCaptcha.php" enctype="multipart/form-data">

                        <div class="inputRow">
                            <label for="inputQuestion">Nouvelle question</label>
                            <input type="text" name="question" placeholder="question" class="input-zone" id="inputQuestion">
                        </div>

                        <div class="inputRow">
                            <label for="inputReponse">Réponse associée</label>
                            <input type="text" name="reponse" placeholder="reponse" class="input-zone" id="inputReponse">
                        </div>

                        <button id="submit-btn" type="submit">Enregistrer</button>
                        
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
