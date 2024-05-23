<?php
function pageLog($usernameLog, $emailLog)
{
    $currentFilePath = realpath($_SERVER['SCRIPT_FILENAME']);
    $logFile = '/var/log/php_log/page_tracking.log';
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $currentTime = date('Y-m-d H:i:s');
    $logMessage = $ipAddress . '_' . $currentTime . '_' . $usernameLog . '_' . $emailLog . '_' . $currentFilePath . ';' . PHP_EOL;

    // Open the log file in append mode
    if ($handle = fopen($logFile, 'a+')) {
        // Write the log message to the file
        fwrite($handle, $logMessage);
        // Close the file handle
        fclose($handle);
    } else {
        // Failed to open log file, handle the error
        error_log("Failed to open log file: $logFile");
    }
}

if (isset($_SESSION['auth'])) {
    $usernameLog = $_SESSION['username'];
    $emailLog = $_SESSION['email'];
    pageLog($usernameLog, $emailLog);
} else {
    $usernameLog = "notLoggedIn";
    $emailLog = "notLoggedIn";
    pageLog($usernameLog, $emailLog);
}