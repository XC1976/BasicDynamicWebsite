<?php
session_start();
$rootPath = "../";

include $rootPath . 'includes/db.php';
//getting dest user id
if (!isset($_SESSION['selected_dest']) && empty($_SESSION['selected_dest'])) {
    echo 'pas de id_dest';
    exit(1);
}
$id_dest = $_SESSION['selected_dest'];
//getting user id
if (!isset($_SESSION['id_user']) || empty($_SESSION['id_user'])) {
    echo 'pas connecté';
    exit(1);
}
$id_user = $_SESSION['id_user'];


$query = "SELECT
            content,
            username,
            profile_pic,
            seen_state,
            DATE_FORMAT(sent_date, '%d/%m %H:%i') AS sent_date
        FROM 
            MESSAGE
        JOIN USER
            ON MESSAGE.id_user = USER.id_user
        WHERE
            MESSAGE.id_user = :id_user
        AND
            destinataire = :id_dest
        OR
            MESSAGE.id_user = :id_dest
        AND
            destinataire = :id_user
        ORDER BY
            sent_date
        ;";
$request = $pdo->prepare($query);
$request->bindParam(":id_user", $id_user);
$request->bindParam(":id_dest", $id_dest);
$request->execute();
$res = $request->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($res);
//var_dump($res);
