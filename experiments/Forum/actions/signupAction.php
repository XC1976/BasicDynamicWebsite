<?php
require('database.php');

// Validation du formulaire
if(isset($_POST['validate'])) {

    // Vérifier si l'user a bien complété tous les champs
    if(!empty($_POST['pseudo']) && !empty($_POST['lastName']) && !empty($_POST['password']) && !empty($_POST['email']) && !empty($_POST['firstName'])) {

        // Les données de l'user
        $user_email = $_POST['email'];
        $user_pseudo = htmlspecialchars($_POST['pseudo']);
        $user_lastName = htmlspecialchars($_POST['lastName']);
        $user_firstName = htmlspecialchars($_POST['firstName']);
        $user_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Vérifier si l'utilisateur existe déjà sur le site
        $checkIfUserAlreadyExists = $bdd->prepare('SELECT pseudo FROM users WHERE pseudo = ?');
        $checkIfUserAlreadyExists->execute(array($user_pseudo));

        // Vérifier si l'user existe déjà
        if($checkIfUserAlreadyExists->rowCount() == 0) {
            // Insérer l'utilisateur dans le bdd
            $insertUserOnWebsite = $bdd->prepare('INSERT INTO users(email, pseudo, nom, prenom, mdp) VALUES(?, ?, ?, ?, ?)');
            $insertUserOnWebsite->execute(array(
                $user_email,
                $user_pseudo,
                $user_lastName,
                $user_firstName,
                $user_password
            ));

            // Récupérer informations de l'utilisateurs
            $getInfosOfThisUserReq = $bdd->prepare('SELECT id, pseudo, nom, prenom FROM users WHERE nom = ? AND prenom = ? AND pseudo = ?');
            $getInfosOfThisUserReq->execute(array(
                $user_lastName,
                $user_firstName,
                $user_pseudo
            ));

            $usersInfos = $getInfosOfThisUserReq->fetch();

            // Authentifier l'utilisateur sur le site et récupérer ses données dans des variables globales $_SESSION
            $_SESSION['auth'] = true;
            $_SESSION['id'] = $usersInfos['id'];
            $_SESSION['lastName'] = $usersInfos['nom'];
            $_SESSION['firstName'] = $usersInfos['prenom'];
            $_SESSION['pseudo'] = $usersInfos['pseudo'];

            // Redirige l'utilisateur vers la page d'accueil
            header('Location: index.php');

        } else {
            $errorMsg = "L'utilisateur existe déjà sur le site";
        }

    } else {
        $errorMsg = "Veuillez complétez tous les champs";
    }
}