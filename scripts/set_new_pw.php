<?php
//this script is triggers after a user submitted a new password in the new-pw.php page
require "../includes/db.php";
function redirectWithError($message) {
    header("Location: ../index.php?message=$message");
    exit();
}

//legitiate access to this script
if ($_SERVER["REQUEST_METHOD"] != "POST" || !isset ($_POST['validate'])) {
    $message = "Vous ne pouvez pas accéder à cette page de cette manière";
    redirectWithError($message);
}

//------------------------------
// verify post parameter (id, token, password01, password02)
if (!isset($_POST["token"]) || empty($_POST["token"]) ) {
    $message="Erreur : Pas de token";
    redirectWithError($message);
}

// id must be submitted
if (!isset($_POST["id"]) || empty($_POST["id"]) ) {
    $message="Erreur : Pas d'identifiant utilisateur";
    redirectWithError($message);
}
// password must be submitted
if (!isset($_POST["password01"]) || empty($_POST["password01"]) ) {
    $message="Erreur : Pas de mot de passe saisi";
    redirectWithError($message);
}

// password must be submitted
if (!isset($_POST["password02"]) || empty($_POST["password02"]) ) {
    $message="Erreur : Vous devez saisir le mot de passe 2 fois";
    redirectWithError($message);
}

$id_user= $_POST["id"];
$post_token = $_POST["token"];
$password01 = $_POST['password01'];
$password02 = $_POST['password02'];

//========= syntax check =========
$redirect = False;

//verify syntax (id, token)
if (strlen($post_token) != 50) {
    $message = 'Format du token Invalide' . $post_token;
    $redirect = True;
}

// user id must me an integer
if (intval($id_user) == 0 && $id_user != "0") {
    $message = ' Identifiant Invalide';
    $message = $message . 'user id = ' . $id_user;
    $message = $message . 'intval = ' . intval($id_user) == 0;
    $redirect = True;
}

if (strlen($password01) < 8 || strlen($password01) > 255) {
    $message = $message . ' Le mot de passe doit etre entre 8 et 255 caracteres';
    $redirect = True;
}

if ($password01 != $password02) {
    $message = $message . ' Le mot de passe doit etre identique.';
    $redirect = True;
}

if ($redirect == True ) {
    redirectWithError($message);
}
//=== hash password

$password = hash('sha256', $password01); //password hashing


//-----------------------------
//verify token
$query = "SELECT expiration_date, token_type FROM TOKEN WHERE user=:id_user AND token_value=:token_value;";
$request = $pdo->prepare($query);
$request->bindParam(":id_user", $id_user);
$request->bindParam(":token_value", $post_token);
$request->execute();
$results = $request->fetchAll(); //exp_date, token type

//verify that token exists
if (empty($results)) {
    $message = "Erreur : Mauvais lien";
    redirectWithError($message);
}

//parsing
$exp_date = $results[0]["expiration_date"];
$token_type = $results[0]["token_type"];

//verify token is valid
$time_now = date("Y-m-d", time());

if ($token_type != "PASSWD" || $time_now > $exp_date) {
    $message = "Adresse Invalide";
    redirectWithError($message);
}
//------------------------------------------
// token exists, is valid and belong to id_userw
$query = "UPDATE USER SET password = :password WHERE id_user=:id_user; 
        
        DELETE FROM TOKEN WHERE(token_value=:token_value);
        
        DELETE FROM TOKEN WHERE(expiration_date<:time_now);"; //delete all other expired token
$request = $pdo->prepare($query);
$request->bindParam(":password", $password);
$request->bindParam(":id_user", $id_user);
$request->bindParam(":token_value", $db_token);
$request->bindParam(":time_now", $time_now);

$request->execute();
$message = "Mot de passe changé avec succès";
header("Location: ../index.php?message=$message");
exit();

