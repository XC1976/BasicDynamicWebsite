<?php
include("../../../includes/db.php");

if (!isset($_POST['userId']) || empty($_POST['userId'])) {
    header('Location: ../../users.php?message=L\'élément n\'a pas pu être identifié.');
    exit;
}

$id = $_POST['userId'];

if (!isset($_POST['name']) || empty($_POST['name'])) {
    header('Location: ../../editUser.php?id_user=' . $id . '&message=Champ de prénom vide.');
    exit;
}   

if (strlen($_POST['name']) < 2 || strlen($_POST['name']) > 30) {
    header('Location: ../../editUser.php?id_user=' . $id . '&message=Prénom non compris entre 2 et 30.');
    exit;
}

if (!isset($_POST['lastname']) || empty($_POST['lastname'])) {
    header('Location: ../../editUser.php?id_user=' . $id . '&message=Champ de nom vide.');
    exit;
}

if (strlen($_POST['lastname']) < 2 || strlen($_POST['lastname']) > 30) {
    header('Location: ../../editUser.php?id_user=' . $id . '&message=Nom non compris entre 2 et 30.');
    exit;
}

if (!isset($_POST['username']) || empty($_POST['username'])) {
    header('Location: ../../editUser.php?id_user=' . $id . '&message=Champ de username vide.');
    exit;
}

if (strlen($_POST['username']) < 4 || strlen($_POST['username']) > 20) {
    header('Location: ../../editUser.php?id_user=' . $id . '&message=username non-compris entre 4 et 20.');
    exit;
}

$q = 'SELECT id_user FROM USER WHERE username = :username AND id_user != :id;';
$req = $pdo->prepare($q);
$req->execute([
    'username' => $_POST['username'],
    'id' => $id
]);

$results = $req->fetchAll();
if (!empty($results)){
    header('Location: ../../editUser.php?id_user=' . $id . '&message=Nom d\'utilisateur déjà utilisé.');
    exit;
}


if (!isset($_POST['email']) || empty($_POST['email'])) {
    header('Location: ../../editUser.php?id_user=' . $id . '&message=Champ d\'émail vide.');
    exit;
}


$q = "SELECT id_user FROM USER WHERE email = :email AND id_user != :id;";
$req = $pdo->prepare($q);
$req->execute([
    'email' => $_POST['email'],
    'id' => $id
]);

$results = $req->fetchAll();
if (!empty($results)){
    header('Location: ../../editUser.php?id_user=' . $id . '&message=Email déjà utilisé.');
    exit;
}

// checks for correct format
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    header('Location: ../../editUser.php?id_user=' . $id . '&message=Format de l\'email incorrecte.');
    exit;
}

// can't ban admin and can't put author as admin 

    if ($_POST['status_value'] == 1 && $_POST['admin_value'] == 1){
        header('Location: ../../editUser.php?id_user=' . $id . '&message=Impossible de bannir un administrateur.');
        exit;
    }
    if ($_POST['author_value'] == 0 && $_POST['admin_value'] == 1){
        header('Location: ../../editUser.php?id_user=' . $id . '&message=un auteur ne peut être administrateur.');
        exit;
    }

$email = $_POST['email'];

// Vérifier le format de l'email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: ../../editUser.php?id_user=' . $id . '&message=Format d\'émail invalide.');
    exit;
}

$name = $_POST['name'];
$lastname = $_POST['lastname'];
$file_name = null;
$username = $_POST['username'];
$status = $_POST['status_value'];
$admin = $_POST['admin_value'];
$author = $_POST['author_value'];

$name = htmlspecialchars($name);
$lastname = htmlspecialchars($lastname);
$email = htmlspecialchars($email);
$username = htmlspecialchars($username);

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {

    $accepted = ['image/jpeg', 'image/gif', 'image/png'];
    if (!in_array($_FILES['image']['type'], $accepted)) {
            header('Location: ../../editUser.php?id_user=' . $id . '&message=type de fichier incorrect !!!!');
            exit;
        }


    $max_size = 1024 * 1024 * 2; // 2Mo
    if ($_FILES['image']['size']> $max_size) {
            header('Location: ../../editUser.php?id_user=' . $id . '&message=le fichier ne doit pas dépasser 2Mo.');
            exit;
        }

    $array = explode('.', $_FILES['image']['name']);
    $ext = end($array);
    $file_name = 'image-' . time() . '.' . $ext;
    $from = $_FILES['image']['tmp_name'];
    $to = '../../../assets/img/profilPic/' . $file_name;
    move_uploaded_file($from, $to);
}

$editUser = "UPDATE USER SET name = :name, lastname = :lastname, email = :email, username = :username, is_banned = :status, admin = :admin, status = :author";

// Ajoute la modification de la photo de profil si un fichier est téléchargé
if ($file_name !== null) {
    $editUser .= ", profile_pic = :pic";
}

$editUser .= " WHERE id_user = :id;";

$req = $pdo->prepare($editUser);
$params = [
    'name' => $name,
    'lastname' => $lastname,
    'email' => $email,
    'username' => $username,
    'status' => $status,
    'admin' => $admin,
    'author' => $author,
    'id' => $id
];

// Ajoute le nom de fichier si la photo de profil est modifiée
if ($file_name !== null) {
    $params['pic'] = $file_name;
}

$req->execute($params);

if ($req->rowCount() > 0) {
    header('Location: ../../editUser.php?id_user=' . $id . '&message=User modifiée avec succès.');
} else {
    header('Location: ../../editUser.php?id_user=' . $id . '&message=Erreur lors de l\'enregistrement.');
}
exit;

?>
