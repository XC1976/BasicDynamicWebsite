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
    <link rel="stylesheet" href="../assets/css/pageSpecific/bookEdit.css">

    <!-- ACTION CHANGE JS  -->
    <script src="scripts/js/changeAction.js" defer></script>

    <!-- SEARCH BAR JS  -->
    <script src="scripts/js/inputAuthor.js" defer></script>
    <script src="scripts/js/searchBarValue.js" defer></script>

    <title>Edit Book</title>
</head>

<body>
    
    <?php  
        include('../includes/navbar_back.php');
        include('../includes/db.php');   
    ?>

    <main>
        <?php  
            // id au bon format dans l'url 
            if (!isset($_GET['id_book']) || !is_numeric($_GET['id_book'])) { 
                //header('location: books.php?message=Identifiant invalide.');
                exit;
            } else {
                $id = $_GET['id_book'];
                
                // on cherche l'id dans la db
                $q = "SELECT BOOK.id_book, title_VF, synopsis, release_date, cover_img, name, lastname 
                      FROM BOOK 
                      JOIN AUTHOR ON BOOK.author = AUTHOR.id_author 
                      WHERE BOOK.id_book = :id;";

        
                $req = $pdo->prepare($q);
                $req->execute(['id' => $id]);
                $book = $req->fetch(PDO::FETCH_ASSOC);
                      
                // Si nous ne le trouvons pas, retour au tableau users  
                if (!$book) { 
                    // header('location: books.php?message=Utilisateur introuvable.');
                    exit;
                } else {                  
                    include('scripts/php/message.php'); 
        ?>
        <div class="form">
            <div class="center-box">
                <div class="title-container">
                    <h1>INFO SUR LE LIVRE</h1>
                    <a class ="btn" href = "reviews.php?id=<?php echo $book['id_book']; ?>">Voir les reviews</a>
                </div>
                <div class="form-container">
                    <!-- action assurée par JS en fonction du bouton cliqué-->

                    <form method="post" action="" id="Form" enctype="multipart/form-data">

                    <div class = "info">
                    <div class ="pic"> <img class="thumbnail" src="../assets/img/books/<?php echo $book['cover_img']; ?>"></div>

                    <div class = "texts">
                        <div class="inputRow">
                            <label for="inputTitle">Title</label>
                            <input name="title" placeholder="titre" class="input-zone" id="inputTitle" value = "<?php echo $book['title_VF']; ?>">
                        </div>

                        <div class="inputRow">
                            <label for="dateInput">Date</label>
                            <input type="date" name="date" placeholder="titre" class="input-zone" id="inputDate" value="<?php echo $book['release_date']; ?>">
                        </div>

                        <div class="inputRow">
                        <div><label for="inputGenre" class="input-zone">Genre</label></div>
                            <select name="genre" id="GENRE">
                            <?php include('scripts/php/displayOptions.php');?>
                            </select>
                        </div>

                        <div class="inputRow" id= "authors">
                        <div>
                            <label for="inputAuthor" class="input-zone">Auteur</label>
                        </div>
                        <input type="text" oninput="FetchAuthorAZERTY()" placeholder="Chercher auteur ..." name="author" id="AUTHOR" value="<?php echo $book['name'] . ' ' . $book['lastname']; ?>">
                            <ul class="" id= "authorOptions">
                            </ul>   
                        </div> 
                        </div>

                        </div>

                        <!-- nom de l'image en value cachée -->
                        <input type="hidden" name="photo" value="<?php echo $book['cover_img']; ?>">

                        <div class="file_selection">
                            <label for="inputImage" class="form-label">Image de profil</label>
                            <input type="file" name="image" class="form-control" id="inputImage">
                        </div>

                        <div class="inputRow">
                            <label for="inputSynopsis">Synopsis</label>
                            <textarea name="synopsis" placeholder="synopsis" class="input-zone" id="inputSynopsis" style="width: 90%; height: 300px;"><?php echo $book['synopsis']; ?></textarea>
                        </div>

                        <input type="hidden" name="bookId" value="<?php echo $book['id_book']; ?>">

                        <button class="btn" id="submit-btn" onclick="changeAction('scripts/php/verificationEditBook.php')" type="submit">Enregistrer</button>
                        <button class="btn" id="delete-btn" onclick="changeAction('scripts/php/deleteBook.php')" type="submit">Supprimer</button>
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
