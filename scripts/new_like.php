<?php
session_start();
$rootPath = "../";

include $rootPath . 'includes/db.php';
//getting post id
$id_post = $_POST['id_post'];
//getting user id
$id_user = $_SESSION['id_user'];

$query = "SELECT id_like FROM LIKE_POST WHERE id_user = :id_user AND id_post = :id_post;";
$request = $pdo->prepare($query);
$request->bindParam(":id_user", $id_user);
$request->bindParam(":id_post", $id_post);
$request->execute();
$res = $request->fetchAll(PDO::FETCH_ASSOC);

if (empty($res)) {
    //inserting a like
    
    $query = "INSERT INTO LIKE_POST(id_post, id_user) VALUES(:id_post, :id_user);";
    $request = $pdo->prepare($query);
    $request->bindParam(":id_post", $id_post);
    $request->bindParam(":id_user", $id_user);
    $request->execute();
} else {
    //deleting like
    $query = "DELETE FROM LIKE_POST WHERE id_user = :id_user AND id_post = :id_post;";
    $request = $pdo->prepare($query);
    $request->bindParam(":id_post", $id_post);
    $request->bindParam(":id_user", $id_user);
    $request->execute();
}

include 'like_nb.php';

