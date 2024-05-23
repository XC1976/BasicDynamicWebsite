<?php 
include 'scripts/php/init.php';

$logFilePath = '/var/log/php_log/newsletter.log';

if (!file_exists($logFilePath)) {
    die("Le fichier de log n'existe pas.");
}

$logsData = [];

$file = fopen($logFilePath, 'r');
if ($file) {
    while (($line = fgets($file)) !== false) {
        $line = trim($line);
        
        // Séparation point-virgule
        $rows = explode(';', $line);
        
        foreach ($rows as $row) {
            if (empty($row)) {
                continue;
            }

            // séparateur "_"
            $parts = explode('_', $row);
            
            if (count($parts) == 2) {
                $time = $parts[0];
                $time = date("d-m-Y H:i:s", strtotime($time));  
                $newsletterId = $parts[1]; 
                
                $logsData[] = [
                    'time' => $time,
                    'newsletter' => $newsletterId
                ];
            }
        }
    }
    fclose($file);
} else {
    die("Impossible d'ouvrir le fichier de log.");
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include('scripts/php/genHeaderLinks.php'); ?>

    <!-- SPECIFIC CSS  -->

    <link rel = "stylesheet" href = "../assets/css/pageSpecific/newsletter.css">

    <!-- SORT CSS & JS -->

    <link rel = "stylesheet" href = "../assets/css/pageSpecific/arrows.css">
    <script src="scripts/js/sortBy.js"></script>

    <title>Historique logs</title>
</head>
<body>
<?php  
        include('../includes/navbar_back.php');
        include('../includes/db.php');   
    ?>
<main>
<div class="logs">
            <div class="title-container">
                <h1>LOGS D'ENVOI</h1>
            </div>

<div class = "table-container"> 
    <table class = "tab">
        <thead>
        <tr> 
          <th onclick="sortTable(0)">Date <span class="arrow0 inactive"></span></th>
          <th onclick="sortTable(1)">Newsletter <span class="arrow1 inactive"></span></th>  
        </tr>
        </thead>
        <tbody>

        <?php
        if(!empty($logsData)) {
        foreach ($logsData as $logrow) : ?>

            <tr>
            <td><?php echo htmlspecialchars($logrow['time']); ?></td>
            <td><?php echo htmlspecialchars($logrow['newsletter']); ?></td>
            </tr>
        <?php
         endforeach;
        }  else {
            echo '<td>aucun élément trouvé.</td>';
         }

        ?>

        </tbody>


</table>
</div>
</div>
</main>
</body>
</html>