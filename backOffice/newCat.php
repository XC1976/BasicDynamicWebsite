<?php include 'scripts/php/init.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include('scripts/php/genHeaderLinks.php'); ?>

    <!-- SPECIFIC CSS  -->
    <link rel="stylesheet" href="../assets/css/pageSpecific/editDiscu.css">

    <!-- ACTION CHANGE JS  -->
    <script src="scripts/js/changeAction.js"></script>

    <title>Nouvelle Catégorie</title>
</head>
<body>
    <?php  
        include('../includes/navbar_back.php');
        include('../includes/db.php');   
    ?>

    <main>
        <?php  
            include('scripts/php/message.php');
        ?>

        <div class="form">
            <div class="center-box">
                <div class="title-container">
                    <h1>NOUVELLE CATÉGORIE</h1>
                </div>
                <div class="form-container"> 
                    
                    <form method="post" action="scripts/php/verificationNewCat.php" id="Form" enctype="multipart/form-data">
                        <div class="inputRow">
                            <label for="inputName">Nom</label>
                            <input type="text" name="name" placeholder="Nom" class="input-zone" id="inputName">
                        </div>
                        
                        <div class="inputRow">
                        <label for="inputParent">Section</label>
                            <select name="parent" class="input-zone" id="inputParent">
                                <option value="Lecture">Lecture</option>
                                <option value="Communauté">Communauté</option>  
                                <option value="Accueil">Accueil</option>   
                            </select>
                        </div>

                        <div class ="buttons">
                        <button class="btn" id="submit-btn" type="submit">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
