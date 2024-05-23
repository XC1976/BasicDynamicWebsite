<?php

include("../../../includes/db.php");

if (!isset($_POST['authorId']) || empty($_POST['authorId'])) {
    header('location: ../../authors.php?message=LOL.');
    exit;
}

$id = $_POST['authorId'];

if (!isset($_POST['name']) || empty($_POST['name']) || !isset($_POST['lastname']) || empty($_POST['lastname'])) {
    header('location: ../../editAuthor.php?id_author=' . $id . '&message=Veuillez renseigner les champs manquants.');
    exit;
}

$q = 'SELECT name, lastname FROM AUTHOR;';
$req = $pdo->prepare($q);
$req->execute();
$result = $req->fetchAll();

$name = $_POST['name'];
$lastname = $_POST['lastname'];

$name = htmlspecialchars($name);
$lastname = htmlspecialchars($lastname);

foreach ($result as $row) {
    
    $escapedName = preg_quote($row['name'], '/');
    $escapedLastname = preg_quote($row['lastname'], '/');
    
    
    $pattern = '/^' . $escapedName . '$/i';
    $patternLastname = '/^' . $escapedLastname . '$/i';
    
    if (preg_match($pattern, $name) && preg_match($patternLastname, $lastname)) {
        header('location: ../../editAuthor.php?id_author=' . $id . '&message=Auteur déjà existant.');
        exit;
    }
}

$q = 'UPDATE AUTHOR SET name = :name, lastname = :lastname WHERE id_author = :id;';
$req = $pdo->prepare($q);
$req->execute([
    'name' => $name,
    'lastname' => $lastname,
    'id' => $id
]);

$res = $req->rowCount();

if ($req->rowCount() == 1) {
    header('location: ../../editAuthor.php?id_author=' . $id . '&message=Auteur modifié avec succès.');
} else {
    header('location: ../../editAuthor.php?id_author=' . $id . '&message=Erreur lors de l\'enregistrement.');
 }
exit;

