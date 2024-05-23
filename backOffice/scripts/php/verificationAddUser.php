<?php
include("../../../includes/db.php");


// checks if the username is set, not empty, not too long or too short, and if it's already used
if (!isset($_POST['username']) || empty($_POST['username']) || strlen($_POST['username']) < 4 || strlen($_POST['username']) > 20) {
    header('location: ../../addUser.php?message=Nom d\'utilisateur vide ou non compris entre 4 et 20 caractères.');
    exit;
}
$q = 'SELECT id_user FROM USER WHERE username = :username';
$req = $pdo->prepare($q);
$req->execute([
    'username' => $_POST['username']]);
$results = $req->fetchAll();
if (!empty($results)){
    header('Location: ../../addUser.php?message=Nom d\'utilisateur déjà utilisé.');
    exit;
}

// identity
if (!isset($_POST['name']) || empty($_POST['name'])) {
    header('Location: ../../addUser.php?message=Nom ou prénom incorrect.s.');
    exit;
}

if (strlen($_POST['name']) < 2 || strlen($_POST['name']) > 30) {
    header('Location: ../../addUser.php?message=Prénom non-compris entre 2 et 30.');
    exit;
}

if (!isset($_POST['lastname']) || empty($_POST['lastname'])) {
    header('Location: ../../addUser.php?message=Champ de nom vide.');
    exit;
}

if (strlen($_POST['lastname']) < 2 || strlen($_POST['lastname']) > 30) {
    header('Location: ../../addUser.php?message=Nom non-compris entre 2 et 30.');
    exit;
}

// checks if the email is set, not empty and not used
if (!isset($_POST['email']) || empty($_POST['email'])) {
    header('location: ../../addUser.php?message=Champ email vide.');
    exit;
}
$q = 'SELECT id_user FROM USER WHERE email = :email';
$req = $pdo->prepare($q);
$req->execute([
    'email' => $_POST['email']]);
$results = $req->fetchAll();
if (!empty($results)){
    header('location: ../../addUser.php?message=Email déjà utilisé.');
    exit;
}

// checks for correct format
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    header('location: ../../addUser.php?message=Format de l\'email incorrecte.');
    exit;
}


if (!isset($_POST['password']) || empty($_POST['password']) || strlen($_POST['password']) < 8 || strlen($_POST['password']) > 255) {
    header('location: ../../addUser.php?message=Champ de mot de passe vide.');
    exit;
}

// checks if the date is set and the user's over 13 yo
if (!isset($_POST['date']) || empty($_POST['date']) || (new DateTime($_POST['date']))->diff(new DateTime())->y < 13) {
    header('location: ../../addUser.php?message=Veuillez saisir une date correcte.');
    exit;
}

// can't ban admin and can't put author as admin 

if ($_POST['stat'] == 0 && $_POST['admin_value'] == 1){
    header('location: ../../addUser.php?message=un auteur ne peut être administrateur.');
    exit;
}


// variables 
$username = $_POST['username'];
$password = $_POST['password'];
$name = $_POST['name'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$date = $_POST['date'];
$stat = $_POST['stat'];
$admin = $_POST['admin_value'];
$bio = '';
$pic = 'default.jpg'; 

// sanitized variables
$name = htmlspecialchars($name);
$lastname = htmlspecialchars($lastname);
$username = htmlspecialchars($username);
filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$email = htmlspecialchars($email);
$password = htmlspecialchars($password);

// password salting and hashing 
$password = hash('sha256', $password);

// empty bios should be accepted, so checks if it is empty or not
if(isset($_POST['bio']) && !empty($_POST['bio'])) {
    $bio = $_POST['bio'];
    $bio = htmlspecialchars($bio);
}


// check if the file set and got loaded without any issue
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    // checks if the file is in the right format
    $accepted = ['image/jpeg', 'image/gif', 'image/png'];
    if (!in_array($_FILES['image']['type'], $accepted)) {
            header('location: ../../addUser.php?message=type de fichier incorrect !!!!');
            exit;
        }
    // checks if the file isn't too heavy
    $max_size = 1024 * 1024 * 2; // 2Mo
    if ($_FILES['image']['size']> $max_size) {
        header('location: ../../addUser.php?message=le fichier ne doit pas dépasser 2Mo.');
            exit;
        }
    // at this point, let's save the file to the profilPic directory and give it a unique name
    $array = explode('.', $_FILES['image']['name']);
    $ext = end($array);
    $pic = 'image-' . time() . '.' . $ext;
    $from = $_FILES['image']['tmp_name'];
    $to = '../../../assets/img/profilPic/' . $pic;
    move_uploaded_file($from, $to);
}



$addUser = "INSERT INTO USER (name, lastname, username, email, profile_pic, bio, password, birthdate, creation_date, status, admin, is_banned, is_verified) 
            VALUES(:name, :lastname, :user, :email, :pic, :bio, :pswd, :bday, CURDATE(), :stat, :admin, 0, 1);";

$req = $pdo->prepare($addUser);

// binding the rest of the parameters
$req->bindParam(':name', $name);
$req->bindParam(':lastname', $lastname);
$req->bindParam(':user', $username);
$req->bindParam(':email', $email);
$req->bindParam(':pic', $pic);
$req->bindParam(':bio', $bio);
$req->bindParam(':pswd', $password);
$req->bindParam(':bday', $date);
$req->bindParam(':stat', $stat);
$req->bindParam(':admin', $admin);

$req->execute();

$res = $req->rowCount();

if ($req->rowCount() == 1) {
    header('location: ../../addUser.php?message=User ajouté avec succès.');
} else {
    header('location: ../../addUser.php?message=Erreur lors de l\'enregistrement.');
 }
exit;


