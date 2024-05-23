<?php
session_start();

// Relative path to root "/"
// ========== PLEASE ADD A "/" AT THE END ! ========== 
$rootPath = '../../';

// Path to DB
require $rootPath . 'includes/db.php';
// Path to tracking
require $rootPath . 'scripts/log_tracking.php';

// Verifie si le nom existe
if(empty($_POST['nom'])) {
    header('Location: ../../pages/marketplace/addProduct.php?message=Il manque le nom !');
    exit;
}

$getDoublonNameRequest = $pdo->prepare('SELECT id_bookToSell FROM BookToSell WHERE book_name = ?;');
$getDoublonNameRequest->execute([
    $_POST['nom']
]);

$getDoublonName = $getDoublonNameRequest->fetch(PDO::FETCH_ASSOC);
$getDoublonNameRowCount = $getDoublonNameRequest->rowCount();

// Nom déjà pris
if($getDoublonNameRowCount > 0) {
    header('Location: ../../pages/marketplace/addProduct.php?message=Le nom est déjà pris !');
    exit;
}

// Vérifie si le nom a été envoyé 
if(empty($_POST['nom'])) {
    header('Location: ../../pages/marketplace/addProduct.php?message=Il manque le prix !');
    exit;
}

// Sanitize name
$sanitizedName = htmlspecialchars($_POST['nom'], ENT_QUOTES);

// Vérifie si le prix est un double positif
if (!is_numeric($_POST['price']) || $_POST['price'] <= 0) {
    header('Location: ../../pages/marketplace/addProduct.php?message=La valeur du prix n\'est pas valide !');
    exit;
} 

// Sanitize price
$sanitizedPrice = htmlspecialchars($_POST['price'], ENT_QUOTES);

// Vérifie si la quantité existe 
if(empty($_POST['quantity'])) {
    header('Location: ../../pages/marketplace/addProduct.php?message=Il manque la quantité !');
    exit;
}

// Vérifie si la quantité est un integer positif
if (!is_int((int)$_POST['quantity'] + 0) || (int)$_POST['quantity'] <= 0) {
    // Value is not a positive integer
    header('Location: ../../pages/marketplace/addProduct.php?message=La quantité n\'est pas un entier positif !');
    exit;
}

// Sanitize quantity
$sanitizedQuantity = htmlspecialchars($_POST['quantity'], ENT_QUOTES);

// Verify that the description is not more than 500 characters
if (strlen($_POST['description']) > 500) {
    header('Location: ../../pages/marketplace/addProduct.php?message=La description ne doit pas dépasser 500 caractères !');
    exit;
}

// Sanitize description
$sanitizedDescription = htmlspecialchars($_POST['description'], ENT_QUOTES);

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
    header('Location: ../../pages/marketplace/addProduct.php?message=Il_manque_une_image !');
    exit;
}

if(!in_array($_FILES['image']['type'], $acceptable)) {
    header('Location: ../../pages/marketplace/addProduct.php?message=Mauvais_format_de_l\'image !');
    exit;
}

// Vérifie que le fichier ne dépasse pas 1MO

$maxsize = 1024*1024;
	
if(($_FILES['image']['size'] > $maxsize)) {
    header('Location: ../../pages/marketplace/addProduct.php?message=Image_trop_grande !');
    exit;
}


// Création d'un chemin pour l'image
$image_name = 'book-' . date('Y-m-d-H-i-s');
$filename = $_FILES["image"]["name"];  // nom de base du fichier avec extension à l'aide de $_FILES
$temp_array = explode(".", $filename);
$extension = end($temp_array); // Suffixe avec extension du fichier
$chemin_image = '../../assets/img/books/' . $image_name . '.' . $extension;
$nomImage = $image_name . '.' . $extension;

// Déplacer le fichier uploadé vers le dossier attitré
move_uploaded_file($_FILES["image"]["tmp_name"], $chemin_image);

// Insertion dans BookToSell

$insertBookToSell = $pdo->prepare('INSERT INTO BookToSell(book_name, price, description, date_published, quantityItem, main_img_name, seller_user) 
VALUES(?, ?, ?, DATE_FORMAT(NOW(), "%Y-%m-%d"), ?, ?, ?)');
$insertBookToSell->execute([
    $sanitizedName,
    $sanitizedPrice,
    $sanitizedDescription,
    $sanitizedQuantity,
    $nomImage,
    $_SESSION['id_user']
]);

header('Location: ../../pages/marketplace/shop.php?message=Produit_ajoute_avec_succes!');
exit;