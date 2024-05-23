<?php

include("../../../includes/db.php");


if (!isset($_POST['title']) || empty($_POST['title'])) {
    header('location: ../../addBook.php?message=Veuillez saisir un titre.');
    exit;
}

if (!isset($_POST['author']) || empty($_POST['author'])) {
    header('location: ../../addBook.php?message=Veuillez saisir l\'identité de l\'auteur correctement.');
    exit;
}

if (!isset($_POST['langue']) || empty($_POST['langue'])) {
    header('location: ../../addBook.php?message=Veuillez préciser la langue de la VO.');
    exit;
}


if (!isset($_POST['date']) || empty($_POST['date'])) {
    header('location: ../../addBook.php?message=Veuillez saisir la date de publication.');
    exit;
}

if (!isset($_POST['genre']) || empty($_POST['genre'])) {
    header('location: ../../addBook.php?message=Veuillez saisir un genre.');
    exit;
}



// variables 
$title = $_POST['title'];
$lang = $_POST['langue'];
$date = $_POST['date'];
$synopsis = '';
$pic = 'default_bookImg.png';

$lang = htmlspecialchars($lang);
$title = htmlspecialchars($title);

$author = explode(' ', $_POST['author']);
$name = $author[0]; // "Jane"
$name = htmlspecialchars($name);
$lastname = $author[1]; // "Austen"
$lastname = htmlspecialchars($lastname);


if(isset($_POST['synopsis']) && !empty($_POST['synopsis'])) {
    $synopsis = $_POST['synopsis'];
    $synopsis = htmlspecialchars($synopsis);
}

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    // checks if the file is in the right format
    $accepted = ['image/jpeg', 'image/gif', 'image/png'];
    if (!in_array($_FILES['image']['type'], $accepted)) {
            header('location: ../../addBook.php?message=type de fichier incorrect !!!!');
            exit;
        }
    // checks if the file isn't too heavy
    $max_size = 1024 * 1024 * 2; // 2Mo
    if ($_FILES['image']['size']> $max_size) {
        header('location: ../../addBook.php?message=le fichier ne doit pas dépasser 2Mo.');
            exit;
        }
    // at this point, let's save the file to the profilPic directory and give it a unique name
    $array = explode('.', $_FILES['image']['name']);
    $ext = end($array);
    $pic = 'image-' . time() . '.' . $ext;
    $from = $_FILES['image']['tmp_name'];
    $to = '../../../assets/img/books/' . $pic;
    move_uploaded_file($from, $to);
}



$addUser = "INSERT INTO BOOK(title_VF, synopsis, release_date, cover_img, lang, genre, author)
            VALUES(:title, :synopsis, :date, :pic, :lang, (SELECT id_genre FROM GENRE WHERE name= :genre), (SELECT id_author FROM AUTHOR WHERE name= :name AND lastname = :lastname) );";

$req = $pdo->prepare($addUser);

// binding the rest of the parameters
$req->bindParam('title', $title);
$req->bindParam('synopsis', $synopsis);
$req->bindParam('date', $date);
$req->bindParam('pic', $pic);
$req->bindParam('lang', $lang);
$req->bindParam('genre', $genre);
$req->bindParam('name', $name);
$req->bindParam('lastname', $lastname);


$req->execute();

$res = $req->rowCount();

if ($req->rowCount() == 1) {
    header('location: ../../addBook.php?message=Livre ajouté avec succès.');
} else {
    header('location: ../../addBook.php?message=Erreur lors de l\'enregistrement.');
 }
exit;


