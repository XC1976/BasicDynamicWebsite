<?php
include("../../../includes/db.php");

function generateUniqueId($length = 5) {
    // Liste des caractères possibles
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $uniqueId = '';

    // Générer la chaîne de caractères
    for ($i = 0; $i < $length; $i++) {
        $uniqueId .= $characters[rand(0, $charactersLength - 1)];
    }

    return $uniqueId;
}


if (!isset($_POST['name']) || empty($_POST['name'])) {
    header('location: ../../newCat.php?message=Champ de nom vide.');
    exit;
}

if (!isset($_POST['parent']) || empty($_POST['parent'])) {
    header('location: ../../newCat.php?message=Veuillez renseigner la section.');
    exit;
}

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

$id = generateUniqueId();

$q = 'INSERT INTO DISCUSSION_CATEGORIE(code_categorie, name, parent_categorie) VALUES(:id, :name, :parent);';
$req = $pdo->prepare($q);
$req->execute([
    'id' => $id,
    'name' => $name,
    'parent' => $parent
]);

if ($req->rowCount() == 1) {
    header('location: ../../forum.php?message= Catégorie crée avec succès.');
} else {
    header('location: ../../forum.php?message=Erreur lors de l\'enregistrement.');
}
exit;



?>