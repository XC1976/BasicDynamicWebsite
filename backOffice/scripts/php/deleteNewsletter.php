<?php

if (!isset($_POST['NewsId']) || empty($_POST['NewsId'])) {
    header('location: ../../newsletter.php?message=L\'élément n\'a pas pu être identifié.');
    exit;
}

include("../../../includes/db.php");

$id = $_POST['NewsId'];

$deleteNews = "DELETE FROM NEWSLETTER WHERE id_nl = :id;";

$req = $pdo->prepare($deleteNews);
$req->execute(['id' => $id]);

if ($req->rowCount() > 0) {
    header('location: ../../newsletter.php?message=Newsletter supprimé avec succès.');
} else {
    header('location: ../../editNewsletter.php?id_nl=' . $id . '&message=Erreur lors de la suppression.');
}
exit;
