<?php
session_start();
$rootPath = "../../../../";


$directory = '/var/backups/openreads/';
date_default_timezone_set('Europe/Paris');
// Initialize an empty array to hold file names and sizes
$filesArray = array();
$i = 0;
if (is_dir($directory)) {
    if ($dh = opendir($directory)) {
        while (($file = readdir($dh)) !== false) {
            $filePath = $directory . '/' . $file;
            if ($file !== '.' && $file !== '..') {
                if (is_file($filePath)) {
                    $fileCreationDate = date("Y-m-d H:i:s", filectime($filePath));
                    $filesArray[$i] = [
                        'size' => filesize($filePath),
                        'name' => $file,
                        'date' => $fileCreationDate,
                    ];
                }
            }
            $i += 1;
        }
        closedir($dh);
    } else {
        echo "Failed to open directory.";
    }
    
} else {
    echo "Not a directory.";
}

?>
<?php foreach ($filesArray as $backup): ?>
    <?php $size = intval($backup['size']) / 1000; ?>
    <tr>
        <td class="backupName"><?= $backup['name'] ?></td>
        <td><?= $backup['date'] ?></td>
        <td><?= $size ?> kB</td>
    </tr>
<?php endforeach ?>


