<?php

if ( isset($_POST['post']) && !empty($_POST['post']) ) {

include('../../../includes/db.php');

$id = $_POST['post'];           

$req = $pdo->prepare("UPDATE POST SET content = NULL WHERE id_post = ?;");
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
