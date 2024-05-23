<?php
session_start();

$rootPath = '../../';
include $rootPath . 'includes/db.php';

$previousPage = $_POST['previous_page'];
$libID = $_POST['libID'];

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
    header('Location: ../../' . $previousPage . '&message=Il_manque_une_image !');
    exit;
}

if(!in_array($_FILES['image']['type'], $acceptable)) {
    header('Location: ../../' . $previousPage . '&message=Mauvais format de l\'image !');
    exit;
}

// Vérifie que le fichier ne dépasse pas 1MO

$maxsize = 1024*1024;
	
if(($_FILES['image']['size'] > $maxsize)) {
    header('Location: ../../' . $previousPage . '&message=Image trop grande !');
    exit;
}


// Création d'un chemin pour l'image
$image_name = 'lib-' . date('Y-m-d-H-i-s');
$filename = $_FILES["image"]["name"];  // nom de base du fichier avec extension à l'aide de $_FILES
$temp_array = explode(".", $filename);
$extension = end($temp_array); // Suffixe avec extension du fichier
$chemin_image = '../../assets/img/libraries/' . $image_name . '.' . $extension;
$nomImage = $image_name . '.' . $extension;

// Déplacer le fichier uploadé vers le dossier attitré
move_uploaded_file($_FILES["image"]["tmp_name"], $chemin_image);

// Update image
$updateImageLibRequest = $pdo->prepare("UPDATE LIB SET library_img = ? WHERE id_lib = ?;");
$updateImageLibRequest->execute([
    $nomImage,
    $libID
]);

header('Location: ../../' . $previousPage . '&message=Image modifiée avec succès !');
exit;