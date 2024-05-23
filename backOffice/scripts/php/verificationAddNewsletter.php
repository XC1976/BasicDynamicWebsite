<?php

if (!isset($_POST['subject']) || empty($_POST['subject'])) {
    header('location: ../../addNewsletter.php?message=Le sujet de la newsletter doit être renseigné.');
    exit;
}

if (strlen($_POST['subject']) > 150) {
    header('location: ../../addNewsletter.php?message=Le sujet de la newsletter ne doit pas dépasser 150 caractères.');
    exit;
}

$allEmpty= 0;

if (isset($_POST['para1']) && !empty($_POST['para1'])) {
    $allEmpty+= 1;
}

if (isset($_POST['para2']) && !empty($_POST['para2'])) {
    $allEmpty+= 1;
}

if (isset($_POST['para3']) && !empty($_POST['para3'])) {
    $allEmpty+= 1;
}


if($allEmpty === 0) {
header('location: ../../addNewsletter.php?message=Un des paragraphes doit être rempli au minimum.');
    exit;
}

if (strlen($_POST['para1']) > 1000 || strlen($_POST['para2']) > 1000 || strlen($_POST['para3']) > 1000) {
    header('location: ../../addNewsletter.php?message=Un des paragraphes ne doit pas dépasser 1000 caractères.');
    exit;
}


include("../../../includes/db.php");

$subject = $_POST['subject'];
$subject = htmlspecialchars($subject);

$para1 = "";
$para1 = "";
$para1 = "";

if (isset($_POST['para1']) || !empty($_POST['para1'])) {
    $para1 = $_POST['para1'];
    $para1 = htmlspecialchars($para1);
}

if (isset($_POST['para2']) || !empty($_POST['para2'])) {
    $para2 = $_POST['para2'];
    $para2 = htmlspecialchars($para2);
}

if (isset($_POST['para3']) || !empty($_POST['para3'])) {
    $para3 = $_POST['para3'];
    $para3 = htmlspecialchars($para3);
}

$addNewsletter = "INSERT INTO NEWSLETTER(subject, paragraph01, paragraph02, paragraph03, is_selected) VALUES (:subject, :para1, :para2, :para3, FALSE);";

$req = $pdo->prepare($addNewsletter);
$req->execute([
    'subject' => $subject,
    'para1' => $para1,
    'para2' => $para2,
    'para3' => $para3,
]);

if ($req->rowCount() == 1) {
    header('location: ../../addNewsletter.php?message=Newsletter ajoutée avec succès.');
} else {
    header('location: ../../addNewsletter.php?message=Erreur lors de l\'enregistrement.');
}
exit;

?>
