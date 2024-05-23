<?php

if (!isset($_GET['book']) || empty($_GET['book'])) {
    header('location: ../../marketplace.php?message=L\'élément n\'a pas pu être identifié.');
    exit;
}

include("../../../includes/db.php");

$id = $_GET['book'];


$deleteBook = " DELETE FROM BookToSell WHERE id_bookToSell = :id;";

    $req = $pdo->prepare($deleteBook);
    $req->execute([
        'id' => $id,
    ]);

    if ($req->rowCount() > 0) {
        header('location: ../../marketplace.php?message=Article supprimé avec succès.');
    } else {
        header('location: ../../bookToSell.php?book='  . $id . '&message=Erreur lors de la supression.');
    }
    exit;
?>