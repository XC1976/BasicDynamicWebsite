<?php
session_start();

$rootPath = '../../';
include $rootPath . 'includes/db.php';

$userFollowedID = $_POST['user_followed'];
$currentUserID = $_POST['current_user'];

// Verify if the current user is already following the user
$getFollowRow = $pdo->prepare("SELECT followed_user FROM Follows WHERE followed_user = ? AND following_user = ?;");
$getFollowRow->execute([
    $userFollowedID,
    $currentUserID
]);

$followRow = $getFollowRow->fetchAll(PDO::FETCH_ASSOC);

if(count($followRow) == 0) {
    $insertFollow = $pdo->prepare("INSERT INTO Follows(followed_user, following_user) VALUES(?, ?);");
    $insertFollow->execute([
        $userFollowedID,
        $currentUserID
    ]);

    echo 'unfollow';
}
else {
    $removeFollow = $pdo->prepare("DELETE FROM Follows WHERE followed_user = ? AND following_user = ?");
    $removeFollow->execute([
        $userFollowedID,
        $currentUserID
    ]);

    echo 'follow';
}