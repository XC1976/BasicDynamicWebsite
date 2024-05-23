<?php

if ( isset($_POST['review']) && !empty($_POST['review']) ) {

include('../../../includes/db.php');

$id = $_POST['review'];           

$req = $pdo->prepare("UPDATE REVIEW_BOOK SET comment = NULL WHERE id_review = ?;");
$success = $req->execute([$id]);

if ($success) {
    http_response_code(201);
} else {
    http_response_code(500);
}


} else {

    http_response_code(400); 
}


?>
