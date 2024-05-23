<?php
include 'scripts/php/init.php';

$logFilePath = '/var/log/php_log/user_signin.log';

if(isset($_POST['file'])) {
    $logFilePath = $_POST['file'];
    }

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
            
            if (count($parts) == 4) {
                $ipAddress = $parts[0];
                $dateTime = $parts[1]; 
                $dateTime = date("d-m-Y H:i:s", strtotime($dateTime));  
                $username = $parts[2];

                $email = $parts[3];
                
                $logsData[] = [
                    'ipAddress' => $ipAddress,
                    'dateTime' => $dateTime,
                    'username' => $username,
                    'email' => $email
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

    <link rel = "stylesheet" href = "../assets/css/pageSpecific/logs.css">
    <script src="scripts/js/changeTab.js"></script>

    <!-- SORT CSS & JS -->

    <link rel = "stylesheet" href = "../assets/css/pageSpecific/arrows.css">
    <script src="scripts/js/sortBy.js"></script>

    <title>Logs newsletter</title>
</head>
<body>
        
<?php
include('../includes/navbar_back.php');
?>
<main>
<div class="logs">
            <div class="title-container">
                <h1>LOGS</h1>
                <button id = "/var/log/php_log/user_signin.log" class = 'btn active' onclick = "changeLogFile('/var/log/php_log/user_signin.log')">connexions</button>
                <button id = "/var/log/php_log/user_signup.log" class = 'btn' onclick = "changeLogFile('/var/log/php_log/user_signup.log')">inscriptions</button>
            </div>

<div class = "table-container"> 
    <table class = "tab">
        <thead>
        <tr> 
          <th>Adresse ip</th> 
          <th onclick="sortTable(1)">Date <span class="arrow1 inactive"></span></th>
          <th onclick="sortTable(2)">Utilisateur <span class="arrow2 inactive"></span></th> 
          <th onclick="sortTable(3)">Email <span class="arrow3 inactive"></span></th>    
        </tr>
        </thead>
        <tbody>

        <?php
        if(!empty($logsData)) {
        foreach ($logsData as $logrow) : ?>

            <tr>
            <td><?php echo htmlspecialchars($logrow['ipAddress']); ?></td>
            <td><?php echo htmlspecialchars($logrow['dateTime']); ?></td>
            <td><?php echo htmlspecialchars($logrow['username']); ?></td>
            <td><?php echo htmlspecialchars($logrow['email']); ?></td>
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
