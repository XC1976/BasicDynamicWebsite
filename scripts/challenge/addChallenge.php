<?php
session_start();

$rootPath = '../../';
include $rootPath . 'includes/db.php';

// Verify POST
if(empty($_POST['idChallenge']) || !isset($_POST['idChallenge'])) {
    echo 'missingPost';
    exit;
}

$challengeID = $_POST['idChallenge'];

// Verify the challenge exists
$verifyChallengeExistRequest = $pdo->prepare("SELECT id FROM CHALLENGELIST WHERE id = ?;");
$verifyChallengeExistRequest->execute([
    $challengeID
]);
$verifyChallengeExist = $verifyChallengeExistRequest->fetch(PDO::FETCH_ASSOC);

if(!$verifyChallengeExist) {
    echo 'challengeDoesntExist';
    exit;
}
// Get challenge informations
$getChallengeInfosRequest = $pdo->prepare("SELECT name, date_end, goal_books FROM CHALLENGELIST WHERE id = ?");
$getChallengeInfosRequest->execute([
    $challengeID
]);
$getChallengeInfos = $getChallengeInfosRequest->fetch(PDO::FETCH_ASSOC);

// Verify if challenge already exists
$verifyChallengeDuplicateRequest = $pdo->prepare("SELECT id_challenge, enCours FROM CHALLENGE WHERE id_challenge = ?;");
$verifyChallengeDuplicateRequest->execute([
    $challengeID
]);
$verifyChallengeDuplicate = $verifyChallengeDuplicateRequest->fetch(PDO::FETCH_ASSOC);

if($verifyChallengeDuplicate) {
    echo 'alreadyExists';
    exit;
}

// Add challenge to users
$addChallengeRequest = $pdo->prepare("INSERT INTO CHALLENGE(date_start, date_end, name, goal_books, id_user, enCours) VALUES(CURRENT_TIMESTAMP, ?, ?, ?, ?, ?);");
$addChallengeRequest->execute([
    $getChallengeInfos['date_end'],
    $getChallengeInfos['name'],
    $getChallengeInfos['goal_books'],
    $_SESSION['id_user'],
    $challengeID
]);

echo 'success';
exit;