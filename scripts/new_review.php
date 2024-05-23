<?php
session_start();

$rootPath = "../";
function redirectWithError($message, $page) {
    var_dump($message);
    header("Location: ..$page&message=$message");
    $message = "";
    exit();
}

require $rootPath . 'includes/db.php';


//===== getting the needed variables ======

// time of the message
$timestamp = date("Y-m-d H:i:s", time());
//prev page to be able to redirect properly
$previous_page = $_POST['previous_page'];
//ui
$id_user = $_SESSION['id_user'];

//checking for illegitimate access of the page
if ($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST['validate'])) {
    redirectWithError("Vous ne pouvez pas accéder a cette page", "");
}
//checking that user is connected
if (empty($_SESSION['id_user']) || !isset($_SESSION['id_user'])) {
    redirectWithError("Vous devez être connecté", $previous_page);
}

//id of the discussion must be provided
$id_book = $_POST['id_book'];

if (!isset($id_book) || empty($id_book)) {
    $message = "Erreur : Impossible de retrouver le livre";
    redirectWithError($message, $previous_page);
}

//========verifying the post content ================

//it must contain something
$post_content = $_POST["review_text"];
if (!isset($post_content)) {
    $message = "Erreur : Le message n'existe pas";
    redirectWithError($message, $previous_page);
}

//it must not be too long
if (strlen($post_content) > 10000) {
    $message = "Erreur : La taille du message est limitée à 10 000 caractères";
    redirectWithError($message, $previous_page);
}

/*===== determinig if it is a REVIEW or a RESPONSE_TO =====
REVIEW = rating between 1 and 5
       = only one per user per book

RESPONSE_TO = rating == -1
            = no amount restrictions

*///verify for valid rating
$rating = $_POST['rating'];

if ($rating >= 1 && $rating <= 5) {
    $respond_to = NULL;
    //====CHECKING that the user has not already reviewed the book
    $query = "SELECT id_review FROM REVIEW_BOOK WHERE id_user = :id_user AND id_book = :id_book AND respond_to IS NULL AND deleted != 1;";

    $request = $pdo->prepare($query);
    $request->bindParam(":id_user", $id_user);
    $request->bindParam(":id_book", $id_book);
    $request->execute();
    $res = $request->fetchAll(PDO::FETCH_ASSOC);
}
else if ($rating == -1) {
    $rating = NULL;
    //must respond_to a comment
    if (empty($_POST['respond_to']) || !isset($_POST['respond_to'])) {
        redirectWithError("Erreur : Impossible d'ajouter la réponse", $previous_page);
    }
    $respond_to = $_POST['respond_to'];
}
else {
    $message = "Note incorrecte";
    redirectWithError($message, $previous_page);
}




if (!empty($res)) {
    $message = "Vous ne pouvez poster qu'une seule critique par livre !";
    redirectWithError($message, $previous_page);
}





//===== inserting comment =====

$query = "INSERT INTO REVIEW_BOOK (comment, rating, time_stamp, id_book, id_user, respond_to) 
          VALUES (:comment, :rating, :timestamp, :id_book, :id_user, :respond_to);";

$request = $pdo->prepare($query);
$request->bindParam(":comment", $post_content);
$request->bindParam(":rating", $rating);
$request->bindParam(":timestamp", $timestamp);
$request->bindParam(":id_book", $id_book);
$request->bindParam(":id_user", $id_user);
$request->bindParam(":respond_to", $respond_to);

$request->execute();

header("Location: $previous_page");