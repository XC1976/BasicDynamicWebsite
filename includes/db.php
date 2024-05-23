<?php

$db = "mysql:host=localhost;dbname=openreads";

$dbUsername = "root";
$dbPassword = "ePvVcHHgOSFLyEZQQglE$";

try {
    $pdo = new PDO($db, $dbUsername, $dbPassword, );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed : " . $e->getMessage();
}
