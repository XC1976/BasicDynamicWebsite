<?php
function redirectWithError($message) {
    header("Location: ../pages/Inscription/connection.php?message=$message");
    $message = "";
    exit();
}