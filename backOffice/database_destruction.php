<?php 
include 'scripts/php/init.php';
include('../includes/navbar_back.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include('scripts/php/genHeaderLinks.php');?>

                 <!-- SPECIFIC CSS  -->
    
    <link rel = "stylesheet" href = "../assets/css/pageSpecific/database_destruction.css">
    <link rel = "stylesheet" href = "../assets/css/general/components/popupDelete.css">
    <title>database destruction</title>
    <!-- DESC: littéralement juste un bouton qui détruit toute la bdd. Dans destroy_database.php, une autre version est commenté, qui elle 
    permet de vider les enregistrements de toutes les tables sans toucher à la structure -->
</head>

<body>

<main>
    <h2 id="message"></h2>
   <?php include('scripts/php/message.php'); ?>
   <table >
        <thead>
            <tr>
                <th>Nom</th>
                <th>Date</th>
                <th>Poids</th>
            </tr>
        </thead>
        <tbody id="backups">
        <!-- Table rows will be inserted here -->
        </tbody>
   </table>
   <div class="btns">
    <button class="good" onclick="togglePopupDb('create', createBackup)">Créer un backup</button>
    <button class="good" onclick="togglePopupDb('restore', restoreBackup)">Restaurer le backup</button>
    <button class="bad" onclick="togglePopupDb('destroy', destroyBackup)">Detruire le backup</button>
    <button class="bad" onclick="togglePopupDb('dropDb', dropDatabase)">Drop database</button>
</div>

    <div id="overlay">
    <div class="popup">
        <h2 id="txtConfirmAction"></h2>
        <input type="text" id="backupNameInput" placeholder="Nom du backup" class="txtinput hidden">
        <h3 id="backupNameOutput" class="txtinput hidden"></h3>
        <div id="buttons">
            <button class="btnPopup" onclick="confirmAction()">Oui</button>
            <button class="btnPopup" onclick="togglePopupDb()">Annuler</button>

        </div>
    </div>

</div>
   <script src="scripts/js/db_manage.js"></script>
</main>
    
</body>
</html>