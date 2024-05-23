<?php

    // Function log historic newsletter
    function logNews($newsletterId) {
        $logFile = '/var/log/php_log/newsletter.log'; 
        $currentTime = date('Y-m-d H:i:s');
        $logMessage = $currentTime . '_' . $newsletterId . PHP_EOL;
    
        if ($handle = fopen($logFile, 'a+')) {
            fwrite($handle, $logMessage);
            fclose($handle);
        } else {
            error_log("Failed to open log file: $logFile");
        }
    }


    try {
    //connection to the database
    require_once "../includes/db.php";

    if (!isset($_POST['NewsId']) || empty($_POST['NewsId'])) {
        header('location: ../backOffice/newsletter.php?message=L\'élément n\'a pas pu être identifié.');
        exit;
    }
    
    $id = $_POST['NewsId'];

        $query = 'UPDATE NEWSLETTER SET is_selected = 0 WHERE is_selected = 1;
                  UPDATE NEWSLETTER SET is_selected = 1 WHERE id_nl = :id;';
        $request = $pdo->prepare($query);
        $request->execute(['id' => $id]);


    //recupérer la liste des mails des users
    $query = 'SELECT email FROM USER WHERE is_verified=1;';

    $request = $pdo->prepare($query);
    $request->execute();
    
    $emails = $request->fetchAll(PDO::FETCH_ASSOC);
    
    // récupérer le contenu dwe la newletter
    $query = 'SELECT subject, paragraph01, paragraph02, paragraph03 FROM NEWSLETTER WHERE is_selected=1;';
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
    
    //var_dump($body);
    //sending an email to every verified address
    foreach ($emails as $mail) {
	    $email = $mail['email'];
        include('../backOffice/send_mail_back.php');
    }

    logNews($id);

    exit();

} catch (PDOException $e) {
    die ("Querry Failed : " . $e->getMessage());
}

exit();
