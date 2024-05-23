<?php
session_start();

$rootPath = '../../';
include $rootPath . 'includes/db.php';

if (!isset($_POST['idBook']) || empty($_POST['idBook'])) {
    echo 'postWrong';
    exit;
}
$bookID = $_POST['idBook'];

// Verify book exists
$verifyBookExistsRequest = $pdo->prepare("SELECT id_book FROM BOOK WHERE id_book = ?;");
$verifyBookExistsRequest->execute([
    $bookID
]);
$verifyBookExists = $verifyBookExistsRequest->fetch(PDO::FETCH_ASSOC);

if (!$verifyBookExists) {
    echo 'bookDoesntExist';
    exit;
}

// see if it's completed
$getCurrentValueRequest = $pdo->prepare("SELECT id_book FROM BOOKCOMPLETE WHERE id_book = ? AND id_user = ?;");
$getCurrentValueRequest->execute([
    $bookID,
    $_SESSION['id_user']
]);
$getCurrentValue = $getCurrentValueRequest->fetch(PDO::FETCH_ASSOC);

if (!$getCurrentValue) {
    // switch to completed
    $switchCompletedRequest = $pdo->prepare("INSERT INTO BOOKCOMPLETE(id_book, id_user) VALUES(?, ?);");
    $switchCompletedRequest->execute([
        $bookID,
        $_SESSION['id_user']
    ]);

    // -1 On every current challenge
    $addChallengeAllRequest = $pdo->prepare("UPDATE CHALLENGE SET goal_books = goal_books - 1 WHERE id_user = ?;");
    $addChallengeAllRequest->execute([
        $_SESSION['id_user']
    ]);

    echo 'switchCompleted';
    return;
} else {
    // delete ==> switch to uncompleted
    $uncompletedRequest = $pdo->prepare("DELETE FROM BOOKCOMPLETE WHERE id_book = ? AND id_user = ?;");
    $uncompletedRequest->execute([
        $bookID,
        $_SESSION['id_user']
    ]);

    // +1 On every current challenge
    $addChallengeAllRequest = $pdo->prepare("UPDATE CHALLENGE SET goal_books = goal_books + 1 WHERE id_user = ?;");
    $addChallengeAllRequest->execute([
        $_SESSION['id_user']
    ]);

    echo 'switchUncompleted';
    return;
}