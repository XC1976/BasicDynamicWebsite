<?php
session_start();

$rootPath = "../";
function redirectWithError($message, $page) {
    header("Location: ..$page?&message=$message");
    $message = "";
    exit();
}

$previous_page = $_POST['previous_page'];

//checking for illegitimate access of the page
if ($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST['validate'])) {
    redirectWithError("You can not access this page", "");
}
//checking that user is connected
if (empty($_SESSION['id_user']) || !isset($_SESSION['id_user'])) {
    redirectWithError("Vous devez être connecté", "");
}
//========verifying the post content ================

//it must contain something
$post_content = $_POST["new_post_text"];
if (!isset($post_content) || empty($post_content)) {
    $message = "Erreur : Message vide";
    redirectWithError($message, $previous_page);
}

//it must not be too long
if (strlen($post_content) > 10000) {
    $message = "Erreur : La taille du message est limitée à 10 000 caractères";
    redirectWithError($message, $previous_page);
}

//id of the discussion must be provided
$id_discu = $_POST['id_discu'];
if (!isset($id_discu) || empty($id_discu)) {
    $message = "Erreur : Impossible de retrouver la discussion";
    redirectWithError($message, $previous_page);
}

//===== getting the needed variables ======
$id_user = $_SESSION['id_user'];

// time of the message
$timestamp = date("Y-m-d H:i:s", time());

//===== database =====
require $rootPath . 'includes/db.php';
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