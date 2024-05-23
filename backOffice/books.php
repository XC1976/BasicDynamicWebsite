<?php
include 'scripts/php/init.php'; 
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <?php include('scripts/php/genHeaderLinks.php');?>

                 <!-- SPECIFIC CSS  -->

    <link rel = "stylesheet" href = "../assets/css/pageSpecific/books.css">
    <title>Books</title>
</head>
<body>

<?php
       include('../includes/navbar_back.php');
       include('../includes/db.php');   
?>

<main>

<?php include('scripts/php/message.php'); ?>
<div class = "container">
    
    <div class = "title">
        <h1>LIVRES</h1>
        <a href="addBook.php">AJOUTER UN LIVRE</a>
    </div>

    <div class="allBooks">

    <?php
    $getAllBooks = "SELECT id_book, title_VF, cover_img FROM BOOK;";
    
    $req = $pdo->prepare($getAllBooks);
    $req->execute();
    $books = $req->fetchAll();      
    
    if (!empty($books)){
        foreach ($books as $book):
    ?> 
        <div class="book" onclick="window.location.href='bookEdit.php?id_book=<?php echo $book['id_book']; ?>';" style="cursor:pointer;">
        <div class = "innerBook">
            <div class="img">
                <img class="cover" src="../assets/img/books/<?php echo $book['cover_img']; ?>">
            </div>
            <div class = "para">
                <p class="title"><?php echo $book['title_VF']; ?></p>
            </div>
            </div>
        </div>
    <?php 
        endforeach;
    } 
    ?>
</div>



</div>

</main>
    
</body>
</html>