<?php 
include 'scripts/php/init.php';
 
include('../includes/navbar_back.php');
include('../includes/db.php');   
            
            if (!isset($_GET['id_author'])) { 
                header('location: authors.php?message=Identifiant invalide.');
                exit;
            } 
                // On selectionne les éléments que nous voulons display
                $q = 'SELECT id_author, name, lastname FROM AUTHOR WHERE id_author = :id';
                $req = $pdo->prepare($q);
                $req->execute(['id' => $_GET['id_author']]);
                $author = $req->fetch(PDO::FETCH_ASSOC);

                if (!$author) { 
                    header('location: authors.php?message=Auteur introuvable.');
                    exit;
                }
        ?>

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

    <title>edit Author</title>
</head>
<body>

    <main>
    <?php include('scripts/php/message.php'); ?>
        <div class="form">
            <div class="center-box">
                <div class="title-container">
                    <h1>MODIFIER L'AUTEUR</h1>
                </div>
                <div class="form-container"> 
    
                    <form method="post" action="" id="Form" enctype="multipart/form-data">
                        <div class="inputRow">
                            <label for="inputName">Modifier le nom</label>
                            <input type="text" name="name" placeholder="prénom" class="input-zone" id="inputName" value="<?php echo $author['name']; ?>">
                        </div>
                        <div class="inputRow">
                            <label for="inputLastname">Modifier la réponse</label>
                            <input type="text" name="lastname" placeholder="nom" class="input-zone" id="inputLastname" value="<?php echo $author['lastname']; ?>">
                        </div>

                        <input type="hidden" name="authorId" value="<?= $author['id_author'] ?>">

                        <button class="btn" id="submit-btn" onclick="changeAction('scripts/php/verificationEditAuthor.php')" type="submit">Enregistrer</button>
                        <button class="btn" id="delete-btn" onclick="changeAction('scripts/php/deleteAuthor.php')" type="submit">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
        <?php 

        ?> 
    </main>
</body>
</html>
