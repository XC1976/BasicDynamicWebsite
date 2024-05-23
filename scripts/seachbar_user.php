<?php
session_start();
$rootPath = "../";

include $rootPath . 'includes/db.php';

//===checking parametters =========
//getting review id
if (!isset($_POST['search']) || empty($_POST['search'])) {
    exit(1);
}
$search = $_POST['search'] . '%'; 

//=== searching for users =====
$query="SELECT 
           id_user,
           username AS name
        FROM 
           USER
        WHERE
            username LIKE :search
        LIMIT
           5;
        ";
$request = $pdo->prepare($query);
$request->bindParam(":search", $search);
$request->execute();
$res_usr = $request->fetchAll(PDO::FETCH_ASSOC);

if (empty($res_usr)) {
    $res_books = '-1';
} 
echo json_encode($res_usr);
