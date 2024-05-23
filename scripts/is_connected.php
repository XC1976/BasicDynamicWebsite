<?php
session_start();
//===== checking that user is connected =====
$is_connected = 0;

if (isset($_SESSION['id_user']) && !empty($_SESSION['id_user']) ) {
    $id_user = $_SESSION['id_user'];
    $is_connected = 1;
}
echo $is_connected;