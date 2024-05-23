<?php
session_start();
// Redirect to the index with an error message chosen prior
function redirectWithError($message) {
    header("Location: ../index.php?message=$message");
    $message = "";
    exit();
}

// Function to log user signing in
function logUserSignin($usernameLog, $emailLog) {
    $logFile = '/var/log/php_log/user_signin.log';
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
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['validate'])) {
    //define form variables
    $email=$_POST['email'];
    $form_password=$_POST['password'];

    $fields = ['email' => $email,
                'mot de passe' => $form_password,
              ];
              
    $message = "Erreur : ";
    $redirect = False;
    foreach ($fields as $field => $userdata) {
            if (empty($userdata)) {
                $message = $message . $field . ", ";
                $redirect = True;
            }
        }

    //if at least one of the field has an error, redirecting with error message
    if ($redirect == true) {
        redirectWithError($message);
    }

    //sanitizing
    filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $email = htmlspecialchars($email);

    //validating
    if (!filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL)) {
        $message = 'Email invalide.' . '<br/>';
        $redirect = True;
    }

    if (strlen($form_password) < 8 || strlen($form_password) > 255 ) { 
        $message = $message . 'Le mot de passe doit être entre 8 et 255 charactères.';
        $redirect = True;
    }

    if ($redirect == True) {
        redirectWithError($message);
    }

    //db interraction
    try {
        //connection to the database
        require_once "../includes/db.php";
        
        //check the password and if the user is banned
        $query = 'SELECT password, is_banned, admin FROM USER WHERE email = :email;';

        $request = $pdo->prepare($query);
        $request->bindParam(":email", $email);
        
        $request->execute();
        $db_password = $request->fetchAll();

        if (empty($db_password)){
            $message = "Veuillez vous inscrire d'abord.";
            redirectWithError($message);
        }
        if($db_password[0]['is_banned'] == 1) {
            $message = "Vous êtes bannis !";
            redirectWithError($message);
        }

        $db_password = $db_password[0]['password'];
        
        if (!$form_password = hash('sha256', $form_password) == $db_password){
            //if password doesn't match
            $message = "Mot de passe erroné.";
            redirectWithError($message);
        } else {

            // Create $_SESSION
            $queryToCreateSession = $pdo->prepare('SELECT * FROM USER WHERE email = ?;');
            $queryToCreateSession->execute([$email]);

            $usersInfos = $queryToCreateSession->fetch(PDO::FETCH_ASSOC);

            $_SESSION['id_user'] = $usersInfos['id_user'];
            $_SESSION['name'] = $usersInfos['name'];
            $_SESSION['lastname'] = $usersInfos['lastname'];
            $_SESSION['username'] = $usersInfos['username'];
            $_SESSION['email'] = $usersInfos['email'];
            $_SESSION['profile_pic'] = $usersInfos['profile_pic'];
            $_SESSION['bio'] = $usersInfos['bio'];
            $_SESSION['birthdate'] = $usersInfos['birthdate'];
            $_SESSION['creation_date'] = $usersInfos['creation_date'];
            $_SESSION['deathdate'] = $usersInfos['deathdate'];
            $_SESSION['status'] = $usersInfos['status'];
            $_SESSION['auth'] = true;

            // Create session admin if user is admin
            if($usersInfos['admin'] == 1) {
                $_SESSION['admin'] = 1;
            }

            // Log user time of signin + username in /var/log/php_log/user_signin.log
            $usernameLog = $_SESSION['username'];
            $emailLog = $_SESSION['email'];
            logUserSignin($usernameLog, $emailLog);

            // Verify if restez connecté button is checked
            if(isset($_POST['remember-me'])) {
                setcookie("email", $_SESSION['email'], time() + 3600*24*365, "/");
                setcookie("password", $_POST['password'], time() + 3600*24*365, "/");
            }
            else {
                setcookie("email", $_SESSION['email'], time() - 36000, "/");
                setcookie("password", $_POST['password'], time() - 36000, "/");
            }

            
            if ($_SESSION['admin'] == 1) {
                header('Location: ../backOffice/frontPage.php');
                exit;
            }
            header('Location: ../index.php');
            
            
        }
            
    } catch (PDOException $e) {
        die("Querry Failed : " . $e->getMessage());
    }

} else
    header("Location: ../index.php");