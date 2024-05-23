<?php

include('../includes/db.php');

$query = 'SELECT subject, paragraph01, paragraph02, paragraph03 FROM NEWSLETTER WHERE id_nl = 1;';
    $request = $pdo->prepare($query);
    $request->execute();
    $newletter_data = $request->fetchAll(PDO::FETCH_ASSOC);

    //getting the newletter data
    $subject = $newletter_data[0]['subject'];
    $paragraph01 = $newletter_data[0]['paragraph01'];
    $paragraph02 = $newletter_data[0]['paragraph02'];
    $paragraph03 = $newletter_data[0]['paragraph03'];
    
    //getting the template
    $body = file_get_contents("../pages/mails/newsletter.html");
    
    //filling the template
    $body = str_replace('%subject%', $subject, $body);
    $body = str_replace('%paragraph01%', $paragraph01, $body);
    $body = str_replace('%paragraph02%', $paragraph02, $body);
    $body = str_replace('%paragraph03%', $paragraph03, $body);


$logFilePath = '/var/log/php_log/user_signin.log';

if (isset($_POST['file'])) {
    $logFilePath = $_POST['file'];
}

if (!file_exists($logFilePath)) {
    die("Le fichier de log n'existe pas.");
}

// 1. Mettre tous les logs au bon format dans un tableau

date_default_timezone_set('Europe/Paris');
$current = date('Y-m-d H:i:s');
$logsData = [];

$oneMonthAgo = (new DateTime())->modify('-1 month')->format('Y-m-d H:i:s');

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

            // Séparateur "_"
            $parts = explode('_', $row);
            
            if (count($parts) == 4) {
                $dateTime = $parts[1]; 
                $email = $parts[3];
                
                $found = false;
                foreach ($logsData as &$log) {
                    if ($log['email'] == $email) {
                        if ($dateTime > $log['dateTime']) {
                            $log['dateTime'] = $dateTime;
                        }
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $logsData[] = [
                        'dateTime' => $dateTime,
                        'email' => $email
                    ];
                }
            }
        }
    }
    fclose($file);

    foreach($logsData as $log) {
        if ($log['dateTime'] < $oneMonthAgo) {
            include('../backOffice/send_mail_back.php');
        }
    }
    
    exit();

} else {
    die("Impossible d'ouvrir le fichier de log.");
}

?>



