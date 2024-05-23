<?php
session_start();

$rootPath = '../../';
include $rootPath . 'includes/db.php';

$blockedUserID = $_POST['user_blocked'];
$currentUserID = $_POST['current_user'];

// Verify if the current user is already following the user
$getBlockRow = $pdo->prepare("SELECT blocked_user FROM BLOCKS WHERE blocked_user = ? AND blocking_user = ?;");
$getBlockRow->execute([
    $blockedUserID,
    $currentUserID
]);

$blockRow = $getBlockRow->fetchAll(PDO::FETCH_ASSOC);

if(count($blockRow) == 0) {
    $insertBlock = $pdo->prepare("INSERT INTO BLOCKS(blocked_user, blocking_user) VALUES(?, ?);");
    $insertBlock->execute([
        $blockedUserID,
        $currentUserID
    ]);

    echo 'unblock';
}
else {
    $removeBlock = $pdo->prepare("DELETE FROM BLOCKS WHERE blocked_user = ? AND blocking_user = ?");
    $removeBlock->execute([
        $blockedUserID,
        $currentUserID
    ]);

    echo 'block';
}