<?php
session_start();
$rootPath = "../../../../";

if(!isset($_POST['name']) || empty($_POST['name'])) {
    exit(1);
}
$name = $_POST['name'];


//creating dump
$host = 'localhost';
$username = 'root';
$password = 'ePvVcHHgOSFLyEZQQglE$';
$dbname = 'openreads';
$backup_file = '/var/backups/openreads/' . $name;

//recreate db
$command = "mariadb --user={$username} --password={$password} --host={$host} -e 'CREATE DATABASE {$dbname}'";
exec($command, $output, $return_var);

//restore backup
$command = "mariadb --user={$username} --password={$password} --host={$host} {$dbname} < {$backup_file}";
exec($command, $output, $return_var);

if ($return_var != 0) {
    echo 1;
    exit();
}

echo 0;
exit();