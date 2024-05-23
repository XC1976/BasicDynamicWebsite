<?php

if (!isset($_GET['id_discu']) || empty($_GET['id_discu'])) {
    header('location: ../../seeDiscussions.php?message=L\'élément n\'a pas pu être identifié.');
    exit;
}

if (!isset($_GET['id_cat']) || empty($_GET['id_cat'])) {
    header('location: ../../forum.php?message=catégorie non trouvée.');
    exit;
}

include("../../../includes/db.php");

$id = $_GET['id_discu'];


$deleteDiscu = " DELETE FROM DISCUSSION WHERE id_discussion = :id;";

    $req = $pdo->prepare($deleteDiscu);
    $req->execute([
        'id' => $id,
    ]);

    if ($req->rowCount() > 0) {
        header('location: ../../seeDiscussions.php?id_cat=' . $_GET['id_cat'] . '&message=Discussion supprimée avec succès.');
    } else {
        header('location: ../../seeDiscussions.php?id_cat=' . $_GET['id_cat'] . '&message=Erreur lors de la supression.');
    }
    exit;
?>