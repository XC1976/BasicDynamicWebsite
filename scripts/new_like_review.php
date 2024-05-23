<?php
session_start();
$rootPath = "../";

include $rootPath . 'includes/db.php';
//getting review id
if (isset($_POST['id_review']) && !empty($_POST['id_review'])) {
    $id_review = $_POST['id_review'];
}
else {
    echo 'Error : no id_review';
    exit(1);
}

//getting user id
if (isset($_SESSION['id_user']) && !empty($_SESSION['id_user'])) {
    $id_user = $_SESSION['id_user'];
}
else {
    echo 'Error : not connected';
    exit(1);
}

$query = "SELECT id_like
          FROM LIKE_REVIEW
          WHERE id_user = :id_user
          AND id_review = :id_review;
        ";
$request = $pdo->prepare($query);
$request->bindParam(":id_user", $id_user);
$request->bindParam(":id_review", $id_review);
$request->execute();
$res = $request->fetchAll(PDO::FETCH_ASSOC);



if (empty($res)) {
    //inserting a like
    
    $query = "INSERT INTO LIKE_REVIEW(id_review, id_user)
              VALUES(:id_review, :id_user);
            ";
    $request = $pdo->prepare($query);
    $request->bindParam(":id_review", $id_review);
    $request->bindParam(":id_user", $id_user);
    $request->execute();
} else {
    //deleting like
    $query = "DELETE FROM LIKE_REVIEW
              WHERE id_user = :id_user
              AND id_review = :id_review;
              ";
    $request = $pdo->prepare($query);
    $request->bindParam(":id_review", $id_review);
    $request->bindParam(":id_user", $id_user);
    $request->execute();
}

include 'like_nb_review.php';

