<?php
session_start();
$rootPath = "../";
require $rootPath . 'includes/db.php';

function redirectWithError($message, $page) {
    header("Location: ..$page?&message=$message");
    $message = "";
    exit();
}

$previous_page = $_POST['previous_page'];

//checking for illegitimate access of the page
if ($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST['validate'])) {
    redirectWithError("Vous ne pouvez pas accéder a cette page", "");
}
//checking that user is connected
if (empty($_SESSION['id_user']) || !isset($_SESSION['id_user'])) {
    redirectWithError("Vous devez être connecté", "");
}
//========verifying the discussion title ================
//check for empty title
$discu_title = $_POST["title"];
if (!isset($discu_title) || empty($discu_title)) {
    $message = "Erreur : Titre vide";
    redirectWithError($message, $previous_page);
}

//check for too long title
if (strlen($discu_title) > 10000) {
    $message = "Erreur : La taille du titre est limitée à 50 caractères";
    redirectWithError($message, $previous_page);
}

//========verifying the post content ================

//it must contain something
$post_content = $_POST["discu_content"];
if (!isset($post_content) || empty($post_content)) {
    $message = "Erreur : Message vide";
    redirectWithError($message, $previous_page);
}

//it must not be too long
if (strlen($post_content) > 10000) {
    $message = "Erreur : La taille du message est limitée à 10 000 caractères";
    redirectWithError($message, $previous_page);
}

//===== getting the needed variables ======
$id_user = $_SESSION['id_user'];

$categorie = $_POST['categorie'];

$title = $_POST['title'];

// time of the message
$timestamp = date("Y-m-d H:i:s", time());

//===== insert new discu =====
$query = "INSERT INTO DISCUSSION(name, categorie, op) VALUES(:title, :categorie, :op);";

$request = $pdo->prepare($query);
$request->bindParam(":title", $title);
$request->bindParam(":categorie", $categorie);
$request->bindParam(":op", $id_user);

$request->execute();

//====== get the primary key of the new discussion
$query = "SELECT MAX(id_discussion) AS id FROM DISCUSSION WHERE name = :title;";

$request = $pdo->prepare($query);
$request->bindParam(":title", $title);;
$request->execute();
$res = $request->fetchAll(PDO::FETCH_ASSOC);
$id_discu = $res[0]['id'];

//===== insert new post =====

/*INSERT INTO POST (content, id_user, id_discu, post_date) 
VALUES ('Pour moi, la clé est de bien développer les personnages !', 6, 3, '2023-02-14  16:00:00');
*/
$query = "INSERT INTO POST (content, id_user, id_discu, post_date) 
          VALUES (:content, :id_user, :id_discu, :timestamp);";

$request = $pdo->prepare($query);
$request->bindParam(":content", $post_content);
$request->bindParam(":id_user", $id_user);
$request->bindParam(":id_discu", $id_discu);
$request->bindParam(":timestamp", $timestamp);

$request->execute();

header("Location: $previous_page");
