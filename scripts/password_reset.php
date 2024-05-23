<?php
//this script is triggered when a user submits the form "forgot-pw.php"
//it sends a mail to the user with a token to let him reset his pw
session_start();
require "../includes/db.php";
function redirectWithError01($message) {
    header("Location: ../?message=$message");
    $message = "";
    exit();
}
//legitiate access to this script
if ($_SERVER["REQUEST_METHOD"] != "POST" || !isset ($_POST['validate'])) {
    redirectWithError01("Vous ne pouvez pas accéder à cette page de cette manière");
}


//email must be filled
if (empty($_POST['email']) || !isset($_POST['email'])) {
    $message = "Erreur : Il faut saisir une addresse email.";
    redirectWithError01($message);
}
$email = $_POST['email'];	

//sanitizing
filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);

//validating
if (!filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL)) {
    $message = $message . 'Email invalide';
    redirectWithError01($message);
}


//=== verify that email exist ===
$query = 'SELECT id_user FROM USER WHERE email = :email;';
$request = $pdo->prepare($query);
$request->bindParam(":email", $email);
$request->execute();
$id_user = $request->fetchAll();
//parsing
$id_user = $id_user[0]["id_user"];

if (empty($id_user)){
    $message = "Veuillez vous inscrire d'abord.";
    redirectWithError01($message);
}

//==== create token
$token_value = bin2hex(random_bytes(25));
//token type must be "ACCOUNT" or "PASSWD"
$token_type = "PASSWD";
//1 day to validate email
$expiration_date = date("Y-m-d", time() + 3600*24);

//=== insert token

$query = "INSERT INTO TOKEN(token_value, token_type, expiration_date, user)
VALUES (:token_value, :token_type, :expiration_date, :user);";

$request = $pdo->prepare($query);

$request->bindParam(":token_value", $token_value);
$request->bindParam(":token_type", $token_type);
$request->bindParam(":expiration_date", $expiration_date);
$request->bindParam(":user", $id_user);

$request->execute();


// Sending confirmation email

$subject = "Réinitialisation de votre mot de passe";
$body = file_get_contents("../pages/mails/reset_passwd.html");

$link = 'http://www.openreads.uk/pages/Inscription/new-pw.php?token=' . $token_value . '&id=' . $id_user;
$body = str_replace('%LINK%', $link, $body);

require "../includes/send_mail.php";