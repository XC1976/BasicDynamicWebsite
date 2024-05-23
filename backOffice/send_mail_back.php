<?php
//this script is a meant to be a reusable email sender
//not bound to any specific function of the website
// you must provide this script :
// - $email
// - $subject
// - $body


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
    
//at this point, we can send the mail
try { 
    $mail =  new PHPMailer(true);
    $mail->isSMTP();
    $mail->SMTPAuth = false;
    $mail->Port = 25; 
    $mail->isHTML(true);
    $mail->setfrom("noreply@openreads.uk");
    $mail->addAddress($email);
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->send();
} catch (Exception $e) {
    echo "mail not sent mail error: " . $e->getMessage();
}

if ($mail->send()) {
    $message = "Nous vous avons envoyé un mail.";
    header("Location: ../backOffice/newsletter.php?message=$message");

}	
