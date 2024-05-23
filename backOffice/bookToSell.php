<?php
include 'scripts/php/init.php';
 
            if (!isset($_GET['book']) || !is_numeric($_GET['book'])) { 
                header('location: marketplace.php?message=Article introuvable.');
                exit;
            }
                include('../includes/db.php');

                $q = "SELECT id_bookToSell, book_name, main_img_name, username, price, state, DATE_FORMAT(date_book, '%d/%m/%Y') AS date, description FROM BookToSell JOIN USER ON id_user = seller_user WHERE id_bookToSell = :id;";
                $req = $pdo->prepare($q);
                $req->execute(['id' => $_GET['book']]);
                $book = $req->fetch(PDO::FETCH_ASSOC);
                
                if (!$book) { 
                    header('location: marketplace.php?message=L\'article n\'existe pas.');
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

    <link rel="stylesheet" href="../assets/css/pageSpecific/bookToSell.css">

    <title>Book to sell page</title>
</head>
<body>
<?php include('../includes/navbar_back.php');
?>

<main>

<div class="title-container">
                    <h1><?php echo $book['book_name']; ?></h1>
                </div>

<div class = "outer-container">
    <div class = "container">
        <div class = "containerRows">
            <div class = "img-container">
                <img class ="imgBook" src='../assets/img/books/<?php echo $book['main_img_name']; ?>'>
            </div>
            <div class = "productInfo">
                <div class  ="detailsProduct">
                <div>
                    <p>mis en ligne par</p>
                    <p class = "info"><?php echo $book['username']; ?></p>
                </div>
                <div>
                    <p>le</p>
                    <p class = "info"><?php echo $book['date']; ?></p>
                </div>
                <div>
                    <p>état</p>
                    <p class = "info"><?php if ($book['book_name'] == 1) { echo 'bon';} else { echo 'usé';} ?></p>
                </div>
                <div>
                    <p>prix</p>
                    <p class = "info"><?php echo $book['price']; ?>€</p>
                </div>
            </div>
            </div>
        </div>

        <div class = "containerRows">
            <p id = "desc"><?php echo $book['description']; ?></p>
        </div>

        <div class = "containerRows"><a href = "scripts/php/deleteBookToSell.php?book=<?php echo $book['id_bookToSell']; ?>" class ="btn">Supprimer</a></div>
    </div>

</div>







</main>

</body>
</html>