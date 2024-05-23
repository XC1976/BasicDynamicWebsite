<?php

include("../../../includes/db.php");


if (!isset($_POST['name']) || empty($_POST['name']) || !isset($_POST['lastname']) || empty($_POST['lastname'])) {
    header('location: ../../addAuthor.php?message=Veuillez renseigner les champs manquants.');
    exit;
}
$q = 'SELECT name, lastname FROM AUTHOR;';
$req = $pdo->prepare($q);
$req->execute();
$result = $req->fetchAll();

$name = $_POST['name'];
$name = htmlspecialchars($name);
$lastname = $_POST['lastname'];
$lastname = htmlspecialchars($lastname);

foreach ($result as $row) {
    // Échapper les caractères spéciaux
    $escapedName = preg_quote($row['name'], '/');
    $escapedLastname = preg_quote($row['lastname'], '/');
    
    // Construire le motif de recherche insensible à la casse
    $pattern = '/^' . $escapedName . '$/i';
    $patternLastname = '/^' . $escapedLastname . '$/i';
    
    // Vérifier si $_POST['name'] ou $_POST['lastname'] correspondent à un élément de $result
    if (preg_match($pattern, $name) && preg_match($patternLastname, $lastname)) {
        header('location: ../../addAuthor.php?message=Auteur déjà existant.');
        exit;
    }
}

$q = 'INSERT INTO AUTHOR(name, lastname) VALUES (:name, :lastname);';
$req = $pdo->prepare($q);
$req->execute([
    'name' => $name,
    'lastname' => $lastname
]);

$res = $req->rowCount();

if ($req->rowCount() == 1) {
    header('location: ../../addAuthor.php?message=Auteur ajouté avec succès.');
} else {
    header('location: ../../addAuthor.php?message=Erreur lors de l\'enregistrement.');
 }
exit;

