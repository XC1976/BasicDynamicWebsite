<?php

if ( isset($_POST['word']) && !empty($_POST['word']) ) {

include('../../../includes/db.php');

$id = $_POST['word'];           

$req = $pdo->prepare("DELETE FROM BAN_WORD WHERE id__word = ?;");
$success = $req->execute([$id]);

if ($success) {
    http_response_code(201); // DELETED
} else {
    http_response_code(500); // INTERNAL_SERVER_ERROR
}


} else {

    //ERROR 
    http_response_code(400); // BAD_REQUEST 
}


?>
