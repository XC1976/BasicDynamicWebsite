<?php

if (!isset($_POST['captchaId']) || empty($_POST['captchaId'])) {
    header('location: ../../captcha.php?message=L\'élément n\'a pas pu être identifié.');
    exit;
}

include("../../../includes/db.php");

$id = $_POST['captchaId'];


$deleteCaptcha = "DELETE FROM CAPTCHA WHERE id_captcha = :id;";

    $req = $pdo->prepare($deleteCaptcha);
    $req->execute([
        'id' => $id]);

    if ($req->rowCount() > 0) {
        header('location: ../../captcha.php?message=Captcha supprimé avec succès.');
    } else {
        header('location: ../../editCaptcha.php?id_captcha=' . $id . '&message=Erreur lors de la supression.');
    }
    exit;
?>