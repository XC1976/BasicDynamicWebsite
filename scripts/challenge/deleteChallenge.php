<?php
session_start();

$rootPath = '../../';
include $rootPath . 'includes/db.php';

if(!isset($_POST['idChallenge']) || empty($_POST['idChallenge'])) {
    echo 'postWrong';
    exit;
}

$challengeID = $_POST['idChallenge'];

// Verify if the challenge is current for user
$verifyChallengeValidRequest = $pdo->prepare("SELECT id_challenge FROM CHALLENGE WHERE id_challenge = ?;");
$verifyChallengeValidRequest->execute([
    $challengeID
]);
$verifyChallengeValid = $verifyChallengeValidRequest->fetch(PDO::FETCH_ASSOC);

if(!$verifyChallengeValid) {
    echo 'challengeDoesntExist';
    exit;
}

// Delete challenge
$deleteChallengeRequest = $pdo->prepare("DELETE FROM CHALLENGE WHERE id_challenge = ?;");
$deleteChallengeRequest->execute([
    $challengeID
]);

echo 'success';
exit;