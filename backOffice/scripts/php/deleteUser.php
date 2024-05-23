<?php

if (!isset($_POST['userId']) || empty($_POST['userId'])) {
    header('location: ../../users.php?message=L\'élément n\'a pas pu être identifié.');
    exit;
}

include("../../../includes/db.php");

$id = $_POST['userId'];


$deleteUser = "DELETE FROM USER WHERE id_user = :id;";

    $req = $pdo->prepare($deleteUser);
    $req->execute([
        'id' => $id]);

    if ($req->rowCount() > 0) {
        header('location: ../../users.php?message=Utilisateur supprimé avec succès.');
    } else {
        header('location: ../../editUser.php?id_user='  . $id . '&message=Erreur lors de la supression.');
    }
    exit;
?>