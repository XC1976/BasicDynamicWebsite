<?php

if (!isset($_POST['word']) || empty($_POST['word'])) {
    header('location: ../../banWords.php?message=Veuillez saisir un mot.');
    exit;
}

$word = $_POST['word'];
$word = htmlspecialchars($word);

include("../../../includes/db.php");

$q = 'SELECT word FROM BAN_WORD;';
$req = $pdo->prepare($q);
$req->execute();
$result = $req->fetchAll(PDO::FETCH_COLUMN);


$pattern = '/^' . preg_quote($word, '/') . '$/i';

foreach ($result as $existingWord) {
    if (preg_match($pattern, $existingWord)) {
        header('location: ../../banWords.php?message=Le mot existe déjà dans la base de données.');
        exit;
    }
}

$q = 'INSERT INTO BAN_WORD (word) VALUES (:word);';
$req = $pdo->prepare($q);
$req->execute(['word' => $word]);

header('location: ../../banWords.php?message=ajouté avec succès.');
exit;
?>
