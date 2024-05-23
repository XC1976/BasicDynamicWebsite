<?php

if (!isset($_POST['catId']) || empty($_POST['catId'])) {
    header('location: ../../editCat.php?message=L\'élément n\'a pas pu être identifié.');
    exit;
}

$id = $_POST['catId'];

if (!isset($_POST['name']) || empty($_POST['name'])) {
    header('location: ../../editCat.php?id_cat=' . $id . '&message=Champ de nom vide.');
    exit;
}

if (!isset($_POST['parent']) || empty($_POST['parent'])) {
    header('location: ../../editCat.php?id_cat=' . $id . '&message=Veuillez renseigner la section.');
    exit;
}

include("../../../includes/db.php");

$name = $_POST['name'];
$parent = $_POST['parent'];

$q = 'SELECT name FROM DISCUSSION_CATEGORIE;';
$req = $pdo->prepare($q);
$req->execute();
$result = $req->fetchAll(PDO::FETCH_COLUMN);


$pattern = '/^' . preg_quote($name, '/') . '$/i';

foreach ($result as $existingName) {
    if (preg_match($pattern, $existingName)) {
        header('location: ../../newCat.php?message=Catégorie déjà existante.');
        exit;
    }
}

$editCat = "UPDATE DISCUSSION_CATEGORIE SET name = :name, parent_categorie = :parent WHERE code_categorie = :id;";

$req = $pdo->prepare($editCat);
$req->execute([
    'name' => $name,
    'parent' => $parent,
    'id' => $id
]);

if ($req->rowCount() == 1) {
    header('location: ../../editCat.php?id_cat=' . $id . '&message= Catégorie modifiée avec succès.');
} else {
    header('location: ../../editCat.php?id_cat=' . $id . '&message=Erreur lors de l\'enregistrement.');
}
exit;

?>
