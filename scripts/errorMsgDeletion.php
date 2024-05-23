<?php
if (isset($_POST['validate'])) {
    // Clear the $_GET variable
    if (isset($_GET['message'])) {
        unset($_GET['message']);
    }
    // Redirect back to the page to see the changes.
    $pathToPreviousPage = $_GET['currentPagePath'];
    header("Location: $pathToPreviousPage");
    exit();
}
?>