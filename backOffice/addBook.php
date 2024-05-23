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

    <!-- SEARCH BAR JS  -->
    <script src="scripts/js/inputAuthor.js" defer></script>
    <script src="scripts/js/searchBarValue.js" defer></script>


    <title>Add Book</title>
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
                    <h1>NOUVEAU LIVRE</h1>
                </div>
                <div class="form-container">
                    <form method="post" action="scripts/php/verificationAddBook.php" enctype="multipart/form-data">

                    <div id = "firstBox">
                        <div class="inputRow">
                            <label for="inputTitle">Titre</label>
                            <input type="text" name="title" placeholder="Titre" class="input-zone" id="inputTitle">
                        </div>

                        <div class="inputRow">
                            <label for="inputLang">Langue VO</label>
                            <input type="text" name="langue" placeholder="Langue" class="input-zone" id="inputLang">
                        </div>

                        <div class="inputRow">
                            <label for="inputDate">Date de publication</label>
                            <input type="date" name="date" placeholder="Date" class="input-zone" id="inputDate">
                        </div>

                        </div>

                    <div id ="secBox">
                        <div class="inputRow" id= "authors">
                            <div><label for="inputAuthor" class="input-zone">Auteur</label></div>
                            <input type= "text" oninput="FetchAuthorAZERTY()" placeholder= "Chercher auteur ..." name="author" id="AUTHOR" value="">
                            <ul class="" id= "authorOptions">
                            </ul>   
                        </div>

                        <div class="inputRow">
                        <div><label for="inputGenre" class="input-zone">Genre</label></div>
                            <select name="genre" id="GENRE">
                            <?php include('scripts/php/displayOptions.php');?>
                            </select>
                        </div>

                        <div class="file_selection">
                        <div><label for="inputImage" class="form-label">Couverture</label></div>
                            <input type="file" name="image" class="form-control" id="inputImage">
                        </div>

                    </div>

                    <div id ="trdBox">
                        <div class="inputRow">
                        <div><label for="inputSynopsis">Synopsis</label></div>
                            <textarea id="inputSynopsis" name="synopsis" rows="10" cols="125" placeholder= "Saisissez votre Synopsis ici"></textarea>
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