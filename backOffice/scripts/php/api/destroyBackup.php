<?php
session_start();
$rootPath = "../../../../";
require $rootPath . 'includes/db.php';

if(!isset($_POST['name']) || empty($_POST['name'])) {
    exit(1);
}
$name = $_POST['name'];



$command = 'rm /var/backups/openreads/' . $name;
$return_val = shell_exec($command);


if ($return_val != 0) {
    echo 1;
    exit();
}
echo 0;
exit();