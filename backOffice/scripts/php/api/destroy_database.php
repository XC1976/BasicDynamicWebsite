<?php
session_start();
$rootPath = "../../../../";

//creating dump
$host = 'localhost';
$username = 'root';
$password = 'ePvVcHHgOSFLyEZQQglE$';
$dbname = 'openreads';

//nuke db
$command = "mariadb --user={$username} --password={$password} --host={$host} -e 'DROP DATABASE IF EXISTS openreads;'";
exec($command, $output, $return_var);


if ($return_var != 0) {
    echo 1;
    exit();
}

echo 0;
exit();