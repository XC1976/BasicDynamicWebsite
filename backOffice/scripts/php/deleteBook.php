<?php

if (!isset($_POST['bookId']) || empty($_POST['bookId'])) {
    header('location: ../../books.php?message=L\'élément n\'a pas pu être identifié.');
    exit;
}

include("../../../includes/db.php");

$id = $_POST['bookId'];


$deleteBook = " DELETE FROM BOOK WHERE id_book = :id;";

    $req = $pdo->prepare($deleteBook);
    $req->execute([
        'id' => $id,
    ]);

    if ($req->rowCount() > 0) {
        header('location: ../../books.php?message=Livre supprimé avec succès.');
    } else {
        header('location: ../../bookEdit.php?id_Book='  . $id . '&message=Erreur lors de la supression.');
    }
    exit;
?>