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
    <link rel="stylesheet" href="../assets/css/pageSpecific/editNewsletter.css">

    <title>Add Newsletter</title>
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
                    <h1>NOUVELLE NEWSLETTER</h1>
                </div>
                <div class="form-container">
            
                    <form method="post" action="scripts/php/verificationAddNewsletter.php" id="Form" enctype="multipart/form-data">
                     
                    <div class="info">
    
                        <div id= "paragraphs">
                        <div class = "input-containers">
                            <label for="inputSubject">Sujet</label>
                            <textarea name="subject" placeholder="Sujet" class="input-zone" id="inputSubject" cols="20" rows="2"></textarea>
                        </div>

                        <div class = "input-containers">
                            <label for="input-containers">Paragraphe 1</label>
                            <textarea name="para1" placeholder="Paragraphe" class="input-zone" id="inputPara1" cols="60" rows="10"></textarea>
                        </div>

                        <div class = "input-containers">
                            <label for="inputPara2">Paragraphe 2</label>
                            <textarea name="para2" placeholder="Paragraphe" class="input-zone" id="inputPara2" cols="60" rows="10"></textarea>
                        </div>

                        <div class = "input-containers">
                            <label for="inputPara3">Paragraphe 3</label>
                            <textarea name="para3" placeholder="Paragraphe" class="input-zone" id="inputPara3" cols="60" rows="10"></textarea>
                        </div>
                        </div>

                    </div>

                        <button class="btn" id="submit-btn" type="submit">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
