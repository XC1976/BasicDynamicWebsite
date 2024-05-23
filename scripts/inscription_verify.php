<?php
session_start();
// Function to redirect to the inscription page with an error message
function redirectWithError($message, $name, $lastname, $username, $email, $birthdate, $status)
{
    if (isset($name))      { $_SESSION['name'] = $name;}
    if (isset($lastname))  { $_SESSION['lastname'] = $lastname;}
    if (isset($username))  { $_SESSION['username'] = $username;}
    if (isset($email))     { $_SESSION['email'] = $email;}
    if (isset($birthdate)) { $_SESSION['birthdate'] = $birthdate;}
    if (isset($status))    { $_SESSION['status'] = $status;}

    header("Location: ../pages/Inscription/inscription.php?message=$message");
    $message = "";
    exit();
}

// Function to log user login events
function logUserSignup($usernameLog, $emailLog) {
    $logFile = '/var/log/php_log/user_signup.log';
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $currentTime = date('Y-m-d H:i:s');
    $logMessage = $ipAddress . '_' . $currentTime . '_' . $usernameLog . '_' . $emailLog . ';' . PHP_EOL;

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

//if the user access this page legitimatly
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset ($_POST['validate'])) {

    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $birthdate = $_POST['birthdate'];
    $status = $_POST['status'];

    $fields = [
        'prénom' => $name,
        'nom de famille' => $lastname,
        'nom d\'utilisateur' => $username,
        'email' => $email,
        'mot de passe' => $password,
        'date de naissance' => $birthdate,
        'status' => $status
    ];

    //verifying that each field is filled in
    $message = "Erreur : Veuillez renseigner les champs suivants : ";
    $redirect = False;
    foreach ($fields as $field => $userdata) {
        if (empty ($userdata)) {
            $message = $message . $field . ", ";
            $redirect = True;
            break;
        }
    }

    //if at least one of the field has an error, redirecting with error message
    if ($redirect == true) {
        redirectWithError($message, $name, $lastname, $username, $email, $birthdate, $status);
    }

    //sanitizing
    $name = htmlspecialchars($name);
    $lastname = htmlspecialchars($lastname);
    $username = htmlspecialchars($username);

    filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $email = htmlspecialchars($email);

    $password = htmlspecialchars($password);
    $birthdate = htmlspecialchars($birthdate);
    $birthdate = date($birthdate);
    $status = htmlspecialchars($status);


    //validate
    $message = '';
    $redirect = False;

    if (strlen($name) < 2 || strlen($name) > 30) {
        $message = $message . 'Le prénom doit être entre 2 et 30 charactères.';
        $redirect = True;
    }

    if (strlen($lastname) < 2 || strlen($lastname) > 30) {
        $message = $message . 'Le nom de famille doit être entre 2 et 30 charactères';
        $redirect = True;
    }

    if (strlen($username) < 4 || strlen($username) > 20) {
        $message = $message . 'Le nom d\'utilisateur doit être entre 4 et 20 charactères.';
        $redirect = True;
    }

    if (!filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL)) {
        $message = $message . 'Email invalide';
        $redirect = True;
    }

    if (strlen($password) < 8 || strlen($password) > 255) {
        $message = $message . 'Le mot de passe doit être entre 8 et 255 charactères.';
        $redirect = True;
    } else {
        $password = hash('sha256', $password);
    }

    //Age verification
    date_default_timezone_set('UTC');
    $thirteenYearsAgo = date("Y-m-d", time() - 3600 * 24 * 4748);


    if ($birthdate > $thirteenYearsAgo) {
        $message = $message . 'Vous devez avoir plus de 13 ans.';
        $redirect = True;
    }
    // creation date
    $creation_date = date('Y-m-d');

    //status = utilisateur ou auteur
    if ($status == 'utilisateur')
        $status = 1;
    else
        $status = 0;

    // is_verified initialization
    $is_verified = 0;

    //------------------------------------
    //create a verification token

    $token_value = bin2hex(random_bytes(25));

    //token type must be "ACCOUNT" or "PASSWD"
    $token_type = "ACCOUNT";

    //1 day to validate email
    $expiration_date = date("Y-m-d", time() + 3600*24);
    $is_banned = 0; //it is the opposite

    if ($redirect == True) {
        redirectWithError($message, $name, $lastname, $username, $email, $birthdate, $status);
    }

    try {
        //connection to the database
        require_once "../includes/db.php";

        //verification de l'email
        $query = 'SELECT id_user FROM USER WHERE email = :email;';

        $request = $pdo->prepare($query);

        $request->bindParam(":email", $email);

        $request->execute();
        $results = $request->fetchAll();

        if (!empty ($results)) {
            $message = "L'adresse email est déja utilisée.";
            redirectWithError($message, $name, $lastname, $username, $email, $birthdate, $status);
        }

        //verification du username
        $query = 'SELECT id_user FROM USER WHERE username = :username;';

        $request = $pdo->prepare($query);
        $request->bindParam(":username", $username);

        $request->execute();
        $results = $request->fetchAll();

        if (!empty ($results)) {
            $message = "Le nom d'utilisateur est déja utilisée.";
            redirectWithError($message, $name, $lastname, $username, $email, $birthdate, $status);
        }

        // === Captcha vertification ===

        // Stock la réponse du captcha dans une variable
        $userAnswerCaptcha = htmlspecialchars($_POST['answerCaptcha']);
        $userAnswerCaptcha = strtolower($userAnswerCaptcha);

        // Vérifie que la réponse au captcha est correct
        if ($userAnswerCaptcha != $_SESSION['goodAnswer']) {
            $message = "La réponse au captcha est incorrecte !";
            redirectWithError($message, $name, $lastname, $username, $email, $birthdate, $status);
        }


        //-----------------------------------
        //add the user data to the database
        $query = "INSERT INTO USER(name, lastname, username, email, password, birthdate, creation_date, status, is_verified)
                  VALUES (:name, :lastname, :username, :email, :password, :birthdate, :creation_date, :status, :is_verified);";

        $request = $pdo->prepare($query);

        $request->bindParam(":name", $name);
        $request->bindParam(":lastname", $lastname);
        $request->bindParam(":username", $username);
        $request->bindParam(":email", $email);
        $request->bindParam(":password", $password);
        $request->bindParam(":birthdate", $birthdate);
        $request->bindParam(":creation_date", $creation_date);
        $request->bindParam(":status", $status);
        $request->bindParam(":is_verified", $is_verified);
        $request->execute();

        // ---------------------------
        // Add username and time log on account creation in /var/log/php_log/user_signup.log
        $usernameLog = $name;
        $emailLog = $email;
        logUserSignup($usernameLog, $emailLog);

        //---------------
        //get user id
        $query = "SELECT id_user FROM USER WHERE email=:email;";

        $request = $pdo->prepare($query);
        $request->bindParam(":email", $email);
        $request->execute();

        $id_user = $request->fetchAll();
        //parsing
        $id_user = $id_user[0]["id_user"];

        //--------------
        // Send token

        $query = "INSERT INTO TOKEN(token_value, token_type, expiration_date, user)
                VALUES (:token_value, :token_type, :expiration_date, :user);";

        $request = $pdo->prepare($query);

        $request->bindParam(":token_value", $token_value);
        $request->bindParam(":token_type", $token_type);
        $request->bindParam(":expiration_date", $expiration_date);
        $request->bindParam(":user", $id_user);

        $request->execute();

        //-------------------------
        //clear database connnection
        $pdo = null;
        $request = null;

        //----------------------------
        // Sending confirmation email

        $subject = "OpenReads : Confirmation de votre addresse mail";
        $body = file_get_contents("../pages/mails/confirmation_mail.html");

        $link = 'http://www.openreads.uk/scripts/verify_mail.php?token=' . $token_value . '&id=' . $id_user;
        $body = str_replace('%LINK%', $link, $body);

        require "../includes/send_mail.php";

        $message = "Nous vous avons envoyé un mail pour vérifer votre compte";



        header("Location: ../index.php?message=$message");
        exit();

    } catch (PDOException $e) {
        die ("Querry Failed : " . $e->getMessage());
    }

} else
    header("Location: ../pages/Inscription/inscription.php?message=$message");

