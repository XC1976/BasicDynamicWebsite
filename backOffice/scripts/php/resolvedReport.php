<?php

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('location: ../../frontPage.php?message=L\'élément n\'a pas pu être identifié.');
    exit;
}

if (!isset($_GET['table']) || empty($_GET['table'])) {
    header('location: ../../frontPage.php?message=La table n\'a pas pu être identifié.');
    exit;
}

include("../../../includes/db.php");

$id = $_GET['id'];
$table = $_GET['table'];

if ($table == 'USER') {
    $delete = "UPDATE REPORT_USER SET processing_status = 1 WHERE id_report_user = :id;";
}

if ($table == 'POST') {
    $delete = "UPDATE REPORT_POST SET processing_status = 1 WHERE id_report_post = :id;";
}

if ($table == 'REVIEW') {
    $delete = "UPDATE REPORT_REVIEW SET processing_status = 1 WHERE id_report_review = :id;";
}



    $req = $pdo->prepare($delete);
    $req->execute([
        'id' => $id,
    ]);

    if ($req->rowCount() > 0) {
        header('location: ../../frontPage.php?message=Traitement du signalement fini.');
    } else {
        header('location: ../../report_' . strtolower($table) . '.php??id='  . $id . '&message=Erreur lors de la supression.');
    }
    exit;
?>