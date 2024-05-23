<?php
session_start();
$rootPath = "../";

include $rootPath . 'includes/db.php';
if (isset($_POST['id_dest']) && !empty($_POST['id_dest'])) {
    $_SESSION['selected_dest'] = $_POST['id_dest'];
    exit();
}

$query="SELECT
            destinataire
        FROM
            MESSAGE
        WHERE
            id_user = :id_user
        AND
            id_message = (SELECT MAX(id_message) FROM MESSAGE);";
$request = $pdo->prepare($query);
$request->bindParam(":id_user", $id_user);
$request->execute();
$res = $request->fetchAll(PDO::FETCH_ASSOC);

if (!empty($res)) {
    $_SESSION = $res[0]['destinataire'];
}