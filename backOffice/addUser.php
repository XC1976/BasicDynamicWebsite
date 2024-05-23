<?php
include 'scripts/php/init.php'; 
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('scripts/php/genHeaderLinks.php'); ?>
    <!-- SPECIFIC CSS  -->
    <link rel="stylesheet" href="../assets/css/pageSpecific/addUser.css">
    <title>add User</title>
</head>
<body>
    <?php  
        include('../includes/navbar_back.php');
        include('../includes/db.php');   
    ?>
    <main>
        <?php include('scripts/php/message.php'); ?>
        <div class="form">
            <div class="center-box">
                <div class="title-container">
                    <h1>NOUVEL UTILISATEUR</h1>
                </div>
                <div class="form-container">
                    <form method="post" action="scripts/php/verificationAddUser.php" enctype="multipart/form-data">
                      <div class = "formInner">
                        <div class="inputRow">
                            <div><label for="inputUsername">Nom d'utilisateur</label></div>
                            <input type="text" name="username" placeholder="username" class="input-zone" id="inputUsername">
                        </div>

                        <div class="inputRow">
                            <div><label for="inputName">Prénom</label></div>
                            <input type="text" name="name" placeholder="name" class="input-zone" id="inputName">
                        </div>


                        <div class="inputRow">
                            <div><label for="inputLastname">Nom</label></div>
                            <input type="text" name="lastname" placeholder="lastname" class="input-zone" id="inputLastname">
                        </div>

                        <div class="inputRow">
                            <div><label for="inputEmail">Email</label></div>
                            <input type="text" name="email" placeholder="email" class="input-zone" id="inputEmail">
                        </div>

                        <div class="inputRow">
                            <div><label for="inputPassword">Mot de passe</label></div>
                            <input type="password" name="password" placeholder="password" class="input-zone" id="inputPassword">
                        </div>

                        <div class="inputRow">
                            <div><label for="inputBio">Biographie</label></div>
                            <textarea id="inputBio" name="bio" rows="4" cols="50" placeholder= "Saisissez votre biographie ici"></textarea>
                        </div>

                        <div class="inputRow">
                            <div><label for="inputBdate">Date de naissance</label></div>
                            <input type="date" name="date" placeholder="date" class="input-zone" id="inputBdate">
                        </div>

                        <div class = "status">
                        <div class="inputRow">              

                            <div><label for="inputAdmin" name="admin" class="input-zone">Droits</label></div>
                            <select class = "input" name ="admin_value">
                                <option value="0">regular</option>
                                <option value="1">admin</option>   
                            </select>


                            <div><label for="inputAuthor" name="status" class="input-zone">Statut</label></div>
                            <select class = "input" name ="stat">
                                <option value="0">auteur</option>
                                <option value="1">utilisateur</option>   
                            </select>
                            </div>
                        </div>

                        <div class="file_selection">
                            <div><label for="inputImage" class="form-label">Image de profil</label></div>
                            <input type="file" name="image" class="form-control" id="inputImage">
                        </div>

                        <button class ="btn" type="submit">Enregistrer</button>
                     </div>  
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
