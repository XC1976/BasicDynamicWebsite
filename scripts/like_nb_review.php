<?php
//getting review id

include $rootPath . 'includes/db.php';

if (!isset($id_review) && array_key_exists('id_review', $_POST)) {
    $id_review = $_POST['id_review'];
} else if (!isset($id_review)){
    echo "Error : cannot find review id";
    exit();
}

$query = "SELECT COUNT(id_like) AS like_nb 
          FROM LIKE_REVIEW 
          WHERE id_review = :id_review;
          ";
$request = $pdo->prepare($query);
$request->bindParam(":id_review", $id_review);
$request->execute();
$like_number = $request->fetchAll(PDO::FETCH_ASSOC);

echo $like_number[0]['like_nb'];
//var_dump($like_number);
