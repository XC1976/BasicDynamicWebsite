<?php
session_start();

// Relative path to root "/"
// ========== PLEASE ADD A "/" AT THE END ! ========== 
$rootPath = '../../';

// Path to DB
require $rootPath . 'includes/db.php';
// Path to tracking
require $rootPath . 'scripts/log_tracking.php';

// Not allow if not connected
if(!isset($_SESSION['auth'])) {
    header('Location: ../others/errorPage.php?message=Vous n\'êtes pas connecté !');
    exit;
}

require('../../includes/fpdf/fpdf.php');

// Get information of current user
$getInformationscurrentUserRequest = $pdo->prepare('SELECT username, email, profile_pic, bio, birthdate, creation_date, deathdate FROM USER WHERE id_user = ?;');
$getInformationscurrentUserRequest->execute([
    $_SESSION['id_user']
]);
$getInformationscurrentUser = $getInformationscurrentUserRequest->fetch(PDO::FETCH_ASSOC);

$userUsername = $getInformationscurrentUser['username'];
$userEmail = $getInformationscurrentUser['email'];
$userImgPath = $rootPath . 'assets/img/profilPic/' . $getInformationscurrentUser['profile_pic'];
$userBio = $getInformationscurrentUser['bio'];
$userBithdate = $getInformationscurrentUser['birthdate'];
$userCreationDate = $getInformationscurrentUser['creation_date'];
$userDeathDate = $getInformationscurrentUser['deathdate'];

$getAllDiscussionsRequest = $pdo->prepare('SELECT POST.content AS content, POST.post_date AS date, DISCUSSION.name AS categorieName 
FROM POST INNER JOIN DISCUSSION ON POST.id_discu = DISCUSSION.id_discussion WHERE id_user = ?;');
$getAllDiscussionsRequest->execute([$_SESSION['id_user']]);
$getAllDiscussions = $getAllDiscussionsRequest->fetchAll(PDO::FETCH_ASSOC);

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Image($userImgPath, 150, 5, 25, 0);
$pdf->Cell(100,8,mb_convert_encoding('Informations de l\'utilisateur' , 'ISO-8859-1', 'UTF-8'), 1, 1);
$pdf->SetFont('Helvetica', '',12);
$pdf->Cell(40,8,mb_convert_encoding('Username : @' , 'ISO-8859-1', 'UTF-8') . $userUsername, 0, 1);
$pdf->Cell(40,8,mb_convert_encoding('Email : ' , 'ISO-8859-1', 'UTF-8') . $userEmail, 0, 1);
$pdf->MultiCell(180,8,mb_convert_encoding('Biographie : ' , 'ISO-8859-1', 'UTF-8') . $userBio, 0, 1);
$pdf->Cell(40,8,mb_convert_encoding('Date d\'anniversaire : ' , 'ISO-8859-1', 'UTF-8') . $userBithdate, 0, 1);
$pdf->Cell(40,8,mb_convert_encoding('Date de création de compte : ', 'ISO-8859-1', 'UTF-8') . $userCreationDate, 0, 1);
$pdf->Cell(40,8,mb_convert_encoding('Date de décès : ', 'ISO-8859-1', 'UTF-8') . $userDeathDate, 0, 1);
$pdf->SetFont('Helvetica', 'BU',16);
$pdf->Cell(40,8,mb_convert_encoding('Postes : ', 'ISO-8859-1', 'UTF-8') . $userDeathDate, 0, 1);
foreach($getAllDiscussions as $value) {
    $stringOfPost = 'Date : ' . $value['date'] . ' dans la discussion : ' . $value['categorieName'];
    $pdf->SetFont('Helvetica', 'B',12);
    $pdf->MultiCell(180,8,mb_convert_encoding($stringOfPost, 'ISO-8859-1', 'UTF-8') . $userDeathDate, 0, 1);
    $pdf->SetFont('Helvetica', '',12);
    $pdf->MultiCell(180,8,mb_convert_encoding($value['content'], 'ISO-8859-1', 'UTF-8') . $userDeathDate, 0, 1);
}
$pdf->Output();