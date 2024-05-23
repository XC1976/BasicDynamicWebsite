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
           username AS name,
           profile_pic
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

//=== adding type information
foreach($res_usr as &$npc) {
   $npc['type'] = 'utilisateur';
}
unset($npc);
//=== searching for books
$search = '%' . $search;
$query="SELECT 
           BOOK.id_book, 
           BOOK.title_VF AS name
        FROM 
           BOOK 
        INNER JOIN 
           AUTHOR ON BOOK.author = AUTHOR.id_author
        WHERE
            BOOK.title_VF LIKE :search
        LIMIT
           5;
        ";

$request = $pdo->prepare($query);
$request->bindParam(":search", $search);
$request->execute();
$res_books = $request->fetchAll(PDO::FETCH_ASSOC);

//=== adding type information
foreach($res_books as &$book) {
   $book['type'] = 'livre';
}
unset($book);

$res = array_merge($res_usr, $res_books);

//var_dump($res);
echo json_encode($res);
