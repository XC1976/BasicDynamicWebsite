<?php

if (!isset($_POST['question']) || empty($_POST['question'])) {
    header('location: ../../addCaptcha.php?message=Champ de question vide.');
    exit;
}

if (!isset($_POST['reponse']) || empty($_POST['reponse'])) {
    header('location: ../../addCaptcha.php?message=Champ de réponse vide.');
    exit;
}

include("../../../includes/db.php");

$question = $_POST['question'];
$question = htmlspecialchars($question);

$reponse = $_POST['reponse']; 
$reponse = htmlspecialchars($reponse);


$addCaptcha = "INSERT INTO CAPTCHA (id_captcha, questions, goodAnswer) VALUES (NULL, :question, :reponse);";

$req = $pdo->prepare($addCaptcha);
$req->execute([
    'question' => $question,
    'reponse' => $reponse
]);

if ($req->rowCount() > 0) {
    header('location: ../../addCaptcha.php?message=Question ajoutée avec succès.');
} else {
    header('location: ../../addCaptcha.php?message=Erreur lors de l\'enregistrement.');
}
exit;

?>
