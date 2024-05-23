<?php include 'scripts/php/init.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include('scripts/php/genHeaderLinks.php'); ?>

        <!-- SPECIFIC CSS  -->

    <link rel="stylesheet" href="../assets/css/pageSpecific/books.css">


    <title>Marketplace</title>
</head>
<body>

<?php include('../includes/navbar_back.php');
    include('../includes/db.php');
?>

<main>

<?php include('scripts/php/message.php'); ?>
<div class = "container">

    <div class = "title">
        <h1>LIVRES EN VENTE</h1>
    </div>

    <div class="allBooks">
    
    <?php


    $getAllBooks = "SELECT id_bookToSell, book_name, main_img_name, username, price FROM BookToSell JOIN USER on id_user = seller_user WHERE buyer_user IS NULL;";
    
    $req = $pdo->prepare($getAllBooks);
    $req->execute();
    $books = $req->fetchAll(); 
    
    if (!empty($books)){
        foreach ($books as $book):
    ?> 
        <div class="book" onclick="window.location.href='bookToSell.php?book=<?php echo $book['id_bookToSell']; ?>';" style="cursor:pointer;">
            <div class = "innerBook">
            <div class="img">
                <img class="cover" src="../assets/img/books/<?php echo $book['main_img_name']; ?>">
            </div>
            <div class = "para">
                <p class="title paragraph booktitle"><?php echo $book['book_name']; ?></p>
                <p class="title paragraph price"><?php echo $book['price']; ?> €</p>
                <p" class="title paragraph seller">vendu par <?php echo $book['username']; ?></p>
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