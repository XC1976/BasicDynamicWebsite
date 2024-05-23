<?php
session_start();

// Require db
require '../../includes/db.php';

// Verify if every $_POST are present
if (
    !isset($_POST['username']) || empty($_POST['username']) ||
    !isset($_POST['email']) || empty($_POST['email']) ||
    !isset($_POST['lastName']) || empty($_POST['lastName']) ||
    !isset($_POST['firstName']) || empty($_POST['firstName']) ||
    !isset($_POST['bio']) || empty($_POST['bio'])
) {
    header('Location: ../../pages/Profil/profile.php?username=' . $_SESSION['username']);
    exit;
}

$username = $_POST['username'];
$email = $_POST['email'];
$lastName = $_POST['lastName'];
$firstName = $_POST['firstName'];
$bio = $_POST['bio'];

//if the user access this page legitimatly
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['validate'])) {
    // Verify if user is connected
    if (empty($_SESSION['auth']) || !isset($_SESSION['auth'])) {
        header('Location: ../../pages/Profil/profile.php?username=' . $_SESSION['username']);
        exit;
    }

    // Sanitizing
    $username = htmlspecialchars($username);
    $email = htmlspecialchars($email);
    $lastName = htmlspecialchars($lastName);
    $firstName = htmlspecialchars($firstName);
    $bio = htmlspecialchars($bio);

    // Verify length
    if (strlen($username) < 4 || strlen($username) > 20) {
        header('Location: ../../pages/Profil/profile.php?username=' . $_SESSION['username'] . '&message=Pseudo entre 4 et 20 caractères !');
        exit;
    }

    if (strlen($lastName) < 2 || strlen($lastName) > 30) {
        header('Location: ../../pages/Profil/profile.php?username=' . $_SESSION['username'] . '&message=Nom entre 2 et 30 caractères !');
        exit;
    }

    if (strlen($firstName) < 2 || strlen($firstName) > 30) {
        header('Location: ../../pages/Profil/profile.php?username=' . $_SESSION['username'] . '&message=Prénom entre 2 et 30 caractères !');
        exit;
    }

    if (strlen($bio) < 10 || strlen($firstName) > 200) {
        header('Location: ../../pages/Profil/profile.php?username=' . $_SESSION['username'] . '&message=Biographie entre 10 et 200 caractères!');
        exit;
    }

    if (!filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL)) {
        header('Location: ../../pages/Profil/profile.php?username=' . $_SESSION['username'] . '&message=Email invalide !');
        exit;
    }

    // Verification if username is already taken
    $verificationUsernameRequest = $pdo->prepare("SELECT id_user FROM USER WHERE username = ?;");
    $verificationUsernameRequest->execute([
        $username
    ]);
    $rowCountUsername = $verificationUsernameRequest->rowCount();

    if ($rowCountUsername != 0) {
        header('Location: ../../pages/Profil/profile.php?username=' . $_SESSION['username'] . '&message=Pseudo déjà pris !');
        exit;
    }

    // Verification if email is already taken
    $verificationEmailRequest = $pdo->prepare("SELECT id_user FROM USER WHERE email = ?;");
    $verificationEmailRequest->execute([
        $email
    ]);
    $rowCountEmail = $verificationEmailRequest->rowCount();

    if ($rowCountEmail != 0) {
        header('Location: ../../pages/Profil/profile.php?username=' . $_SESSION['username'] . '&message=Email déjà pris !');
        exit;
    }

    // Update informations
    $updateUsernameRequest = $pdo->prepare('UPDATE USER SET username = ?, name = ?, lastname = ?, email = ?, bio = ? WHERE id_user = ?');
    $updateUsernameRequest->execute([
        $username,
        $firstName,
        $lastName,
        $email,
        $bio,
        $_SESSION['id_user']
    ]);

    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;
    $_SESSION['lastname'] = $lastName;
    $_SESSION['name'] = $firstName;

    header('Location: ../../pages/Profil/profile.php?username=' . $username . '&message=Informations modifiées avec succès !');
    exit;
}