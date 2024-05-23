<?php
session_start();

// Require DB
require '../../includes/db.php';

// =========================
// Conditions liés à l'image si ça a été upload
// =========================

// Tableaux contenant les types de fichiers autorisés
$acceptable = array(
    'image/jpeg',
    'image/jpg',
    'image/gif',
    'image/png'
);

// Verification du type de fichier
if($_FILES['image']['name'] == '') {
    header('Location: ../../pages/Profil/profile.php?' . 'username=' . $_SESSION['username'] . '&message=Il manque une image !');
    exit;
}

if(!in_array($_FILES['image']['type'], $acceptable)) {
    header('Location: ../../pages/Profil/profile.php?' . 'username=' . $_SESSION['username'] . '&message=Mauvais format de l\'image !');
    exit;
}

// Vérifie que le fichier ne dépasse pas 1MO

$maxsize = 1024*1024;
	
if(($_FILES['image']['size'] > $maxsize)) {
    header('Location: ../../pages/Profil/profile.php?' . 'username=' . $_SESSION['username'] . '&message=Image trop grande !');
    exit;
}


// Création d'un chemin pour l'image
$image_name = 'pp-' . date('Y-m-d-H-i-s');
$filename = $_FILES["image"]["name"];  // nom de base du fichier avec extension à l'aide de $_FILES
$temp_array = explode(".", $filename);
$extension = end($temp_array); // Suffixe avec extension du fichier
$chemin_image = '../../assets/img/profilPic/' . $image_name . '.' . $extension;
$nomImage = $image_name . '.' . $extension;

// Déplacer le fichier uploadé vers le dossier attitré
move_uploaded_file($_FILES["image"]["tmp_name"], $chemin_image);

// Modifier de l'image
$modifyPPImageRequest = $pdo->prepare("UPDATE USER SET profile_pic = ? WHERE id_user = ?;");
$modifyPPImageRequest->execute([
    $nomImage,
    $_SESSION['id_user']
]);

$_SESSION['profile_pic'] = $nomImage;

header('Location: ../../pages/Profil/profile.php?' . 'username=' . $_SESSION['username'] . '&message=Image modifiée avec succès !');
exit;