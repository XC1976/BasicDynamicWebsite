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

    <title>edit Catégorie</title>
</head>
<body>
    <?php  
        include('../includes/navbar_back.php');
        include('../includes/db.php');   
    ?>

    <main>
        <?php  

            if (!isset($_GET['id_cat']) || empty($_GET['id_cat'])) { 
                header('location: forum.php?message=Identifiant de catégorie invalide.');
                exit;
            } else {

                $q = 'SELECT code_categorie, parent_categorie, name FROM DISCUSSION_CATEGORIE WHERE code_categorie = :id';
                $req = $pdo->prepare($q);
                $req->execute(['id' => $_GET['id_cat']]);
                $cat = $req->fetch(PDO::FETCH_ASSOC);

            
                if (!$cat) { 
                    header('location: forum.php?message=catégorie introuvable.');
                    exit;
                } else { 
                    include('scripts/php/message.php');
        ?>

        <div class="form">
            <div class="center-box">
                <div class="title-container">
                    <h1>MODIFIER LA CATÉGORIE</h1>
                </div>
                <div class="form-container"> 
                    
                    <form method="post" action="" id="Form" enctype="multipart/form-data">
                        <div class="inputRow">
                            <label for="inputName">Nom</label>
                            <input type="text" name="name" placeholder="Nom" class="input-zone" id="inputName" value="<?php echo $cat['name']; ?>">
                        </div>
                        
                        <div class="inputRow">
                        <label for="inputParent">Section</label>
                            <select name="parent" class="input-zone" id="inputParent">
                                <option value="Lecture" <?php if ('Lecture' == $cat['parent_categorie']) {echo 'selected';} ?> >Lecture</option>
                                <option value="Communauté" <?php if ('Communauté' == $cat['parent_categorie']) {echo 'selected';} ?>>Communauté</option>  
                                <option value="Accueil" <?php if ('Accueil' == $cat['parent_categorie']) {echo 'selected';} ?>>Accueil</option>   
                            </select>
                        </div>
                       
                        <input type="hidden" name="catId" value="<?= $cat['code_categorie'] ?>">

                        <!-- changeAction est une fonction JS qui change l'action du form on click-->
                        <div class ="buttons">
                        <button class="btn" id="submit-btn" onclick="changeAction('scripts/php/verificationEditCat.php')" type="submit">Enregistrer</button>
                        <button class="btn" id="delete-btn" onclick="changeAction('scripts/php/deleteCat.php')" type="submit">Supprimer</button>
                        </div>
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
