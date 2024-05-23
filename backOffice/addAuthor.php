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
    <link rel="stylesheet" href="../assets/css/pageSpecific/addBook.css">


    <title>Add Author</title>
</head>
<body>

<?php  
        include('../includes/navbar_back.php');  
    ?>

<main>
        <?php include('scripts/php/message.php'); ?>
        <div class="form">
            <div class="center-box">
                <div class="title-container">
                    <h1>NOUVEL AUTEUR</h1>
                </div>
                <div class="form-container">
                    <form method="post" action="scripts/php/verificationAddAuthor.php" enctype="multipart/form-data">

                    <div id = "firstBox">
                        <div class="inputRow">
                            <label for="inputName">Prénom</label>
                            <input type="text" name="name" placeholder="Prénom" class="input-zone" id="inputName">
                        </div>

                        <div class="inputRow">
                            <label for="inputLastname">Nom</label>
                            <input type="text" name="lastname" placeholder="lastname" class="input-zone" id="inputLastname">
                        </div>

                        </div>

                        <button id="submit-btn" type="submit">Enregistrer</button>
                        
                    </form>
                </div>
            </div>
        </div>
    </main>
    
</body>
</html>