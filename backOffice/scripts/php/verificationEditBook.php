<?php


if (!isset($_POST['bookId']) || empty($_POST['bookId'])) {
    header('location: ../../books.php?message=L\'élément n\'a pas pu être identifié.');
    exit;
}

$id = $_POST['bookId'];

if (!isset($_POST['title']) || empty($_POST['title'])) {
    header('location: ../../bookEdit.php?' . $id . 'message=Champ de titre vide.');
    exit;
}

if (!isset($_POST['author']) || empty($_POST['author'])) {
    header('location: ../../editBook.php?message=Veuillez saisir l\'identité de l\'auteur correctement.');
    exit;
}

if (!isset($_POST['date']) || empty($_POST['date'])) {
    header('location: ../../bookEdit.php?' . $id . 'message=Champ de date vide.');
    exit;
}

if (!isset($_POST['synopsis']) || empty($_POST['synopsis'])) {
    header('location: ../../bookEdit.php?' . $id . 'message=Champ de synopsis vide.');
    exit;
}

include("../../../includes/db.php");

$title = $_POST['title']; 
$date = $_POST['date']; 
$synopsis = $_POST['synopsis'];

$title = htmlspecialchars($title);
$synopsis = htmlspecialchars($synopsis);



$author = explode(' ', $_POST['author']);
$name = $author[0]; // "Jane"
$name = htmlspecialchars($name);

$lastname = implode(' ', array_slice($author, 1)); // "Austen Smith"
$lastname = htmlspecialchars($lastname);



if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {

    $array = explode('.', $_FILES['image']['name']); 
    $ext = end($array); 
    $file_name = 'image-' . time() . '.' . $ext;
    $from = $_FILES['image']['tmp_name']; 
    $to = '../../../assets/img/books/' . $file_name; 

    move_uploaded_file($from, $to);

    $editBook = "UPDATE BOOK SET title_VF = :title, release_date = :date, cover_img = :img, synopsis = :text WHERE id_Book = :id;
                 UPDATE BOOK SET author = (SELECT id_author FROM AUTHOR WHERE name = :name AND lastname = :lastname) WHERE id_book = :id;";
} else {
    // Si aucune nouvelle image n'est téléchargée, conserve l'image existante
    $editBook = "UPDATE BOOK SET title_VF = :title, release_date = :date, synopsis = :text WHERE id_Book = :id;
                UPDATE BOOK SET author = (SELECT id_author FROM AUTHOR WHERE name = :name AND lastname = :lastname) WHERE id_book = :id;";
}

$req = $pdo->prepare($editBook);
$req->execute([
    'title' => $title,
    'date' => $date,
    'img' => $file_name ?? null, // Utilisez la nouvelle image si elle existe, sinon null
    'text' => $synopsis,
    'id' => $id,
    'name' => $name,
    'lastname' => $lastname,
    'id' => $id
]);


$results = $req->fetchAll(PDO::FETCH_ASSOC);
var_dump($results);


    if (empty($results)) {
        header('location: ../../bookEdit.php?id_book=' . $id . '&message=Livre modifiée avec succès.');
    } else {
        header('location: ../../bookEdit.php?id_book=' . $id . '&message=Erreur lors de l\'enregistrement.');
    }
    exit;
?>