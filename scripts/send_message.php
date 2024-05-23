<?php
session_start();
$rootPath = "../";

include $rootPath . 'includes/db.php';
//getting dest user id
if (!isset($_SESSION['selected_dest']) && empty($_SESSION['selected_dest'])) {
    echo 'pas de id_dest';
    exit(1);
}
$id_dest = $_SESSION['selected_dest'];

//getting post content
if (!isset($_POST['content']) || empty($_POST['content'])) {
    echo 'pas de content';
    exit(1);
}
$content = $_POST['content'];


//getting user id
if (!isset($_SESSION['id_user']) || empty($_SESSION['id_user'])) {
    echo 'pas connecté';
    exit(1);
}
$id_user = $_SESSION['id_user'];

date_default_timezone_set('Europe/Paris');
$time = date('Y-m-d H:i:s');



$query = "INSERT INTO MESSAGE (content, destinataire, sent_date, seen_state, id_user)
        VALUES (:content, :id_dest, :time, FALSE, :id_user);
        ";
$request = $pdo->prepare($query);
$request->bindParam(":content", $content);
$request->bindParam(":id_dest", $id_dest);
$request->bindParam(":time", $time);
$request->bindParam(":id_user", $id_user);
$request->execute();
$res = $request->fetchAll(PDO::FETCH_ASSOC);




//echo 200 si tout est okay
