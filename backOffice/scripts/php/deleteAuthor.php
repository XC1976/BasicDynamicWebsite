<?php

if (!isset($_POST['authorId']) || empty($_POST['authorId'])) {
    header('location: ../../authors.php?message=L\'élément n\'a pas pu être identifié.');
    exit;
}

include("../../../includes/db.php");

$id = $_POST['authorId'];


$deleteAuthor = " DELETE FROM AUTHOR WHERE id_author = :id;";

    $req = $pdo->prepare($deleteAuthor);
    $req->execute([
        'id' => $id,
    ]);

    if ($req->rowCount() > 0) {
        header('location: ../../Authors.php?message=Auteur supprimé avec succès.');
    } else {
        header('location: ../../AuthorEdit.php?id_author='  . $id . '&message=Erreur lors de la supression.');
    }
    exit;
?>