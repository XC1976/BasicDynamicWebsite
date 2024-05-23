<?php

if (!isset($_POST['captchaId']) || empty($_POST['captchaId'])) {
    header('location: ../../editCaptcha.php?message=L\'élément n\'a pas pu être identifié.');
    exit;
}

$id = $_POST['captchaId'];

if (!isset($_POST['reponse']) || empty($_POST['reponse'])) {
    header('location: ../../editCaptcha.php?' . $id . 'message=Champ de réponse vide.');
    exit;
}

if (!isset($_POST['question']) || empty($_POST['question'])) {
    header('location: ../../editCaptcha.php?' . $id . 'message=Champ de question vide.');
    exit;
}

include("../../../includes/db.php");

$question = $_POST['question'];
$reponse = $_POST['reponse']; 

$question = htmlspecialchars($question);
$reponse = htmlspecialchars($reponse);

$editCaptcha = "UPDATE CAPTCHA SET questions = :question, goodAnswer = :reponse WHERE id_captcha = :id;";

$req = $pdo->prepare($editCaptcha);
$req->execute([
    'question' => $question,
    'reponse' => $reponse,
    'id' => $id
]);

if ($req->rowCount() > 0) {
    header('location: ../../editCaptcha.php?id_captcha=' . $id . '&message=Question modifiée avec succès.');
} else {
    header('location: ../../editCaptcha.php?id_captcha=' . $id . '&message=Erreur lors de l\'enregistrement.');
}
exit;

?>
