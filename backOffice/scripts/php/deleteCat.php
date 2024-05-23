<?php

if (!isset($_POST['catId']) || empty($_POST['catId'])) {
    header('location: ../../forum.php?message=L\'élément n\'a pas pu être identifié.');
    exit;
}

include("../../../includes/db.php");

$id = $_POST['catId'];


$deleteCat = "DELETE FROM DISCUSSION_CATEGORIE WHERE code_categorie = :id;";

    $req = $pdo->prepare($deleteCat);
    $req->execute([
        'id' => $id]);

    if ($req->rowCount() > 0) {
        header('location: ../../forum.php?message=Catégorie supprimé avec succès.');
    } else {
        header('location: ../../editCat.php?id_Cat=' . $id . '&message=Erreur lors de la supression.');
    }
    exit;
?>