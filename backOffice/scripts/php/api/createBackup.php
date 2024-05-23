<?php
session_start();
$rootPath = "../../../../";


if(!isset($_POST['name']) || empty($_POST['name'])) {
    exit(1);
}
$name = 'openreads_' . $_POST['name'];


//creating dump
$host = 'localhost';
$username = 'root';
$password = 'ePvVcHHgOSFLyEZQQglE$';
$dbname = 'openreads';

$backup_file = '/var/backups/openreads/' . $name . '.sql';

$command = "mysqldump --user={$username} --password={$password} --host={$host} {$dbname} > {$backup_file} && chmod 700 $backup_file";

exec($command, $output, $return_var);

if ($return_var != 0) {
    echo 1;
    exit();
}


echo 0;
exit();